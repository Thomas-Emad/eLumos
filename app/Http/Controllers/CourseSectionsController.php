<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Http\Resources\SectionsCourseResource;
use App\Models\CourseSections;

class CourseSectionsController extends Controller
{
  public function getSections(Request $request)
  {
    $sections = CourseSections::where('course_id', $request->course_id)->OrderBy('order_sort', 'asc')->get();
    return response()->json([
      'success' => true,
      'sections' => SectionsCourseResource::collection($sections),
    ], 200);
  }

  public function addSection(Request $request)
  {
    $request->validate([
      'course_id' => ['required', 'exists:courses,id'],
      'title' => ['required', 'min:5', 'max:50'],
    ]);

    $course = Course::findOrFail($request->course_id);
    $course->sections()->create([
      'title' => $request->title,
      'order_sort' => $course->sections()->count() + 1
    ]);

    return response()->json([
      'section' => [
        new SectionsCourseResource($course->sections()->get()->last()),
      ],
      'message' => 'Added Section Has Been Done Successfully.'
    ], 200);
  }

  public function update(Request $request)
  {
    $request->validate([
      'section_id' => ['required', 'exists:course_sections,id'],
      'course_id'  => ['required', 'exists:courses,id'],
      'title' => ['required', 'min:5', 'max:50'],
    ]);

    $section = CourseSections::where('course_id', $request->course_id)->where('id', $request->section_id)->firstOrFail();
    $section->update([
      'title' => $request->title,
    ]);

    return response()->json([
      'message' => 'Updated Section Has Been Done Successfully.',
      'section' => new SectionsCourseResource($section)
    ], 202);
  }

  public function changeSortSection(Request $request)
  {
    $request->validate([
      'section_id' => ['required', 'exists:course_sections,id'],
      'course_id'  => ['required', 'exists:courses,id'],
      'up' => ['required']
    ]);

    $up = ($request->up === 'true');
    $course = Course::findOrFail($request->course_id);
    $sections = $course->sections()->get();
    $currentSection = collect($sections)->where('id', $request->section_id)->firstOrFail();

    if ($up) {
      $previous = collect($sections)->where('order_sort', $currentSection->order_sort - 1)->firstOrFail();
      $course->changeSortOrderSection($currentSection->id, true); //  order_sort - 1 for every section
      $course->changeSortOrderSection($previous->id, false); //  Switch
    } else {
      $next =  collect($sections)->where('order_sort', $currentSection->order_sort + 1)->first();
      $course->changeSortOrderSection($currentSection->id, false); //  order_sort + 1 for every section
      $course->changeSortOrderSection($next->id, true); //  Switch
    }

    return $this->getSections($request);
  }

  public function destroy(Request $request)
  {
    $request->validate([
      'section_id' => ['required', 'exists:course_sections,id'],
      'course_id'  => ['required', 'exists:courses,id'],
    ]);

    $course = Course::findOrFail($request->course_id);
    $sections = $course->sections()->get();
    $sections->where('id', $request->section_id)->first()->delete();

    // Change Order Sort => order_sort - 1 for every section
    foreach ($sections as $section) {
      if ($section->id == $request->section_id) continue;
      $course->changeSortOrderSection($section->id, true);
    }

    return response()->json([
      'message' => 'Deleted Section Has Been Done Successfully.',
      'section_id' => $request->section_id
    ], 200);
  }
}
