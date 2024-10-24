<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\CourseLectures;

class WatchCourseLectureMiddleware
{
  protected static bool $statusAllowUseTerminate = false;
  protected static ?string $lectureUri = null;

  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    $lectures = CourseLectures::where('course_id', $request->course)
      ->select('id', 'order_sort')
      ->with([
        'watchedLecture' => function ($query) {
          $query->where('user_id', Auth::id());
        }
      ])
      ->get();

    $firstLectureInCourse = $lectures->sortBy('order_sort')->first()->id;

    // if we not have lecture in uri, sit one
    static::$lectureUri = ($request->lecture) ??  $firstLectureInCourse;

    $lastLectureWatched = $lectures->filter(function ($lecture) {
      return isset($lecture->watchedLecture);
    })->sortByDesc('watchedLecture.lecture_id')->first();


    $currentLectureWatched = $lectures->where('id', static::$lectureUri)
      ->first()?->watchedLecture;

    $nextLectureCanWatch = $lectures->where('order_sort', ($lastLectureWatched->order_sort ?? 0) + 1)
      ->pluck('id');

    // Compile all open lectures for watching
    $openForWatch = array_filter([
      $firstLectureInCourse,
      $lastLectureWatched?->id,
      $currentLectureWatched?->lecture_id,
      ...$nextLectureCanWatch->toArray(),
    ]);

    if (!in_array(static::$lectureUri, $openForWatch)) {
      return abort(404); // tell him we should watch prev lectures first
    }

    // Pass status for work Terminate or not
    static::$statusAllowUseTerminate = false;

    return $next($request);
  }


  /**
   * Handle tasks after the response has been sent to the browser.
   *
   * Create or update a watched course lecture record in the watched_course_lectures table,
   * given the lecture and course id's.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Symfony\Component\HttpFoundation\Response  $response
   * @return void
   */
  public function terminate(Request $request, Response $response)
  {
    if (Auth::check() && !is_null(static::$lectureUri) && static::$statusAllowUseTerminate === true) {
      $courseId = $request->route('course');
      $this->watchCourseLecture(static::$lectureUri, $courseId);
    }
  }

  /**
   * Create or update a watched course lecture record in the watched_course_lectures table,
   * given the lecture and course id's.
   *
   * @param int $lectureId
   * @param int $courseId
   * @return void
   */
  private function watchCourseLecture($lectureId, $courseId)
  {
    Auth::user()->watchedCourseLectures()->updateOrCreate(
      ['lecture_id' => $lectureId, 'course_id' => $courseId],
      ['lecture_id' => $lectureId, 'course_id' => $courseId]
    );
  }
}
