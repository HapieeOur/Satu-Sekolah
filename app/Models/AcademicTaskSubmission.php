<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AcademicTaskSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_task_id',
        'student_id',
        'submission_file_path',
        'student_notes',
        'submitted_at',
        'grade',
        'teacher_feedback',
        'graded_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'graded_at' => 'datetime',
            'grade' => 'integer',
        ];
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(AcademicTask::class, 'academic_task_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Check if the submission file is an image.
     */
    public function isSubmissionImage(): bool
    {
        if (! $this->submission_file_path) {
            return false;
        }

        $extension = strtolower(pathinfo($this->submission_file_path, PATHINFO_EXTENSION));

        return in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'bmp']);
    }

    /**
     * Get the public asset URL for the submission file.
     */
    public function getSubmissionFileUrlAttribute(): ?string
    {
        return $this->submission_file_path ? asset('storage/'.$this->submission_file_path) : null;
    }
}
