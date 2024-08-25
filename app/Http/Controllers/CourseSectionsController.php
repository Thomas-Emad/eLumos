<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use  App\Http\Resources\SectionsCourseResource;

class CourseSectionsController extends Controller
{
  public function getSections(Request $request)
  {
    $course = Course::findOrFail($request->course_id)->with('sections')->first();
    return response()->json([
      'success' => true,
      'sections' => SectionsCourseResource::collection($course->sections),
    ], 200);
  }

  public function addSection(Request $request)
  {
    $request->validate([
      'course_id' => ['required', 'exists:courses,id'],
      'title' => ['required', 'max:50'],
    ]);

    $course = Course::findOrFail($request->course_id);
    $course->sections()->create([
      'title' => $request->title,
      'order_sort' => $course->sections()->count() + 1
    ]);

    return response()->json([
      'success' => true,
      'section' => [
        new SectionsCourseResource($course->sections()->get()->last()),
      ],
      'message' => 'Added Section Has Been Done Successfully.'
    ], 200);
  }
}
