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
use App\Http\Resources\InstructorCourseDetailsResource;

class CourseStudentController extends Controller
{
  public function index(Request $request)
  {
    $courses = Course::with(['user', 'wishlist'])
      ->where('status', 'active')
      ->paginate(9);
    return view('pages.courses', compact('courses'));
  }

  /**
   * Show the course details page.
   *
   * @param  string  $id
   * @return \Illuminate\Contracts\View\View
   */
  public function show(String $id)
  {
    $course = Course::with([
      'user:id,name,headline,photo',
      'reviews:id,course_id,user_id,rate,content',
      'enrolleds:id,course_id,user_id',
      'sections:id,course_id,title,order_sort',
      'sections.lectures:id,section_id,title,order_sort,video,video_duration,content',
      'sections.lectures.exam:lecture_id'
    ])
      ->withCount(['lectures as totalLectures'])
      ->withSum('lectures as totalLecturesTime', 'video_duration')->findOrFail($id);
    $reviewStudent = $course->reviews->where('user_id', auth()->user()->id)->first();
    $hasThisCourse = !is_null($course->enrolleds->where('user_id', auth()->user()->id)->first());
    $averageRating = $this->averageRating($course->reviews->sum('rate'), $course->reviews->count());

    if ($course->status !== 'active' && !auth()->user()->hasAnyPermission('control-courses', 'instructors-control-courses')) {
      return abort(403);
    }

    return view('pages.course-details', compact('course', 'reviewStudent', 'hasThisCourse', 'averageRating'));
  }

  /**
   * Retrieve paginated reviews for a specific course.
   *
   * @param string $courseId The ID of the course for which to retrieve reviews.
   * @param int $pagination The number of reviews per page (default is 10).
   * @return array An array containing the 'content' with a collection of
   *               ReviewUserCourseResource and 'pagination' details including
   *               first page, current page, and last page numbers.
   */
  public function getReviews(string $courseId, int $pagination = 10)
  {
    $reviews = ReviewCourse::with('user')
      ->where("course_id", $courseId)
      ->orderByDesc("created_at")
      ->paginate($pagination);
    return [
      'content' => ReviewUserCourseResource::collection($reviews),
      'pagination' => [
        'first_page' => 1,
        'current_page' => $reviews->currentPage(),
        'last_page' => $reviews->lastPage(),
      ],
    ];
  }

  /**
   * Retrieve and return reviews and instructor details for a specific course.
   *
   * This function fetches the statistical progress of ratings, reviews content,
   * and instructor details for a given course. It combines the results into a
   * JSON response.
   *
   * @param Request $request The request object containing the course and instructor IDs.
   * @param StatisticsRateCourseAction $action The action class responsible for fetching rating statistics.
   * @return \Illuminate\Http\JsonResponse A JSON response containing reviews content and instructor details.
   */
  public function reviews(Request $request, StatisticsRateCourseAction $action)
  {
    $ratesProgress = $action->getStatistics($request->course_id);
    $reviews = $this->getReviews($request->course_id);
    $instructor = new InstructorCourseDetailsResource($this->fetchInstructor($request->instructor_id));
    return response()->json([
      'reviewsContent' => [
        'ratesProgress' => $ratesProgress,
        'reviews' => $reviews
      ],
      'instructorContent' => $instructor
    ], 200);
  }

  /**
   * Retrieves an instructor's profile information, along with course details.
   * 
   * @param string $instructor_id The ID of the instructor to retrieve.
   * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model The instructor's profile, along with course details.
   */
  private function fetchInstructor(string $instructor_id)
  {
    return User::select('id', 'name', 'headline', 'photo', 'description')
      ->with(['courses' => function ($query) {
        $query->with([
          'enrolleds:id,course_id',
          'lectures:id,course_id,video_duration',
        ])
          ->withCount(['reviews as totalReviews'])
          ->withSum('reviews as totalRate', 'rate');
      }])
      ->where('id', $instructor_id)
      ->first();
  }

  private function averageRating(int $totalStars, int $totalUsers): float
  {
    $totalUsers = $totalUsers !== 0 ? $totalUsers : 1;
    return $totalStars / $totalUsers;
  }
}
