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
        'title' => \Str::limit($this->title, 20),
        'status' => $this->status,
        'mockup' => json_decode($this->mockup)->url ?? null,
      ],
      'user' => [
        'id' => $this->user->id,
        'username' => $this->user->username,
        'name' => $this->user->name,
        'headline' => $this->user->headline,
        'photo' => $this->user->photo,
      ]
    ];
  }
}
