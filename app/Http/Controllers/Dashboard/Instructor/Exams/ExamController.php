<?php

namespace App\Http\Controllers\Dashboard\Instructor\Exams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ExamController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $exams = Exam::paginate(15);
    return view('pages.dashboard.instructor.exams.index', compact('exams'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $validation = Validator::make($request->all(), [
      'title' => 'required|string|min:3|max:100'
    ]);

    if (!$validation->fails()) {
      Exam::create([
        'publisher_id' => Auth::user()->id,
        'title' => $request->title
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
  public function show(string $id)
  {
    $exam = Exam::with('questions')->findOrFail($id);

    return view('pages.dashboard.instructor.exams.manage', compact('exam'));
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
    $exam = Exam::findOrFail($id);
    $exam->delete();
    return redirect()->route('dashboard.instructor.exams.index')->with('notification', [
      'type' => 'success',
      'message' => 'We Delete This Exam Successfuly..'
    ]);
  }
}
