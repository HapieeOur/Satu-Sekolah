<?php

namespace App\Http\Controllers\Teacher;

use App\Contracts\Services\AttendanceServiceInterface;
use App\Http\Controllers\Controller;
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
}
