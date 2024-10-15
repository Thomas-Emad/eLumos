<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\CourseLectures;

class WatchCourseLectureMiddleware
{
  protected static bool $statusAllowUseTerminate;

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

    $lastLectureWatched = $lectures->filter(function ($lecture) {
      return $lecture->watchedLecture ?? null;
    })->sortByDesc('watchedLecture.lecture_id')->first();

    $currentLectureWatched = $lectures->where('id', $request->lecture)
      ->first()?->watchedLecture;

    $nextLectureCanWatch = $lectures->where('order_sort', ($lastLectureWatched->order_sort ?? 0) + 1)
      ->pluck('id');

    $firstLectureInCourse = $lectures->sortBy('order_sort')->first()->id;

    // Compile all open lectures for watching
    $openForWatch = array_filter([
      $firstLectureInCourse,
      $lastLectureWatched?->id,
      $currentLectureWatched?->lecture_id,
      ...$nextLectureCanWatch->toArray(),
    ]);

    if (!in_array($request->lecture, $openForWatch)) {
      return abort(404); // tell him we should watch prev lectures first
    }

    // Pass status for work Terminate or not
    static::$statusAllowUseTerminate = true;

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
    if (Auth::check() && static::$statusAllowUseTerminate === true) {
      $lectureId = $request->route('lecture');
      $courseId = $request->route('course');
      $this->watchCourseLecture($lectureId, $courseId);
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
