<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exam extends Model
{
  use HasFactory, HasUuids;

  protected $fillable = ['publisher_id', 'title', 'duration'];


  public function questions(): HasMany
  {
    return $this->hasMany(ExamQuestion::class, 'exam_id', 'id');
  }
  public function answers(): HasMany
  {
    return $this->hasMany(ExamQuestionAnswer::class, 'exam_id', 'id');
  }


  public function lectures(): hasMany
  {
    return $this->hasMany(ExamCourseLecture::class);
  }

  public function students(): hasMany
  {
    return $this->hasMany(StudentCourseExam::class);
  }
}
