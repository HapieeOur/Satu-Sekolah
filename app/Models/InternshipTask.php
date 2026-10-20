<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InternshipTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'internship_company_id',
        'title',
        'description',
        'due_date',
        'attachment_path',
    ];

    protected function casts(): array
    {
        return [
            'due_date' => 'datetime',
        ];
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(InternshipCompany::class, 'internship_company_id');
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(InternshipTaskSubmission::class);
    }
}
