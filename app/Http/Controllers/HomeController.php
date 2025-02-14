<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use App\Actions\TopCategoiresUsedAction;
use App\Models\{User, Course, Order, CoursesEnrolled};
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;

class HomeController extends Controller
{
  /**
   * Handle the home page request and cache the content.
   *
   * This function retrieves the top categories, most bought courses, and various statistics 
   * (courses, instructors, students, and earnings), and caches the result for 6 days.
   *
   * @return View The rendered home page view with cached content.
   */
  public function __invoke(): View
  {
    $content = Cache::remember('home.content', 3600 * 24 * 6, function () {
      $topCatgeoiresUsed = (new TopCategoiresUsedAction)->getTopCategoires(6);
      $topCoursesBuyed = $this->topCoursesBuyed();
      $counters = $this->counters();

      return [
        'categories' => $topCatgeoiresUsed,
        'courses' => $topCoursesBuyed,
        'counters' => $counters
      ];
    });

    return view('pages.home', compact('content'));
  }

  /**
   * Get the top 4 most purchased courses with their total video duration.
   *
   * This function retrieves the top 4 courses based on the number of enrollments, 
   * including course details, category, instructor, and total video duration of lectures.
   *
   * @return Collection A collection of the top 4 most bought courses.
   */
  private function topCoursesBuyed(): Collection
  {
    return  CoursesEnrolled::with([
      'course:id,user_id,category_id,title,mockup,price',
      'course.category:id,name',
      'course.user:id,username,name',
    ])->select('course_id', DB::raw('count(*) as count'))
      ->addSelect(DB::raw('(SELECT SUM(video_duration) FROM course_lectures WHERE course_lectures.course_id = courses_enrolleds.course_id) as lectures_sum_video_duration'))
      ->groupBy('course_id')
      ->orderBy('count', 'desc')
      ->take(4)
      ->get();
  }

  /**
   * Get statistics for courses, users, and earnings.
   *
   * Returns the total number of courses, instructors, students, and total earnings from orders.
   *
   * @return object An object with the following properties:
   * - `courses`: Total number of courses (int).
   * - `instructors`: Total number of instructors (int).
   * - `students`: Total number of students (int).
   * - `earns`: Total earnings (float).
   */
  private function counters(): object
  {
    $courses = Course::count();
    $users = User::where('steps_forward', 'complate')->get('id');
    $earns = Order::sum('amount');

    $instructors = $users->filter(function ($query) {
      return $query->hasRole('instructor');
    })->count();

    $students = $users->filter(function ($query) {
      return $query->hasRole('student');
    })->count();

    return (object) [
      'courses' =>  $courses,
      'instructors' => $instructors,
      'students' => $students,
      'earns' => $earns
    ];
  }
}
