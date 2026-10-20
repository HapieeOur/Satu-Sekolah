<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\AcademicExam;
use App\Models\AcademicExamScore;
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

class TeacherExamController extends Controller
{
    /**
     * Get the authenticated teacher profile.
     */
    protected function getTeacher(): Teacher
    {
        return Teacher::where('user_id', Auth::id())->firstOrFail();
    }

    /**
     * Display a listing of daily exams created by this teacher.
     */
    public function index(): View
    {
        $teacher = $this->getTeacher();

        $exams = AcademicExam::with(['classroom.students', 'subject', 'scores'])
            ->where('teacher_id', $teacher->id)
            ->latest('exam_date')
            ->paginate(10);

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

        return view('teacher.exams.index', compact('exams', 'classrooms', 'subjects'));
    }

    /**
     * Store a new daily exam.
     */
    public function store(Request $request): RedirectResponse
    {
        $teacher = $this->getTeacher();

        $validated = $request->validate([
            'classroom_id' => ['required', 'exists:classrooms,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'exam_date' => ['required', 'date'],
            'duration_minutes' => ['required', 'integer', 'min:15', 'max:240'],
            'passing_score' => ['required', 'integer', 'min:0', 'max:100'],
        ]);

        $examDate = Carbon::parse($validated['exam_date']);
        if (is_string($validated['exam_date']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', trim($validated['exam_date']))) {
            $examDate = $examDate->setTime(8, 0, 0);
        }

        $academicYear = AcademicYear::where('is_active', true)->first();

        AcademicExam::create([
            'teacher_id' => $teacher->id,
            'classroom_id' => $validated['classroom_id'],
            'subject_id' => $validated['subject_id'],
            'academic_year_id' => $academicYear?->id,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'exam_date' => $examDate->format('Y-m-d H:i:s'),
            'duration_minutes' => $validated['duration_minutes'],
            'passing_score' => $validated['passing_score'],
            'status' => 'scheduled',
        ]);

        return redirect()->route('teacher.exams.index')->with('success', 'Agenda Ujian Harian berhasil dibuat.');
    }

    /**
     * Display the specified exam and student scores roster.
     */
    public function show(AcademicExam $exam): View
    {
        $teacher = $this->getTeacher();

        if ($exam->teacher_id !== $teacher->id) {
            abort(403, 'Anda tidak berwenang mengakses ujian guru lain.');
        }

        $exam->load(['classroom.students.user', 'subject', 'scores.student']);

        $classroomStudents = $exam->classroom->students()
            ->with('user')
            ->orderBy('name')
            ->get();

        $scoresByStudent = $exam->scores->keyBy('student_id');

        $gradedScores = $exam->scores->whereNotNull('score');
        $averageScore = $gradedScores->count() > 0 ? round($gradedScores->avg('score'), 1) : null;
        $passedCount = $gradedScores->where('score', '>=', $exam->passing_score)->count();
        $remedialCount = $gradedScores->where('score', '<', $exam->passing_score)->count();

        return view('teacher.exams.show', compact(
            'exam',
            'classroomStudents',
            'scoresByStudent',
            'averageScore',
            'passedCount',
            'remedialCount'
        ));
    }

    /**
     * Save student scores for an exam.
     */
    public function saveScores(Request $request, AcademicExam $exam): RedirectResponse
    {
        $teacher = $this->getTeacher();

        if ($exam->teacher_id !== $teacher->id) {
            abort(403, 'Anda tidak berwenang menginput nilai ujian guru lain.');
        }

        $validated = $request->validate([
            'scores' => ['required', 'array'],
            'scores.*.student_id' => ['required', 'exists:students,id'],
            'scores.*.score' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'scores.*.notes' => ['nullable', 'string', 'max:255'],
        ]);

        foreach ($validated['scores'] as $item) {
            if ($item['score'] === null || $item['score'] === '') {
                continue;
            }

            $numericScore = (float) $item['score'];
            $isRemedial = $numericScore < $exam->passing_score;

            AcademicExamScore::updateOrCreate(
                [
                    'academic_exam_id' => $exam->id,
                    'student_id' => $item['student_id'],
                ],
                [
                    'score' => $numericScore,
                    'is_remedial' => $isRemedial,
                    'notes' => $item['notes'] ?? null,
                    'graded_at' => now(),
                ]
            );
        }

        $exam->update(['status' => 'completed']);

        return back()->with('success', 'Nilai ujian harian siswa berhasil disimpan.');
    }

    /**
     * Delete an academic exam.
     */
    public function destroy(AcademicExam $exam): RedirectResponse
    {
        $teacher = $this->getTeacher();

        if ($exam->teacher_id !== $teacher->id) {
            abort(403, 'Anda tidak berwenang menghapus ujian ini.');
        }

        $exam->delete();

        return redirect()->route('teacher.exams.index')->with('success', 'Agenda ujian harian berhasil dihapus.');
    }
}
