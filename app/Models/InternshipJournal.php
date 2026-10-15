<?php

namespace App\Models;

use App\Enums\InternshipJournalStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InternshipJournal extends Model
{
    use HasFactory;

    protected $fillable = [
        'internship_placement_id',
        'date',
        'title',
        'activity_description',
        'attachment_path',
        'status',
        'mentor_notes',
        'reviewed_by',
        'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'status' => InternshipJournalStatus::class,
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

    public function scopePendingReview(Builder $query): Builder
    {
        return $query->where('status', InternshipJournalStatus::Submitted);
    }
}
