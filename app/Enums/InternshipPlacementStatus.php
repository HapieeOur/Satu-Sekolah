<?php

namespace App\Enums;

enum InternshipPlacementStatus: string
{
    case Active = 'active';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Active => 'Aktif',
            self::Completed => 'Selesai',
            self::Cancelled => 'Dibatalkan',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Active => 'bg-emerald-50 text-emerald-800 border-emerald-300',
            self::Completed => 'bg-slate-100 text-slate-800 border-slate-300',
            self::Cancelled => 'bg-rose-50 text-rose-800 border-rose-300',
        };
    }
}
