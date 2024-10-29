<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseLectures extends Model
{
  use HasFactory;

  protected $fillable = [
    'course_id',
    'title',
    'content',
    'video',
    'video_duration',
    'order_sort'
  ];

  public function exam(): HasOne
  {
    return $this->hasOne(ExamCourseLecture::class, 'lecture_id', 'id');
  }
  public function examStudent(): HasMany
  {
    return $this->hasMany(StudentCourseExam::class, 'lecture_id', 'id');
  }

  public function attachments(): HasMany
  {
    return $this->hasMany(CourseLectureAttachment::class, 'lecture_id', 'id');
  }

  public function course(): BelongsTo
  {
    return $this->belongsTo(Course::class, 'course_id', 'id');
  }
  public function section(): BelongsTo
  {
    return $this->belongsTo(CourseSections::class, 'section_id', 'id');
  }

  public function watchedLecture()
  {
    return $this->hasOne(WatchedCourseLecture::class, 'lecture_id', 'id');
  }
}
