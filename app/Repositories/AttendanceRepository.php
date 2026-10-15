<?php

namespace App\Repositories;

use App\Contracts\Repositories\AttendanceRepositoryInterface;
use App\Enums\AttendanceStatus;
use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Database\Eloquent\Collection;

class AttendanceRepository implements AttendanceRepositoryInterface
{
    public function getByClassroomAndDate(int $classroomId, string $date): Collection
    {
        return Attendance::with(['student', 'schedule.subject', 'schedule.teacher.user'])
            ->where('classroom_id', $classroomId)
            ->whereDate('date', $date)
            ->orderBy('check_in_time')
            ->get();
    }

    public function getByScheduleAndDate(int $scheduleId, string $date): Collection
    {
        return Attendance::with(['student', 'schedule.classroom', 'schedule.subject'])
            ->where('schedule_id', $scheduleId)
            ->whereDate('date', $date)
            ->orderBy('check_in_time')
            ->get();
    }

    public function getClassroomSummary(int $classroomId, ?string $date = null): array
    {
        $query = Attendance::where('classroom_id', $classroomId);

        if ($date) {
            $query->whereDate('date', $date);
        }

        $records = $query->get();
        $total = $records->count();

        $hadir = $records->where('status', AttendanceStatus::Hadir)->count();
        $terlambat = $records->where('status', AttendanceStatus::Terlambat)->count();
        $izin = $records->where('status', AttendanceStatus::Izin)->count();
        $sakit = $records->where('status', AttendanceStatus::Sakit)->count();
        $alpa = $records->where('status', AttendanceStatus::Alpa)->count();

        $presentTotal = $hadir + $terlambat;
        $rate = $total > 0 ? round(($presentTotal / $total) * 100, 1) : 0.0;

        return [
            'total' => $total,
            'hadir' => $hadir,
            'terlambat' => $terlambat,
            'izin' => $izin,
            'sakit' => $sakit,
            'alpa' => $alpa,
            'attendance_rate' => $rate,
        ];
    }

    public function getStudentRecapForClassroom(int $classroomId, ?string $startDate = null, ?string $endDate = null): Collection
    {
        return Student::where('classroom_id', $classroomId)
            ->with(['attendances' => function ($q) use ($startDate, $endDate) {
                if ($startDate && $endDate) {
                    $q->whereBetween('date', [$startDate, $endDate]);
                }
            }])
            ->orderBy('name')
            ->get()
            ->map(function (Student $student) {
                $attendances = $student->attendances;
                $hadir = $attendances->where('status', AttendanceStatus::Hadir)->count();
                $terlambat = $attendances->where('status', AttendanceStatus::Terlambat)->count();
                $izin = $attendances->where('status', AttendanceStatus::Izin)->count();
                $sakit = $attendances->where('status', AttendanceStatus::Sakit)->count();
                $alpa = $attendances->where('status', AttendanceStatus::Alpa)->count();
                $total = $attendances->count();

                $student->hadir_count = $hadir;
                $student->terlambat_count = $terlambat;
                $student->izin_count = $izin;
                $student->sakit_count = $sakit;
                $student->alpa_count = $alpa;
                $student->total_recorded = $total;
                $student->rate = $total > 0 ? round((($hadir + $terlambat) / $total) * 100, 1) : 100.0;

                return $student;
            });
    }

    public function createOrUpdate(array $attributes, array $values): Attendance
    {
        return Attendance::updateOrCreate($attributes, $values);
    }
}
