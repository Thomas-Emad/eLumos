<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\{StatusTicketEnum, PriorityTicketEnum};

class TicketLog extends Model
{
  protected $fillable = [
    'user_id',
    'ticket_id',
    'status',
    'priority',
    'reason'
  ];


  public function ticket(): BelongsTo
  {
    return $this->belongsTo(Ticket::class);
  }

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class, 'user_id');
  }


  protected function casts(): array
  {
    return [
      'status' => StatusTicketEnum::class,
      'priority' => PriorityTicketEnum::class
    ];
  }
}
