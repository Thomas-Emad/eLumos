<?php

namespace App\Http\Traits;

use App\Models\Course;

trait UpdateStepsStatusTrait
{
  protected static function updateStepsStatusWithIncrementStep($stepName, Course $course)
  {
    $stepsStatusJson = json_decode($course->steps_status);

    if ($stepsStatusJson->$stepName == 'off') {
      $stepsStatusJson->$stepName = 'on';
      $course->increment('steps');
      $course->update([
        'steps_status' =>  json_encode($stepsStatusJson)
      ]);
    }

    return true;
  }
}
