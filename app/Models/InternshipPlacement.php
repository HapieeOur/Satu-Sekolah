<?php

namespace App\Models;

use App\Enums\InternshipPlacementStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InternshipPlacement extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'internship_company_id',
        'teacher_id',
        'academic_year_id',
        'start_date',
        'end_date',
        'department',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'status' => InternshipPlacementStatus::class,
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(InternshipCompany::class, 'internship_company_id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(InternshipAttendance::class);
    }

    public function journals(): HasMany
    {
        return $this->hasMany(InternshipJournal::class);
    }

    public function leaveRequests(): HasMany
    {
        return $this->hasMany(InternshipLeaveRequest::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', InternshipPlacementStatus::Active);
    }

    public function scopeForTeacher(Builder $query, int $teacherId): Builder
    {
        return $query->where('teacher_id', $teacherId);
    }
}
