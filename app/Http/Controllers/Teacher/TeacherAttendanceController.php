<?php

namespace App\Http\Controllers\Teacher;

use App\Contracts\Services\AttendanceServiceInterface;
use App\Enums\AttendanceStatus;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TeacherAttendanceController extends Controller
{
    public function __construct(
        protected AttendanceServiceInterface $attendanceService
    ) {}

    /**
     * Display student attendance for a teacher's specific teaching schedule session.
     */
    public function index(Request $request): View
    {
        $userId = Auth::id();
        $schedules = $this->attendanceService->getTeacherSchedules($userId);

        $selectedScheduleId = $request->filled('schedule_id')
            ? (int) $request->input('schedule_id')
            : ($schedules->first()?->id ?? null);

        $date = $request->input('date', now()->toDateString());

        $schedule = null;
        $attendances = collect();
        $enrolledStudents = collect();

        if ($selectedScheduleId) {
            $data = $this->attendanceService->getTeacherScheduleAttendance($userId, $selectedScheduleId, $date);
            $schedule = $data['schedule'];
            $attendances = $data['attendances'];
            $enrolledStudents = $data['enrolledStudents'];
        }

        return view('teacher.attendances.index', compact(
            'schedules',
            'selectedScheduleId',
            'schedule',
            'attendances',
            'enrolledStudents',
            'date'
        ));
    }

    /**
     * Store or update attendance records for a teaching schedule session.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'schedule_id' => ['required', 'exists:schedules,id'],
            'date' => ['required', 'date'],
            'attendances' => ['required', 'array', 'min:1'],
            'attendances.*.status' => ['required', 'string', 'in:hadir,terlambat,izin,sakit,alpa'],
            'attendances.*.notes' => ['nullable', 'string', 'max:255'],
        ]);

        $userId = Auth::id();
        $teacher = Teacher::where('user_id', $userId)->first();
        if (! $teacher) {
            abort(403, 'Profil guru tidak ditemukan.');
        }

        $schedule = Schedule::findOrFail($validated['schedule_id']);
        if ($schedule->teacher_id !== $teacher->id) {
            abort(403, 'Jadwal pelajaran ini bukan milik Anda.');
        }

        $dateFormatted = Carbon::parse($validated['date'])->toDateString();
        $savedCount = 0;

        foreach ($validated['attendances'] as $studentId => $item) {
            $student = Student::find($studentId);
            if (! $student) {
                continue;
            }

            Attendance::updateOrCreate(
                [
                    'schedule_id' => $schedule->id,
                    'student_id' => $student->id,
                    'date' => $dateFormatted,
                ],
                [
                    'classroom_id' => $schedule->classroom_id,
                    'status' => AttendanceStatus::from($item['status']),
                    'check_in_time' => now()->format('H:i:s'),
                    'notes' => $item['notes'] ?? null,
                ]
            );

            $savedCount++;
        }

        return redirect()->route('teacher.attendances.index', [
            'schedule_id' => $schedule->id,
            'date' => $dateFormatted,
        ])->with('success', "Presensi berhasil disimpan untuk {$savedCount} siswa.");
    }
}
