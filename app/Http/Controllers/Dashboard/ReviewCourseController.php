<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\ReviewCourse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ReviewCourseRequest;

class ReviewCourseController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //
  }



  /**
   * Get Statistics Rate For Course
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function getStatisticsRate(Request $request): JsonResponse
  {
    $rates = ReviewCourse::where("course_id", $request->course_id)->get(['id', 'rate']);
    $totalCountRates = $rates->count() > 0 ? $rates->count() : 1;
    $result = [];
    for ($i = 5; $i >= 1; $i--) {
      $result[] =
        [
          'rate' => $i,
          'count' => $rates->where('rate', $i)->count(),
          'progress' => ($rates->where('rate', $i)->count() / $totalCountRates) * 100
        ];
    }

    return response()->json($result, 200);
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
    ReviewCourse::where('id', $id)->where('user_id', Auth::id())->update([
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
