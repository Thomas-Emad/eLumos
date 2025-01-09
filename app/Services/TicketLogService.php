<?php

namespace App\Services;

use Illuminate\Support\Facades\Notification;
use App\Notifications\TicketSupportNotification;
use App\Models\User;

class TicketLogService
{
  /**
   * Update the status of a ticket.
   *
   * This method updates the status and the `completed_at` timestamp of a given ticket.
   *
   * @param \App\Models\Ticket $ticket The ticket to update.
   * @param string $status The new status to set.
   */
  public function updateStatusTicket($ticket, $status): void
  {
    $ticket->update([
      'status' => $status,
      'completed_at' => now()
    ]);
  }

  /**
   * Update the priority of a ticket.
   *
   * This method updates the priority and the `completed_at` timestamp of a given ticket.
   *
   * @param \App\Models\Ticket $ticket The ticket to update.
   * @param string $priority The new priority to set.
   */
  public function updatePriorityTicket($ticket, $priority): void
  {
    $ticket->update([
      'priority' => $priority,
      'completed_at' => now()
    ]);
  }

  /**
   * Create a new log entry for a ticket.
   *
   * This method logs the action performed on a ticket, such as a status or priority change,
   * and records the reason for the change.
   *
   * @param \App\Models\Ticket $ticket The ticket to log.
   * @param string $status The ticket's new status.
   * @param string $priority The ticket's new priority.
   * @param string $reason The reason for the status or priority change.
   */
  public function createNewLog($ticket, $status, $priority, $reason): void
  {
    $ticket->logs()->create([
      'user_id' => auth()->user()->id,
      'status' => $status,
      'priority' => $priority,
      'reason' => $reason
    ]);
  }

  /**
   * Send a notification to the user associated with the ticket.
   *
   * This method sends a notification to the user about the ticket's status or priority change.
   *
   * @param \App\Models\Ticket $ticket The ticket to notify the user about.
   * @param string $message The notification message to send.
   */
  public function sendNotificationUser($ticket, $message): void
  {
    Notification::send(User::find($ticket->user_id), new TicketSupportNotification(
      $ticket,
      $message
    ));
  }
}
