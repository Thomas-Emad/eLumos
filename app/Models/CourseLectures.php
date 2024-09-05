<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourseLectures extends Model
{
  use HasFactory;

  protected $fillable = [
    'course_id',
    'title',
    'content',
    'video_id',
    'order_sort'
  ];

  public function attachments(): HasMany
  {
    return $this->hasMany(CourseLectureAttachment::class, 'lecture_id', 'id');
  }
}
