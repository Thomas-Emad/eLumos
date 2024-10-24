<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
}
