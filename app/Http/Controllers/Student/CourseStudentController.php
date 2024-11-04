<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseStudentController extends Controller
{
  public function index(Request $request)
  {
    $courses = Course::with(['user', 'wishlist'])
      ->where('status', 'active')
      ->paginate(9);
    return view('pages.courses', compact('courses'));
  }


  public function show(String $id = null)
  {
    $course = Course::with(['user', 'sections',  'lectures', 'tags'])->findOrFail($id);

    if ($course->status !== 'active' && !auth()->user()->hasAnyPermission('control-courses', 'instructors-control-courses')) {
      return abort(403);
    }

    return view('pages.course-details', compact('course'));
  }
}
