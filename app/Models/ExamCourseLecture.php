<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamCourseLecture extends Model
{
  use HasFactory;

  protected $fillable = [
    'exam_id', 'course_id', 'lecture_id'
  ];
}
