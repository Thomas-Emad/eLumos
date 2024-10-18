<?php

namespace App\Http\Resources\Dashboard\Instructor;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamQuestionResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      'question' => [
        'id' => $this->id,
        'title' => $this->title,
        'type_question' => $this->type_question
      ],
      'answers' => ExamQuestionAnswersResource::collection($this->answers)
    ];
  }
}
