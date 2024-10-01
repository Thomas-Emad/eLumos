<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Observers\Dashboard\CoursesObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

use Illuminate\Contracts\Database\Eloquent\Builder;


#[ObservedBy([CoursesObserver::class])]
class Course extends Model
{
  use HasFactory, SoftDeletes, HasUuids;

  protected $fillable = [
    'user_id',
    'title',
    'headline',
    'description',
    'mockup',
    'preview_video',
    'language_id',
    'price',
    'learn',
    'requirements',
    'steps',
    'steps_status',
    'status',
    'level',
    'message'
  ];


  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }
  public function sections(): HasMany
  {
    return $this->hasMany(CourseSections::class, 'course_id', 'id');
  }
  public function lectures(): HasMany
  {
    return $this->hasMany(CourseLectures::class, 'course_id', 'id');
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

  public function tags(): BelongsToMany
  {
    return $this->BelongsToMany(Tag::class, "course_tags", 'course_id', 'tag_id');
  }
}
