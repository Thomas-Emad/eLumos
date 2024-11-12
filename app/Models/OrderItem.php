<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
  protected $fillable = [
    'order_id',
    'course_id'
  ];
}
