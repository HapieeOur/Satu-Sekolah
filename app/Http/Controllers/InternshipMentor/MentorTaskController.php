<?php

namespace App\Http\Controllers\InternshipMentor;

use App\Contracts\Services\InternshipServiceInterface;
use App\Http\Controllers\Controller;
use App\Models\InternshipCompany;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MentorTaskController extends Controller
{
    public function __construct(
        protected InternshipServiceInterface $internshipService
    ) {}

    public function index(): View
    {
        $userId = Auth::id();
        $tasks = $this->internshipService->getMentorTasks($userId);
        $companies = InternshipCompany::orderBy('name')->get();

        return view('internship-mentor.tasks.index', compact('tasks', 'companies'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'due_date' => ['required', 'date', 'after_or_equal:today'],
            'internship_company_id' => ['nullable', 'exists:internship_companies,id'],
        ]);

        $this->internshipService->createMentorTask(Auth::id(), $validated);

        return redirect()->route('mentor.tasks.index')->with('success', 'Tugas PKL baru berhasil diterbitkan.');
    }

    public function show(int $id): View
    {
        $userId = Auth::id();
        $data = $this->internshipService->getTaskWithSubmissions($userId, $id);

        return view('internship-mentor.tasks.show', $data);
    }

    public function grade(Request $request, int $submissionId): RedirectResponse
    {
        $validated = $request->validate([
            'grade' => ['required', 'integer', 'min:0', 'max:100'],
            'feedback' => ['nullable', 'string', 'max:500'],
        ]);

        $this->internshipService->gradeSubmission(
            Auth::id(),
            $submissionId,
            $validated['grade'],
            $validated['feedback']
        );

        return back()->with('success', 'Penilaian dan umpan balik tugas berhasil disimpan.');
    }
}
