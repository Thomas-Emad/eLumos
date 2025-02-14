<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LectureCourseResource extends JsonResource
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
      'username' => $this->username,
      'title' => $this->title,
      'order_sort' => $this->order_sort,
      'hasContent' => !is_null($this->content),
      'hasVideo' =>  !is_null($this->video),
      'hasExam' => !is_null($this->exam),
    ];
  }
}
