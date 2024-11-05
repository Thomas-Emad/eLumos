<?php

namespace App\Actions;

use App\Models\ReviewCourse;

class StatisticsRateCourseAction
{
  public function getStatistics(string $courseId)
  {
    $rates = ReviewCourse::where("course_id", $courseId)->get(['id', 'rate']);
    $totalCountRates = $rates->count() > 0 ? $rates->count() : 1;
    $result = [];
    for ($i = 5; $i >= 1; $i--) {
      $result[] =
        [
          'rate' => $i,
          'count' => $rates->where('rate', $i)->count(),
          'progress' => ($rates->where('rate', $i)->count() / $totalCountRates) * 100
        ];
    }

    return $result;
  }
}
