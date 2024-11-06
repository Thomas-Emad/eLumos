<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InstructorCourseDetailsResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    // Initialize counters
    $totalLectureTime = 0;
    $totalStudents = 0;
    $totalLectures = 0;
    $totalReviewsCount = 0;
    $totalRate = 0;

    foreach ($this->courses as $course) {
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
    return [
      'profile_user' => route("dashboard.profile", $this->id),
      'name' => $this->name,
      'headline' => $this->headline,
      'photo' => asset('storage/' . $this->photo),
      'description' => $this->description ?? '',
      'countCourses' => $this->courses->count(),
      'timeLectures' => explainSecondsToHumans($totalLectureTime),
      'countLectures' => $totalLectures,
      'totalStudents' => $totalStudents,
      'rateInstructor' =>  $averageRating
    ];
  }
}
