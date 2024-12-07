<?php

namespace App\Observers\Dashboard;

use App\Models\Course;
use App\Models\User;
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
    Cache::forget("courses.draft." . $course->user_id);

    Notification::send(User::find($course->user_id), new CourseInstructorNotification($course));
  }

  /**
   * Handle the Course "updated" event.
   */
  public function updated(Course $course): void
  {
    Cache::forget("courses.pending." . $course->user_id);
    Cache::forget("courses.published." . $course->user_id);
    Cache::forget("courses.draft." . $course->user_id);

    // send notifications:
    if ($course->status != 'draft') {
      Notification::send(User::find($course->user_id), new CourseInstructorNotification($course));
    }
  }

  /**
   * Handle the Course "deleted" event.
   */
  public function deleted(Course $course): void
  {
    Cache::forget("courses.pending." . $course->user_id);
    Cache::forget("courses.published." . $course->user_id);
    Cache::forget("courses.draft." . $course->user_id);

    Notification::send(User::find($course->user_id), new CourseInstructorNotification($course));
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
