<?php

namespace App\Http\Resources\Dashboard\Instructor;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamQuestionAnswersResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      'id' => $this->id,
      'title' => $this->title,
      'type_question' => $this->type_question,
      'answer' => $this->answer,
      'is_true' =>  $this->is_true
    ];
  }
}
