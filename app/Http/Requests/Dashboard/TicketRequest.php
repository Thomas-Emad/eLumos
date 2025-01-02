<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;
use Illuminate\Contracts\Validation\Validator;

class TicketRequest extends FormRequest
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
      'subject' => "required|min:10|max:255|string",
      'description' => "required|min:50|max:2000|string",
      'attachments' => [
        "sometimes",
        "max:3",
        'array',
      ],
      'attachments.*' => [
        File::types(['png', 'jpg', 'jpeg', 'webp', 'pdf', 'word', 'mp4'])
          ->max(1024 * 20)
      ],
      'type' => "in:assistant,payment,technial_support,other"
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
    // Return a redirect with validation errors and custom notification
    redirect()->back()->with([
      'notification' => [
        'type' => 'fail',
        'message' => 'Something is wrong: ' . $validator->errors()->first(),
      ],
    ])->withErrors($validator)
      ->withInput()->throwResponse();
  }
}
