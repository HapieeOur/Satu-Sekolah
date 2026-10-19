<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InternshipSubmissionResource extends JsonResource
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
            'internship_task_id' => $this->internship_task_id,
            'student_id' => $this->student_id,
            'student' => $this->student ? [
                'id' => $this->student->id,
                'nis' => $this->student->nis,
                'name' => $this->student->name,
                'classroom' => $this->student->classroom?->name,
            ] : null,
            'submission_file_url' => $this->submission_file_path ? asset('storage/'.$this->submission_file_path) : null,
            'student_notes' => $this->student_notes,
            'submitted_at' => $this->submitted_at?->format('Y-m-d H:i:s'),
            'status' => $this->status?->value ?? $this->status,
            'status_label' => method_exists($this->status, 'label') ? $this->status->label() : ucfirst($this->status?->value ?? (string) $this->status),
            'grade' => $this->grade,
            'mentor_feedback' => $this->mentor_feedback,
            'graded_at' => $this->graded_at?->format('Y-m-d H:i:s'),
            'grader' => $this->grader ? [
                'id' => $this->grader->id,
                'name' => $this->grader->name,
            ] : null,
        ];
    }
}
