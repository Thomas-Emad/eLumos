<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseReviewLog extends Model
{
  protected $fillable = [
    'course_id',
    'reviewed_by',
    'reviewed_at',
    'reason',
    'status'
  ];

  public function course()
  {
    return $this->belongsTo(Course::class);
  }
  public function reviewer()
  {
    return $this->belongsTo(User::class, 'reviewed_by', 'id');
  }
}
