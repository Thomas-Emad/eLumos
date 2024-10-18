<?php

namespace App\Http\Controllers\Dashboard\Instructor\Exams;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExamQuestionRequest;
use App\Http\Resources\Dashboard\Instructor\ExamQuestionResource;
use App\Models\ExamQuestion;
use App\Services\ExamQuestionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExamQuestionController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(ExamQuestionRequest $request, ExamQuestionService $questionsService)
  {
    // Store Question
    $questionId = $questionsService->storeQuestion($request->exam_id, $request->title, $request->type_question);

    // Store Answers
    $questionsService->storeAnswers(
      $request->exam_id,
      $questionId,
      $request->answers,
      $request->input('where-true'),
      $request->type_question
    );

    return redirect()->back()->with('notification', [
      'type' => 'success',
      'message' => 'Question Added Successfuly..'
    ]);
  }

  /**
   * Return a component of answers based on type question.
   *
   * @param string $type The type of question, default is 'checkbox'.
   * @return \Illuminate\Http\Response
   */
  public function getComponent($type = 'checkbox')
  {
    if (!request()->ajax()) {
      return abort(404);
    }
    $type = match ($type) {
      'checkbox' => 'checkbox',
      'radio' => 'radio',
      'text' => 'text',
      'attachment' => 'attachment',
      default => 'checkbox'
    };
    return view('components.instructor.exams.answers-' . $type)->render();
  }


  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    if (!request()->ajax()) {
      return abort(404);
    }
    $question = ExamQuestion::with('answers')->findOrFail($id);

    return response()->json(new ExamQuestionResource($question));
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
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
