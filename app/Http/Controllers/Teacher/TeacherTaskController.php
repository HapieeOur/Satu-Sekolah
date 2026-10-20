<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\AcademicTask;
use App\Models\AcademicTaskSubmission;
use App\Models\AcademicYear;
use App\Models\Classroom;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TeacherTaskController extends Controller
{
    /**
     * Get the authenticated teacher profile.
     */
    protected function getTeacher(): Teacher
    {
        return Teacher::where('user_id', Auth::id())->firstOrFail();
    }

    /**
     * Display a listing of academic tasks created by this teacher.
     */
    public function index(): View
    {
        $teacher = $this->getTeacher();

        $tasks = AcademicTask::with(['classroom.students', 'subject', 'submissions'])
            ->where('teacher_id', $teacher->id)
            ->latest('created_at')
            ->paginate(10);

        // Classrooms taught by this teacher or where teacher is homeroom teacher
        $classroomIds = Schedule::where('teacher_id', $teacher->id)->pluck('classroom_id');
        $classrooms = Classroom::whereIn('id', $classroomIds)
            ->orWhere('teacher_id', $teacher->id)
            ->orderBy('name')
            ->get();

        if ($classrooms->isEmpty()) {
            $classrooms = Classroom::orderBy('name')->get();
        }

        $subjects = $teacher->subjects()->exists()
            ? $teacher->subjects
            : Subject::orderBy('name')->get();

        return view('teacher.tasks.index', compact('tasks', 'classrooms', 'subjects'));
    }

    /**
     * Store a new academic task for a classroom.
     */
    public function store(Request $request): RedirectResponse
    {
        $teacher = $this->getTeacher();

        $validated = $request->validate([
            'classroom_id' => ['required', 'exists:classrooms,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'due_date' => ['required', 'date', 'after_or_equal:today'],
            'attachment' => ['nullable', 'file', 'mimes:pdf,doc,docx,zip,rar,xls,xlsx,ppt,pptx,jpg,png,jpeg,webp,gif', 'max:10240'],
        ]);

        $dueDate = Carbon::parse($validated['due_date']);
        if (is_string($validated['due_date']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', trim($validated['due_date']))) {
            $dueDate = $dueDate->endOfDay();
        }

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('academic_tasks', 'public');
        }

        $academicYear = AcademicYear::where('is_active', true)->first();
        $classroom = Classroom::find($validated['classroom_id']);
        $subject = Subject::find($validated['subject_id']);

        $title = ! empty($validated['title'])
            ? trim($validated['title'])
            : 'Tugas '.($subject?->name ?? 'Mata Pelajaran').' - Kelas '.($classroom?->name ?? '');

        AcademicTask::create([
            'teacher_id' => $teacher->id,
            'classroom_id' => $validated['classroom_id'],
            'subject_id' => $validated['subject_id'],
            'academic_year_id' => $academicYear?->id,
            'title' => $title,
            'description' => $validated['description'],
            'due_date' => $dueDate->format('Y-m-d H:i:s'),
            'attachment_path' => $attachmentPath,
        ]);

        return redirect()->route('teacher.tasks.index')->with('success', 'Tugas mata pelajaran berhasil diterbitkan ke kelas.');
    }

    /**
     * Update the specified task.
     */
    public function update(Request $request, AcademicTask $task): RedirectResponse
    {
        $teacher = $this->getTeacher();

        if ($task->teacher_id !== $teacher->id) {
            abort(403, 'Anda tidak berwenang memperbarui tugas guru lain.');
        }

        $validated = $request->validate([
            'classroom_id' => ['required', 'exists:classrooms,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'due_date' => ['required', 'date'],
            'attachment' => ['nullable', 'file', 'mimes:pdf,doc,docx,zip,rar,xls,xlsx,ppt,pptx,jpg,png,jpeg,webp,gif', 'max:10240'],
            'remove_attachment' => ['nullable', 'boolean'],
        ]);

        $dueDate = Carbon::parse($validated['due_date']);

        $attachmentPath = $task->attachment_path;

        if ($request->boolean('remove_attachment')) {
            $attachmentPath = null;
        }

        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('academic_tasks', 'public');
        }

        $classroom = Classroom::find($validated['classroom_id']);
        $subject = Subject::find($validated['subject_id']);

        $title = ! empty($validated['title'])
            ? trim($validated['title'])
            : 'Tugas '.($subject?->name ?? 'Mata Pelajaran').' - Kelas '.($classroom?->name ?? '');

        $task->update([
            'classroom_id' => $validated['classroom_id'],
            'subject_id' => $validated['subject_id'],
            'title' => $title,
            'description' => $validated['description'],
            'due_date' => $dueDate->format('Y-m-d H:i:s'),
            'attachment_path' => $attachmentPath,
        ]);

        return back()->with('success', 'Perubahan tugas berhasil disimpan.');
    }

    /**
     * Display the specified task and all classroom submissions.
     */
    public function show(AcademicTask $task): View
    {
        $teacher = $this->getTeacher();

        if ($task->teacher_id !== $teacher->id) {
            abort(403, 'Anda tidak berwenang mengakses tugas guru lain.');
        }

        $task->load(['classroom.students.user', 'subject', 'teacher.user', 'submissions.student.user']);

        $classroomStudents = $task->classroom->students()
            ->with('user')
            ->orderBy('name')
            ->get();

        $submissionsByStudent = $task->submissions->keyBy('student_id');

        return view('teacher.tasks.show', compact('task', 'classroomStudents', 'submissionsByStudent'));
    }

    /**
     * Grade a student's submission.
     */
    public function grade(Request $request, AcademicTaskSubmission $submission): RedirectResponse
    {
        $teacher = $this->getTeacher();

        if ($submission->task->teacher_id !== $teacher->id) {
            abort(403, 'Anda tidak berwenang menilai tugas guru lain.');
        }

        $validated = $request->validate([
            'grade' => ['required', 'integer', 'min:0', 'max:100'],
            'feedback' => ['nullable', 'string', 'max:1000'],
        ]);

        $submission->update([
            'grade' => $validated['grade'],
            'teacher_feedback' => $validated['feedback'] ?? null,
            'graded_at' => now(),
            'status' => 'graded',
        ]);

        return back()->with('success', 'Nilai dan umpan balik tugas berhasil disimpan.');
    }

    /**
     * Delete an academic task.
     */
    public function destroy(AcademicTask $task): RedirectResponse
    {
        $teacher = $this->getTeacher();

        if ($task->teacher_id !== $teacher->id) {
            abort(403, 'Anda tidak berwenang menghapus tugas ini.');
        }

        $task->delete();

        return redirect()->route('teacher.tasks.index')->with('success', 'Tugas berhasil dihapus.');
    }
}
