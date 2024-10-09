<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CoursesEnrolledResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    $this->course->load('lectures');

    return [
      'data' => [
        'id' => $this->course->id,
        'title' => \Str::limit($this->course->title, 20),
        'mockup' => json_decode($this->course->mockup)->url ?? null,
        'progress' => ($this->progress_lectures / $this->course->lectures()->count()) * 100
      ],
      'user' => [
        'id' => $this->user->id,
        'name' => $this->user->name,
        'headline' => $this->user->headline,
        'photo' => Storage::url($this->user->photo),
      ]
    ];
  }
}
