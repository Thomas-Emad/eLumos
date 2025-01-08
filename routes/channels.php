<?php

use App\Models\Ticket;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('ticket.{id}', function ($user, $id) {
  return Ticket::find($id)->user_id === $user->id || $user->hasAnyPermission(['support']);
});

Broadcast::channel('ticket-notification', function ($user) {
  return $user->hasAnyPermission(['support']);
});
