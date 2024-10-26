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

if (!function_exists('getLectureIcons')) {
  function getLectureIcons($text, $video, $exam)
  {
    $iconsHtml = [
      'text' => '<i class="fa-solid fa-book"></i>',
      'video' => '<i class="fa-solid fa-video"></i>',
      'exam' => '<i class="fa-solid fa-clipboard-question"></i>'
    ];
    $html = '';

    if ($text) {
      $html .= $iconsHtml['text'];
    }
    if ($video) {
      $html .= $iconsHtml['video'];
    }
    if ($exam) {
      $html .= $iconsHtml['exam'];
    }

    return $html;
  }
}
