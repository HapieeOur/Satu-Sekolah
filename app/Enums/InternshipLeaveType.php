<?php

namespace App\Enums;

enum InternshipLeaveType: string
{
    case Izin = 'izin';
    case Sakit = 'sakit';

    public function label(): string
    {
        return match ($this) {
            self::Izin => 'Izin',
            self::Sakit => 'Sakit',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Izin => 'bg-blue-50 text-blue-800 border-blue-300',
            self::Sakit => 'bg-purple-50 text-purple-800 border-purple-300',
        };
    }
}
