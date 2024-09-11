<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\CourseSections;
use App\Models\CourseLectures;
use App\Http\Resources\SectionsCourseResource;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CourseLecturesController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request): JsonResponse
  {
    $request->validate([
      'section_id' => ['required', 'exists:course_sections,id'],
      'title' => ['required', 'min:5', 'max:50'],
      'content' => ['nullable', 'max:5000', 'string'],
      'video' => ['nullable', 'max:40000', 'mimeTypes:video/mp4'],
    ]);

    try {
      $section = CourseSections::findOrFail($request->section_id);

      if ($section->lectures()->count() < 10) {

        // upload video
        if ($request->hasFile('video')) {
          $videoJson =  $this->uploadVideo($request);
        }

        // Store data
        $section->lectures()->create([
          'course_id' => $section->course_id,
          'title' => $request->title,
          'video' => $videoJson ?? null,
          'content' => $request->content ?? null,
          'order_sort' => $section->lectures()->count() + 1
        ]);

        return response()->json([
          'section' => new SectionsCourseResource($section->get()->last()),
          'message' => 'Added Lecture Has Been Done Successfully.'
        ], 200);
      } else {
        return response()->json([
          'message' => 'You Can\'t Add More Than 10 Lectures in one Section.'
        ], 400);
      }
    } catch (\Exception $e) {
      return response()->json([
        'message' => 'Something Went Wrong.' . $e->getMessage()
      ], 400);
    }
  }

  /**
   * Uploads a video to Cloudinary and returns the public ID and secure URL of the uploaded video.
   *
   * @param Request $request The HTTP request object containing the video file to be uploaded.
   * @return string The JSON-encoded video information including the public ID and secure URL.
   */
  protected function uploadVideo(Request $request): string
  {
    $video = Cloudinary::uploadVideo($request->video->getRealPath(), [
      "asset_folder" => "videos/",
      'resource_type' => "video",
      "chunk_size" => 6000000,
    ]);
    $videoJson = [
      'public_id' => $video->getPublicId(),
      'url' => $video->getSecurePath(),
    ];

    return json_encode($videoJson);
  }

  /**
   * Display the specified resource.
   */
  public function show(string $lecture_id = null): JsonResponse
  {
    $lecture = CourseLectures::findOrFail($lecture_id);
    return response()->json([
      'title' => $lecture->title,
      'content' => $lecture->content,
      'exams' => [],
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request)
  {
    $request->validate([
      'lecture_id' => ['required', 'exists:course_lectures,id'],
      'title' => ['required', 'min:5', 'max:50'],
      'content' => ['nullable', 'max:5000', 'string'],
      'video' => ['nullable', 'max:40000', 'mimeTypes:video/mp4'],
    ]);

    try {
      $lecture = CourseLectures::findOrFail($request->lecture_id);

      // upload video
      if ($request->hasFile('video')) {
        if ($lecture->video) {
          Cloudinary::destroy($lecture->video->public_id);
        }

        $videoJson =  $this->uploadVideo($request);
      } else {
        $videoJson = $lecture->video ?? null;
      }

      // Update data
      $lecture->update([
        'title' => $request->title,
        'video' => $videoJson ?? null,
        'content' => $request->content ?? null,
      ]);


      return response()->json([
        'section' => new SectionsCourseResource($lecture->section),
        'message' => 'Updated Lecture Has Been Done Successfully.'
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'message' => 'Something Went Wrong. ' . $e->getMessage()
      ], 400);
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id): JsonResponse
  {
    $lecture = CourseLectures::findOrFail($id);
    $lecture->delete();
    return response()->json([
      'message' => 'Lecture Has Been Deleted Successfully.'
    ], 200);
  }
}
