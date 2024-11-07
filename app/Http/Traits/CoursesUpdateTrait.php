<?php

namespace App\Http\Traits;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Http\Traits\UploadAttachmentTrait;
use App\Http\Traits\UpdateStepsStatusTrait;

trait CoursesUpdateTrait
{
  use UploadAttachmentTrait, UpdateStepsStatusTrait;

  /**
   * Update course title, headline, description, language and tags.
   *
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\Course $course
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  protected static function stepOneUpdate(Request $request, Course $course)
  {
    $validated =  $request->validate([
      'title' => 'required|min:10|max:50',
      'headline' => 'required|min:50|max:255',
      'description' => 'required|min:50|max:1000',
      'language' => 'required|exists:languages,id',
      'category' => 'required|exists:tags,id',
      'tags' => 'required|array|max:5|min:1',
      'tags.*' => 'required|exists:tags,id',
    ]);

    $validated['category_id'] = $request->category;

    $course->update($validated);
    static::updateStepsStatusWithIncrementStep('stepOne', $course);

    return redirect()->route('dashboard.instructor.courses.edit', ['course' => $course->id, 'step' => $request->input('step') + 1])->with('success', 'Course updated successfully');
  }


  /**
   * Update course mockup and video presentation.
   *
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\Course $course
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  protected static function stepTwoUpdate(Request $request, Course $course)
  {
    $request->validate([
      'mockup' => ['required', File::types(['png', 'jpg', 'jpeg'])->max(2 * 1024)],
      'video-persentation' => ['required', File::types(['mp4'])->max(5 * 1024)],
    ]);

    // delete old attachments
    if ($request->hasFile('mockup') || $request->hasFile('video-persentation')) {
      static::destoryAttachment($course->mockup, 'image');
      static::destoryAttachment($course->video_preview, 'video');
    }
    $imageJson = static::uploadAttachment($request->file('mockup'), 'images', 'image');
    $videoPresentationJson = static::uploadVideo($request->file('video-persentation'), 'videos', 'video');

    $course->update([
      'mockup' => $imageJson,
      'preview_video' => $videoPresentationJson,
    ]);

    static::updateStepsStatusWithIncrementStep('stepTwo', $course);

    return redirect()->route('dashboard.instructor.courses.edit', ['course' => $course->id, 'step' => $request->input('step') + 1])->with('success', 'Course updated successfully');
  }

  /**
   * Update course learn, requirements and level.
   *
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\Course $course
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  protected static function stepThreeUpdate(Request $request, Course $course)
  {
    $request->validate([
      'learn' => ['required', 'min:50', 'max:2000'],
      'requirements' => ['required', 'min:50', 'max:2000'],
      'level' => ['required', 'in:beginner,intermediate,advanced']
    ]);

    $course->update($request->only('learn', 'requirements', 'level'));

    static::updateStepsStatusWithIncrementStep('stepThree', $course);

    return redirect()->route('dashboard.instructor.courses.edit', ['course' => $course->id, 'step' => $request->input('step') + 1])->with('success', 'Course updated successfully');
  }

  /**
   * Update course message after purchasing and after completing.
   *
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\Course $course
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  protected static function stepFiveUpdate(Request $request, Course $course)
  {
    $request->validate([
      'message-before-start' => ['required', 'min:50', 'max:2000'],
      'message-complete' => ['required', 'min:50', 'max:2000'],
    ]);

    $message = json_encode([
      'before_start' => $request->input('message-before-start'),
      'complete' => $request->input('message-complete'),
    ]);

    $course->update([
      'message' => $message
    ]);

    static::updateStepsStatusWithIncrementStep('stepFive', $course);

    return redirect()->route('dashboard.instructor.courses.edit', ['course' => $course->id, 'step' => $request->input('step') + 1])->with('success', 'Course updated successfully');
  }


  /**
   * Update course price and status to pending.
   *
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\Course $course
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  protected static function stepSixUpdate(Request $request, Course $course)
  {
    if ($course->steps == 6) {
      $request->validate([
        'price' => ['required', 'decimal:1,2', 'min:0.0', 'max:10000.0'],
      ]);

      $course->update([
        'price' => $request->price,
        'status' => 'pending'
      ]);

      static::updateStepsStatusWithIncrementStep('stepSix', $course);
      return redirect()->route('dashboard.instructor.courses.index')->with('success', 'The course has been sent for review, please wait for it.');
    }

    return redirect()->back();
  }
}
