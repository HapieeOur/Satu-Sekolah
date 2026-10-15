<?php

namespace App\Services;

use App\Contracts\Repositories\ScheduleRepositoryInterface;
use App\Contracts\Services\ScheduleServiceInterface;
use App\Models\Schedule;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ScheduleService implements ScheduleServiceInterface
{
    public function __construct(
        public ScheduleRepositoryInterface $scheduleRepository
    ) {}

    public function getFiltered(array $filters): Collection
    {
        return $this->scheduleRepository->getFiltered($filters);
    }

    public function findById(int $id): ?Schedule
    {
        return $this->scheduleRepository->findById($id);
    }

    public function create(array $data): Schedule
    {
        $this->validateScheduleConflicts($data);

        return $this->scheduleRepository->create($data);
    }

    public function update(Schedule $schedule, array $data): Schedule
    {
        $this->validateScheduleConflicts($data, $schedule->id);

        return $this->scheduleRepository->update($schedule, $data);
    }

    public function delete(Schedule $schedule): bool
    {
        return $this->scheduleRepository->delete($schedule);
    }

    public function getTeachersBySubject(int $subjectId): Collection
    {
        $subject = Subject::with('teachers.user')->find($subjectId);

        return $subject ? $subject->teachers : new Collection;
    }

    public function validateScheduleConflicts(array $data, ?int $excludeId = null): void
    {
        $academicYearId = (int) $data['academic_year_id'];
        $semester = is_object($data['semester']) ? $data['semester']->value : (string) $data['semester'];
        $classroomId = (int) $data['classroom_id'];
        $subjectId = (int) $data['subject_id'];
        $teacherId = (int) $data['teacher_id'];
        $roomId = ! empty($data['room_id']) ? (int) $data['room_id'] : null;
        $dayOfWeek = is_object($data['day_of_week']) ? $data['day_of_week']->value : (string) $data['day_of_week'];
        $startTime = $data['start_time'];
        $endTime = $data['end_time'];

        // 1. Validasi guru terhubung ke mata pelajaran (pivot subject_teacher)
        $teachesSubject = DB::table('subject_teacher')
            ->where('subject_id', $subjectId)
            ->where('teacher_id', $teacherId)
            ->exists();

        if (! $teachesSubject) {
            throw ValidationException::withMessages([
                'teacher_id' => 'Guru yang dipilih tidak ditugaskan untuk mengajar mata pelajaran ini.',
            ]);
        }

        // 2. Validasi bentrok kelas
        $classConflict = $this->scheduleRepository->findClassroomConflict(
            $academicYearId,
            $semester,
            $classroomId,
            $dayOfWeek,
            $startTime,
            $endTime,
            $excludeId
        );

        if ($classConflict) {
            $conflictSubject = $classConflict->subject?->name ?? 'Mata pelajaran lain';
            $conflictTime = $classConflict->time_range;
            throw ValidationException::withMessages([
                'start_time' => "Bentrok jadwal kelas: Kelas ini sudah memiliki jadwal {$conflictSubject} pada {$conflictTime}.",
            ]);
        }

        // 3. Validasi bentrok guru
        $teacherConflict = $this->scheduleRepository->findTeacherConflict(
            $academicYearId,
            $semester,
            $teacherId,
            $dayOfWeek,
            $startTime,
            $endTime,
            $excludeId
        );

        if ($teacherConflict) {
            $conflictClass = $teacherConflict->classroom?->name ?? 'kelas lain';
            $conflictTime = $teacherConflict->time_range;
            throw ValidationException::withMessages([
                'teacher_id' => "Bentrok jadwal guru: Guru ini sudah memiliki jadwal mengajar di {$conflictClass} pada {$conflictTime}.",
            ]);
        }

        // 4. Validasi bentrok ruangan jika ruangan diisi
        if ($roomId) {
            $roomConflict = $this->scheduleRepository->findRoomConflict(
                $academicYearId,
                $semester,
                $roomId,
                $dayOfWeek,
                $startTime,
                $endTime,
                $excludeId
            );

            if ($roomConflict) {
                $conflictClass = $roomConflict->classroom?->name ?? 'kelas lain';
                $conflictTime = $roomConflict->time_range;
                throw ValidationException::withMessages([
                    'room_id' => "Bentrok penggunaan ruangan: Ruangan ini sudah digunakan oleh {$conflictClass} pada {$conflictTime}.",
                ]);
            }
        }
    }
}
