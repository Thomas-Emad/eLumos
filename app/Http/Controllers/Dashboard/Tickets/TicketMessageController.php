<?php

namespace App\Http\Controllers\Dashboard\Tickets;

use App\Enums\StatusTicketEnum;
use App\Events\MessageTicketBroadcast;
use App\Http\Controllers\Controller;
use App\Models\{Ticket, TicketMessage};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketMessageController extends Controller
{
  /**
   * Broadcast a new message for a ticket and change its status.
   *
   * This method validates the incoming request, creates a new ticket message,
   * changes the ticket status, and broadcasts the new message to other clients
   * using Laravel broadcasting. If the message is successfully created, 
   * the rendered view for the message is returned.
   *
   * @param \Illuminate\Http\Request $request The request containing the ticket message data.
   * @return \Illuminate\Http\JsonResponse The response with the rendered message view or an error message.
   * @throws \Illuminate\Validation\ValidationException If the request data is invalid.
   * @throws \Exception If there is an issue creating the message or broadcasting the event.
   */
  public function broadcast(Request $request)
  {
    // Validate the request to ensure data integrity
    $validated = $request->validate([
      'ticket_id' => 'required|integer|exists:tickets,id',
      'user_id' => 'required|integer|exists:users,id',
      'message' => 'required|string|max:255',
    ]);

    try {
      $message = TicketMessage::create([
        'ticket_id' => $validated['ticket_id'],
        'user_id' => $validated['user_id'],
        'message' => $validated['message'],
      ]);

      $this->changeStatusTicket($validated['ticket_id']);

      // Broadcast the event
      broadcast(new MessageTicketBroadcast($validated['ticket_id'], $message->id, $validated['user_id']))->toOthers();

      // Return the rendered view for the message
      return response()->json([
        'view' => view('pages.dashboard.tickets.partials.right-message', compact('message'))->render()
      ]);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Failed to send message.'], 500);
    }
  }

  /**
   * Change the status of the ticket based on the user's role.
   *
   * This method updates the status of the ticket based on the user sending
   * the message. If the message is sent by the ticket owner, the status 
   * will be set to `WAIT_SUPPORT`. If sent by support staff, the status 
   * will be set to `WAIT_USER`.
   *
   * @param int $id The ticket ID to update.
   * @return void
   */
  private function changeStatusTicket($id): void
  {
    $ticket = Ticket::find($id);
    $status = $ticket->user_id == Auth::id() ? StatusTicketEnum::WAIT_SUPPORT : StatusTicketEnum::WAIT_USER;
    Ticket::where('ticket_id', $id)
      ->update([
        'status' => $status
      ]);
  }

  /**
   * Retrieve a specific message for a ticket and return its rendered view.
   *
   * This method validates the incoming request, fetches the message with 
   * the provided ticket ID and message ID, and returns the rendered view 
   * for that message and mark it as readed. If the message is not found, a 404 error is returned.
   *
   * @param \Illuminate\Http\Request $request The request containing the ticket and message IDs.
   * @return \Illuminate\Http\JsonResponse The response with the rendered message view or an error message.
   * @throws \Illuminate\Validation\ValidationException If the request data is invalid.
   * @throws \Exception If there is an issue fetching the message.
   */
  public function receiver(Request $request)
  {
    // Validate the request to ensure data integrity
    $validated = $request->validate([
      'ticket_id' => 'required|integer|exists:tickets,id',
      'message_ticket_id' => 'required|integer|exists:ticket_messages,id',
    ]);

    try {
      $message = TicketMessage::where('id', $validated['message_ticket_id'])
        ->where('ticket_id', $validated['ticket_id'])->first();

      $message->update([
        'read_at' => now()
      ]);

      // Check if the message exists
      if (!$message) {
        return response()->json(['error' => 'Message not found.'], 404);
      }

      // Return the rendered view for the message
      return response()->json([
        'view' => view('pages.dashboard.tickets.partials.left-message', compact('message'))->render()
      ]);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Failed to send message.'], 500);
    }
  }
}
