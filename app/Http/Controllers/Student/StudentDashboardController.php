<?php

namespace App\Http\Controllers\Student;

use App\Enums\AttendanceStatus;
use App\Enums\DayOfWeek;
use App\Enums\InternshipPlacementStatus;
use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Attendance;
use App\Models\InternshipPlacement;
use App\Models\Post;
use App\Models\Schedule;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class StudentDashboardController extends Controller
{
    /**
     * Resolve the student profile associated with the authenticated user.
     */
    protected function getStudent()
    {
        $user = Auth::user();
        if (! $user) {
            return null;
        }

        $student = Student::with(['classroom.academicYear', 'classroom.teacher.user'])
            ->where('user_id', $user->id)
            ->first();

        if (! $student && $user->nis) {
            $student = Student::with(['classroom.academicYear', 'classroom.teacher.user'])
                ->where('nis', $user->nis)
                ->first();

            if ($student && ! $student->user_id) {
                $student->update(['user_id' => $user->id]);
            }
        }

        if (! $student && $user->nisn) {
            $student = Student::with(['classroom.academicYear', 'classroom.teacher.user'])
                ->where('nisn', $user->nisn)
                ->first();

            if ($student && ! $student->user_id) {
                $student->update(['user_id' => $user->id]);
            }
        }

        return $student;
    }

    /**
     * Display student portal overview dashboard.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $student = $this->getStudent();
        $activeAcademicYear = AcademicYear::where('is_active', true)->first();

        $dayMapping = [
            1 => DayOfWeek::Senin,
            2 => DayOfWeek::Selasa,
            3 => DayOfWeek::Rabu,
            4 => DayOfWeek::Kamis,
            5 => DayOfWeek::Jumat,
            6 => DayOfWeek::Sabtu,
        ];
        $todayDay = $dayMapping[now()->dayOfWeek] ?? null;

        $weeklySchedules = collect();
        $todaySchedules = collect();
        $nextSchedule = null;

        if ($student && $student->classroom_id) {
            $weeklySchedules = Schedule::with(['subject', 'teacher.user', 'room'])
                ->where('classroom_id', $student->classroom_id)
                ->when($activeAcademicYear, fn ($q) => $q->where('academic_year_id', $activeAcademicYear->id))
                ->orderBy('day_of_week')
                ->orderBy('start_time')
                ->get();

            if ($todayDay) {
                $todaySchedules = $weeklySchedules->where('day_of_week', $todayDay->value)->values();
                $currentTime = now()->format('H:i:s');
                $nextSchedule = $todaySchedules->first(fn ($s) => $s->end_time >= $currentTime);
            }
        }

        // Attendance stats
        $attendancesSummary = [
            'total' => 0,
            'hadir' => 0,
            'terlambat' => 0,
            'izin' => 0,
            'sakit' => 0,
            'alpa' => 0,
            'rate' => 100.0,
        ];
        $recentAttendances = collect();

        if ($student) {
            $allAttendances = Attendance::with(['schedule.subject'])
                ->where('student_id', $student->id)
                ->latest('date')
                ->get();

            $total = $allAttendances->count();
            $hadir = $allAttendances->where('status', AttendanceStatus::Hadir)->count();
            $terlambat = $allAttendances->where('status', AttendanceStatus::Terlambat)->count();
            $izin = $allAttendances->where('status', AttendanceStatus::Izin)->count();
            $sakit = $allAttendances->where('status', AttendanceStatus::Sakit)->count();
            $alpa = $allAttendances->where('status', AttendanceStatus::Alpa)->count();

            $attendancesSummary = [
                'total' => $total,
                'hadir' => $hadir,
                'terlambat' => $terlambat,
                'izin' => $izin,
                'sakit' => $sakit,
                'alpa' => $alpa,
                'rate' => $total > 0 ? round((($hadir + $terlambat) / $total) * 100, 1) : 100.0,
            ];
            $recentAttendances = $allAttendances->take(5);
        }

        // Active internship placement (PKL)
        $activePlacement = null;
        if ($student) {
            $activePlacement = InternshipPlacement::with(['company', 'teacher.user', 'academicYear'])
                ->where('student_id', $student->id)
                ->where('status', InternshipPlacementStatus::Active)
                ->latest()
                ->first();
        }

        // School Announcements
        $announcements = Post::published()
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('student.dashboard', compact(
            'user',
            'student',
            'activeAcademicYear',
            'todayDay',
            'todaySchedules',
            'nextSchedule',
            'weeklySchedules',
            'attendancesSummary',
            'recentAttendances',
            'activePlacement',
            'announcements'
        ));
    }

    /**
     * Display student's weekly timetable.
     */
    public function schedules(Request $request): View
    {
        $student = $this->getStudent();
        $activeAcademicYear = AcademicYear::where('is_active', true)->first();

        $selectedDay = $request->input('day');

        $schedulesQuery = Schedule::with(['subject', 'teacher.user', 'room'])
            ->when($student && $student->classroom_id, fn ($q) => $q->where('classroom_id', $student->classroom_id))
            ->when($activeAcademicYear, fn ($q) => $q->where('academic_year_id', $activeAcademicYear->id))
            ->when($selectedDay, fn ($q) => $q->where('day_of_week', $selectedDay))
            ->orderBy('day_of_week')
            ->orderBy('start_time');

        $schedules = $student && $student->classroom_id ? $schedulesQuery->get() : collect();

        return view('student.schedules', compact('student', 'schedules', 'selectedDay', 'activeAcademicYear'));
    }

    /**
     * Display student's attendance records.
     */
    public function attendances(Request $request): View
    {
        $student = $this->getStudent();

        $attendances = collect();
        $summary = [
            'total' => 0,
            'hadir' => 0,
            'terlambat' => 0,
            'izin' => 0,
            'sakit' => 0,
            'alpa' => 0,
            'rate' => 100.0,
        ];

        if ($student) {
            $query = Attendance::with(['schedule.subject', 'schedule.teacher.user'])
                ->where('student_id', $student->id);

            if ($request->filled('month')) {
                $month = $request->input('month');
                $query->whereMonth('date', substr($month, 5, 2))
                    ->whereYear('date', substr($month, 0, 4));
            }

            $attendances = $query->latest('date')->paginate(15)->withQueryString();

            $allRecords = Attendance::where('student_id', $student->id)->get();
            $total = $allRecords->count();
            $hadir = $allRecords->where('status', AttendanceStatus::Hadir)->count();
            $terlambat = $allRecords->where('status', AttendanceStatus::Terlambat)->count();
            $izin = $allRecords->where('status', AttendanceStatus::Izin)->count();
            $sakit = $allRecords->where('status', AttendanceStatus::Sakit)->count();
            $alpa = $allRecords->where('status', AttendanceStatus::Alpa)->count();

            $summary = [
                'total' => $total,
                'hadir' => $hadir,
                'terlambat' => $terlambat,
                'izin' => $izin,
                'sakit' => $sakit,
                'alpa' => $alpa,
                'rate' => $total > 0 ? round((($hadir + $terlambat) / $total) * 100, 1) : 100.0,
            ];
        }

        return view('student.attendances', compact('student', 'attendances', 'summary'));
    }

    /**
     * Display student's PKL / Internship details.
     */
    public function internship(Request $request): View
    {
        $student = $this->getStudent();
        $activePlacement = null;

        if ($student) {
            $activePlacement = InternshipPlacement::with([
                'company',
                'teacher.user',
                'academicYear',
                'attendances' => fn ($q) => $q->latest('date')->take(5),
                'journals' => fn ($q) => $q->latest('date')->take(5),
            ])
                ->where('student_id', $student->id)
                ->where('status', InternshipPlacementStatus::Active)
                ->latest()
                ->first();
        }

        return view('student.internship', compact('student', 'activePlacement'));
    }
}
