<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudentCourseExam extends Model
{
  use HasFactory, HasUuids;

  protected $fillable = [
    'lecture_id',
    'exam_id',
    'user_id',
    'degree',
    'total_degree',
    'status',
  ];

  public function lecture(): BelongsTo
  {
    return $this->belongsTo(CourseLectures::class, 'lecture_id', 'id');
  }

  public function exam(): BelongsTo
  {
    return $this->belongsTo(Exam::class, 'exam_id', 'id');
  }


  public function answerStudent(): HasMany
  {
    return $this->hasMany(StudentCourseExamAnswer::class, 'std_course_exam_id', 'id');
  }
}
