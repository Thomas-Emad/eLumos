<?php

namespace App\Http\Controllers\Dashboard\Instructor\Exams;

use App\Models\Exam;
use App\Models\StudentCourseExamAnswer;
use App\Http\Traits\FilterByDateTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class ExamController extends Controller
{
  use FilterByDateTrait;

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request): View
  {
    $exams = Exam::where('title', 'like', "%$request->title%")->whereBetween('created_at', static::filterByDate($request->filterByDate))
      ->paginate(15);

    $answers = StudentCourseExamAnswer::with([
      'question:id,title,type_question',
      "sessionStudent:id,exam_id",
      "sessionStudent.exam:id,title"
    ])->where('is_true', null)->get();


    return view('pages.dashboard.instructor.exams.index', compact('exams', 'answers'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request): RedirectResponse
  {
    $validation = Validator::make($request->all(), [
      'title' => 'required|string|min:3|max:100',
      'duration' => 'nullable|integer|max:240'
    ]);

    if (!$validation->fails()) {
      Exam::create([
        'publisher_id' => Auth::user()->id,
        'title' => $request->title,
        'duration' => $request->duration
      ]);

      return redirect()->back()->with('notification', [
        'type' => 'success',
        'message' => 'Exam Added Successfuly..'
      ]);
    } else {
      return redirect()->back()->with('notification', [
        'type' => 'fail',
        'message' => 'Somethings is wrong: ' . $validation->errors()->first()
      ]);
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id): View
  {
    $exam = Exam::with([
      'questions',
      'students',
      'lectures'
    ])->findOrFail($id);

    return view('pages.dashboard.instructor.exams.manage', compact('exam'));
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id): RedirectResponse
  {
    $exam = Exam::findOrFail($id);

    if ($exam->students->count() > 0) {
      return redirect()->route('dashboard.instructor.exams.index')->with('notification', [
        'type' => 'fail',
        'message' => 'Sorry, you cannot clear this exam, because some students have already passed this exam...'
      ]);
    }

    $exam->delete();
    return redirect()->route('dashboard.instructor.exams.index')->with('notification', [
      'type' => 'success',
      'message' => 'We Delete This Exam Successfuly..'
    ]);
  }
}
