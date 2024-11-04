<?php

namespace App\Services;

use App\Models\CoursesEnrolled;
use App\Models\CourseLectures;
use Illuminate\Support\Str;


class CoursesEnrolledService
{
  /**
   * Create a new class instance.
   */
  public function __construct()
  {
    //
  }


  /**
   * Get the course enrolled for the current user.
   *
   * @param \App\Models\Course $course
   *
   * @return \App\Models\CoursesEnrolled
   */
  public function getCourseEnrolled($course): CoursesEnrolled
  {
    $courseStudent = CoursesEnrolled::with([
      'course:id,title,mockup',
      'course.reviews:course_id,user_id,rate,content',
      'course.sections:id,course_id,title',
      'course.sections.lectures:id,course_id,section_id,title,video,video_duration,content,order_sort',
      'course.sections.lectures.exam:id,course_id,lecture_id,exam_id',
      'course.sections.lectures.examStudent:id,lecture_id,exam_id,status',
      'course.sections.lectures.watchedLecture' => function ($query) {
        $query->where('user_id', auth()->user()->id);
      }
    ])->where("course_id", $course)->where('user_id', auth()->user()->id)
      ->select('course_id')->firstOrFail();

    return $courseStudent;
  }

  /**
   * Retrieves the current lecture based on the provided lecture ID or defaults to the first lecture.
   *
   * Iterates through the sections of the enrolled course to find the lecture
   * corresponding to the given lecture ID. If no lecture ID is provided, it returns
   * the first lecture of the first section.
   *
   * @param  \App\Models\CoursesEnrolled  $courseStudent  The enrolled course instance containing sections and lectures.
   * @param  int|null  $currentLectureId  The ID of the current lecture to find. If null, defaults to the first lecture.
   * @return \App\Models\CourseLectures  The current lecture instance.
   */
  public function getCurrentLectureFromAll($courseStudent, $currentLectureId = null): CourseLectures
  {
    foreach ($courseStudent->course->sections as $section) {
      if (!is_null($currentLectureId)) {
        $indexCurrent = $section->lectures->search(function ($lecture) use ($currentLectureId) {
          return $lecture->id == $currentLectureId;
        });

        if ($indexCurrent !== false) {
          $currentLecture =  $section->lectures[$indexCurrent];
        }
      } else {
        $currentLecture =  $section->lectures[0];
        break;
      }
    }

    return $currentLecture;
  }
  /**
   * Gets the next lecture after the current one from all lectures in the course.
   *
   * @param  \App\Models\CoursesEnrolled  $courseStudent
   * @param  int  $currentLectureId
   * @return \App\Models\CourseLectures|null
   */
  public function getNextLectureFromAll($courseStudent, $currentLectureId): CourseLectures|null
  {
    $nextLecture = null;
    foreach ($courseStudent->course->sections as $section) {
      $indexCurrent = $section->lectures->search(function ($lecture) use ($currentLectureId) {
        return $lecture->id == $currentLectureId;
      });

      if ($indexCurrent !== false && $indexCurrent < $section->lectures->count() - 1) {
        $nextLecture =  $section->lectures[$indexCurrent + 1];
      }
    }

    return $nextLecture;
  }

  /**
   * Calculates the time out in seconds for watching a lecture. The time out is a combination of
   * two values: the time it takes to read the content of the lecture, and half the duration of the
   * video. The time it takes to read the content is calculated by dividing the number of words in
   * the content by 300 (assuming a reading speed of 300 words per minute), and then multiplying
   * the result by 10 (to convert minutes to seconds). The half video duration is calculated by
   * dividing the video duration by 2.
   *
   * @param  \App\Models\CourseLectures  $lecture
   * @return int
   */
  public function setTimeOutForWatchLecture($lecture): int
  {
    // Calc Count Words in content field for time out reading
    $timeoutReading = !is_null($lecture->content) ?  round(Str::wordCount($lecture->content) / 300) * 10 : 0;
    $timeoutVideoInHalf = !is_null($lecture->video_duration) ?  round($lecture->video_duration / 2) : 0;
    return $timeoutReading + $timeoutVideoInHalf;
  }
}
