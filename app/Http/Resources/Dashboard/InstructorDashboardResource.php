<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class InstructorDashboardResource extends JsonResource
{
  public int $totalCourses = 0;
  public int $totalStudents = 0;
  public int $totalEarnings = 0;
  public array $courses = [];

  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    if ($this->status) {
      $courses = Auth::user()->courses()
        ->select('courses.id', 'courses.title', 'courses.mockup', 'courses.status')
        ->withCount('enrolleds')->withSum('orderItems', 'amount')
        ->get();

      $this->instructorStatistics($courses);
    }

    return  [
      "courses" => $courses ?? null,
      "totalCourses" => $this->totalCourses,
      "totalStudents" => $this->totalStudents,
      "totalEarnings" => $this->totalEarnings
    ];
  }

  /**
   * Calculates the total of courses, students and earnings for the instructor dashboard statistics.
   *
   * @return void
   */
  private function instructorStatistics($courses): void
  {
    $this->totalCourses  = $courses->where('status', 'active')->count();
    $this->totalStudents = $courses->sum('enrolleds_count');
    $this->totalEarnings = $courses->sum('order_items_sum_amount');
  }
}
