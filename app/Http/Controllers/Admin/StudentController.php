<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Services\ClassroomServiceInterface;
use App\Contracts\Services\StudentServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreStudentRequest;
use App\Http\Requests\Admin\UpdateStudentRequest;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function __construct(
        protected StudentServiceInterface $studentService,
        protected ClassroomServiceInterface $classroomService
    ) {}

    public function index(Request $request): View
    {
        $search = $request->input('search');
        $classroomId = $request->filled('classroom_id') ? (int) $request->input('classroom_id') : null;
        $status = $request->input('status');

        $students = $this->studentService->getPaginated(15, $search, $classroomId, $status)->withQueryString();
        $classrooms = $this->classroomService->getAllForActiveYear();

        return view('admin.students.index', compact('students', 'classrooms'));
    }

    public function create(): View
    {
        $classrooms = $this->classroomService->getAllForActiveYear();

        return view('admin.students.create', compact('classrooms'));
    }

    public function store(StoreStudentRequest $request): RedirectResponse
    {
        $this->studentService->create($request->validated());

        return redirect()->route('admin.students.index')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function edit(Student $student): View
    {
        $classrooms = $this->classroomService->getAllForActiveYear();

        return view('admin.students.edit', compact('student', 'classrooms'));
    }

    public function update(UpdateStudentRequest $request, Student $student): RedirectResponse
    {
        $this->studentService->update($student, $request->validated());

        return redirect()->route('admin.students.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Student $student): RedirectResponse
    {
        $this->studentService->delete($student);

        return redirect()->route('admin.students.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }
}
