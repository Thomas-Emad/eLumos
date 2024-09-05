<?php

namespace App\Http\Controllers;

use App\Models\CourseSections;
use Illuminate\Http\Request;
use App\Http\Resources\SectionsCourseResource;
use Yaza\LaravelGoogleDriveStorage\Gdrive;
use App\Classes\GoogleDriveService;

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
  public function store(Request $request)
  {
    $request->validate([
      'section_id' => ['required', 'exists:course_sections,id'],
      'title' => ['required', 'min:5', 'max:50'],
      'content' => ['nullable', 'max:5000', 'string'],
      'video' => ['nullable', 'max:40000'],
    ]);

    $section = CourseSections::findOrFail($request->section_id);

    if ($section->lectures()->count() < 10) {

      // upload video
      if ($request->hasFile('video')) {
        $video_id = (GoogleDriveService::uploadFile($request->file('video'), 'resumable'))->id;
      }

      // Store data
      $section->lectures()->create([
        'course_id' => $section->course_id,
        'title' => $request->title,
        'video_id' => $video_id ?? null,
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
  }

  public function uploadVideo(Request $request)
  {
    $request->validate([
      'section_id' => ['required', 'exists:course_sections,id'],
      'video' => ['required', 'max:40000'],
    ]);

    $video_id = (GoogleDriveService::uploadFile($request->file('video')))->id;

    return $video_id;
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
