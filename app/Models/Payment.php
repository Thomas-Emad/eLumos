<?php

namespace App\Models;

use App\Observers\PaymentObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

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
}
