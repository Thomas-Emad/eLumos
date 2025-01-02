<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\TicketRequest;
use App\Http\Traits\UploadAttachmentTrait;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;


class TicketController extends Controller implements HasMiddleware
{
  use UploadAttachmentTrait;

  public static function middleware(): array
  {
    return [
      new Middleware('permission:support', except: ['index', 'show']),
    ];
  }

  public function index()
  {
    $tickets = Ticket::latest()->paginate(10);
    return view('pages.dashboard.tickets.index', compact('tickets'));
  }

  public function create()
  {
    return view('pages.dashboard.tickets.create');
  }

  public function store(TicketRequest $request)
  {
    $attachments = [];

    foreach ($request->file('attachments') as $file) {
      $attachments[] = $this->uploadAttachmentFile($file);
    }

    Ticket::create([
      'request_id' => $this->generatorRequestID(),
      'user_id' => Auth::id(),
      'subject' => $request->subject,
      'description' => $request->description,
      'type' => $request->type,
      'attachments' => json_encode(($attachments))
    ]);

    return redirect()->route('dashboard.tickets.index')->with([
      'notification' => [
        'type' => 'success',
        'message' => 'The ticket has been created successfully, you will be replied as soon as possible',
      ],
    ]);
  }

  public function show($requestID)
  {
    $ticket = Ticket::where('request_id', $requestID)->firstOrFail();
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
}
