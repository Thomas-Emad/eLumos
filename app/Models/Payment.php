<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
