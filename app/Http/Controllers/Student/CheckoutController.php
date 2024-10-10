<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
  public function saveCourses()
  {
    $courses = Auth::user()->basketWithCourses()->select('courses.id')->where('status', 'active')->pluck('id');

    Auth::user()->enrolledCourses()->attach($courses);
    Auth::user()->baskets()->whereIn('course_id', $courses)->delete();

    return redirect()->route('dashboard.index')->with('notification', [
      'type' => 'success',
      'message' => "You have successfully saved your courses."
    ]);
  }
}
