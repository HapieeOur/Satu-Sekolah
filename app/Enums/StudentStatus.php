<?php

namespace App\Enums;

enum StudentStatus: string
{
    case AKTIF = 'aktif';
    case ALUMNI = 'alumni';
    case PINDAH = 'pindah';
    case KELUAR = 'keluar';

    public function label(): string
    {
        return match ($this) {
            self::AKTIF => 'Aktif',
            self::ALUMNI => 'Alumni / Lulus',
            self::PINDAH => 'Pindah Sekolah',
            self::KELUAR => 'Keluar / DO',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::AKTIF => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            self::ALUMNI => 'bg-blue-50 text-blue-700 border-blue-200',
            self::PINDAH => 'bg-amber-50 text-amber-700 border-amber-200',
            self::KELUAR => 'bg-rose-50 text-rose-700 border-rose-200',
        };
    }
}
