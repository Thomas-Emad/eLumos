<?php

namespace App\Observers\Dashboard;

use App\Models\Course;
use Illuminate\Support\Facades\Cache;

class CoursesObserver
{
  /**
   * Handle the Course "created" event.
   */
  public function created(Course $course): void
  {
    Cache::forget("courses.draft");
  }

  /**
   * Handle the Course "updated" event.
   */
  public function updated(Course $course): void
  {
    Cache::forget("courses.draft");
  }

  /**
   * Handle the Course "deleted" event.
   */
  public function deleted(Course $course): void
  {
    Cache::forget("courses.draft");
  }

  /**
   * Handle the Course "restored" event.
   */
  public function restored(Course $course): void
  {
    //
  }

  /**
   * Handle the Course "force deleted" event.
   */
  public function forceDeleted(Course $course): void
  {
    //
  }
}