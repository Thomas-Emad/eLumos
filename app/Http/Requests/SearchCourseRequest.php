<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchCourseRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  public function prepareForValidation()
  {
    $this->merge([
      'selectBy' => $this->input("selectBy") ?? 'top-rate',
      'levels' => $this->input('levels') ?? ['beginner', 'intermediate', 'advanced'],
      'freeCourse' => in_array('free', $this->input('coursePrice') ?? []),
      'paidCourse' => in_array('paid', $this->input('coursePrice') ?? []),

    ]);
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
      //
    ];
  }
}
