<?php

namespace App\Enums;

enum DayOfWeek: string
{
    case Senin = 'senin';
    case Selasa = 'selasa';
    case Rabu = 'rabu';
    case Kamis = 'kamis';
    case Jumat = 'jumat';
    case Sabtu = 'sabtu';

    public function label(): string
    {
        return match ($this) {
            self::Senin => 'Senin',
            self::Selasa => 'Selasa',
            self::Rabu => 'Rabu',
            self::Kamis => 'Kamis',
            self::Jumat => 'Jumat',
            self::Sabtu => 'Sabtu',
        };
    }

    /**
     * Get all day values.
     *
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get options array for selects.
     *
     * @return array<string, string>
     */
    public static function options(): array
    {
        return [
            self::Senin->value => self::Senin->label(),
            self::Selasa->value => self::Selasa->label(),
            self::Rabu->value => self::Rabu->label(),
            self::Kamis->value => self::Kamis->label(),
            self::Jumat->value => self::Jumat->label(),
            self::Sabtu->value => self::Sabtu->label(),
        ];
    }
}
