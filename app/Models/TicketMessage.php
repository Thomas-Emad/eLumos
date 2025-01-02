<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketMessage extends Model
{
  protected $fillable = [
    'ticket_id',
    'user_id',
    'message',
    'attachment',
    'reaction',
    'read_at'
  ];

  public function ticket(): BelongsTo
  {
    return $this->belongsTo(Ticket::class);
  }
}
