<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InternshipTaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $userId = $request->user()?->id;
        $studentId = $request->user()?->student?->id;

        $submission = null;
        if ($studentId && $this->relationLoaded('submissions')) {
            $userSub = $this->submissions->firstWhere('student_id', $studentId);
            $submission = $userSub ? new InternshipSubmissionResource($userSub) : null;
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'due_date' => $this->due_date?->format('Y-m-d'),
            'attachment_url' => $this->attachment_path ? asset('storage/' . $this->attachment_path) : null,
            'company' => $this->company ? [
                'id' => $this->company->id,
                'name' => $this->company->name,
            ] : null,
            'teacher' => $this->teacher ? [
                'id' => $this->teacher->id,
                'name' => $this->teacher->user?->name,
            ] : null,
            'submission' => $submission,
            'submissions_count' => $this->whenCounted('submissions'),
        ];
    }
}
