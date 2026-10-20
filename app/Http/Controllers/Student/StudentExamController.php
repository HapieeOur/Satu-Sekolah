<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AcademicExam;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class StudentExamController extends Controller
{
    /**
     * Display a listing of exams for the student's classroom.
     */
    public function index(): View
    {
        $user = Auth::user();
        $student = $user->student ?? Student::where('user_id', $user->id)->first();

        if (! $student || ! $student->classroom_id) {
            abort(403, 'Profil kelas siswa tidak ditemukan.');
        }

        $exams = AcademicExam::with([
            'teacher.user',
            'subject',
            'scores' => fn ($q) => $q->where('student_id', $student->id),
        ])
            ->where('classroom_id', $student->classroom_id)
            ->orderBy('exam_date', 'desc')
            ->paginate(12);

        return view('student.exams.index', compact('exams', 'student'));
    }
}
