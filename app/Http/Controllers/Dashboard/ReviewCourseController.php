<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\ReviewCourse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ReviewCourseRequest;
use App\Actions\StatisticsRateCourseAction;
use Illuminate\Routing\Controllers\HasMiddleware;

class ReviewCourseController extends Controller  implements HasMiddleware
{

  public static function middleware(): array
  {
    return [
      'permission:buy-courses',
    ];
  }

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $reviews = Auth::user()->reviews()->with('course:id,title,mockup')->latest()->paginate(15);

    return view('pages.dashboard.student.reviews', compact('reviews'));
  }

  /**
   * Get Statistics Rate For Course
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function getStatisticsRate(Request $request, StatisticsRateCourseAction $action): JsonResponse
  {
    return response()->json($action->getStatistics($request->course_id), 200);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(ReviewCourseRequest $request)
  {
    ReviewCourse::create([
      'user_id' => Auth::id(),
      ...$request->validated(),
    ]);

    return redirect()->back()->with('notification', [
      'type' => 'success',
      'message' => 'Your review has been sent successfully..'
    ]);
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
  public function edit(string $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(ReviewCourseRequest $request, string $id)
  {
    $review = ReviewCourse::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

    $review->update([
      ...$request->validated(),
    ]);

    return redirect()->back()->with('notification', [
      'type' => 'success',
      'message' => 'Your review has been sent successfully..'
    ]);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
