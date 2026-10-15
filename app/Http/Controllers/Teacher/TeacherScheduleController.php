<?php

namespace App\Http\Controllers\Teacher;

use App\Contracts\Services\AcademicYearServiceInterface;
use App\Contracts\Services\ScheduleServiceInterface;
use App\Enums\DayOfWeek;
use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TeacherScheduleController extends Controller
{
    public function __construct(
        protected ScheduleServiceInterface $scheduleService,
        protected AcademicYearServiceInterface $academicYearService
    ) {}

    /**
     * Display personal teaching schedule for the authenticated teacher.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $teacher = $user->teacher;

        $activeYear = AcademicYear::where('is_active', true)->first();
        $academicYearId = $request->filled('academic_year_id')
            ? (int) $request->input('academic_year_id')
            : ($activeYear?->id ?? null);

        $semester = $request->filled('semester')
            ? $request->input('semester')
            : ($activeYear?->semester ?? 'ganjil');

        $academicYears = $this->academicYearService->getAll();
        $days = DayOfWeek::options();

        $schedulesGrouped = collect();
        $totalSlots = 0;
        $uniqueClassrooms = collect();

        if ($teacher && $academicYearId) {
            $filters = [
                'academic_year_id' => $academicYearId,
                'semester' => $semester,
                'teacher_id' => $teacher->id,
            ];

            $schedules = $this->scheduleService->getFiltered($filters);
            $totalSlots = $schedules->count();
            $uniqueClassrooms = $schedules->pluck('classroom.name')->unique();
            $schedulesGrouped = $schedules->groupBy(fn ($item) => $item->day_of_week->value);
        }

        return view('teacher.schedules.index', compact(
            'teacher',
            'academicYears',
            'academicYearId',
            'semester',
            'days',
            'schedulesGrouped',
            'totalSlots',
            'uniqueClassrooms'
        ));
    }
}
