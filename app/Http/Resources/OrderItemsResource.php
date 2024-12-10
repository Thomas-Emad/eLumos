<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemsResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      'amount' => $this->amount . " " . $this->currency,
      'title' => $this->course->title,
      'mockup' => json_decode($this->course->mockup)->url,
      'url' => route('course-details', $this->course->id),
    ];
  }
}
