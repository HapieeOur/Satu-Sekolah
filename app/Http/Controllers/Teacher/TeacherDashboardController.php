<?php

namespace App\Http\Controllers\Teacher;

use App\Enums\DayOfWeek;
use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Classroom;
use App\Models\Post;
use App\Models\Schedule;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TeacherDashboardController extends Controller
{
    /**
     * Display the teacher dashboard with real teaching assignments, upcoming schedules, and announcements.
     */
    public function index(): View
    {
        $user = Auth::user();
        $teacher = Teacher::with('subjects')->where('user_id', $user->id)->first();

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
        $currentTime = now()->format('H:i:s');

        $todaySchedules = collect();
        $nextSchedule = null;
        $assignedClassrooms = collect();
        $assignedSubjects = collect();
        $weeklySchedulesCount = 0;

        if ($teacher) {
            $assignedSubjects = $teacher->subjects;

            $weeklySchedulesQuery = Schedule::with(['classroom', 'subject', 'room', 'academicYear'])
                ->where('teacher_id', $teacher->id)
                ->when($activeAcademicYear, fn ($q) => $q->where('academic_year_id', $activeAcademicYear->id));

            $weeklySchedulesCount = (clone $weeklySchedulesQuery)->count();

            // Assigned classrooms where the teacher actually teaches
            $classroomIds = (clone $weeklySchedulesQuery)->pluck('classroom_id')->unique();
            $assignedClassrooms = Classroom::with('academicYear')->whereIn('id', $classroomIds)->get();

            if ($todayDay) {
                $todaySchedules = (clone $weeklySchedulesQuery)
                    ->where('day_of_week', $todayDay->value)
                    ->orderBy('start_time')
                    ->get();

                // Find next upcoming schedule today
                $nextSchedule = $todaySchedules->first(fn ($s) => $s->end_time >= $currentTime);
            }

            // If no schedule left today, look for next day's first schedule
            if (! $nextSchedule && $weeklySchedulesCount > 0) {
                $nextSchedule = (clone $weeklySchedulesQuery)
                    ->orderBy('day_of_week')
                    ->orderBy('start_time')
                    ->first();
            }
        }

        // Announcements and school news
        $recentAnnouncements = Post::published()
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('dashboard.teacher', compact(
            'user',
            'teacher',
            'activeAcademicYear',
            'todayDay',
            'todaySchedules',
            'nextSchedule',
            'assignedClassrooms',
            'assignedSubjects',
            'weeklySchedulesCount',
            'recentAnnouncements'
        ));
    }
}
