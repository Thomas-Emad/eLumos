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
