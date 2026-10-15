<?php

namespace App\Models;

use App\Enums\InternshipTaskSubmissionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InternshipTaskSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'internship_task_id',
        'student_id',
        'submission_file_path',
        'student_notes',
        'submitted_at',
        'status',
        'grade',
        'mentor_feedback',
        'graded_by',
        'graded_at',
    ];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'graded_at' => 'datetime',
            'status' => InternshipTaskSubmissionStatus::class,
            'grade' => 'integer',
        ];
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(InternshipTask::class, 'internship_task_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function grader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'graded_by');
    }
}
