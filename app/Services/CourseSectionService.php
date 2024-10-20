<?php

namespace App\Services;

use App\Models\Course;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CourseSectionService
{
  /**
   * Create a new class instance.
   */
  public function __construct()
  {
    //
  }


  /**
   * Changes the sort order of a section.
   *
   * @param Course $course the course the section belongs to.
   * @param bool $up if true, move the section up. Otherwise, move it down.
   * @param array $sections the sorted array of sections.
   * @param CourseSection $currentSection the current section.
   */
  public function changeSortOrder(Course $course, $up, $sections, $currentSection): void
  {
    if ($up) {
      $previous = collect($sections)->where('order_sort', $currentSection->order_sort - 1)->firstOrFail();
      $course->changeSortOrderSection($currentSection->id, true); //  order_sort - 1 for every section
      $course->changeSortOrderSection($previous->id, false); //  Switch
    } else {
      $next =  collect($sections)->where('order_sort', $currentSection->order_sort + 1)->first();
      $course->changeSortOrderSection($currentSection->id, false); //  order_sort + 1 for every section
      $course->changeSortOrderSection($next->id, true); //  Switch
    }
  }

  /**
   * Deletes all videos of lectures of a section.
   *
   * @param  \Illuminate\Database\Eloquent\Collection  $lectures
   * @return void
   */
  public function deleteAllVideo($lectures): void
  {
    // delete videos Lectures of this section
    foreach ($lectures as $lecture) {
      if ($lecture->video) Cloudinary::destroy(json_decode($lecture->video)->public_id, ['resource_type' => 'video']);
    }
  }
}
