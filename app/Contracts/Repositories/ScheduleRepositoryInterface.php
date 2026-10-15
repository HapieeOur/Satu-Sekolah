<?php

namespace App\Contracts\Repositories;

use App\Models\Schedule;
use Illuminate\Database\Eloquent\Collection;

interface ScheduleRepositoryInterface
{
    /**
     * Get schedules with filters.
     *
     * @param array{
     *     academic_year_id?: int,
     *     semester?: string,
     *     classroom_id?: int,
     *     teacher_id?: int,
     *     day_of_week?: string,
     *     subject_id?: int
     * } $filters
     */
    public function getFiltered(array $filters): Collection;

    public function findById(int $id): ?Schedule;

    public function create(array $data): Schedule;

    public function update(Schedule $schedule, array $data): Schedule;

    public function delete(Schedule $schedule): bool;

    /**
     * Find any schedule conflicting with classroom at given academic period, day, and time interval.
     */
    public function findClassroomConflict(
        int $academicYearId,
        string $semester,
        int $classroomId,
        string $dayOfWeek,
        string $startTime,
        string $endTime,
        ?int $excludeId = null
    ): ?Schedule;

    /**
     * Find any schedule conflicting with teacher at given academic period, day, and time interval.
     */
    public function findTeacherConflict(
        int $academicYearId,
        string $semester,
        int $teacherId,
        string $dayOfWeek,
        string $startTime,
        string $endTime,
        ?int $excludeId = null
    ): ?Schedule;

    /**
     * Find any schedule conflicting with room at given academic period, day, and time interval.
     */
    public function findRoomConflict(
        int $academicYearId,
        string $semester,
        int $roomId,
        string $dayOfWeek,
        string $startTime,
        string $endTime,
        ?int $excludeId = null
    ): ?Schedule;
}
