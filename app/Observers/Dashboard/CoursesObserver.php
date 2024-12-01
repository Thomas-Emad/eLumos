<?php

namespace App\Observers\Dashboard;

use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Notifications\CourseInstructorNotification;
use Illuminate\Support\Facades\Notification;

class CoursesObserver
{
  /**
   * Handle the Course "created" event.
   */
  public function created(Course $course): void
  {
    Cache::forget("courses.draft." . auth()->id());
    Cache::forget("courses.published." . auth()->id());

    Notification::send(Auth::user(), new CourseInstructorNotification($course));
  }

  /**
   * Handle the Course "updated" event.
   */
  public function updated(Course $course): void
  {
    Cache::forget("courses.pending." . auth()->id());
    Cache::forget("courses.published." . auth()->id());
    Cache::forget("courses.draft." . auth()->id());

    // send notifications:
    if ($course->status == 'pending') {
      Notification::send(Auth::user(), new CourseInstructorNotification($course));
    }
  }

  /**
   * Handle the Course "deleted" event.
   */
  public function deleted(Course $course): void
  {
    Cache::forget("courses.pending." . auth()->id());
    Cache::forget("courses.published." . auth()->id());
    Cache::forget("courses.draft." . auth()->id());
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
