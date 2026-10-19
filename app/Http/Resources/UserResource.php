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
            'phone' => $this->phone,
            'avatar_url' => $this->avatar ? asset('storage/'.$this->avatar) : null,
            'is_active' => (bool) $this->is_active,
            'roles' => $this->roles->pluck('name'),
            'student' => $this->whenLoaded('student', fn () => new StudentProfileResource($this->student), $this->student ? new StudentProfileResource($this->student) : null),
            'teacher' => $this->whenLoaded('teacher', fn () => new TeacherProfileResource($this->teacher), $this->teacher ? new TeacherProfileResource($this->teacher) : null),
        ];
    }
}
