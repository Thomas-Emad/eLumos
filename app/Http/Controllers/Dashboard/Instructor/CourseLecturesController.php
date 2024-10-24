<?php

namespace App\Http\Controllers\Dashboard\Instructor;

use App\Models\Course;
use App\Models\CourseLectures;
use App\Services\CourseLectureService;
use App\Http\Controllers\Controller;
use App\Http\Traits\UploadAttachmentTrait;
use App\Http\Traits\UpdateStepsStatusTrait;
use App\Http\Requests\CourseLectureRequest;
use App\Http\Resources\SectionsCourseResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;


class CourseLecturesController extends Controller
{
  use UploadAttachmentTrait, UpdateStepsStatusTrait;

  /**
   * Store a newly created resource in storage.
   */
  public function store(CourseLectureRequest $request, CourseLectureService $lectureService): JsonResponse
  {
    try {
      $section = $request->section();

      // upload video
      if ($request->hasFile('video')) {
        $videoJson = static::uploadVideo($request->file('video'), 'videos', 'video');
      }

      // Store data
      $lecture =  $section->lectures()->create([
        'course_id' => $section->course_id,
        'title' => $request->title,
        'video' => $videoJson ?? null,
        'video_duration' => isset($videoJson) ? json_decode($videoJson)->duration : null,
        'content' => $request->content ?? null,
        'order_sort' => $section->lectures()->count() + 1
      ]);

      $lectureService->syncExam($lecture->exam, $request->exam, $lecture);

      if ($section->lectures()->count() === 3) {
        static::updateStepsStatusWithIncrementStep('stepFour', $section->course);
      }

      return response()->json([
        'section' => new SectionsCourseResource($section->get()->last()),
        'notification' => [
          'type' => 'success',
          'message' => 'Lecture Added Successfully.'
        ]
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'notification' => [
          'type' => 'fail',
          'message' => 'Something Went Wrong.' . $e->getMessage()
        ]
      ], 400);
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(string $lecture_id = null): JsonResponse
  {
    $lecture = CourseLectures::with('exam')->findOrFail($lecture_id);
    return response()->json([
      'id' => $lecture->id,
      'title' => $lecture->title,
      'content' => $lecture->content,
      'exam' => $lecture->exam->exam_id ?? null,
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(CourseLectureRequest $request, CourseLectureService $lectureService): JsonResponse
  {
    $lecture = CourseLectures::findOrFail($request->id);

    // upload video
    $videoJson = $lectureService->updateVideo($request->file('video'), $lecture->video);

    // Update data
    $lecture->update([
      'title' => $request->title,
      'video' => $videoJson ?? null,
      'video_duration' => json_decode($videoJson)->duration ?? null,
      'content' => $request->content ?? null,
    ]);

    $lectureService->syncExam($lecture->exam, $request->exam, $lecture);

    return response()->json([
      'section' => new SectionsCourseResource($lecture->section->get()->first()),
      'notification' => [
        'type' => 'success',
        'message' => "Lecture Has Been Updated Successfully."
      ]
    ]);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Request $request, CourseLectureService $lectureService): JsonResponse
  {
    try {
      $course = Course::findOrFail($request->course_id);
      $lectures = $course->lectures()->get();
      $currentLecture = $lectures->where('id', $request->lecture_id)->first();

      if ($currentLecture->video) {
        Cloudinary::destroy(json_decode($currentLecture->video)->public_id, ['resource_type' => 'video']);
      }
      $currentLecture->delete();

      $lectureService->changeOrderLecture($course, $lectures, $request->lecture_id);

      return response()->json([
        'message' => 'Deleted Lecture Has Been Done Successfully.',
        'lecture_id' => $currentLecture->id,
        'section_id' => $currentLecture->section_id
      ], 200);
    } catch (\Throwable $e) {
      return response()->json([
        'message' => $e->getMessage()
      ], 500);
    }
  }
}
