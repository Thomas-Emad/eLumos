<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentCourseExam;
use App\Http\Traits\UploadAttachmentTrait;
use App\Services\StudentExamService;


class StudentExamController extends Controller
{
  use UploadAttachmentTrait;

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $sessions = StudentCourseExam::with('exam')->paginate(15);
    return view('pages.dashboard.student.exams.index', compact('sessions'));
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
  public function store(Request $request)
  {
    //
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
    $session = StudentCourseExam::with(
      'exam:id,title,duration',
      'exam.questions:id,exam_id,title,type_question',
      'exam.questions.answers:id,question_id,answer,is_true'
    )->findOrFail($id);

    return view('pages.dashboard.student.exams.exam', compact('session'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, StudentExamService $studentExamService, string $id)
  {
    $session = StudentCourseExam::with([
      'exam:id,duration',
      'exam.questions:id,exam_id,type_question',
      'exam.questions.answers:id,question_id,is_true'
    ])->findOrFail($id);

    $request->validate([
      'user_id' => 'required|in:0,' . $session->user_id,
      'questions' => 'array|min:' . $session->exam->questions->count(),
      'questions.*.typeQuestion' => 'required|in:checkbox,radio,text,attachment',
      'questions.*.answers' => 'required',
    ]);

    $studentExamService->questionsEngine($session, $request->questions);

    $statusExam = $studentExamService->getStatusExam($session->exam->questions->count());

    // After finish from Correct Answers Upload Session
    $session->update([
      'degree' => $studentExamService->getDegree(),
      'status' => $statusExam
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
