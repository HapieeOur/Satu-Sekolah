<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Api\ApiController;
use App\Models\AcademicYear;
use App\Models\Attendance;
use App\Models\Schedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentAcademicController extends ApiController
{
    /**
     * Get class timetable for the authenticated student.
     */
    public function schedules(Request $request): JsonResponse
    {
        $student = $request->user()?->student;
        if (! $student || ! $student->classroom_id) {
            return $this->respondWithError('Data kelas siswa tidak ditemukan.', 404);
        }

        $academicYear = AcademicYear::where('is_active', true)->first();

        $query = Schedule::with(['subject', 'teacher.user', 'room'])
            ->where('classroom_id', $student->classroom_id);

        if ($academicYear) {
            $query->where('academic_year_id', $academicYear->id);
        }

        if ($request->filled('day')) {
            $query->where('day_of_week', $request->input('day'));
        }

        $schedules = $query->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get()
            ->map(fn ($s) => [
                'id' => $s->id,
                'day_of_week' => $s->day_of_week?->value ?? $s->day_of_week,
                'day_label' => method_exists($s->day_of_week, 'label') ? $s->day_of_week->label() : ucfirst($s->day_of_week?->value ?? (string) $s->day_of_week),
                'start_time' => substr((string) $s->start_time, 0, 5),
                'end_time' => substr((string) $s->end_time, 0, 5),
                'time_range' => $s->time_range,
                'subject' => $s->subject ? [
                    'id' => $s->subject->id,
                    'name' => $s->subject->name,
                    'code' => $s->subject->code,
                ] : null,
                'teacher' => $s->teacher && $s->teacher->user ? [
                    'id' => $s->teacher->id,
                    'name' => $s->teacher->user->name,
                ] : null,
                'room' => $s->room ? [
                    'id' => $s->room->id,
                    'name' => $s->room->name,
                    'code' => $s->room->code,
                ] : null,
            ]);

        return $this->respondWithSuccess([
            'classroom' => [
                'id' => $student->classroom->id,
                'name' => $student->classroom->name,
                'major' => $student->classroom->major,
            ],
            'schedules' => $schedules,
        ], 'Jadwal pelajaran kelas siswa.');
    }

    /**
     * Get academic classroom attendance history.
     */
    public function attendances(Request $request): JsonResponse
    {
        $student = $request->user()?->student;
        if (! $student) {
            return $this->respondWithError('Data siswa tidak ditemukan.', 404);
        }

        $attendances = Attendance::with(['schedule.subject', 'classroom'])
            ->where('student_id', $student->id)
            ->orderBy('date', 'desc')
            ->paginate(20);

        return $this->respondWithPagination($attendances, null, 'Riwayat presensi kelas.');
    }
}
