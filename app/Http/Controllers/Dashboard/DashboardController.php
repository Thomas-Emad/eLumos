<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Order;
use App\Models\Course;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;


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
      'coursesCount' => $courses->total(),
      'activeCoursesCount' =>  $courses->filter(fn ($course) => $course->status === 'incomplete')->count(),
      'completedCoursesCount' => $courses->filter(fn ($course) => $course->status === 'completed')->count()
    ];

    // Get courses instructor
    $coursesInstructor = $this->coursesInstructorWithCache();
    $admin = $this->adminWithCache();

    return view("pages.dashboard.home", compact("courses", 'studentStatistics', 'coursesInstructor', 'admin'));
  }

  private function coursesInstructor()
  {
    $totalCourses = 0;
    $totalStudents = 0;
    $totalEarnings = 0;
    $coursesInstructor = '';
    if (Auth::user()->hasPermissionTo('instructors-control-courses')) {
      $coursesInstructor = Auth::user()->courses()
        ->select('courses.id', 'courses.title', 'courses.mockup', 'courses.status')
        ->withCount('enrolleds')->withSum('orderItems', 'amount')
        ->get();
      $totalCourses  = $coursesInstructor->where('status', 'active')->count();
      $totalStudents = $coursesInstructor->sum('enrolleds_count');
      $totalEarnings = $coursesInstructor->sum('order_items_sum_amount');
    }

    return (object) [
      "courses" => $coursesInstructor,
      "totalCourses" => $totalCourses,
      "totalStudents" => $totalStudents,
      "totalEarnings" => $totalEarnings
    ];
  }
  private function coursesInstructorWithCache()
  {
    return   Cache::remember('dashboard.instructor', 60 * 60, function () {
      return $this->coursesInstructor();
    });
  }

  private function admin()
  {
    $totalReviews = 0;
    $totalOpenReviews = 0;
    $totalUsers = 0;
    $totalSales = 0;
    $totalProfit = 0;
    $totalUnwithdrawnProfit = 0;

    // get info about reviews courses
    $courses = Course::get(['id', 'preview_at', 'status']);
    $totalReviews = $courses->whereNotNull("preview_at")->count();
    $totalOpenReviews = $courses->whereNull("preview_at")->count();

    if (Auth::user()->hasPermissionTo('roles')) {
      $totalUsers = User::count();

      // get Orders Information
      $orders = Order::withSum('items', 'platform_profit')
        ->withSum(['items' => function ($query) {
          $query->where('withdraw', false);
        }], 'amount')
        ->where("status", "succeeded")->get(['id', 'status', 'amount']);

      $totalSales = $orders->sum('amount');
      $totalProfit =  $orders->sum("items_sum_platform_profit");
      $totalUnwithdrawnProfit =  $orders->sum("items_sum_amount");
    }

    return (object) [
      "totalReviews" => $totalReviews,
      "totalOpenReviews" => $totalOpenReviews,
      "totalUsers" => $totalUsers,
      "totalSales" => $totalSales,
      "totalProfit" => $totalProfit,
      "totalUnwithdrawnProfit" => $totalUnwithdrawnProfit,
    ];
  }

  private function adminWithCache()
  {
    return  Cache::remember('dashboard.admin.roles', 3600, function () {
      return $this->admin();
    });
  }
}
