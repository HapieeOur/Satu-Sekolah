<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InternshipPlacementResource extends JsonResource
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
            'department' => $this->department,
            'status' => $this->status?->value ?? $this->status,
            'status_label' => method_exists($this->status, 'label') ? $this->status->label() : ucfirst($this->status?->value ?? (string) $this->status),
            'start_date' => $this->start_date?->format('Y-m-d'),
            'end_date' => $this->end_date?->format('Y-m-d'),
            'notes' => $this->notes,
            'company' => $this->company ? [
                'id' => $this->company->id,
                'name' => $this->company->name,
                'address' => $this->company->address,
                'contact_person' => $this->company->contact_person,
                'phone' => $this->company->phone,
                'email' => $this->company->email,
                'latitude' => (float) $this->company->latitude,
                'longitude' => (float) $this->company->longitude,
                'radius_meters' => (int) $this->company->radius_meters,
            ] : null,
            'mentor' => $this->teacher ? [
                'id' => $this->teacher->id,
                'name' => $this->teacher->user?->name,
                'phone' => $this->teacher->phone,
                'nip' => $this->teacher->nip,
            ] : null,
            'student' => $this->student ? [
                'id' => $this->student->id,
                'nis' => $this->student->nis,
                'name' => $this->student->name,
                'classroom' => $this->student->classroom?->name,
            ] : null,
        ];
    }
}
