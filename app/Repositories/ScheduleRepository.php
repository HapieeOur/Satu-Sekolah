<?php

namespace App\Repositories;

use App\Contracts\Repositories\ScheduleRepositoryInterface;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ScheduleRepository implements ScheduleRepositoryInterface
{
    /**
     * Get schedules with filters.
     */
    public function getFiltered(array $filters): Collection
    {
        $query = Schedule::with([
            'academicYear',
            'classroom',
            'subject',
            'teacher.user',
            'room',
        ]);

        if (! empty($filters['academic_year_id'])) {
            $query->where('academic_year_id', $filters['academic_year_id']);
        }

        if (! empty($filters['semester'])) {
            $query->where('semester', $filters['semester']);
        }

        if (! empty($filters['classroom_id'])) {
            $query->where('classroom_id', $filters['classroom_id']);
        }

        if (! empty($filters['teacher_id'])) {
            $query->where('teacher_id', $filters['teacher_id']);
        }

        if (! empty($filters['day_of_week'])) {
            $query->where('day_of_week', $filters['day_of_week']);
        }

        if (! empty($filters['subject_id'])) {
            $query->where('subject_id', $filters['subject_id']);
        }

        return $query
            ->orderByRaw("CASE day_of_week
                WHEN 'senin' THEN 1
                WHEN 'selasa' THEN 2
                WHEN 'rabu' THEN 3
                WHEN 'kamis' THEN 4
                WHEN 'jumat' THEN 5
                WHEN 'sabtu' THEN 6
                ELSE 7 END")
            ->orderBy('start_time')
            ->get();
    }

    public function findById(int $id): ?Schedule
    {
        return Schedule::with([
            'academicYear',
            'classroom',
            'subject',
            'teacher.user',
            'room',
        ])->find($id);
    }

    public function create(array $data): Schedule
    {
        return Schedule::create($data);
    }

    public function update(Schedule $schedule, array $data): Schedule
    {
        $schedule->update($data);

        return $schedule;
    }

    public function delete(Schedule $schedule): bool
    {
        return (bool) $schedule->delete();
    }

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
    ): ?Schedule {
        return Schedule::where('academic_year_id', $academicYearId)
            ->where('semester', $semester)
            ->where('classroom_id', $classroomId)
            ->where('day_of_week', $dayOfWeek)
            ->when($excludeId, fn (Builder $q) => $q->where('id', '!=', $excludeId))
            ->where(function (Builder $q) use ($startTime, $endTime) {
                $q->where('start_time', '<', $endTime)
                    ->where('end_time', '>', $startTime);
            })
            ->with(['subject', 'teacher.user'])
            ->first();
    }

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
    ): ?Schedule {
        return Schedule::where('academic_year_id', $academicYearId)
            ->where('semester', $semester)
            ->where('teacher_id', $teacherId)
            ->where('day_of_week', $dayOfWeek)
            ->when($excludeId, fn (Builder $q) => $q->where('id', '!=', $excludeId))
            ->where(function (Builder $q) use ($startTime, $endTime) {
                $q->where('start_time', '<', $endTime)
                    ->where('end_time', '>', $startTime);
            })
            ->with(['subject', 'classroom'])
            ->first();
    }

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
    ): ?Schedule {
        return Schedule::where('academic_year_id', $academicYearId)
            ->where('semester', $semester)
            ->where('room_id', $roomId)
            ->where('day_of_week', $dayOfWeek)
            ->when($excludeId, fn (Builder $q) => $q->where('id', '!=', $excludeId))
            ->where(function (Builder $q) use ($startTime, $endTime) {
                $q->where('start_time', '<', $endTime)
                    ->where('end_time', '>', $startTime);
            })
            ->with(['classroom', 'subject'])
            ->first();
    }
}
