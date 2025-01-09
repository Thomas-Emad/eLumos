<?php

namespace App\Http\Controllers\Dashboard\Tickets;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\TicketLogRequest;
use App\Models\{Ticket, TicketLog};
use Illuminate\Http\Request;
use App\Services\TicketLogService;
use Illuminate\Http\RedirectResponse;

class TicketLogController extends Controller
{
  /**
   * Fetch and display the logs for a specific ticket.
   *
   * This method handles AJAX requests to fetch the latest 20 logs for a ticket
   * and renders the corresponding view. If the request is not AJAX, a 404 error
   * is returned.
   *
   * @param \Illuminate\Http\Request $request The request containing the ticket_id.
   * @return \Illuminate\Http\JsonResponse A JSON response containing the rendered HTML content of the logs.
   * @throws \Symfony\Component\HttpKernel\Exception\HttpException If the request is not AJAX.
   */
  public function logs(Request $request)
  {
    if (!request()->ajax()) {
      return abort(404);
    }
    $logs = TicketLog::with('user:id,name')
      ->where('ticket_id', $request->ticket_id)->latest()->take(20)->get();

    $content = view('pages.dashboard.tickets.partials.logs-history', [
      'logs' => $logs
    ])->render();

    return response()->json([
      'content' => $content
    ]);
  }

  /**
   * Change the status of a ticket and log the action.
   *
   * This method updates the status of a ticket, creates a new log entry, and sends
   * a notification to the user. After the action, it redirects to the tickets index page
   * with a success message.
   *
   * @param \App\Http\Requests\TicketLogRequest $request The request containing ticket_id, status, and reason.
   * @param \App\Services\TicketLogService $service The service used to update the ticket, create logs, and send notifications.
   * @return \Illuminate\Http\RedirectResponse A redirect response with a success message.
   */

  public function changeStatus(TicketLogRequest $request, TicketLogService $service): RedirectResponse
  {
    $ticket = Ticket::findOrFail($request->ticket_id);

    $service->updateStatusTicket($ticket, $request->status);
    $service->createNewLog($ticket, $request->status, $ticket->priority, $request->reason);
    $service->sendNotificationUser($ticket, 'This ticket has been closed.');

    return redirect()->route('dashboard.tickets.index')->with([
      'notification' => [
        'type' => 'success',
        'message' => 'This ticket has been closed successfully.',
      ],
    ]);
  }

  /**
   * Change the priority of a ticket and log the action.
   *
   * This method updates the priority of a ticket, creates a new log entry, and sends
   * a notification to the user. If the request is successful, it redirects back with
   * a success message.
   *
   * @param \App\Http\Requests\TicketLogRequest $request The request containing ticket_id, priority, and reason.
   * @param \App\Services\TicketLogService $service The service used to update the ticket, create logs, and send notifications.
   * @return \Illuminate\Http\RedirectResponse A redirect response with a success message.
   */

  public function changePriority(TicketLogRequest $request, TicketLogService $service): RedirectResponse
  {
    $ticket = Ticket::findOrFail($request->ticket_id);

    $service->updatePriorityTicket($ticket, $request->priority);
    $service->createNewLog($ticket, $ticket->status, $ticket->priority, $request->reason);
    $service->sendNotificationUser($ticket, 'This ticket has been prioritized..');

    return redirect()->back()->with([
      'notification' => [
        'type' => 'success',
        'message' => 'This ticket has been prioritized..',
      ],
    ]);
  }
}
