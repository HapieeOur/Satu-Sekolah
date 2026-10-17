<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentProfileResource extends JsonResource
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
            'nis' => $this->nis,
            'nisn' => $this->nisn,
            'name' => $this->name,
            'gender' => $this->gender,
            'phone' => $this->phone,
            'address' => $this->address,
            'parent_name' => $this->parent_name,
            'parent_phone' => $this->parent_phone,
            'status' => $this->status,
            'classroom' => $this->classroom ? [
                'id' => $this->classroom->id,
                'name' => $this->classroom->name,
                'major' => $this->classroom->major,
                'grade_level' => $this->classroom->grade_level,
            ] : null,
        ];
    }
}
