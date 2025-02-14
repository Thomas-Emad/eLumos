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

    if ($video) {
      $html .= $iconsHtml['video'];
    }
    if ($text) {
      $html .= $iconsHtml['text'];
    }
    if ($exam) {
      $html .= $iconsHtml['exam'];
    }

    return $html;
  }
}


if (!function_exists('calcDegreeAnswer')) {
  function calcDegreeAnswer(int $totalAnswers, int $countTrueAnswers)
  {
    return round((1 / $totalAnswers) * $countTrueAnswers, 2);
  }
}


if (!function_exists('getImagePaymentByStatus')) {
  function getImagePaymentByStatus($status = null): string
  {
    return match ($status) {
      'pending' => asset('assets/images/icons/wait.png'),
      'succeeded' => asset('assets/images/congratulation.png'),
      'failed' => asset('assets/images/fail.png'),
      'canceled' => asset('assets/images/canceled.png'),
    };
  }
}

if (!function_exists('getMessagePaymentByStatus')) {
  function getMessagePaymentByStatus($status = null): string
  {
    return match ($status) {
      'pending' => "Payment is pending.",
      'succeeded' => "Payment was successful.",
      'failed' => "Payment failed.",
      'canceled' => "Payment was canceled.",
      default => "Unknown payment status.",
    };
  }
}


if (!function_exists('getParameterFromJsonOrNull')) {
  function getParameterFromJsonOrNull($condition, $attribute)
  {
    return isset($condition) ? json_decode($condition)->$attribute : '';
  }
}