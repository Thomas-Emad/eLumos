<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class CourseReviewLogRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    $user = auth()->user();

    // Check if the user is authenticated
    if (!$user) {
      return false;
    }

    // Check if the user has admin privileges
    if ($user->can('admin-control-courses')) {
      return true;
    }

    // Check if the user has instructor privileges and owns the course
    if (
      $user->can('instructors-control-courses') &&
      $user->courses()->whereKey($this->course_id)->exists() &&
      in_array($this->status, ['active', 'inactive', 'removed'])
    ) {
      return true;
    }

    return false;
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
