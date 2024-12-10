<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
  protected $fillable = [
    'user_id',
    'amount',
    'discount',
    'amount_use_wallet',
    'status',
  ];


  public function items(): HasMany
  {
    return $this->hasMany(OrderItem::class);
  }
}
