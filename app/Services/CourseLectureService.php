<?php

namespace App\Services;

use App\Http\Traits\UploadAttachmentTrait;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CourseLectureService
{
  use UploadAttachmentTrait;

  /**
   * Sync exam for a lecture.
   *
   * @param  \App\Models\ExamCourseLecture|null  $oldExam
   * @param  int|null  $newExamId
   * @param  \App\Models\CourseLectures  $lecture
   * @return void
   */
  public function syncExam($oldExam, $newExamId, $lecture): void
  {
    $content = [
      'exam_id' => $newExamId,
      'course_id' => $lecture->course_id,
      'lecture_id' => $lecture->id
    ];

    if (!is_null($oldExam) && is_null($newExamId)) {
      $oldExam->delete();
    } elseif (!is_null($newExamId)) {
      if (!is_null($oldExam)) {
        $oldExam->update($content);
      } else {
        $lecture->exam()->create($content);
      }
    }
  }

  /**
   * Update the video for a lecture.
   *
   * If $newVideo is not null, it will be uploaded to Cloudinary and the old video will be deleted.
   * If $newVideo is null, the old video will be kept.
   *
   * @param  \Illuminate\Http\UploadedFile|null  $newVideo
   * @param  string|null  $oldVideo
   * @return string|null
   */
  public function updateVideo($newVideo, $oldVideo)
  {
    if (!is_null($newVideo)) {
      // Check if $oldVideo is not null and has a valid structure
      if (!empty($oldVideo)) {
        $oldVideoData = json_decode($oldVideo);
        if ($oldVideoData && isset($oldVideoData->public_id)) {
          Cloudinary::destroy($oldVideoData->public_id, ['resource_type' => 'video']);
        }
      }

      $videoJson = static::uploadVideo($newVideo, 'videos', 'video');
    } else {
      $videoJson = $oldVideo ?? null;
    }

    return $videoJson;
  }

  /**
   * Decreases the order_sort by 1 for all lectures except the one specified by $lectureId.
   *
   * @param mixed $course The course object.
   * @param array $lectures The array of lectures to update the order_sort.
   * @param int $lectureId The ID of the lecture to exclude from the update.
   */
  public function changeOrderLecture($course, $lectures, $lectureId)
  {
    // Change Order Sort => order_sort - 1 for every lecture
    foreach ($lectures as $lecture) {
      if ($lecture->id == $lectureId) continue;
      $course->changeSortOrderLecture($lecture->id, true);
    }
  }
}
