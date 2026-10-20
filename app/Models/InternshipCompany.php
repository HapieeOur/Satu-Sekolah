<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InternshipCompany extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'teacher_id',
        'name',
        'address',
        'contact_person',
        'phone',
        'email',
        'latitude',
        'longitude',
        'radius_meters',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'radius_meters' => 'integer',
        ];
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function placements(): HasMany
    {
        return $this->hasMany(InternshipPlacement::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(InternshipTask::class);
    }
}
