<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicExam extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'classroom_id',
        'subject_id',
        'academic_year_id',
        'title',
        'description',
        'exam_date',
        'duration_minutes',
        'passing_score',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'exam_date' => 'datetime',
            'duration_minutes' => 'integer',
            'passing_score' => 'integer',
        ];
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function scores(): HasMany
    {
        return $this->hasMany(AcademicExamScore::class);
    }
}
