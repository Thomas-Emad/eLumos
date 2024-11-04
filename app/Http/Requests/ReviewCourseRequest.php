<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ReviewCourseRequest extends FormRequest
{
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
      'course_id' => "required|exists:courses,id",
      'rate' => "required|integer|min:1|max:5",
      'content' => "nullable|string|max:600"
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
    $errorCount = $validator->errors()->count();
    $firstError = $validator->errors()->first();

    // Manually flash the notification to the session
    session()->flash('notification', [
      'type' => 'fail',
      'message' => "Error in verifying data ($errorCount): $firstError"
    ]);

    throw new ValidationException($validator);
  }
}
