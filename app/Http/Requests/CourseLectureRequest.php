<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\CourseSections;

class CourseLectureRequest extends FormRequest
{
  protected $section;

  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
      'section_id' => [
        Rule::requiredIf($this->routeIs('dashboard.api.instructor.courses.lectures.store')),
        'exists:course_sections,id',
      ],
      'id' => [
        Rule::requiredIf($this->routeIs('dashboard.api.instructor.courses.lectures.update')),
        'exists:course_lectures,id',
      ],
      'title' => ['required', 'min:5', 'max:49'],
      'content' => ['nullable', 'max:5000', 'string'],
      'video' => ['exclude_unless:video,null', 'max:40000', 'mimetypes:video/mp4'],
      'exam' => 'nullable|exists:exams,id'
    ];
  }

  /**
   * Handle a failed validation attempt.
   *
   * @param  \Illuminate\Contracts\Validation\Validator  $validator
   * @return void
   *
   * @throws \Illuminate\Validation\ValidationException
   */
  protected function failedValidation(Validator $validator)
  {
    throw new HttpResponseException(response()->json([
      'notification' => [
        'type' => 'fail',
        'message' => "Error in verifying data (" . $validator->errors()->count() . "): " . $validator->errors()->first()
      ]
    ], 400));
  }


  /**
   * Check if section_id is valid before querying the section and
   * make sure not to add more than 10 lectures in one section.
   *
   * @return void
   *
   * @throws \Illuminate\Validation\ValidationException
   */
  public function validateResolved()
  {
    parent::validateResolved();

    // Check if section_id is valid before querying the section
    if ($this->has('section_id')) {
      $sectionId = $this->input('section_id');
      $this->section = CourseSections::with(['course', 'lectures'])->findOrFail($sectionId);

      // If the section already has 10 lectures
      if ($this->section->lectures()->count() >= 10) {
        throw new HttpResponseException(response()->json([
          'notification' => [
            'type' => 'fail',
            'message' => 'You Can\'t Add More Than 10 Lectures in one Section.'
          ]
        ], 400));
      }
    }
  }

  // Add a method to get the section
  public function section()
  {
    return $this->section;
  }
}
