<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseStudentController extends Controller
{



  public function index(Request $request)
  {

    $courses = Course::with(['user', 'wishlist'])->paginate(9);
    return view('courses', compact('courses'));
  }



  public function show(String $id = null)
  {
    $course = Course::with(['user', 'sections',  'lectures', 'tags'])->findOrFail($id);

    if ($course->status !== 'active' && !auth()->user()->hasAnyPermission('control-courses', 'instructors-control-courses')) {
      return abort(403);
    }

    return view('course-details', compact('course'));
  }
}