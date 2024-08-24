<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CoursesDashboardResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      'data' => [
        'id' => $this->id,
        'title' => $this->title,
        'status' => $this->status,
        'image' => $this->image
      ],
      'user' => [
        'id' => $this->user->id,
        'name' => $this->user->name,
        'headline' => $this->user->headline,
        'photo' => $this->user->photo,
      ]
    ];
  }
}
