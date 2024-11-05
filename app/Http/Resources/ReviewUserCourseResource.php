<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewUserCourseResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      'profile_user' =>  route("dashboard.profile", $this->user->id),
      'photo' => asset('storage/' . $this->user->photo),
      'name' => Str::limit($this->user->name, 20),
      'headline' => $this->user->headline ?? '',
      'rate' => $this->rate,
      'content' => $this->content ?? 'This was left blank.'
    ];
  }
}
