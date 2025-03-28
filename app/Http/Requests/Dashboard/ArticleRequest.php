<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'slug' => 'required|min:3|max:255|unique:articles,slug',
            'title' => "required|min:3|max:255|string",
            'headline' => 'required|min:3|max:255',
            // 'photo' => [
            //     'sometimes',
            //     File::types(['png', 'jpg', 'jpeg'])
            //         ->min(128)
            //         ->max(1024 * 20)
            // ],
            'content' => 'required|min:10|max:2024',
            'tags' => 'required|array|min:1|max:5'
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => Auth::id(),
            'tags' => explode(',', $this->tags)
        ]);
    }

    protected function passedValidation()
    {
        // $tags = 
        $this->merge([
            'user_id' => Auth::id(),
        ]);
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
        redirect()->back()->with([
            'notification' => [
                'type' => 'fail',
                'message' => 'Something is wrong: ' . $validator->errors()->first(),
            ],
        ])->withInput()
            ->withErrors($validator)->throwResponse();
    }
}
