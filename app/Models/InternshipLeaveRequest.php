<?php

namespace App\Models;

use App\Enums\InternshipLeaveStatus;
use App\Enums\InternshipLeaveType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InternshipLeaveRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'internship_placement_id',
        'type',
        'start_date',
        'end_date',
        'reason',
        'attachment_path',
        'status',
        'reviewed_by',
        'reviewed_at',
        'review_notes',
    ];

    protected function casts(): array
    {
        return [
            'type' => InternshipLeaveType::class,
            'status' => InternshipLeaveStatus::class,
            'start_date' => 'date',
            'end_date' => 'date',
            'reviewed_at' => 'datetime',
        ];
    }

    public function placement(): BelongsTo
    {
        return $this->belongsTo(InternshipPlacement::class, 'internship_placement_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', InternshipLeaveStatus::Pending);
    }
}
