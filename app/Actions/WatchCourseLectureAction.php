<?php

namespace App\Actions;

use Illuminate\Support\Facades\Auth;
use App\Models\CourseLectures;

class WatchCourseLectureAction
{
  /**
   * Mark a lecture as watched by the user.
   *
   * Also updates the progress of the course by the user.
   *
   * @param int $courseId
   * @param int $lectureId
   * @return void
   */
  public function markupLecture($courseId, $lectureId): void
  {
    $lecture = Auth::user()->watchedCourseLectures()->updateOrCreate(
      ['lecture_id' => $lectureId, 'course_id' => $courseId],
      ['lecture_id' => $lectureId, 'course_id' => $courseId, 'updated_at' => now()]
    );

    // If it's new Watch Update progress Course
    if ($lecture->created_at == $lecture->updated_at) {
      $total_lectures = CourseLectures::where('course_id', $courseId)->count();
      $progress =  (Auth::user()->watchedCourseLectures()->count() / $total_lectures) * 100;
      $progress = $progress <= 100 ? $progress : 100;

      // Update Status, Progress
      $enrolled = Auth::user()->enrolled()->where('course_id', $courseId)->first();
      if ($enrolled->progress_lectures == 0) {
        $enrolled->status = 'incomplete';
      }
      $enrolled->progress_lectures = $progress;
      $this->markupAsCompleted($enrolled, $progress);
      $enrolled->save();
    }
  }

  private function markupAsCompleted($enrolled, int $progress)
  {
    if ($progress === 100) {
      $enrolled->certificate_id = $enrolled->user_id . '-' . $enrolled->id . '-' . time();
      $enrolled->completed_at = now();
      $enrolled->status = 'completed';
      return true;
    }
    return false;
  }
}
