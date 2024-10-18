<?php

namespace App\Services;

use App\Models\Course;

class CourseSectionService
{
  /**
   * Create a new class instance.
   */
  public function __construct()
  {
    //
  }

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
}
