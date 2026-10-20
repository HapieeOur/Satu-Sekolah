<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classroom extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'grade_level',
        'major',
        'academic_year_id',
        'teacher_id',
    ];

    /**
     * Academic year relation.
     */
    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    /**
     * Homeroom teacher (Wali Kelas) relation.
     */
    public function homeroomTeacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    /**
     * Alias for homeroom teacher relation.
     */
    public function teacher(): BelongsTo
    {
        return $this->homeroomTeacher();
    }

    /**
     * Students enrolled in this classroom.
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    /**
     * Schedules for this classroom.
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Attendances recorded for this classroom.
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}
