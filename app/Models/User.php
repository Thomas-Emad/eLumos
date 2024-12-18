<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements MustVerifyEmail
{
  use HasFactory, Notifiable, HasRoles;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'username',
    'headline',
    'email',
    'password',
    'steps_forward',
    'photo',
    'status',
    'description',
    'media',
    'wallet',
    'oauth_id',
    'oauth_provider',
    'oauth_token'
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }

  public function tags(): BelongsToMany
  {
    return $this->belongsToMany(Tag::class, 'user_tags', 'user_id', 'tag_id');
  }

  public function courses(): HasMany
  {
    return $this->hasMany(Course::class, 'user_id');
  }

  public function wishlistWithCourses(): BelongsToMany
  {
    return $this->belongsToMany(Course::class, 'wishlists', 'user_id', 'course_id');
  }
  public function wishlist(): HasMany
  {
    return $this->hasMany(Wishlist::class, 'user_id', 'id')->withTrashed();
  }

  public function baskets(): HasMany
  {
    return $this->hasMany(Basket::class, 'user_id', 'id');
  }
  public function basketWithCourses(): BelongsToMany
  {
    return $this->belongsToMany(Course::class, 'baskets', 'user_id', 'course_id');
  }

  public function enrolledCourses(): BelongsToMany
  {
    return $this->belongsToMany(Course::class, 'courses_enrolleds');
  }
  public function enrolled(): HasMany
  {
    return $this->hasMany(CoursesEnrolled::class);
  }

  public function watchedCourseLectures(): HasMany
  {
    return $this->hasMany(WatchedCourseLecture::class, 'user_id', 'id');
  }
  public function sessionsExam(): HasMany
  {
    return $this->hasMany(StudentCourseExam::class);
  }

  public function reviews(): HasMany
  {
    return $this->hasMany(ReviewCourse::class);
  }

  public function orders(): HasMany
  {
    return $this->hasMany(Order::class);
  }
}
