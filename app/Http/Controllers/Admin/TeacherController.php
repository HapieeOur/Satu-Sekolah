<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Services\SubjectServiceInterface;
use App\Contracts\Services\TeacherServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTeacherRequest;
use App\Http\Requests\Admin\UpdateTeacherRequest;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeacherController extends Controller
{
    public function __construct(
        protected TeacherServiceInterface $teacherService,
        protected SubjectServiceInterface $subjectService
    ) {}

    public function index(Request $request): View
    {
        $search = $request->input('search');
        $teachers = $this->teacherService->getPaginated(15, $search)->withQueryString();

        return view('admin.teachers.index', compact('teachers'));
    }

    public function create(): View
    {
        // Users with role 'guru' who don't already have a teacher record
        $availableUsers = User::role('guru')
            ->whereDoesntHave('teacher')
            ->orderBy('name')
            ->get();

        $subjects = $this->subjectService->getAll();

        return view('admin.teachers.create', compact('availableUsers', 'subjects'));
    }

    public function store(StoreTeacherRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $subjectIds = $validated['subject_ids'] ?? [];
        unset($validated['subject_ids']);

        $this->teacherService->create($validated, $subjectIds);

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function edit(Teacher $teacher): View
    {
        $teacher->load(['user', 'subjects']);
        $subjects = $this->subjectService->getAll();

        return view('admin.teachers.edit', compact('teacher', 'subjects'));
    }

    public function update(UpdateTeacherRequest $request, Teacher $teacher): RedirectResponse
    {
        $validated = $request->validated();
        $subjectIds = $validated['subject_ids'] ?? [];
        unset($validated['subject_ids']);

        $this->teacherService->update($teacher, $validated, $subjectIds);

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(Teacher $teacher): RedirectResponse
    {
        $this->teacherService->delete($teacher);

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Data guru berhasil dihapus.');
    }
}
