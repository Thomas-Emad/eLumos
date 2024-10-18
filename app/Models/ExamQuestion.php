<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamQuestion extends Model
{
  use HasFactory;

  protected $fillable = [
    'exam_id', 'title', 'type_question'
  ];

  public function answers(): HasMany
  {
    return $this->hasMany(ExamQuestionAnswer::class, 'question_id', 'id');
  }
}
