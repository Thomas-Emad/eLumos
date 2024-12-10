<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
  protected $fillable = [
    'order_id',
    'course_id',
    'amount',
    'user_profit',
    'platform_profit',
    'withdraw'
  ];

  public function course(): BelongsTo
  {
    return $this->belongsTo(Course::class);
  }
}
