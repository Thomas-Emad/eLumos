<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\Dashboard\AdminDashboardResource;
use App\Http\Resources\Dashboard\InstructorDashboardResource;


class DashboardController extends Controller
{
  /**
   * Handle the incoming request.
   */
  public function __invoke(Request $request)
  {
    $coursesQuery = Auth::user()->enrolledCourses()
      ->select(['courses.id', 'courses.user_id', 'courses.title', 'courses.status'])
      ->with([
        'user:id,name,photo,headline',
      ])
      ->withCount(['reviews as reviewsCount', 'wishlist']);

    // Paginate courses
    $courses = $coursesQuery->paginate(10);

    // Calculate counts
    $studentStatistics = (object) [
      'coursesCount' => $courses?->total(),
      'activeCoursesCount' =>  $courses?->filter(fn ($course) => $course->status === 'incomplete')->count(),
      'completedCoursesCount' => $courses?->filter(fn ($course) => $course->status === 'completed')->count()
    ];

    $coursesInstructor = $this->coursesInstructorWithCache();
    $admin = $this->adminWithCache();

    return view("pages.dashboard.home", compact("courses", 'studentStatistics', 'coursesInstructor', 'admin'));
  }

  /**
   * Get the courses for instructor with the statistics.
   *
   * @return \App\Http\Resources\Dashboard\InstructorDashboardResource
   */
  private function coursesInstructor()
  {
    $status = (object) [
      "status"  => Auth::user()->hasPermissionTo("instructors-control-courses")
    ];
    return (object) (new InstructorDashboardResource($status));
  }


  /**
   * Get the courses for instructor with the statistics and cache it for 1 hour.
   * 
   * @return \App\Http\Resources\Dashboard\InstructorDashboardResource
   */
  private function coursesInstructorWithCache()
  {
    return Cache::remember('dashboard.instructor' . Auth::id(), 60 * 60, function () {
      return $this->coursesInstructor();
    });
  }

  /**
   * Get the courses for admin with the statistics.
   *
   * @return \App\Http\Resources\Dashboard\AdminDashboardResource
   */
  private function admin()
  {
    $courses = Course::get(['preview_at']);
    return  (object) (new AdminDashboardResource($courses));
  }

  /**
   * Get the courses for admin with the statistics and cache it for 1 hour.
   * 
   * @return \App\Http\Resources\Dashboard\AdminDashboardResource
   */
  private function adminWithCache()
  {
    return Cache::remember('dashboard.admin.roles', 3600, function () {
      return $this->admin();
    });
  }
}
