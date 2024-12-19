<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CourseReviewLogRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return auth()->check() && auth()->user()->can('admin-control-courses');
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
      'course_id' => 'required|exists:courses,id',
      'status' => 'required|in:draft,pending,rejected,active,blocked,removed,inactive',
      'reason' => 'sometimes|nullable|string|max:1000',
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
    // Redirect back with session data and validation errors
    redirect()->back()->with([
      'notification' => [
        'type' => 'fail',
        'message' => 'Something is wrong: ' . $validator->errors()->first(),
      ],
    ])->withErrors($validator)->throwResponse();
  }
}
