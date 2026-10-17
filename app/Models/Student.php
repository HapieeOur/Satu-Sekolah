<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'nis',
        'nisn',
        'name',
        'gender',
        'classroom_id',
        'phone',
        'address',
        'parent_name',
        'parent_phone',
        'status',
    ];

    /**
     * User account relation.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Classroom relation.
     */
    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    /**
     * Attendances of this student.
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Internship placements of this student.
     */
    public function internshipPlacements(): HasMany
    {
        return $this->hasMany(InternshipPlacement::class);
    }

    /**
     * Internship task submissions of this student.
     */
    public function taskSubmissions(): HasMany
    {
        return $this->hasMany(InternshipTaskSubmission::class);
    }

    /**
     * Scope only active students.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'aktif');
    }
}
