<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Actions\WatchCourseLectureAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class WatchCourseLectureController extends Controller
{
  /**
   * Handle the incoming request.
   */
  public function __invoke(Request $request, WatchCourseLectureAction $watchAction)
  {
    try {
      $vildation = Validator::make($request->all(), [
        'course_id' => 'required|exists:courses,id',
        'lecture_id' => 'required|exists:course_lectures,id',
      ]);

      if ($vildation->fails()) {
        return response()->json([
          'message' => 'failed'
        ], 500);
      }

      $watchAction->markupLecture($request->course_id, $request->lecture_id);

      return response()->json([
        'message' => 'done'
      ]);
    } catch (\Exception $e) {
      return response()->json([
        'message' => 'failed'
      ], 500);
    }
  }
}
