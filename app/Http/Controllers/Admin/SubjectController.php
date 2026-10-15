<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Services\SubjectServiceInterface;
use App\Contracts\Services\TeacherServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSubjectRequest;
use App\Http\Requests\Admin\UpdateSubjectRequest;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubjectController extends Controller
{
    public function __construct(
        protected SubjectServiceInterface $subjectService,
        protected TeacherServiceInterface $teacherService
    ) {}

    public function index(Request $request): View
    {
        $search = $request->input('search');
        $subjects = $this->subjectService->getPaginated(15, $search)->withQueryString();

        return view('admin.subjects.index', compact('subjects'));
    }

    public function create(): View
    {
        $teachers = $this->teacherService->getAll();

        return view('admin.subjects.create', compact('teachers'));
    }

    public function store(StoreSubjectRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $teacherIds = $validated['teacher_ids'] ?? [];
        unset($validated['teacher_ids']);

        $this->subjectService->create($validated, $teacherIds);

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function edit(Subject $subject): View
    {
        $subject->load('teachers.user');
        $teachers = $this->teacherService->getAll();

        return view('admin.subjects.edit', compact('subject', 'teachers'));
    }

    public function update(UpdateSubjectRequest $request, Subject $subject): RedirectResponse
    {
        $validated = $request->validated();
        $teacherIds = $validated['teacher_ids'] ?? [];
        unset($validated['teacher_ids']);

        $this->subjectService->update($subject, $validated, $teacherIds);

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    public function destroy(Subject $subject): RedirectResponse
    {
        $this->subjectService->delete($subject);

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}
