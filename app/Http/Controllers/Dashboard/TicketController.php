<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\TicketRequest;
use App\Http\Traits\UploadAttachmentTrait;
use App\Models\{Ticket, User};
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TicketSupportNotification;
use App\Events\NewTicketNotificationBroadcast;

class TicketController extends Controller implements HasMiddleware
{
  use UploadAttachmentTrait;

  public static function middleware(): array
  {
    return [
      // new Middleware('permission:support', except: ['index', 'show', 'create', 'store']),
    ];
  }

  public function index()
  {
    $tickets = Ticket::when(!Auth::user()->hasPermissionTo('support'), function (Builder $query) {
      return $query->where('user_id', Auth::id());
    })->latest()->paginate(10);
    return view('pages.dashboard.tickets.index', compact('tickets'));
  }

  public function create()
  {
    return view('pages.dashboard.tickets.create');
  }

  public function store(TicketRequest $request)
  {
    if ($request->file('attachments')) {
      $attachments = [];
      foreach ($request->file('attachments') as $file) {
        $attachments[] = $this->uploadAttachmentFile($file);
      }
    }

    $ticket =  Ticket::create([
      'request_id' => $this->generatorRequestID(),
      'user_id' => Auth::id(),
      'subject' => $request->subject,
      'description' => $request->description,
      'type' => $request->type,
      'attachments' => isset($attachments) ? json_encode(($attachments)) : null
    ]);

    // Broadcast the event
    broadcast(new NewTicketNotificationBroadcast($ticket->id))->toOthers();

    return redirect()->route('dashboard.tickets.show', ['ticket' => $ticket->id])->with([
      'notification' => [
        'type' => 'success',
        'message' => 'The ticket has been created successfully, you will be replied as soon as possible',
      ],
    ]);
  }

  public function show($requestID)
  {
    $ticket = Ticket::where('request_id', $requestID)->firstOrFail();
    if ($ticket->user_id !== Auth::id() && !Auth::user()->hasPermissionTo('support')) {
      return abort(403);
    }
    return view('pages.dashboard.tickets.show', compact('ticket'));
  }

  private function uploadAttachmentFile($file)
  {
    $extension = $file->getClientOriginalExtension();
    if (in_array($extension, ['png', 'jpg', 'jpeg', 'webp', 'pdf', 'word'])) {
      return static::uploadAttachment($file, 'tickets', 'image');
    } else {
      return static::uploadVideo($file, 'tickets', 'video');
    }
  }

  private function generatorRequestID()
  {
    return time() . '-' . Auth::id();
  }

  public function closeTicket(Request $request)
  {
    $request->validate([
      'status' => 'required|in:close_user,close_support',
    ]);

    $ticket = Ticket::findOrFail($request->ticket_id);
    // return dd(Auth::id());
    if ($ticket->user_id == Auth::id() || Auth::user()->hasPermissionTo('support')) {
      $ticket->update([
        'status' => $request->status,
        'completed_at' => now()
      ]);

      Notification::send(User::find($ticket->user_id), new TicketSupportNotification(
        $ticket,
        'This ticket has been closed.'
      ));

      return redirect()->route('dashboard.tickets.index')->with([
        'notification' => [
          'type' => 'success',
          'message' => 'This ticket has been closed successfully.',
        ],
      ]);
    } else {
      return  abort(403);
    }
  }

  public function review(Request $request)
  {
    $request->validate([
      'rate' => "required|integer|min:1|max:5",
      'content' => "nullable|string|max:600"
    ]);

    $ticket = Ticket::findOrFail($request->ticket_id);

    if ($ticket->user_id == Auth::id()) {
      $ticket->update([
        'rate' => $request->rate,
        'feedback' => $request->content,
        'completed_at' => now()
      ]);

      return redirect()->route('dashboard.tickets.index')->with([
        'notification' => [
          'type' => 'success',
          'message' => 'Your Review has been sent successfully, thank you. We are always working to improve it.',
        ],
      ]);
    } else {
      return  abort(403);
    }
  }
}
