<?php

namespace App\Services;

use App\Contracts\Repositories\AttendanceRepositoryInterface;
use App\Contracts\Services\AttendanceServiceInterface;
use App\Models\Classroom;
use App\Models\Schedule;
use App\Models\Teacher;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;

class AttendanceService implements AttendanceServiceInterface
{
    public function __construct(
        protected AttendanceRepositoryInterface $attendanceRepository
    ) {}

    public function getHomeroomAttendance(int $userId, string $date): array
    {
        $teacher = Teacher::where('user_id', $userId)->first();
        if (! $teacher) {
            return [
                'classroom' => null,
                'attendances' => new Collection,
                'summary' => [
                    'total' => 0,
                    'hadir' => 0,
                    'terlambat' => 0,
                    'izin' => 0,
                    'sakit' => 0,
                    'alpa' => 0,
                    'attendance_rate' => 0.0,
                ],
                'date' => $date,
            ];
        }

        // Classroom where this teacher is homeroom teacher
        $classroom = Classroom::with('students')->where('teacher_id', $teacher->id)->first();
        if (! $classroom) {
            return [
                'classroom' => null,
                'attendances' => new Collection,
                'summary' => [
                    'total' => 0,
                    'hadir' => 0,
                    'terlambat' => 0,
                    'izin' => 0,
                    'sakit' => 0,
                    'alpa' => 0,
                    'attendance_rate' => 0.0,
                ],
                'date' => $date,
            ];
        }

        $attendances = $this->attendanceRepository->getByClassroomAndDate($classroom->id, $date);
        $summary = $this->attendanceRepository->getClassroomSummary($classroom->id, $date);

        return [
            'classroom' => $classroom,
            'attendances' => $attendances,
            'summary' => $summary,
            'date' => $date,
        ];
    }

    public function getHomeroomRecap(int $userId, ?string $startDate = null, ?string $endDate = null): array
    {
        $teacher = Teacher::where('user_id', $userId)->first();
        if (! $teacher) {
            return [
                'classroom' => null,
                'studentRecap' => new Collection,
            ];
        }

        $classroom = Classroom::where('teacher_id', $teacher->id)->first();
        if (! $classroom) {
            return [
                'classroom' => null,
                'studentRecap' => new Collection,
            ];
        }

        $studentRecap = $this->attendanceRepository->getStudentRecapForClassroom($classroom->id, $startDate, $endDate);

        return [
            'classroom' => $classroom,
            'studentRecap' => $studentRecap,
        ];
    }

    public function getTeacherScheduleAttendance(int $userId, int $scheduleId, string $date): array
    {
        $schedule = Schedule::with(['classroom.students', 'subject', 'teacher'])->findOrFail($scheduleId);

        // IDOR Check: Ensure teacher is assigned to this schedule
        if ($schedule->teacher?->user_id !== $userId) {
            throw new AuthorizationException('Anda tidak memiliki wewenang untuk mengakses data presensi pada jadwal mengajar guru lain.');
        }

        $attendances = $this->attendanceRepository->getByScheduleAndDate($scheduleId, $date);
        $enrolledStudents = $schedule->classroom?->students ?? new Collection;

        return [
            'schedule' => $schedule,
            'attendances' => $attendances,
            'enrolledStudents' => $enrolledStudents,
            'date' => $date,
        ];
    }

    public function getTeacherSchedules(int $userId): Collection
    {
        $teacher = Teacher::where('user_id', $userId)->first();
        if (! $teacher) {
            return new Collection;
        }

        return Schedule::with(['classroom', 'subject'])
            ->where('teacher_id', $teacher->id)
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
}
