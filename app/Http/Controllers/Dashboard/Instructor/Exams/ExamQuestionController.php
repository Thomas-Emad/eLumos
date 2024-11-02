<?php

namespace App\Http\Controllers\Dashboard\Instructor\Exams;

use App\Models\ExamQuestion;
use App\Services\ExamQuestionService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExamQuestionRequest;
use App\Http\Resources\Dashboard\Instructor\ExamQuestionResource;
use Illuminate\Http\{Request, RedirectResponse, JsonResponse};

class ExamQuestionController extends Controller
{
  /**
   * Store a newly created resource in storage.
   */
  public function store(ExamQuestionRequest $request, ExamQuestionService $questionsService): RedirectResponse
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
  public function getComponent($type = 'checkbox'): String
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
    return view('components.exams.answers-' . $type)->render();
  }


  /**
   * Display the specified resource.
   */
  public function show(string $id): JsonResponse
  {
    if (!request()->ajax()) {
      return abort(404);
    }
    $question = ExamQuestion::with('answers')->findOrFail($id);

    return response()->json(new ExamQuestionResource($question));
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Request $request): RedirectResponse
  {
    $request->validate([
      'id' => 'required|exists:exam_questions,id'
    ]);

    $question =  ExamQuestion::with(['exam:id', 'exam.students:id'])->findOrFail($request->id);

    if ($question->exam->students->count() > 0) {
      return redirect()->route('dashboard.instructor.exams.index')->with('notification', [
        'type' => 'fail',
        'message' => 'Sorry, you cannot clear this exam, because some students have already passed this exam...'
      ]);
    }

    $question->delete();

    return redirect()->back()->with('notification', [
      'type' => 'success',
      'message' => 'Question Delete Successfuly..'
    ]);
  }
}
