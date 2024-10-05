<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Basket extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'course_id'
  ];

  public function courses(): BelongsTo
  {
    return $this->belongsTo(Course::class, 'course_id', 'id');
  }
}
