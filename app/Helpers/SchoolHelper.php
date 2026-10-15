<?php

namespace App\Helpers;

use Carbon\Carbon;

class SchoolHelper
{
    /**
     * Format NIP into standardized grouped presentation if length is 18 digits.
     * Example: 19800101 200501 1 001
     */
    public static function formatNip(?string $nip): string
    {
        if (! $nip) {
            return '-';
        }

        $clean = preg_replace('/\D/', '', $nip);
        if (strlen($clean) === 18) {
            return substr($clean, 0, 8).' '.substr($clean, 8, 6).' '.substr($clean, 14, 1).' '.substr($clean, 15, 3);
        }

        return $nip;
    }

    /**
     * Format phone number to clean display.
     */
    public static function formatPhone(?string $phone): string
    {
        if (! $phone) {
            return '-';
        }

        return $phone;
    }

    /**
     * Format dates into Indonesian locale convention.
     */
    public static function formatDate(?string $date, string $format = 'd M Y'): string
    {
        if (! $date) {
            return '-';
        }

        return Carbon::parse($date)->translatedFormat($format);
    }

    /**
     * Calculate distance between two coordinates in meters (Haversine formula).
     * Useful for PKL geofence validation.
     */
    public static function calculateDistanceMeters(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371000; // in meters

        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($lonDelta / 2) * sin($lonDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return round($earthRadius * $c, 2);
    }
}
