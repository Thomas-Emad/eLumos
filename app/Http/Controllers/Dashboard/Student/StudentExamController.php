<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Models\StudentCourseExam;
use App\Models\ExamQuestion;
use App\Http\Controllers\Controller;
use App\Http\Traits\FilterByDateTrait;
use App\Http\Traits\UploadAttachmentTrait;
use App\Services\StudentExamService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;


class StudentExamController extends Controller
{
  use UploadAttachmentTrait, FilterByDateTrait;

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request): View
  {
    $sessions = StudentCourseExam::with(['exam'])
      ->whereHas('exam', function ($query) use ($request) {
        $query->where('title', 'LIKE', "%$request->title%");
      })->whereBetween('created_at', static::filterByDate($request->filterByDate))
      ->paginate(15);
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
    $totalDegree = ExamQuestion::where('exam_id',  $request->exam_id)->count();
    if ($totalDegree === 0) {
      return abort(500);
    }

    if ($request->type !== 'join') {
      $session = Auth::user()->sessionsExam()->create(
        ['lecture_id' => $request->lecture_id, 'exam_id' => $request->exam_id, 'total_degree' => $totalDegree]
      );
    } else {
      $session = Auth::user()->sessionsExam()->firstOrCreate(
        ['lecture_id' => $request->lecture_id, 'exam_id' => $request->exam_id],
        ['lecture_id' => $request->lecture_id, 'exam_id' => $request->exam_id, 'total_degree' => $totalDegree]
      );
    }
    return redirect()->route("dashboard.student.exams.test", ['exam' => $session->id]);
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

    // check from Duration Exam's Session 
    if ($session->status !== 'processing') {
      return view('pages.dashboard.student.exams.alerts.done', compact('session'));
    } elseif (!is_null($session->exam->duration) && (now()->addMinutes($session->exam->duration) <= $session->created_at->addMinutes($session->exam->duration))) {
      return view('pages.dashboard.student.exams.alerts.expired');
    }

    $timeLeftExam = round(now()->diffInSeconds($session->created_at->addMinutes($session->exam->duration)), 0);

    return view('pages.dashboard.student.exams.exam', compact('session', 'timeLeftExam'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, StudentExamService $studentExamService, string $id)
  {
    $session = StudentCourseExam::with([
      'lecture:id,course_id',
      'exam:id,duration',
      'exam.questions:id,exam_id,type_question',
      'exam.questions.answers:id,question_id,is_true'
    ])->where('status', 'processing')->findOrFail($id);

    $request->validate([
      'user_id' => 'required|in:0,' . $session->user_id,
      'questions' => 'array|max:' . $session->exam->questions->count(),
    ]);

    $studentExamService->questionsEngine($session, $request->questions);

    $statusExam = $studentExamService->getStatusExam($session->exam->questions->count());

    // Save User Watched this Lecture
    if ($statusExam === 'sucess') {
      $studentExamService->markupOnWatchLecture($session->lecture->course_id, $session->lecture_id);
    }

    // After finish from Correct Answers Upload Session
    $session->update([
      'degree' => $studentExamService->getDegree(),
      'status' => $statusExam
    ]);

    return redirect()->route('dashboard.student.exams.done', $session->id);
  }




  public function report(string $session)
  {
    $session = StudentCourseExam::with([
      'lecture:id,course_id',
      'lecture.course:id,title,mockup',
      'exam:id,title,duration',
      'exam.questions:id,exam_id,title,type_question',
      'exam.questions.answers:id,question_id,is_true,answer',
      'exam.questions.answers.answerStudent' => function ($query) use ($session) {
        $query->where('std_course_exam_id', $session);
      },
    ])->findOrFail($session);




    // return dd($session);
    return view('pages.dashboard.student.exams.alerts.report', compact('session'));
  }

  public function done(string $session)
  {
    $session = StudentCourseExam::findOrfail($session);
    return view('pages.dashboard.student.exams.alerts.done', compact('session'));
  }
}
