<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InternshipAttendanceResource extends JsonResource
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
            'status' => $this->status?->value ?? $this->status,
            'status_label' => method_exists($this->status, 'label') ? $this->status->label() : ucfirst($this->status?->value ?? (string) $this->status),
            'check_in_time' => $this->check_in_time ? substr((string) $this->check_in_time, 0, 5) : null,
            'check_in_latitude' => $this->check_in_latitude !== null ? (float) $this->check_in_latitude : null,
            'check_in_longitude' => $this->check_in_longitude !== null ? (float) $this->check_in_longitude : null,
            'check_in_photo_url' => $this->check_in_photo_path ? asset('storage/' . $this->check_in_photo_path) : null,
            'check_in_distance_meters' => $this->check_in_distance_meters !== null ? (float) $this->check_in_distance_meters : null,
            'check_in_within_radius' => (bool) $this->check_in_within_radius,
            'check_out_time' => $this->check_out_time ? substr((string) $this->check_out_time, 0, 5) : null,
            'check_out_latitude' => $this->check_out_latitude !== null ? (float) $this->check_out_latitude : null,
            'check_out_longitude' => $this->check_out_longitude !== null ? (float) $this->check_out_longitude : null,
            'check_out_photo_url' => $this->check_out_photo_path ? asset('storage/' . $this->check_out_photo_path) : null,
            'check_out_distance_meters' => $this->check_out_distance_meters !== null ? (float) $this->check_out_distance_meters : null,
            'check_out_within_radius' => (bool) $this->check_out_within_radius,
            'verification_status' => $this->verification_status?->value ?? $this->verification_status,
            'verification_status_label' => method_exists($this->verification_status, 'label') ? $this->verification_status->label() : ucfirst($this->verification_status?->value ?? (string) $this->verification_status),
            'rejection_reason' => $this->rejection_reason,
            'notes' => $this->notes,
            'is_manual_correction' => (bool) $this->is_manual_correction,
            'student' => $this->placement && $this->placement->student ? [
                'id' => $this->placement->student->id,
                'nis' => $this->placement->student->nis,
                'name' => $this->placement->student->name,
                'classroom' => $this->placement->student->classroom?->name,
            ] : null,
        ];
    }
}
