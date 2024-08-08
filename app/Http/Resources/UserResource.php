<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'role_id' => $this->roles->first()->id,
            'roles' => [
                [
                    'id' => 1,
                    'name' => 'Owner'
                ],
                [
                    'id' => 2,
                    'name' => 'Admin'
                ],
            ],
            'photo' => $this->photo
        ];
    }
}
