<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        'course_id' => $this->course->id,
        'title' => Str::limit($this->course->title, 20),
        'mockup' => json_decode($this->course->mockup)->url ?? null,
        'progress' => ($this->progress_lectures),
        'rate' => [
          'stars' => $this->course->average_rating,
        ]
      ],
      'user' => [
        'id' => $this->course->user->id,
        'username' => $this->course->user->username,
        'name' =>  $this->course->user->name,
        'headline' => Str::limit($this->course->user->headline, 20),
        'photo' => Storage::url($this->course->user->photo),
      ]
    ];
  }
}
