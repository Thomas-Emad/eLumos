<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewCourse extends Model
{
  protected $fillable = [
    'user_id',
    'course_id',
    'rate',
    'content'
  ];
}
