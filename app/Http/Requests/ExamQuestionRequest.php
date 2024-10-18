<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ExamQuestionRequest extends FormRequest
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
    $rules = [
      'exam_id' => 'required|exists:exams,id',
      'title' => 'required|string|min:3|max:100',
      'type_question' => 'required|in:checkbox,radio,text,attachment',
      'answers' => 'required|array',
      'where-true' => 'required|array',
      'where-true.*' => 'required|string'
    ];

    if (in_array($this->type_question, ['text', 'attachment'])) {
      $rules['answers.*'] = 'nullable|string';
    } else {
      $rules['answers.*'] = 'required|string';
    }

    return $rules;
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
