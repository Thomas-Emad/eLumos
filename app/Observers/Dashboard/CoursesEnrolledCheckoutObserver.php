<?php

namespace App\Observers\Dashboard;

use App\Models\CoursesEnrolled;
use Illuminate\Support\Facades\Cache;

class CoursesEnrolledCheckoutObserver
{
  /**
   * Handle the Course "created" event.
   */
  public function created(CoursesEnrolled $course): void
  {
    Cache::forget("courses.preview.all." . auth()->id());
    Cache::forget("courses.preview.active." . auth()->id());
  }

  /**
   * Handle the Course "updated" event.
   */
  public function updated(CoursesEnrolled $course): void
  {
    Cache::forget("courses.preview.active." . auth()->id());
    Cache::forget("courses.preview.completed." . auth()->id());
  }
}
