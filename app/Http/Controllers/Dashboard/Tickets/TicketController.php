<?php

namespace App\Http\Controllers\Dashboard\Tickets;

use App\Models\Ticket;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\TicketRequest;
use App\Http\Traits\UploadAttachmentTrait;
use App\Events\NewTicketNotificationBroadcast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Database\Query\Builder;
use Symfony\Component\HttpFoundation\RedirectResponse;

class TicketController extends Controller
{
  use UploadAttachmentTrait;

  /**
   * Display the list of tickets based on the given request parameters.
   *
   * This method retrieves the tickets using the `getTickets` method, passing the current request. 
   * It returns the view with the tickets data for rendering the tickets list.
   *
   * @param \Illuminate\Http\Request $request The request instance containing query parameters such as subject and status.
   * 
   * @return \Illuminate\View\View The view for the ticket index page with the retrieved tickets.
   */
  public function index(Request $request): View
  {
    $tickets =  $this->getTickets($request);

    return view('pages.dashboard.tickets.index', compact('tickets'));
  }

  /**
   * Fetch and return the table data for tickets, including pagination and content.
   *
   * This method retrieves the tickets based on the current request and passes them 
   * to a view that generates the table content and pagination links. It ensures 
   * that the correct query parameters are preserved in the pagination links.
   *
   * @param \Illuminate\Http\Request $request The current HTTP request instance.
   * 
   * @return \Illuminate\Http\JsonResponse A JSON response containing the table content and pagination.
   */
  public function table(Request $request)
  {
    $tickets = $this->getTickets($request);

    // Get the current URL with query parameters for pagination links
    $paginationLinks = $tickets->withPath(url('/dashboard/tickets') . '?' . http_build_query($request->except('page')));

    return response()->json([
      'content' => view('pages.dashboard.tickets.partials.table', compact('tickets'))->render(),
      'pagination' => view('pages.dashboard.tickets.partials.pagination', compact('tickets'))->render(),
    ]);
  }

  /**
   * Retrieve the tickets based on the given request parameters.
   *
   * This method fetches the tickets for the current user (or all tickets if the user has permission), 
   * filters them based on the provided `subject` and `status`, and paginates the results. 
   * It also ensures that the pagination links preserve the filters.
   *
   * @param \Illuminate\Http\Request $request The current HTTP request instance containing query parameters like subject and status.
   * 
   * @return \Illuminate\Pagination\LengthAwarePaginator The paginated tickets collection.
   */
  private function getTickets(Request $request)
  {
    $tickets = Ticket::when(!Auth::user()->hasPermissionTo('support'), function (Builder $query) {
      return $query->where('user_id', Auth::id());
    })
      ->where('subject', "like", "%$request->subject%")
      ->whereIn('status', $this->getStatusTickets($request->status))
      ->latest()->paginate(10);

    // Ensure the pagination links include query parameters for filters
    $tickets->withPath(url('/dashboard/tickets')  . '?' . http_build_query($request->except('page')));

    return $tickets;
  }

  /**
   * Get the list of statuses to filter tickets by.
   *
   * Returns all statuses if `null` or 'all' is passed, otherwise returns the specific status.
   *
   * @param string|null $status The status to filter by.
   * @return array List of statuses.
   */
  private function getStatusTickets(string|null $status): array
  {
    return (is_null($status) || $status == 'all') ? ['pending', 'wait_support', 'wait_user', 'solved', 'close_support', 'close_user'] : [$status];
  }

  /**
   * Show the form for creating a new ticket.
   *
   * This method returns the view to create a new ticket.
   *
   * @return Illuminate\Contracts\View\View The view for creating a new ticket.
   */
  public function create(): View
  {
    return view('pages.dashboard.tickets.create');
  }

  /**
   * Store a newly created ticket in the database.
   *
   * This method validates and stores a new ticket. It also handles uploading
   * any attachments, generates a unique ticket request ID, and broadcasts an
   * event for the new ticket.
   *
   * @param \App\Http\Requests\Dashboard\TicketRequest $request The validated request containing ticket data.
   * @return \Illuminate\Http\RedirectResponse A redirect to the ticket details page with a success notification.
   */
  public function store(TicketRequest $request): RedirectResponse
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
    broadcast(new NewTicketNotificationBroadcast($ticket->request_id))->toOthers();

    return redirect()->route('dashboard.tickets.show', ['ticket' => $ticket->request_id])->with([
      'notification' => [
        'type' => 'success',
        'message' => 'The ticket has been created successfully, you will be replied as soon as possible',
      ],
    ]);
  }

  /**
   * Show a specific ticket and its messages.
   *
   * This method retrieves a ticket based on the provided `requestID`. It also
   * fetches the associated user and messages. If the ticket is not found or the
   * user does not have permission to view it, a 403 error is returned. 
   * Once the ticket is loaded, the method updates all unread messages as read.
   * Finally, the ticket is passed to the view.
   *
   * @param string $requestID The unique request ID of the ticket.
   * @return \Illuminate\View\View|\Illuminate\Http\Response The view with the ticket details or an error response.
   * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the ticket is not found.
   * @throws \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException If the user does not have permission to view the ticket.
   */
  public function show($requestID)
  {
    $ticket = Ticket::with([
      'user:id,name,photo',
      'messages:ticket_id,user_id,message,created_at'
    ])
      ->where('request_id', $requestID)->firstOrFail();
    if ($ticket->user_id !== Auth::id() && !Auth::user()->hasPermissionTo('support')) {
      return abort(403);
    }

    $allowSendMessage = in_array($ticket->status->value, ['pending', 'wait_user', 'wait_supprot']);

    $this->updateAllMessageAsReaded($ticket);
    return view('pages.dashboard.tickets.show', compact('ticket', 'allowSendMessage'));
  }

  /**
   * Mark all unread messages for a ticket as read.
   *
   * This private method updates the `read_at` field for all unread messages
   * associated with the provided ticket. If the message is already read (i.e., 
   * `read_at` is not null), it will not be updated.
   *
   * @param \App\Models\Ticket $ticket The ticket whose messages will be updated.
   * @return void
   */
  private function updateAllMessageAsReaded($ticket)
  {
    $ticket->messages()->where('user_id', Auth::id())
      ->whereNull('read_at')->update([
        'read_at' => now()
      ]);
  }

  /**
   * Upload an attachment file for a ticket.
   *
   * This method handles the uploading of files attached to a ticket. It checks
   * the file type and calls appropriate methods to store the file as an image 
   * or video.
   *
   * @param \Illuminate\Http\UploadedFile $file The uploaded file to be stored.
   * @return string The file path of the uploaded attachment.
   */
  private function uploadAttachmentFile($file): string
  {
    $extension = $file->getClientOriginalExtension();
    if (in_array($extension, ['png', 'jpg', 'jpeg', 'webp', 'pdf', 'word'])) {
      return static::uploadAttachment($file, 'tickets', 'image');
    } else {
      return static::uploadVideo($file, 'tickets', 'video');
    }
  }

  /**
   * Generate a unique request ID for the ticket.
   *
   * This method generates a unique ticket request ID by combining the current
   * timestamp and the user's ID.
   *
   * @return string The generated request ID.
   */
  private function generatorRequestID()
  {
    return time() . '-' . Auth::id();
  }

  /**
   * Submit a review (rating and feedback) for a ticket.
   *
   * This method validates the rating and content, checks that the logged-in user
   * is the owner of the ticket, and updates the ticket with the review. A success
   * notification is displayed once the review is submitted.
   *
   * @param \Illuminate\Http\Request $request The request containing the rating and feedback.
   * @return \Illuminate\Http\RedirectResponse A redirect to the ticket index page with a success notification.
   * @throws \Symfony\Component\HttpKernel\Exception\HttpException If the user does not own the ticket.
   */
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
