<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Classroom;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\StudentGrade;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TeacherGradeController extends Controller
{
    /**
     * Get the authenticated teacher profile.
     */
    protected function getTeacher(): Teacher
    {
        return Teacher::where('user_id', Auth::id())->firstOrFail();
    }

    /**
     * Display the gradebook matrix and score input form.
     */
    public function index(Request $request): View
    {
        $teacher = $this->getTeacher();
        $isHomeroomRoute = $request->routeIs('homeroom.*');

        $homeroomClass = Classroom::where('teacher_id', $teacher->id)->first();

        // Available classrooms
        if ($isHomeroomRoute && $homeroomClass) {
            $classrooms = collect([$homeroomClass]);
            $defaultClassId = $homeroomClass->id;
        } else {
            $scheduleClassIds = Schedule::where('teacher_id', $teacher->id)->pluck('classroom_id');
            $classrooms = Classroom::whereIn('id', $scheduleClassIds)
                ->orWhere('teacher_id', $teacher->id)
                ->orderBy('name')
                ->get();

            if ($classrooms->isEmpty()) {
                $classrooms = Classroom::orderBy('name')->get();
            }

            $defaultClassId = $classrooms->first()?->id;
        }

        $selectedClassroomId = (int) $request->input('classroom_id', $defaultClassId);
        $selectedClassroom = Classroom::find($selectedClassroomId);

        // Subjects
        $subjects = $teacher->subjects()->exists() && ! $isHomeroomRoute
            ? $teacher->subjects
            : Subject::orderBy('name')->get();

        $selectedSubjectId = (int) $request->input('subject_id', $subjects->first()?->id);
        $selectedSubject = Subject::find($selectedSubjectId);

        // Component type & title
        $type = $request->input('type', 'tugas');
        $title = $request->input('title', 'Tugas 1');

        $students = collect();
        $existingGrades = collect();
        $averageScore = null;
        $highestScore = null;
        $lowestScore = null;
        $passedCount = 0;

        if ($selectedClassroom) {
            $students = Student::where('classroom_id', $selectedClassroom->id)
                ->with('user')
                ->orderBy('name')
                ->get();

            if ($selectedSubject) {
                $existingGrades = StudentGrade::where('classroom_id', $selectedClassroom->id)
                    ->where('subject_id', $selectedSubject->id)
                    ->where('type', $type)
                    ->where('title', $title)
                    ->get()
                    ->keyBy('student_id');

                $validScores = $existingGrades->pluck('score')->filter(fn ($s) => $s !== null);
                if ($validScores->isNotEmpty()) {
                    $averageScore = round($validScores->avg(), 1);
                    $highestScore = round($validScores->max(), 1);
                    $lowestScore = round($validScores->min(), 1);
                    $passedCount = $validScores->filter(fn ($s) => $s >= 75)->count();
                }
            }
        }

        return view('teacher.grades.index', compact(
            'classrooms',
            'selectedClassroom',
            'subjects',
            'selectedSubject',
            'type',
            'title',
            'students',
            'existingGrades',
            'averageScore',
            'highestScore',
            'lowestScore',
            'passedCount',
            'isHomeroomRoute'
        ));
    }

    /**
     * Store or update batch student grades.
     */
    public function store(Request $request): RedirectResponse
    {
        $teacher = $this->getTeacher();

        $validated = $request->validate([
            'classroom_id' => ['required', 'exists:classrooms,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'type' => ['required', 'string', 'in:tugas,ulangan_harian,uts,uas,praktik,akhir'],
            'title' => ['required', 'string', 'max:100'],
            'grades' => ['required', 'array'],
            'grades.*.student_id' => ['required', 'exists:students,id'],
            'grades.*.score' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'grades.*.notes' => ['nullable', 'string', 'max:255'],
        ]);

        $academicYear = AcademicYear::where('is_active', true)->first();

        foreach ($validated['grades'] as $item) {
            if ($item['score'] === null || $item['score'] === '') {
                // Delete if cleared
                StudentGrade::where('classroom_id', $validated['classroom_id'])
                    ->where('subject_id', $validated['subject_id'])
                    ->where('student_id', $item['student_id'])
                    ->where('type', $validated['type'])
                    ->where('title', $validated['title'])
                    ->delete();

                continue;
            }

            StudentGrade::updateOrCreate(
                [
                    'classroom_id' => $validated['classroom_id'],
                    'subject_id' => $validated['subject_id'],
                    'student_id' => $item['student_id'],
                    'type' => $validated['type'],
                    'title' => $validated['title'],
                ],
                [
                    'teacher_id' => $teacher->id,
                    'academic_year_id' => $academicYear?->id,
                    'score' => (float) $item['score'],
                    'notes' => $item['notes'] ?? null,
                ]
            );
        }

        return back()->with('success', "Nilai {$validated['title']} berhasil disimpan.");
    }
}
