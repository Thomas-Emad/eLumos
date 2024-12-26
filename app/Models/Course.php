<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Observers\Dashboard\CoursesObserver;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
    'category_id',
    'language_id',
    'price',
    'learn',
    'requirements',
    'steps',
    'steps_status',
    'status',
    'level',
    'message',
    'rate',
    'average_rating'
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

  public function changeSortOrderLecture(int $lecture_id, bool $up = true)
  {
    $lecture = $this->lectures()->findOrFail($lecture_id);
    if ($up) {
      if ($lecture->order_sort > 1) {
        $lecture->decrement('order_sort', 1);
      }
    } else {
      $lecture->increment('order_sort', 1);
    }
    return $this;
  }

  public function tags(): BelongsToMany
  {
    return $this->BelongsToMany(Tag::class, "course_tags", 'course_id', 'tag_id');
  }

  public function category(): BelongsTo
  {
    return $this->BelongsTo(Tag::class, 'category_id', 'id');
  }


  public function wishlist(): HasMany
  {
    return $this->hasMany(Wishlist::class, 'course_id', 'id')->withTrashed();
  }

  public function enrolleds(): HasMany
  {
    return $this->hasMany(CoursesEnrolled::class);
  }
  public function reviews(): HasMany
  {
    return $this->hasMany(ReviewCourse::class);
  }

  /* Orders */
  public function orderItems(): HasMany
  {
    return $this->hasMany(OrderItem::class);
  }

  public function logs(): HasMany
  {
    return $this->hasMany(CourseReviewLog::class, 'course_id', 'id');
  }

  /*  Scopes  */
  public function scopeSearch(Builder $query, $search)
  {
    if ($search) {
      return $query->where('title', 'like', "%$search%");
    }
    return $query;
  }
  public function scopePrice(Builder $query, bool $statusPaid, bool $statusFree)
  {
    if ($statusPaid && $statusFree) {
      return $query;
    } elseif ($statusPaid) {
      return $query->where('price', ">", "0");
    } elseif ($statusFree) {
      return $query->where('price', "0");
    }
  }
  public function scopeLevels(Builder $query, array $levels)
  {
    return $query->whereIn('level', $levels);
  }
  public function scopeSelectBy(Builder $query, string $select)
  {
    switch ($select) {
      case 'top-rate':
        return $query->orderBy("average_rating", "DESC");
        break;

      case 'oldest-published':
        return $query->orderBy('preview_at', 'ASC');
        break;

      case 'new-published':
        return $query->orderBy('preview_at', 'DESC');
        break;

      case 'high-price':
        return $query->orderBy('price', 'DESC');
        break;

      case 'low-price':
        return $query->orderBy('price', 'ASC');
        break;
    }
  }
}
