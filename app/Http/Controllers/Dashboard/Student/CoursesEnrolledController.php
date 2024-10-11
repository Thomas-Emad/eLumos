<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use App\Models\CoursesEnrolled;
use App\Models\Course;
use App\Http\Resources\CoursesEnrolledResource;
use App\Models\CourseLectures;
use Illuminate\Support\Facades\Cache;


class CoursesEnrolledController extends Controller
{

  protected array $getStatus = [
    'all' => ['new', 'completed', 'incomplete'],
    'active' => ['new', 'incomplete'],
    'completed' => ['completed']
  ];

  public function index()
  {
    $courses = CoursesEnrolled::where('user_id', auth()->id())->select('status')->pluck('status');

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

    return view('pages.dashboard.student.courses-list', ['countCourses' => $countCourses]);
  }

  public function getCourses()
  {
    if (!request()->ajax()) {
      return abort(404);
    }

    try {
      // Cache Courses
      $type = in_array(request()->input('type'), array_keys($this->getStatus)) ? request()->input('type') : 'all';

      $courses = Cache::remember("courses.preview.$type." . auth()->id(), 60 * 60 * 60 * 6, function () use ($type) {
        $data = CoursesEnrolled::with(['user', 'course'])->select('course_id', 'user_id', 'progress_lectures')
          ->where('courses_enrolleds.user_id', auth()->id())
          ->whereIn('courses_enrolleds.status', $this->getStatus[$type])
          ->orderBy('buyer_at')
          ->paginate(10);
        return CoursesEnrolledResource::collection($data);
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

  public function show(string $course, string $lecture)
  {
    $courseStudent = CoursesEnrolled::with(['course:id,title,mockup', 'course.sections:id,course_id,title',  'course.sections.lectures:id,section_id,title,video_duration'])
      ->where("course_id", $course)->where('user_id', auth()->user()->id)
      ->select('course_id')->firstOrFail();

    $contentLecture = CourseLectures::where('course_id', $course)->where('id', $lecture)
      ->select('id', 'title', 'video', 'content')->first();

    $nextLecture = CourseLectures::where('course_id', $course)
      ->where('id', '>', $contentLecture->id)->select('id')
      ->orderBy('order_sort', 'asc')
      ->first();

    $nextLectureId = $nextLecture ? $nextLecture->id : null;

    return view('pages.dashboard.student.playlist', compact('courseStudent', 'contentLecture', 'nextLectureId'));
  }
}
