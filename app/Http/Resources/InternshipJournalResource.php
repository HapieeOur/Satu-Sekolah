<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InternshipJournalResource extends JsonResource
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
            'internship_placement_id' => $this->internship_placement_id,
            'date' => $this->date?->format('Y-m-d'),
            'title' => $this->title,
            'activity_description' => $this->activity_description,
            'attachment_url' => $this->attachment_path ? asset('storage/'.$this->attachment_path) : null,
            'status' => $this->status?->value ?? $this->status,
            'status_label' => method_exists($this->status, 'label') ? $this->status->label() : ucfirst($this->status?->value ?? (string) $this->status),
            'mentor_notes' => $this->mentor_notes,
            'reviewed_at' => $this->reviewed_at?->format('Y-m-d H:i:s'),
            'reviewer' => $this->reviewer ? [
                'id' => $this->reviewer->id,
                'name' => $this->reviewer->name,
            ] : null,
            'student' => $this->placement && $this->placement->student ? [
                'id' => $this->placement->student->id,
                'nis' => $this->placement->student->nis,
                'name' => $this->placement->student->name,
                'classroom' => $this->placement->student->classroom?->name,
            ] : null,
        ];
    }
}
