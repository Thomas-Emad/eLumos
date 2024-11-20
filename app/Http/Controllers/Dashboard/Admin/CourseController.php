<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\FilterByDateTrait;
use Illuminate\Routing\Controllers\HasMiddleware;

class CourseController extends Controller implements HasMiddleware
{
  use FilterByDateTrait;

  public static function middleware()
  {
    return [
      'permission:admin-control-courses'
    ];
  }
  /**
   * Show the admin courses index page.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Contracts\View\View
   */
  public function index(Request $request)
  {
    $filterBy =  $request->date ?? 'last_month';

    $courses = Course::where('status', '!=', 'draft')
      ->where('title', "like", "%$request->title%")->whereBetween("created_at", static::filterByDate($filterBy))
      ->with('lectures')->select('id', 'title', 'mockup', 'status', 'price')
      ->orderBy('status', 'ASC')->paginate(20);

    return view('pages.dashboard.admin.courses', compact('courses'));
  }

  /**
   * Review Status Of Course
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function reviewStatusCourse(Request $request)
  {
    $request->validate([
      'id' => 'required|exists:courses,id',
      'status' => "required|in:accept,redject"
    ]);

    Course::where("id", $request->id)->update([
      'status' => $request->status == 'accept' ? 'active' : 'redject',
      'preview_at' => now()
    ]);

    return redirect()->back()->with('notification', [
      'type' => 'success',
      'message' => "The Course was $request->status Successfully."
    ]);
  }
}
