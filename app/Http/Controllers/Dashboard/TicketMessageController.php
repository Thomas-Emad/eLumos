<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\PusherBroadcast;
use App\Http\Controllers\Controller;
use App\Models\TicketMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;

class TicketMessageController extends Controller
{
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

      // Broadcast the event
      broadcast(new PusherBroadcast($validated['ticket_id'], $message->id))->toOthers();

      // Return the rendered view for the message
      return response()->json([
        'view' => view('pages.dashboard.tickets.partials.right-message', compact('message'))->render()
      ]);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Failed to send message.'], 500);
    }
  }

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
