<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'company' => $this->company,
            'department' => $this->department,
            'job_title' => $this->job_title,
            'desk' => $this->desk,
            'state' => $this->state,
            'type' => $this->type,
            'permission_level' => $this->permission_level,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
