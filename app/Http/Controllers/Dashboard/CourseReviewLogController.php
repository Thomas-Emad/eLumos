<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseReviewLogRequest;
use App\Models\{Course, CourseReviewLog};
use Illuminate\Support\Facades\DB;

class CourseReviewLogController extends Controller
{
  /**
   * Display the course review logs for a given course.
   *
   * This method handles AJAX requests to fetch and display course review logs.
   * It retrieves logs from the database, groups them by review date, and renders
   * the corresponding view. If the request is not an AJAX request, a 404 response
   * is returned.
   *
   * @param \Illuminate\Http\Request $request The incoming request containing the course ID.
   * @return \Illuminate\Http\JsonResponse A JSON response containing the rendered HTML content of the logs.
   * @throws \Symfony\Component\HttpKernel\Exception\HttpException If the request is not AJAX.
   */

  public function show(Request $request)
  {
    if (!request()->ajax()) {
      return abort(404);
    }
    $logs = CourseReviewLog::select(
      DB::raw('DATE_FORMAT(reviewed_at, "%Y-%m-%d") as review_date'),
      'status',
      'reason',
      'reviewed_by',
      'reviewed_at'
    )->with('reviewer:id,name')
      ->where('course_id', $request->course_id)
      ->get()
      ->groupBy(function ($log) {
        return \Carbon\Carbon::parse($log->reviewed_at)->toDateString();
      });

    $content = view('pages.dashboard.admin.partials.course-review-log-show', [
      'logs' => $logs
    ])->render();

    return response()->json([
      'content' => $content
    ]);
  }
  /**
   * Store a new course review log and update the course status.
   *
   * This method handles the storage of a new course review log and updates the
   * course status based on the request data. After processing, the user is redirected
   * back with a success notification.
   *
   * @param \App\Http\Requests\CourseReviewLogRequest $request The validated request containing course review details.
   * @return \Illuminate\Http\RedirectResponse A redirect response back to the previous page with a success notification.
   */

  public function store(CourseReviewLogRequest $request)
  {
    // Update the course status
    $course = Course::find($request->course_id);
    $course->status = $request->status;
    $course->save();

    // Create a new course review log
    CourseReviewLog::create([
      'course_id' => $request->course_id,
      'status' => $request->status,
      'reason' => $request->reason,
      'reviewed_by' => auth()->id(),
      'reviewed_at' => now()
    ]);

    return redirect()->back()->with('notification', [
      'type' => 'success',
      'message' => "Course status updated successfully."
    ]);
  }
}
