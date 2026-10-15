<?php

namespace App\Contracts\Repositories;

use App\Models\Attendance;
use Illuminate\Database\Eloquent\Collection;

interface AttendanceRepositoryInterface
{
    /**
     * Get attendance records for a classroom on a specific date.
     */
    public function getByClassroomAndDate(int $classroomId, string $date): Collection;

    /**
     * Get attendance records for a specific schedule session on a date.
     */
    public function getByScheduleAndDate(int $scheduleId, string $date): Collection;

    /**
     * Get statistics summary (hadir, terlambat, izin, sakit, alpa) for a classroom on a date.
     *
     * @return array{
     *     total: int,
     *     hadir: int,
     *     terlambat: int,
     *     izin: int,
     *     sakit: int,
     *     alpa: int,
     *     attendance_rate: float
     * }
     */
    public function getClassroomSummary(int $classroomId, ?string $date = null): array;

    /**
     * Get attendance recap grouped by student for a classroom within optional date range.
     */
    public function getStudentRecapForClassroom(int $classroomId, ?string $startDate = null, ?string $endDate = null): Collection;

    /**
     * Create or update attendance record.
     */
    public function createOrUpdate(array $attributes, array $values): Attendance;
}
