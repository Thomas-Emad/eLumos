<?php

namespace App\Http\Controllers\Student;

use App\Models\Tag;
use App\Models\User;
use App\Models\Course;
use App\Models\ReviewCourse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchCourseRequest;
use App\Actions\StatisticsRateCourseAction;
use App\Http\Resources\ReviewUserCourseResource;
use App\Http\Resources\InstructorCourseDetailsResource;
use Illuminate\Support\Facades\Auth;

class CourseStudentController extends Controller
{
  public function index(SearchCourseRequest $request)
  {
    $courses = Course::with([
      'user:id,name,photo,headline',
      'wishlist' => function ($query) {
        $query->where('user_id', auth()?->id());
      }
    ])
      ->withCount('reviews as reviewsCount')
      ->where('status', 'active')
      ->search($request->title)
      ->price($request->paidCourse, $request->freeCourse)
      ->levels($request->levels)
      ->selectBy($request->selectBy)
      ->when($request->tags, function ($query) use ($request) {
        $query->whereHas('tags', fn($query) => $query->whereIn('tag_id', (array) $request->tags));
      })
      ->when($request->category && $request->category != 0, fn($query) => $query->where('category_id', $request->category))
      ->when($request->rates, fn($query) => $query->whereIn('rate', $request->rates))
      ->paginate(9);

    $categories = Tag::get(['id', 'name']);
    $enrolledStudent = Auth::check() ? auth()->user()->enrolledCourses()->pluck('course_id')->toArray() : [];
    return view('pages.courses', compact('courses', 'categories', 'enrolledStudent'));
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
      'tags:id,name',
      'category:id,name',
      'user:id,name,headline,photo',
      'reviews:id,course_id,user_id,rate,content',
      'enrolleds:id,course_id,user_id',
      'sections:id,course_id,title,order_sort',
      'sections.lectures:id,section_id,title,order_sort,video,video_duration,content',
      'sections.lectures.exam:lecture_id'
    ])
      ->withCount(['lectures as totalLectures'])
      ->withSum('lectures as totalLecturesTime', 'video_duration')->findOrFail($id);
    $reviewStudent = $course->reviews->where('user_id', auth()->user()?->id)->first();
    $hasThisCourse = !is_null($course->enrolleds->where('user_id', auth()->user()?->id)->first());
    $averageRating = $course->average_rating;

    if (Auth::check() && $course->status !== 'active' && !auth()->user()->hasAnyPermission('control-courses', 'instructors-control-courses')) {
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
}
