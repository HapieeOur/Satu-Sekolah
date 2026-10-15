<?php

namespace App\Http\Controllers\Homeroom;

use App\Contracts\Services\AttendanceServiceInterface;
use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HomeroomDashboardController extends Controller
{
    public function __construct(
        protected AttendanceServiceInterface $attendanceService
    ) {}

    /**
     * Display the homeroom teacher dashboard with real classroom metrics.
     */
    public function index(): View
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();

        $classroom = null;
        $totalStudents = 0;
        $attendanceSummary = [
            'total' => 0,
            'hadir' => 0,
            'terlambat' => 0,
            'izin' => 0,
            'sakit' => 0,
            'alpa' => 0,
            'attendance_rate' => 0.0,
        ];
        $recentAttendances = collect();

        if ($teacher) {
            $classroom = Classroom::with(['students', 'academicYear'])
                ->where('teacher_id', $teacher->id)
                ->first();

            if ($classroom) {
                $totalStudents = $classroom->students->count();
                $attendanceData = $this->attendanceService->getHomeroomAttendance($user->id, now()->toDateString());
                $attendanceSummary = $attendanceData['summary'];
                $recentAttendances = $attendanceData['attendances']->take(5);
            }
        }

        return view('dashboard.homeroom', compact(
            'user',
            'teacher',
            'classroom',
            'totalStudents',
            'attendanceSummary',
            'recentAttendances'
        ));
    }
}
