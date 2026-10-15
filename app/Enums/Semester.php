<?php

namespace App\Enums;

enum Semester: string
{
    case GANJIL = 'ganjil';
    case GENAP = 'genap';

    public function label(): string
    {
        return match ($this) {
            self::GANJIL => 'Semester Ganjil (1)',
            self::GENAP => 'Semester Genap (2)',
        };
    }
}
