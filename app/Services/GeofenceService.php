<?php

namespace App\Services;

class GeofenceService
{
    /**
     * Calculate distance between two GPS coordinates in meters using Haversine formula.
     *
     * @param float $lat1 Latitude of point 1
     * @param float $lon1 Longitude of point 1
     * @param float $lat2 Latitude of point 2
     * @param float $lon2 Longitude of point 2
     * @return float Distance in meters
     */
    public static function calculateDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371000; // meters

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return round($angle * $earthRadius, 2);
    }

    /**
     * Check if given coordinates are within the specified radius (in meters) of target coordinates.
     *
     * @param float $userLat
     * @param float $userLon
     * @param float $targetLat
     * @param float $targetLon
     * @param int $radiusMeters
     * @return array{is_within_radius: bool, distance_meters: float}
     */
    public static function checkGeofence(
        float $userLat,
        float $userLon,
        float $targetLat,
        float $targetLon,
        int $radiusMeters
    ): array {
        $distance = self::calculateDistance($userLat, $userLon, $targetLat, $targetLon);

        return [
            'is_within_radius' => $distance <= $radiusMeters,
            'distance_meters' => $distance,
        ];
    }
}
