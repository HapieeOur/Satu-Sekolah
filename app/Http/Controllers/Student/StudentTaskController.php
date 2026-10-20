<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AcademicTask;
use App\Models\AcademicTaskSubmission;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class StudentTaskController extends Controller
{
    /**
     * Get the authenticated student profile.
     */
    protected function getStudent(): Student
    {
        $user = Auth::user();
        $student = $user->student;

        if (! $student) {
            $student = Student::where('user_id', $user->id)->first();
        }

        if (! $student) {
            abort(403, 'Profil siswa tidak ditemukan.');
        }

        return $student;
    }

    /**
     * Display a listing of academic tasks for the student's classroom.
     */
    public function index(): View
    {
        $student = $this->getStudent();

        $tasks = collect();
        if ($student->classroom_id) {
            $tasks = AcademicTask::with([
                'teacher.user',
                'subject',
                'submissions' => fn ($q) => $q->where('student_id', $student->id),
            ])
                ->where('classroom_id', $student->classroom_id)
                ->orderBy('due_date', 'asc')
                ->paginate(10);
        }

        return view('student.tasks.index', compact('tasks', 'student'));
    }

    /**
     * Display the specified task and student's submission status.
     */
    public function show(AcademicTask $task): View
    {
        $student = $this->getStudent();

        if ($task->classroom_id !== $student->classroom_id) {
            abort(403, 'Tugas ini bukan diperuntukkan bagi kelas Anda.');
        }

        $task->load(['teacher.user', 'subject', 'classroom']);

        $submission = AcademicTaskSubmission::where('academic_task_id', $task->id)
            ->where('student_id', $student->id)
            ->first();

        return view('student.tasks.show', compact('task', 'submission', 'student'));
    }

    /**
     * Submit an assignment solution.
     */
    public function submit(Request $request, AcademicTask $task): RedirectResponse
    {
        $student = $this->getStudent();

        if ($task->classroom_id !== $student->classroom_id) {
            abort(403, 'Tugas ini bukan diperuntukkan bagi kelas Anda.');
        }

        $validated = $request->validate([
            'submission_file' => ['required', 'file', 'mimes:pdf,doc,docx,zip,rar,xls,xlsx,ppt,pptx,jpg,png,jpeg,webp,gif', 'max:20480'],
            'student_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $filePath = $request->file('submission_file')->store('academic_submissions', 'public');

        $isLate = now()->gt($task->due_date);

        AcademicTaskSubmission::updateOrCreate(
            [
                'academic_task_id' => $task->id,
                'student_id' => $student->id,
            ],
            [
                'submission_file_path' => $filePath,
                'student_notes' => $validated['student_notes'] ?? null,
                'submitted_at' => now(),
                'status' => $isLate ? 'late' : 'submitted',
            ]
        );

        return back()->with('success', 'Tugas Anda berhasil diserahkan ke guru.');
    }
}
