<?php

namespace App\Enums;

enum InternshipVerificationStatus: string
{
    case Verified = 'verified';
    case Pending = 'pending';
    case Rejected = 'rejected';
    case Corrected = 'corrected';

    public function label(): string
    {
        return match ($this) {
            self::Verified => 'Terverifikasi',
            self::Pending => 'Menunggu Verifikasi',
            self::Rejected => 'Ditolak',
            self::Corrected => 'Koreksi Manual',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Verified => 'bg-emerald-50 text-emerald-800 border-emerald-300',
            self::Pending => 'bg-amber-50 text-amber-800 border-amber-300',
            self::Rejected => 'bg-rose-50 text-rose-800 border-rose-300',
            self::Corrected => 'bg-indigo-50 text-indigo-800 border-indigo-300',
        };
    }
}
