<?php

namespace App\Enums;

enum AttendanceStatus: string
{
    case Hadir = 'hadir';
    case Terlambat = 'terlambat';
    case Izin = 'izin';
    case Sakit = 'sakit';
    case Alpa = 'alpa';

    public function label(): string
    {
        return match ($this) {
            self::Hadir => 'Hadir',
            self::Terlambat => 'Terlambat',
            self::Izin => 'Izin',
            self::Sakit => 'Sakit',
            self::Alpa => 'Alpa / Tanpa Keterangan',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Hadir => 'bg-emerald-50 text-emerald-800 border-emerald-300',
            self::Terlambat => 'bg-amber-50 text-amber-800 border-amber-300',
            self::Izin => 'bg-blue-50 text-blue-800 border-blue-300',
            self::Sakit => 'bg-purple-50 text-purple-800 border-purple-300',
            self::Alpa => 'bg-rose-50 text-rose-800 border-rose-300',
        };
    }

    /**
     * Get all status values.
     *
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
