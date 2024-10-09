<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



class CoursesEnrolled extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id', 'course_id', 'progress_lectures', 'status', 'buyer_at'
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }

  public function course(): BelongsTo
  {
    return $this->belongsTo(Course::class, 'course_id', 'id');
  }
}
