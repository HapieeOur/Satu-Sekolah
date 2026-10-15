<?php

namespace App\Models;

use App\Enums\DayOfWeek;
use App\Enums\Semester;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'academic_year_id',
        'semester',
        'classroom_id',
        'subject_id',
        'teacher_id',
        'room_id',
        'day_of_week',
        'start_time',
        'end_time',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'semester' => Semester::class,
            'day_of_week' => DayOfWeek::class,
        ];
    }

    /**
     * Academic year relation.
     */
    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    /**
     * Classroom relation.
     */
    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    /**
     * Subject relation.
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Teacher relation.
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Room relation.
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Attendances recorded for this schedule.
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Formatted start and end time.
     */
    public function getTimeRangeAttribute(): string
    {
        $start = substr((string) $this->start_time, 0, 5);
        $end = substr((string) $this->end_time, 0, 5);

        return "{$start} - {$end}";
    }

    /**
     * Scope for filtering by academic year and semester.
     */
    public function scopeForAcademicPeriod(Builder $query, int $academicYearId, string|Semester $semester): Builder
    {
        $semesterValue = $semester instanceof Semester ? $semester->value : $semester;

        return $query->where('academic_year_id', $academicYearId)
            ->where('semester', $semesterValue);
    }

    /**
     * Scope for classroom.
     */
    public function scopeForClassroom(Builder $query, int $classroomId): Builder
    {
        return $query->where('classroom_id', $classroomId);
    }

    /**
     * Scope for teacher.
     */
    public function scopeForTeacher(Builder $query, int $teacherId): Builder
    {
        return $query->where('teacher_id', $teacherId);
    }

    /**
     * Scope for day of week.
     */
    public function scopeForDay(Builder $query, string|DayOfWeek $day): Builder
    {
        $dayValue = $day instanceof DayOfWeek ? $day->value : $day;

        return $query->where('day_of_week', $dayValue);
    }
}
