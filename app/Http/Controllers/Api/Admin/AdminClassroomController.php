<?php

namespace App\Http\Controllers\Api\Admin;

use App\Contracts\Services\AcademicYearServiceInterface;
use App\Contracts\Services\ClassroomServiceInterface;
use App\Models\AcademicYear;
use App\Models\Classroom;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminClassroomController extends AdminBaseController
{
    public function __construct(
        protected ClassroomServiceInterface $classroomService,
        protected AcademicYearServiceInterface $academicYearService
    ) {}

    /**
     * Display a listing of classrooms.
     */
    public function index(Request $request): JsonResponse
    {
        $this->authorizeAdmin();

        $query = Classroom::with(['academicYear', 'homeroomTeacher.user'])
            ->withCount('students')
            ->latest();

        if ($request->filled('academic_year_id')) {
            $query->where('academic_year_id', $request->input('academic_year_id'));
        }

        if ($request->filled('grade_level')) {
            $query->where('grade_level', $request->input('grade_level'));
        }

        $classrooms = $query->get()->map(function ($c) {
            return [
                'id' => $c->id,
                'name' => $c->name,
                'grade_level' => $c->grade_level,
                'major' => $c->major,
                'academic_year_id' => $c->academic_year_id,
                'academic_year_name' => $c->academicYear?->name ?? 'Belum Diatur',
                'teacher_id' => $c->teacher_id,
                'walas_name' => $c->homeroomTeacher?->user?->name ?? 'Belum Ditentukan',
                'walas_nip' => $c->homeroomTeacher?->nip ?? '-',
                'students_count' => $c->students_count,
            ];
        });

        return $this->respondWithSuccess($classrooms, 'Daftar kelas berhasil diambil.');
    }

    /**
     * Store a newly created classroom.
     */
    public function store(Request $request): JsonResponse
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'grade_level' => ['required', 'integer', 'between:10,12'],
            'major' => ['required', 'string', 'max:50'],
            'academic_year_id' => ['nullable', 'exists:academic_years,id'],
            'teacher_id' => ['nullable', 'exists:teachers,id'],
        ]);

        // Fallback to active academic year if not provided
        if (empty($validated['academic_year_id'])) {
            $activeYear = AcademicYear::where('is_active', true)->first();
            $validated['academic_year_id'] = $activeYear?->id;
        }

        $classroom = Classroom::create($validated);
        $classroom->load(['academicYear', 'homeroomTeacher.user']);

        return $this->respondWithSuccess([
            'id' => $classroom->id,
            'name' => $classroom->name,
            'grade_level' => $classroom->grade_level,
            'major' => $classroom->major,
            'walas_name' => $classroom->homeroomTeacher?->user?->name ?? 'Belum Ditentukan',
            'students_count' => 0,
        ], 'Data rombongan belajar (kelas) berhasil ditambahkan.', 201);
    }

    /**
     * Delete classroom.
     */
    public function destroy(Classroom $classroom): JsonResponse
    {
        $this->authorizeAdmin();

        $name = $classroom->name;
        $classroom->delete();

        return $this->respondWithSuccess(null, "Kelas {$name} berhasil dihapus.");
    }
}
