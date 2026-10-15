<?php

namespace App\Enums;

enum Gender: string
{
    case MALE = 'L';
    case FEMALE = 'P';

    public function label(): string
    {
        return match ($this) {
            self::MALE => 'Laki-laki',
            self::FEMALE => 'Perempuan',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::MALE => 'bg-blue-50 text-blue-700 border-blue-200',
            self::FEMALE => 'bg-pink-50 text-pink-700 border-pink-200',
        };
    }
}
