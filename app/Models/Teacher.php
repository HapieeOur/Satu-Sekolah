<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'nip',
        'nuptk',
        'gender',
        'phone',
        'address',
    ];

    /**
     * User account relation.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Subjects taught by this teacher (pivot: subject_teacher).
     */
    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'subject_teacher')
            ->withTimestamps();
    }

    /**
     * Classrooms where this teacher is homeroom teacher (wali kelas).
     */
    public function classrooms(): HasMany
    {
        return $this->hasMany(Classroom::class, 'teacher_id');
    }

    /**
     * Teaching schedules for this teacher.
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Internship placements mentored by this teacher.
     */
    public function internshipPlacements(): HasMany
    {
        return $this->hasMany(InternshipPlacement::class);
    }

    /**
     * Internship tasks assigned by this teacher.
     */
    public function internshipTasks(): HasMany
    {
        return $this->hasMany(InternshipTask::class);
    }

    /**
     * Accessor for full teacher name from user relation.
     */
    public function getNameAttribute(): string
    {
        return $this->user?->name ?? 'Tanpa Nama';
    }
}
