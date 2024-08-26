<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
  use HasFactory, SoftDeletes, HasUuids;

  protected $fillable = [
    'title',
    'headline',
    'description',
    'image',
    'preview_video',
    'language_id',
    'price',
    'learn',
    'requirements',
    'status',
    'level',
    'user_id',
  ];


  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }
  public function sections(): HasMany
  {
    return $this->hasMany(CourseSections::class, 'course_id', 'id');
  }


  public function changeSortOrderSection(int $section_id, bool $up = true)
  {
    $section = $this->sections()->findOrFail($section_id);
    if ($up) {
      if ($section->order_sort > 1) {
        $section->decrement('order_sort', 1);
      }
    } else {
      $section->increment('order_sort', 1);
    }
    return $this;
  }
}
