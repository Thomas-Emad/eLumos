<?php

if (!function_exists('checkCourseInBasket')) {
  function checkCourseInBasket($id)
  {
    if (Auth::check()) {
      return Auth::user()->baskets()->where('course_id', $id)->exists();
    }
    return in_array($id, request()->cookie('baskets') ? unserialize(request()->cookie('baskets')) : []);
  }
}

if (!function_exists('explainSecondsToHumans')) {
  function explainSecondsToHumans($seconds)
  {
    $interval = \Carbon\CarbonInterval::seconds($seconds)->cascade(); // Automatically adjusts hours, minutes, etc.

    // Format the output
    return $interval->forHumans([
      'short' => true,
      'parts' => 3,
    ]);
  }
}
