<?php

namespace App\Http\Controllers\Student;

use App\Models\User;
use App\Models\Course;
use App\Models\ReviewCourse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Actions\StatisticsRateCourseAction;
use App\Http\Resources\ReviewUserCourseResource;

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
    $course = Course::with(['user', 'reviews', 'enrolled', 'sections',  'lectures', 'tags'])->findOrFail($id);
    $reviewStudent = $course->reviews()->where('user_id', Auth::id())->first();
    $hasThisCourse = $course->enrolled()->exists();

    if ($course->status !== 'active' && !auth()->user()->hasAnyPermission('control-courses', 'instructors-control-courses')) {
      return abort(403);
    }

    return view('pages.course-details', compact('course', 'reviewStudent', 'hasThisCourse'));
  }

  public function getReviews(string $courseId)
  {
    $reviews = ReviewCourse::with('user')->where("course_id", $courseId)
      ->orderByDesc("created_at")->paginate(1);
    return [
      'content' => ReviewUserCourseResource::collection($reviews),
      'pagination' =>  [
        'first_page' => 1,
        'current_page' => $reviews->currentPage(),
        'last_page' => $reviews->lastPage(),
      ],
    ];
  }

  public function reviews(Request $request, StatisticsRateCourseAction $action)
  {
    $ratesProgress = $action->getStatistics($request->course_id);
    $reviews = $this->getReviews($request->course_id);
    $instructor = $this->instructor($request->instructor_id);
    return response()->json([
      'reviewsContent' => [
        'ratesProgress' => $ratesProgress,
        'reviews' => $reviews
      ],
      'instructorContent' => $instructor
    ], 200);
  }

  private function instructor(string $instructor_id)
  {
    $instructor = User::select('id', 'name', 'headline', 'photo')
      ->with('courses:id,user_id')
      ->where('id', $instructor_id)
      ->first();

    // Get info instructor Courses's
    $CoursesId = $instructor->courses->pluck('id')->toArray();
    $courses = Course::select('id')->with([
      'enrolled:id,course_id',
      'lectures:id,course_id,video_duration'
    ])->whereIn('id', $CoursesId)->get();

    $enrolledStudent = 0;
    $timeLectures = 0;
    $countLectures = 0;
    foreach ($courses as $course) {
      $enrolledStudent += !is_null($course->enrolled) ? sizeof($course->enrolled) : 0;
      $timeLectures +=  $course->lectures->sum('video_duration');
      $countLectures +=  !is_null($course->lectures) ? sizeof($course->lectures) : 0;
    }

    return [
      'profile_user' => route("dashboard.profile", $instructor->id),
      'name' => $instructor->name,
      'headline' =>  $instructor->headline,
      'photo' => asset('storage/' .  $instructor->photo),
      'description' =>  $instructor->description,
      'countCourses' => $instructor->courses->count(),
      'timeLectures' => explainSecondsToHumans($timeLectures),
      'countLectures' => $countLectures,
      'totalStudents' => $enrolledStudent
    ];
  }
}
