<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Http\Resources\SectionsCourseResource;
use App\Models\CourseSections;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CourseSectionsController extends Controller
{
  /**
   * Retrieves course sections based on the provided course ID.
   *
   * @param Request $request The HTTP request containing the course ID.
   * @return \Illuminate\Http\JsonResponse A JSON response containing the course sections.
   */
  public function index(Request $request)
  {
    $sections = CourseSections::where('course_id', $request->course_id)->OrderBy('order_sort', 'asc')->get();
    return response()->json([
      'success' => true,
      'sections' => SectionsCourseResource::collection($sections),
    ], 200);
  }

  /**
   * Adds a new section to a course based on the provided request data.
   *
   * @param Request $request The HTTP request containing the course ID and section title.
   * @return \Illuminate\Http\JsonResponse A JSON response containing the newly added section and a success message.
   */
  public function store(Request $request)
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
        new SectionsCourseResource($course->sections()->get()->last())
      ],
      'message' => 'Added Section Has Been Done Successfully.'
    ], 200);
  }

  /**
   * Updates an existing course section based on the provided request data.
   *
   * @param Request $request The HTTP request containing the course ID, section ID, and new title.
   * @return \Illuminate\Http\JsonResponse A JSON response containing the updated section and a success message.
   */
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

  /**
   * Changes the sort order of a course section.
   *
   * @param Request $request The HTTP request containing the course ID, section ID, and direction of the sort order change.
   * @return The updated sections.
   */
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

    return $this->index($request);
  }

  /**
   * Deletes a course section and updates the order sort of the remaining sections.
   *
   * @param Request $request The HTTP request containing the section ID and course ID.
   * @return \Illuminate\Http\JsonResponse A JSON response containing a success message and the deleted section ID.
   */
  public function destroy(Request $request)
  {
    $request->validate([
      'section_id' => ['required', 'exists:course_sections,id'],
      'course_id'  => ['required', 'exists:courses,id'],
    ]);

    $course = Course::findOrFail($request->course_id);
    $sections = $course->sections()->get();
    $section = $sections->where('id', $request->section_id)->first();

    // delete videos Lectures of this section
    foreach ($section->lectures as $lecture) {
      if ($lecture->video) Cloudinary::destroy(json_decode($lecture->video)->public_id, ['resource_type' => 'video']);
    }

    $section->delete();

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
