<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wishlist extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'user_id',
    'course_id'
  ];


  public function course(): BelongsTo
  {
    return $this->belongsTo(Course::class, 'course_id', 'id');
  }
}
