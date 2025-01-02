<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{

  protected $fillable = [
    'request_id',
    'user_id',
    'subject',
    'description',
    'attachments',
    'type',
    'status',
    'priority',
    'rate',
    'feedback',
    'completed_at'
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }
  public function messages(): HasMany
  {
    return $this->hasMany(TicketMessage::class);
  }
}
