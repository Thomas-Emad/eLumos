<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Basket extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'user_id',
    'course_id'
  ];

  public function courses(): BelongsTo
  {
    return $this->belongsTo(Course::class, 'course_id', 'id');
  }
}
