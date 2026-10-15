<?php

namespace App\Models;

use App\Enums\InternshipAttendanceStatus;
use App\Enums\InternshipVerificationStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InternshipAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'internship_placement_id',
        'date',
        'status',
        'check_in_time',
        'check_in_latitude',
        'check_in_longitude',
        'check_in_photo_path',
        'check_in_distance_meters',
        'check_in_within_radius',
        'check_out_time',
        'check_out_latitude',
        'check_out_longitude',
        'check_out_photo_path',
        'check_out_distance_meters',
        'check_out_within_radius',
        'verification_status',
        'rejection_reason',
        'notes',
        'is_manual_correction',
        'corrected_by',
        'correction_reason',
        'corrected_at',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'status' => InternshipAttendanceStatus::class,
            'verification_status' => InternshipVerificationStatus::class,
            'check_in_within_radius' => 'boolean',
            'check_out_within_radius' => 'boolean',
            'is_manual_correction' => 'boolean',
            'corrected_at' => 'datetime',
        ];
    }

    public function placement(): BelongsTo
    {
        return $this->belongsTo(InternshipPlacement::class, 'internship_placement_id');
    }

    public function corrector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'corrected_by');
    }

    public function scopeForDate(Builder $query, string $date): Builder
    {
        return $query->whereDate('date', $date);
    }

    public function scopePendingVerification(Builder $query): Builder
    {
        return $query->where('verification_status', InternshipVerificationStatus::Pending);
    }
}
