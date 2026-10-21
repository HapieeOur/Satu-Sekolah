<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Services\AcademicYearServiceInterface;
use App\Contracts\Services\ClassroomServiceInterface;
use App\Contracts\Services\TeacherServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreClassroomRequest;
use App\Http\Requests\Admin\UpdateClassroomRequest;
use App\Models\Classroom;
use App\Models\Teacher;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClassroomController extends Controller
{
    public function __construct(
        protected ClassroomServiceInterface $classroomService,
        protected AcademicYearServiceInterface $academicYearService,
        protected TeacherServiceInterface $teacherService
    ) {}

    public function index(Request $request): View
    {
        $academicYearId = $request->filled('academic_year_id') ? (int) $request->input('academic_year_id') : null;
        $gradeLevel = $request->filled('grade_level') ? (int) $request->input('grade_level') : null;

        $classrooms = $this->classroomService->getPaginated(15, $academicYearId, $gradeLevel)->withQueryString();
        $academicYears = $this->academicYearService->getAll();

        return view('admin.classrooms.index', compact('classrooms', 'academicYears'));
    }

    public function create(): View
    {
        UserService::ensureTeacherProfilesExist();

        $academicYears = $this->academicYearService->getAll();
        $teachers = Teacher::with('user')
            ->whereHas('user', function ($q) {
                $q->where('is_active', true)
                  ->whereHas('roles', fn($r) => $r->where('name', 'wali_kelas'));
            })
            ->get();

        return view('admin.classrooms.create', compact('academicYears', 'teachers'));
    }

    public function store(StoreClassroomRequest $request): RedirectResponse
    {
        $this->classroomService->create($request->validated());

        return redirect()->route('admin.classrooms.index')
            ->with('success', 'Data kelas berhasil ditambahkan.');
    }

    public function edit(Classroom $classroom): View
    {
        UserService::ensureTeacherProfilesExist();

        $academicYears = $this->academicYearService->getAll();
        $teachers = Teacher::with('user')
            ->whereHas('user', function ($q) use ($classroom) {
                $q->where('is_active', true)
                  ->where(function ($sub) use ($classroom) {
                      $sub->whereHas('roles', fn($r) => $r->where('name', 'wali_kelas'));
                      if ($classroom->teacher_id) {
                          $sub->orWhere('id', $classroom->teacher?->user_id);
                      }
                  });
            })
            ->get();

        return view('admin.classrooms.edit', compact('classroom', 'academicYears', 'teachers'));
    }

    public function update(UpdateClassroomRequest $request, Classroom $classroom): RedirectResponse
    {
        $this->classroomService->update($classroom, $request->validated());

        return redirect()->route('admin.classrooms.index')
            ->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function destroy(Classroom $classroom): RedirectResponse
    {
        $this->classroomService->delete($classroom);

        return redirect()->route('admin.classrooms.index')
            ->with('success', 'Data kelas berhasil dihapus.');
    }
}
