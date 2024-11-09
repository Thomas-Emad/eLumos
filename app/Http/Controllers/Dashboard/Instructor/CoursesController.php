<?php

namespace App\Http\Controllers\Dashboard\Instructor;

use App\Models\Exam;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use App\Http\Traits\CoursesUpdateTrait;
use App\Http\Resources\CoursesDashboardResource;
use Illuminate\Routing\Controllers\HasMiddleware;

class CoursesController extends Controller implements HasMiddleware
{
  use CoursesUpdateTrait;

  protected array $getStatus = [
    'published' => ['active'],
    'draft' => ['draft', 'blocked', 'removed', 'inactive'],
    'pending' => ['pending'],
  ];

  public static function middleware(): array
  {
    return [
      'permission:instructors-control-courses',
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

    return view('pages.dashboard.instructor.courses', ['countCourses' => $countCourses]);
  }

  /**
   * Return the courses of the user according to the type given in the request
   *
   * @param string $type The type of courses to retrieve. It can be 'published', 'draft' or 'pending'
   * @return JsonResponse The courses of the user with the given type
   */
  public function getCourses(): JsonResponse
  {
    if (!request()->ajax()) {
      return abort(404);
    }

    try {
      // Cache Courses
      $type = in_array(request()->input('type'), array_keys($this->getStatus)) ? request()->input('type') : 'published';

      $courses = Cache::remember("courses.$type." . auth()->id(), 60 * 60 * 24 * 30, function () use ($type) {
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
      return view('pages.dashboard.instructor.controll-course.course-operations');
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
      'title' => 'required|min:10|max:50',
      'headline' => 'required|min:50|max:255',
      'description' => 'required|min:50|max:1000',
      'language' => 'required|exists:languages,id',
      'tags' => 'required|array|max:5|min:1',
      'category' => 'required|exists:tags,id',
      'tags.*' => 'required|exists:tags,id',
    ]);

    // Format Json steps_status
    $stepsStatus = [
      'stepOne' => 'on',
      'stepTwo' => 'off',
      'stepThree' => 'off',
      'stepFive' => 'off',
      'stepFour' => 'off',
      'stepSix' => 'off',
    ];

    $course = Course::create([
      'user_id' => auth()->user()->id,
      'title' => $request->title,
      'headline' => $request->headline,
      'description' => $request->description,
      'language_id' => $request->language,
      'steps_status' => json_encode($stepsStatus),
      'category_id' => $request->category
    ]);

    $course->tags()->attach($request->tags);

    return redirect()->route('dashboard.instructor.courses.edit', ['course' => $course->id, 'step' => 2])->with('success', 'Course added successfully');
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Course $course)
  {
    $course->load(['tags', 'sections']);
    if ($course->user_id != auth()->user()->id) {
      return abort(403);
    }

    $exams = Exam::with('questions')->get();

    return view('pages.dashboard.instructor.controll-course.course-operations', compact('course', 'exams'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Course $course)
  {
    if ($course->user_id != auth()->user()->id) {
      return abort(403);
    }
    return match ($request->input('step')) {
      '1' => self::stepOneUpdate($request, $course),
      '2' => self::stepTwoUpdate($request, $course),
      '3' => self::stepThreeUpdate($request, $course),
      '5' => self::stepFiveUpdate($request, $course),
      '6' => self::stepSixUpdate($request, $course),
      default => abort(404),
    };
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Request $request)
  {
    $course = Course::findOrFail($request->id);
    if ($course->user_id != auth()->user()->id) {
      return abort(403);
    }
    $course->delete();
    return redirect()->route('dashboard.instructor.courses')->with('success', 'Course deleted successfully');
  }
}
