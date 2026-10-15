<?php

namespace App\Contracts\Services;

use App\Models\Schedule;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

interface ScheduleServiceInterface
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

    /**
     * Validate and create schedule.
     *
     * @throws ValidationException
     */
    public function create(array $data): Schedule;

    /**
     * Validate and update schedule.
     *
     * @throws ValidationException
     */
    public function update(Schedule $schedule, array $data): Schedule;

    public function delete(Schedule $schedule): bool;

    /**
     * Get list of teachers assigned to a subject.
     */
    public function getTeachersBySubject(int $subjectId): Collection;

    /**
     * Validate all schedule constraints (teacher relation, class conflict, teacher conflict, room conflict).
     *
     * @throws ValidationException
     */
    public function validateScheduleConflicts(array $data, ?int $excludeId = null): void;
}
