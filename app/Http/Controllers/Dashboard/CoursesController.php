<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Http\Resources\CoursesDashboardResource;
use App\Http\Traits\UploadAttachmentTrait;
use App\Http\Traits\UpdateStepsStatusTrait;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rules\File;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;



class CoursesController extends Controller implements HasMiddleware
{
  use UploadAttachmentTrait, UpdateStepsStatusTrait;

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
      'title' => 'required|min:10|max:50',
      'headline' => 'required|min:50|max:255',
      'description' => 'required|min:50|max:1000',
      'language' => 'required|exists:languages,id',
      'tags' => 'required|array|max:3|min:1',
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
      'steps_status' => json_encode($stepsStatus)
    ]);

    $course->tags()->attach($request->tags);

    return redirect()->route('dashboard.course.edit', ['course' => $course->id, 'step' => 2])->with('success', 'Course added successfully');
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
    $course->load(['tags', 'sections']);
    if ($course->user_id != auth()->user()->id) {
      return abort(404);
    }

    return view('dashboard.instructor.course.course-operations', ['course' => $course]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Course $course)
  {
    return match ($request->input('step')) {
      '1' => self::stepOneUpdate($request, $course),
      '2' => self::stepTwoUpdate($request, $course),
      '3' => self::stepThreeUpdate($request, $course),
      '5' => self::stepFiveUpdate($request, $course),
      '6' => self::stepSixUpdate($request, $course),
      default => abort(404),
    };
  }

  protected static function stepOneUpdate(Request $request, Course $course)
  {
    $validated =  $request->validate([
      'title' => 'required|min:10|max:50',
      'headline' => 'required|min:50|max:255',
      'description' => 'required|min:50|max:1000',
      'language' => 'required|exists:languages,id',
      'tags' => 'required|array',
      'tags.*' => 'required|exists:tags,id',
    ]);

    $course->update($validated);
    static::updateStepsStatusWithIncrementStep('stepOne', $course);

    return redirect()->route('dashboard.course.edit', ['course' => $course->id, 'step' => $request->input('step') + 1])->with('success', 'Course updated successfully');
  }

  protected static function stepTwoUpdate(Request $request, Course $course)
  {
    $request->validate([
      'mockup' => ['required', File::image()->max(2 * 1024)],
      'video-persentation' => ['required', File::types(['mp4'])->max(5 * 1024)],
    ]);

    // delete old attachments
    if ($course->mockup) {
      Cloudinary::destroy(json_decode($course->image)->public_id, ['resource_type' => 'image']);
      Cloudinary::destroy(json_decode($course->preview_video)->public_id, ['resource_type' => 'video']);
    }
    $imageJson = static::uploadAttachment($request->file('mockup'), 'images', 'image');
    $videoPresentationJson = static::uploadVideo($request->file('video-persentation'), 'videos', 'video');

    $course->update([
      'mockup' => $imageJson,
      'preview_video' => $videoPresentationJson,
    ]);

    static::updateStepsStatusWithIncrementStep('stepTwo', $course);

    return redirect()->route('dashboard.course.edit', ['course' => $course->id, 'step' => $request->input('step') + 1])->with('success', 'Course updated successfully');
  }

  protected static function stepThreeUpdate(Request $request, Course $course)
  {
    $request->validate([
      'learn' => ['required', 'min:50', 'max:2000'],
      'requirements' => ['required', 'min:50', 'max:2000'],
      'level' => ['required', 'in:beginner,intermediate,advanced']
    ]);

    $course->update($request->only('learn', 'requirements', 'level'));

    static::updateStepsStatusWithIncrementStep('stepThree', $course);

    return redirect()->route('dashboard.course.edit', ['course' => $course->id, 'step' => $request->input('step') + 1])->with('success', 'Course updated successfully');
  }
  protected static function stepFiveUpdate(Request $request, Course $course)
  {
    $request->validate([
      'message-before-start' => ['required', 'min:50', 'max:2000'],
      'message-complete' => ['required', 'min:50', 'max:2000'],
    ]);

    $message = json_encode([
      'before_start' => $request->input('message-before-start'),
      'complete' => $request->input('message-complete'),
    ]);

    $course->update([
      'message' => $message
    ]);

    static::updateStepsStatusWithIncrementStep('stepFive', $course);

    return redirect()->route('dashboard.course.edit', ['course' => $course->id, 'step' => $request->input('step') + 1])->with('success', 'Course updated successfully');
  }
  protected static function stepSixUpdate(Request $request, Course $course)
  {
    if ($course->steps == 6) {
      $request->validate([
        'price' => ['required', 'decimal:1,2', 'min:0.0', 'max:10000.0'],
      ]);

      $course->update([
        'price' => $request->price,
        'status' => 'pending'
      ]);

      static::updateStepsStatusWithIncrementStep('stepSix', $course);
      return redirect()->route('dashboard.courses')->with('success', 'The course has been sent for review, please wait for it.');
    }

    return redirect()->back();
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Request $request)
  {
    $course = Course::findOrFail($request->id);
    $course->delete();
    return redirect()->route('dashboard.courses')->with('success', 'Course deleted successfully');
  }
}
