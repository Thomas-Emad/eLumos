<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Observers\Dashboard\CoursesEnrolledCheckoutObserver;

#[ObservedBy(CoursesEnrolledCheckoutObserver::class)]
class CoursesEnrolled extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'course_id',
    'progress_lectures',
    'certificate_id',
    'status',
    'buyer_at',
    'completed_at'
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }

  public function course(): BelongsTo
  {
    return $this->belongsTo(Course::class, 'course_id', 'id');
  }
  public function lectures(): HasMany
  {
    return $this->hasMany(CourseLectures::class, 'course_id', 'id');
  }

  public function reviews(): HasMany
  {
    return $this->hasMany(ReviewCourse::class, 'course_id', 'course_id');
  }
}
