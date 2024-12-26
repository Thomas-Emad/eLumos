<?php

namespace App\Http\Controllers\Dashboard\Instructor;

use App\Models\Exam;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Http\Traits\CoursesUpdateTrait;
use App\Http\Resources\CoursesDashboardResource;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Services\StatisticCourseService;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\UploadAttachmentTrait;


class CoursesController extends Controller implements HasMiddleware
{
  use CoursesUpdateTrait, UploadAttachmentTrait;

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

    return redirect()->route('dashboard.instructor.courses.edit', ['course' => $course->id, 'step' => 2])
      ->with('notification', [
        'type' => 'success',
        'message' => "Course Created successfully."
      ]);
  }

  public function status(string $id)
  {
    return $id;
  }

  /**
   * Display statistics for a specific course.
   *
   * This function retrieves detailed statistical data for a given course, 
   * including logs, order items (aggregated by month and grouped by course), 
   * reviews, and their associated users. It calculates average watch time 
   * and profits using the provided service.
   *
   * @param StatisticCourseService $statistic The service handling statistical calculations.
   * @param string $id The ID of the course whose statistics are being retrieved.
   * 
   * @return \Illuminate\View\View The statistics view with the relevant data.
   */
  public function statistics(StatisticCourseService $statistic, string $id): View
  {
    $course = Course::with([
      'logs',
      'orderItems' => function ($query) {
        return $query->select(DB::raw("sum(user_profit) as profit, DATE_FORMAT(created_at, '%Y/%m') as date"), 'course_id')
          ->groupBy('course_id', DB::raw("DATE_FORMAT(created_at, '%Y/%m')"))
          ->orderBy('date');
      },
      'reviews',
      'reviews.user:id,name'
    ])
      ->withCount('reviews')
      ->findOrFail($id);
    $avargetWatchs = $statistic->avargetWatchs($course->enrolleds());
    $profits =  $statistic->profits($course->orderItems, '');

    return view('pages.dashboard.instructor.controll-course.statistics', compact(
      'course',
      'avargetWatchs',
      'profits'
    ));
  }

  public function updatePriceCourse(Request $request)
  {
    $request->validate([
      'course_id' => 'required|exists:course,id',
      'price' => 'required|decimal:1,2|min:0.0|max:10000.0',
    ]);

    $course = Course::where('id', $request->course_id)->first();
    $course->update([
      'price' => $request->price,
    ]);

    return redirect()->route('course-details', $request->course_id)
      ->with('notification', [
        'type' => 'success',
        'message' => "Updated Price has been done."
      ]);
  }

  public function support()
  {
    return 'support is here';
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
    $course = Course::withCount("enrolleds")->findOrFail($request->id);
    if ($course->user_id != auth()->user()->id) {
      return abort(403);
    }

    // Check If there is anyone have this course?!
    if ($course->enrolleds_count == 0) {
      $this->deleteContentCloudCourse($course->id);
      $course->delete();
    } else {
      $course->update([
        'status' => 'removed'
      ]);
    }

    return redirect()->route('dashboard.instructor.courses.index')
      ->with('notification', [
        'type' => 'success',
        'message' => "Course deleted successfully."
      ]);
  }

  /**
   * Delete all associated media content of a course from cloud storage.
   *
   * This function handles the deletion of:
   * - Lecture videos associated with the course.
   * - The main course video, if present.
   * - The course's mockup image, if present.
   *
   * @param int $id The ID of the course whose media content is to be deleted.
   * 
   * @return void
   */
  private function deleteContentCloudCourse($id)
  {
    $course = Course::with([
      'lectures'
    ])->findOrFail($id);

    foreach ($course->lectures as $lecture) {
      if (!is_null($lecture->video)) {
        static::destoryAttachment($lecture->video, 'video');
      }
    }

    if (!is_null($course->video)) {
      static::destoryAttachment($course->video, 'video');
    }
    if (!is_null($course->mockup)) {
      static::destoryAttachment($course->mockup, 'image');
    }
  }
}
