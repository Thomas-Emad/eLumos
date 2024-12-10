<?php

namespace App\Models;

use App\Observers\PaymentObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[ObservedBy([PaymentObserver::class])]
class Payment extends Model
{
  protected $fillable = [
    'user_id',
    'order_id',
    'amount',
    'payment_provider',
    'payment_method',
    'currency',
    'status',
    'transaction_id',
    'transaction_details',
    'payment_date'
  ];

  public function order(): HasOne
  {
    return $this->hasOne(Order::class, 'id', 'order_id');
  }
  public function items(): HasMany
  {
    return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
  }
}
