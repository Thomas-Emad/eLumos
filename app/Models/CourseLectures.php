<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseLectures extends Model
{
  use HasFactory;

  protected $fillable = [
    'course_id',
    'title',
    'content',
    'video',
    'video_duartion',
    'order_sort'
  ];

  public function attachments(): HasMany
  {
    return $this->hasMany(CourseLectureAttachment::class, 'lecture_id', 'id');
  }

  public function section(): BelongsTo
  {
    return $this->belongsTo(CourseSections::class, 'section_id', 'id');
  }
}
