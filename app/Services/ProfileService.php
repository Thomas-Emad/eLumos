<?php

namespace App\Services;

class ProfileService
{
  /**
   * Create a new class instance.
   */
  public function __construct()
  {
    //
  }

  public function formatInstructor($instructor)
  {
    // Initialize counters
    $totalLectureTime = 0;
    $totalStudents = 0;
    $totalLectures = 0;
    $totalReviewsCount = 0;
    $totalRate = 0;

    foreach ($instructor->courses as $course) {
      $totalLectureTime += $course->lectures->sum('video_duration');
      $totalStudents +=  !is_null($course->enrolleds) ? $course->enrolleds->count() : 0;
      $totalLectures += !is_null($course->lectures) ? $course->lectures->count() : 0;

      // Add up reviews count and rating for each course
      $totalReviewsCount += $course->totalReviews;
      $totalRate += $course->totalRate;
    }

    // Calculate average rating for the instructor
    $averageRating = $totalReviewsCount > 0 ? $totalRate / $totalReviewsCount : 0;

    // Return formatted instructor data
    return (object) [
      'id' =>  $instructor->id,
      'name' => $instructor->name,
      'email' => $instructor->email,
      'username' => $instructor->username,
      'headline' => $instructor->headline,
      'photo' => asset('storage/' . $instructor->photo),
      'description' => $instructor->description ?? 'There is No Description here..',
      'created_at' => $instructor->created_at,
      'email_verified_at' => $instructor->email_verified_at,
      'countCourses' => $instructor->courses->count(),
      'timeLectures' => explainSecondsToHumans($totalLectureTime),
      'countLectures' => $totalLectures,
      'totalStudents' => $totalStudents,
      'rateInstructor' =>  $averageRating
    ];
  }
}
