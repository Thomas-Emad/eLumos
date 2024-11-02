<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentCourseExamAnswer extends Model
{
  use HasFactory;

  protected $fillable = [
    'std_course_exam_id',
    'question_id',
    'answer_id',
    'is_true',
    'content',
  ];

  public function sessionStudent(): BelongsTo
  {
    return $this->belongsTo(StudentCourseExam::class, 'std_course_exam_id', 'id');
  }
  public function question(): BelongsTo
  {
    return $this->belongsTo(ExamQuestion::class, 'question_id', 'id');
  }
}
