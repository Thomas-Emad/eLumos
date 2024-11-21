<?php

namespace App\Observers\Dashboard;

use App\Models\Course;
use App\Models\ReviewCourse;

class ReviewCoursesObserver
{
  /**
   * Handle the Course "created" event.
   */
  public function created(ReviewCourse $review): void
  {
    $this->updateRating($review->course_id);
  }

  /**
   * Handle the Course "updated" event.
   */
  public function updated(ReviewCourse $review): void
  {
    $this->updateRating($review->course_id);
  }

  /**
   * Update the rating of a course after a review has been added or updated
   *
   * @param string $courseId The ID of the course to update
   *
   * @return void
   */
  private function updateRating(string $courseId): void
  {
    $course = Course::with('reviews')->findOrFail($courseId);

    $countUsers = $course->reviews->count();
    $totalUsers = $countUsers !== 0 ? $countUsers : 1;
    $averageRating = $course->reviews->sum('rate') / $totalUsers;

    $course->update([
      'rate' => round($averageRating),
      'average_rating' => $averageRating,
    ]);
  }
}
