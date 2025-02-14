<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\Permission\Models\Permission;

class ShowRoleInfoRescource extends JsonResource
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
            'name' => $this->name,
            'created' => $this->created_at->toDateTimeString(),
            'users_count' => $this->users()->count(),
            'permissions_count' => $this->permissions()->count(),
            'permissions' => $this->permissions()->get(['id', 'name']),
            'all_permissions' => Permission::get(['id', 'name'])
        ];
    }
}
