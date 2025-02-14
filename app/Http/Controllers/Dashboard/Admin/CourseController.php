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
   * Display detailed content of a course.
   *
   * This method handles AJAX requests to fetch and display detailed information about a course.
   * It retrieves the course with its associated sections, lectures, and related data. If the request
   * is not an AJAX request, a 404 response is returned.
   *
   * @param \Illuminate\Http\Request $request The incoming request containing the course ID.
   * @return \Illuminate\Http\JsonResponse A JSON response containing the rendered HTML content of the course details.
   * @throws \Symfony\Component\HttpKernel\Exception\HttpException If the request is not AJAX.
   */

  public function show(Request $request)
  {
    if (!request()->ajax()) {
      return abort(404);
    }

    $course = Course::where('id', $request->id)->with([
      'sections:id,course_id,title',
      'sections.lectures:id,section_id,title,video_duration,content,video',
      'sections.lectures.exam:id,lecture_id',
      'user:id,username,name'
    ])->withCount('lectures')
      ->firstOrFail();

    $content = view('pages.dashboard.admin.partials.course-content', compact('course'))->render();
    return response()->json(['content' => $content]);
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

    $course = Course::where("id", $request->id)->firstOrFail();
    $course->update([
      'status' => $request->status == 'accept' ? 'active' : 'redject',
      'preview_at' => now()
    ]);

    return redirect()->back()->with('notification', [
      'type' => 'success',
      'message' => "The Course was $request->status Successfully."
    ]);
  }
}
