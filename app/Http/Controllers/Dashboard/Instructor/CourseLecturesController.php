<?php

namespace App\Http\Controllers\Dashboard\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Traits\UploadAttachmentTrait;
use App\Http\Traits\UpdateStepsStatusTrait;
use App\Http\Resources\SectionsCourseResource;
use App\Models\Course;
use App\Models\CourseLectures;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

use App\Http\Requests\CourseLectureRequest;


class CourseLecturesController extends Controller
{
  use UploadAttachmentTrait, UpdateStepsStatusTrait;

  /**
   * Store a newly created resource in storage.
   */
  public function store(CourseLectureRequest $request)
  {
    try {
      $section = $request->section();

      // upload video
      if ($request->hasFile('video')) {
        $videoJson = static::uploadVideo($request->file('video'), 'videos', 'video');
      }

      // Store data
      $section->lectures()->create([
        'course_id' => $section->course_id,
        'title' => $request->title,
        'video' => $videoJson ?? null,
        'video_duartion' => isset($videoJson) ? json_decode($videoJson)->duration : null,
        'content' => $request->content ?? null,
        'order_sort' => $section->lectures()->count() + 1
      ]);

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
    $lecture = CourseLectures::findOrFail($lecture_id);
    return response()->json([
      'id' => $lecture->id,
      'title' => $lecture->title,
      'content' => $lecture->content,
      'exams' => [],
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(CourseLectureRequest $request)
  {
    $lecture = CourseLectures::findOrFail($request->id);

    // upload video
    if ($request->hasFile('video')) {
      if ($lecture->video) {
        Cloudinary::destroy(json_decode($lecture->video)->public_id, ['resource_type' => 'video']);
      }

      $videoJson =  static::uploadVideo($request->file('video'), 'videos', 'video');
    } else {
      $videoJson = $lecture->video ?? null;
    }

    // Update data
    $lecture->update([
      'title' => $request->title,
      'video' => $videoJson ?? null,
      'video_duartion' => json_decode($videoJson)->duration ?? null,
      'content' => $request->content ?? null,
    ]);

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
  public function destroy(Request $request): JsonResponse
  {
    try {
      $course = Course::findOrFail($request->course_id);
      $lectures = $course->lectures()->get();
      $cturrenLecture = $lectures->where('id', $request->lecture_id)->first();

      if ($cturrenLecture->video) {
        Cloudinary::destroy(json_decode($cturrenLecture->video)->public_id, ['resource_type' => 'video']);
      }
      $cturrenLecture->delete();

      // Change Order Sort => order_sort - 1 for every lecture
      foreach ($lectures as $lecture) {
        if ($lecture->id == $request->lecture_id) continue;
        $course->changeSortOrderLecture($lecture->id, true);
      }

      return response()->json([
        'message' => 'Deleted Lecture Has Been Done Successfully.',
        'lecture_id' => $lecture->id,
        'section_id' => $lecture->section_id
      ], 200);
    } catch (\Throwable $e) {
      return response()->json([
        'message' => $e->getMessage()
      ], 500);
    }
  }
}
