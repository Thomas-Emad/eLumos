<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Resources\CoursesDashboardResource;
use Illuminate\Support\Facades\Cache;

class CoursesController extends Controller implements HasMiddleware
{
  protected array $getStatus = [
    'published' => ['active'],
    'draft' => ['draft', 'blocked', 'removed', 'inactive'],
    'pending' => ['pending'],
  ];

  public static function middleware(): array
  {
    return [
      'permission:control-courses',
    ];
  }
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $courses = Course::where('user_id', auth()->id())->pluck('status');

    // Initialize the $countCourses array with keys from $this->getStatus and values set to 0
    $countCourses = array_fill_keys(array_keys($this->getStatus), 0);

    // Loop through the statuses and count occurrences
    foreach ($courses as $status) {
      foreach ($this->getStatus as $key => $statuses) {
        if (in_array($status, $statuses)) {
          $countCourses[$key]++;
        }
      }
    }

    return view('dashboard.courses', ['countCourses' => $countCourses]);
  }

  public function getCourses(): JsonResponse
  {
    if (!request()->ajax()) {
      return abort(404);
    }

    try {
      // Cache Courses
      $type = in_array(request()->input('type'), array_keys($this->getStatus)) ? request()->input('type') : 'published';

      $courses = Cache::remember("courses.$type", 60 * 60 * 24 * 30, function () use ($type) {
        $courses = Course::with('user')->where('user_id', auth()->user()->id)
          ->whereIn('status', $this->getStatus[$type])
          ->paginate(10);
        return CoursesDashboardResource::collection($courses);
      });
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 500);
    }

    return response()->json([
      'count' => $courses->total(),
      'courses' =>  $courses,
      'pagination' =>  [
        'first_page' => 1,
        'current_page' => $courses->currentPage(),
        'last_page' => $courses->lastPage(),
      ],
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create(): View
  {
    if (empty(request()->input('step')) || request()->input('step') == '1') {
      return view('dashboard.instructor.course.course-operations');
    } else {
      return abort(404);
    }
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'learn-course' => 'required|min:50|max:1000',
      'requirements-course' => 'required|min:50|max:1000',
    ]);

    $course = Course::create([
      'user_id' => auth()->user()->id,
      'learn' => $request->input('learn-course'),
      'requirements' => $request->input('requirements-course'),
    ]);

    return redirect()->route('dashboard.course.edit', ['course' => $course->id])->with('success', 'Course added successfully');
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Course $course)
  {
    if ($course->user_id != auth()->user()->id) {
      return abort(404);
    }
    return view('dashboard.instructor.course.course-operations', ['course' => $course]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
