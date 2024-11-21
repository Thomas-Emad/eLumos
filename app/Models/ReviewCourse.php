<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Observers\Dashboard\ReviewCoursesObserver;

#[ObservedBy([ReviewCoursesObserver::class])]
class ReviewCourse extends Model
{
  protected $fillable = [
    'user_id',
    'course_id',
    'rate',
    'content'
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }
}
