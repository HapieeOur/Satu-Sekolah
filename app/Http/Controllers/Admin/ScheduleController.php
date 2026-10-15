<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Services\AcademicYearServiceInterface;
use App\Contracts\Services\ClassroomServiceInterface;
use App\Contracts\Services\RoomServiceInterface;
use App\Contracts\Services\ScheduleServiceInterface;
use App\Contracts\Services\SubjectServiceInterface;
use App\Contracts\Services\TeacherServiceInterface;
use App\Enums\DayOfWeek;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreScheduleRequest;
use App\Http\Requests\Admin\UpdateScheduleRequest;
use App\Models\AcademicYear;
use App\Models\Classroom;
use App\Models\Schedule;
use App\Models\Subject;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ScheduleController extends Controller
{
    public function __construct(
        protected ScheduleServiceInterface $scheduleService,
        protected ClassroomServiceInterface $classroomService,
        protected SubjectServiceInterface $subjectService,
        protected TeacherServiceInterface $teacherService,
        protected RoomServiceInterface $roomService,
        protected AcademicYearServiceInterface $academicYearService
    ) {}

    /**
     * Display schedules filtered by classroom.
     */
    public function index(Request $request): View
    {
        $activeYear = AcademicYear::where('is_active', true)->first();
        $academicYearId = $request->filled('academic_year_id')
            ? (int) $request->input('academic_year_id')
            : ($activeYear?->id ?? null);

        $semester = $request->filled('semester')
            ? $request->input('semester')
            : ($activeYear?->semester ?? 'ganjil');

        $classroomId = $request->filled('classroom_id') ? (int) $request->input('classroom_id') : null;
        $dayOfWeek = $request->filled('day_of_week') ? $request->input('day_of_week') : null;

        $academicYears = $this->academicYearService->getAll();
        $classrooms = $this->classroomService->getAll();
        $days = DayOfWeek::options();

        $selectedClassroom = $classroomId ? Classroom::with('homeroomTeacher.user')->find($classroomId) : null;

        $schedulesGrouped = collect();

        if ($classroomId && $academicYearId) {
            $filters = [
                'academic_year_id' => $academicYearId,
                'semester' => $semester,
                'classroom_id' => $classroomId,
            ];

            if ($dayOfWeek) {
                $filters['day_of_week'] = $dayOfWeek;
            }

            $schedules = $this->scheduleService->getFiltered($filters);
            $schedulesGrouped = $schedules->groupBy(fn ($item) => $item->day_of_week->value);
        }

        return view('admin.schedules.index', compact(
            'academicYears',
            'classrooms',
            'days',
            'academicYearId',
            'semester',
            'classroomId',
            'dayOfWeek',
            'selectedClassroom',
            'schedulesGrouped'
        ));
    }

    /**
     * Show form to create schedule.
     */
    public function create(Request $request): View
    {
        $activeYear = AcademicYear::where('is_active', true)->first();
        $defaultAcademicYearId = $request->input('academic_year_id', $activeYear?->id);
        $defaultSemester = $request->input('semester', $activeYear?->semester ?? 'ganjil');
        $defaultClassroomId = $request->input('classroom_id');

        $academicYears = $this->academicYearService->getAll();
        $classrooms = $this->classroomService->getAll();
        $subjects = Subject::with('teachers.user')->orderBy('name')->get();
        $rooms = $this->roomService->getAll();
        $days = DayOfWeek::options();

        return view('admin.schedules.create', compact(
            'academicYears',
            'classrooms',
            'subjects',
            'rooms',
            'days',
            'defaultAcademicYearId',
            'defaultSemester',
            'defaultClassroomId'
        ));
    }

    /**
     * Store a newly created schedule.
     */
    public function store(StoreScheduleRequest $request): RedirectResponse
    {
        $this->scheduleService->create($request->validated());

        return redirect()->route('admin.schedules.index', [
            'academic_year_id' => $request->academic_year_id,
            'semester' => $request->semester,
            'classroom_id' => $request->classroom_id,
        ])->with('success', 'Jadwal pelajaran berhasil ditambahkan.');
    }

    /**
     * Show form to edit schedule.
     */
    public function edit(Schedule $schedule): View
    {
        $schedule->load(['academicYear', 'classroom', 'subject', 'teacher.user', 'room']);

        $academicYears = $this->academicYearService->getAll();
        $classrooms = $this->classroomService->getAll();
        $subjects = Subject::with('teachers.user')->orderBy('name')->get();
        $rooms = $this->roomService->getAll();
        $days = DayOfWeek::options();

        // Get teachers for the selected subject
        $teachersForSubject = $this->scheduleService->getTeachersBySubject($schedule->subject_id);

        return view('admin.schedules.edit', compact(
            'schedule',
            'academicYears',
            'classrooms',
            'subjects',
            'teachersForSubject',
            'rooms',
            'days'
        ));
    }

    /**
     * Update an existing schedule.
     */
    public function update(UpdateScheduleRequest $request, Schedule $schedule): RedirectResponse
    {
        $this->scheduleService->update($schedule, $request->validated());

        return redirect()->route('admin.schedules.index', [
            'academic_year_id' => $request->academic_year_id,
            'semester' => $request->semester,
            'classroom_id' => $request->classroom_id,
        ])->with('success', 'Jadwal pelajaran berhasil diperbarui.');
    }

    /**
     * Delete schedule.
     */
    public function destroy(Schedule $schedule): RedirectResponse
    {
        $classroomId = $schedule->classroom_id;
        $academicYearId = $schedule->academic_year_id;
        $semester = $schedule->semester->value;

        $this->scheduleService->delete($schedule);

        return redirect()->route('admin.schedules.index', [
            'academic_year_id' => $academicYearId,
            'semester' => $semester,
            'classroom_id' => $classroomId,
        ])->with('success', 'Jadwal pelajaran berhasil dihapus.');
    }

    /**
     * API to get teachers assigned to a subject.
     */
    public function teachersBySubject(Subject $subject): JsonResponse
    {
        $teachers = $subject->teachers()->with('user')->get()->map(fn ($teacher) => [
            'id' => $teacher->id,
            'name' => $teacher->name,
            'nip' => $teacher->nip ?? '-',
        ]);

        return response()->json($teachers);
    }
}
