<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use function PHPUnit\Framework\isNull;

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
      'title' => $this->title,
      'order_sort' => $this->order_sort,
      'hasContent' => !is_null($this->content),
      'hasVideo' =>  !is_null($this->video),
      'hasExam' => false,
    ];
  }
}