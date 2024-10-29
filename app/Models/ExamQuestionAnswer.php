<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ExamQuestionAnswer extends Model
{
  use HasFactory;

  protected $fillable = [
    'exam_id', 'question_id', 'type_question', 'answer', 'is_true'
  ];

  public function answerStudent(): HasOne
  {
    return $this->hasOne(StudentCourseExamAnswer::class, 'answer_id', 'id');
  }
}
