<?php

namespace App\Contracts\Services;

use App\Models\Classroom;
use App\Models\Schedule;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;

interface AttendanceServiceInterface
{
    /**
     * Get attendance data for a homeroom teacher (Wali Kelas) on a given date.
     *
     * @return array{
     *     classroom: ?Classroom,
     *     attendances: Collection,
     *     summary: array,
     *     date: string
     * }
     */
    public function getHomeroomAttendance(int $userId, string $date): array;

    /**
     * Get semester / range attendance recap for a homeroom teacher's classroom.
     *
     * @return array{
     *     classroom: ?Classroom,
     *     studentRecap: Collection
     * }
     */
    public function getHomeroomRecap(int $userId, ?string $startDate = null, ?string $endDate = null): array;

    /**
     * Get attendance for a subject teacher (Guru Mata Pelajaran) for a specific schedule session on a date.
     *
     * @return array{
     *     schedule: Schedule,
     *     attendances: Collection,
     *     enrolledStudents: Collection,
     *     date: string
     * }
     *
     * @throws AuthorizationException
     */
    public function getTeacherScheduleAttendance(int $userId, int $scheduleId, string $date): array;

    /**
     * Get all schedules assigned to a teacher for dropdown filter.
     */
    public function getTeacherSchedules(int $userId): Collection;
}
