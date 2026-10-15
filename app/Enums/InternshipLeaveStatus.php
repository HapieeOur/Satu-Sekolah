<?php

namespace App\Enums;

enum InternshipLeaveStatus: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Menunggu Verifikasi',
            self::Approved => 'Disetujui',
            self::Rejected => 'Ditolak',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Pending => 'bg-amber-50 text-amber-800 border-amber-300',
            self::Approved => 'bg-emerald-50 text-emerald-800 border-emerald-300',
            self::Rejected => 'bg-rose-50 text-rose-800 border-rose-300',
        };
    }
}
