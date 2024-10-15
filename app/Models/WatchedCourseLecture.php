<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WatchedCourseLecture extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'course_id',
    'lecture_id',
  ];

  public function lecture(): BelongsTo
  {
    return $this->belongsTo(CourseLectures::class, 'lecture_id', 'id');
  }
}
