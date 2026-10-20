<?php

namespace App\Http\Controllers\Homeroom;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HomeroomStudentController extends Controller
{
    /**
     * Get the homeroom classroom for the authenticated teacher.
     */
    protected function getHomeroomClassroom(): ?Classroom
    {
        $teacher = Teacher::where('user_id', Auth::id())->first();
        if (! $teacher) {
            return null;
        }

        return Classroom::with(['academicYear'])
            ->where('teacher_id', $teacher->id)
            ->first();
    }

    /**
     * Display listing of students belonging to the homeroom class.
     */
    public function index(Request $request): View
    {
        $classroom = $this->getHomeroomClassroom();

        if (! $classroom) {
            return view('homeroom.students.index', [
                'classroom' => null,
                'students' => collect(),
                'totalStudents' => 0,
                'maleCount' => 0,
                'femaleCount' => 0,
            ]);
        }

        $query = $classroom->students()->with(['user', 'attendances']);

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('nis', 'like', "%{$q}%")
                    ->orWhere('nisn', 'like', "%{$q}%");
            });
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->input('gender'));
        }

        $students = $query->orderBy('name')->paginate(20)->withQueryString();

        $totalStudents = $classroom->students()->count();
        $maleCount = $classroom->students()->where('gender', 'L')->count();
        $femaleCount = $classroom->students()->where('gender', 'P')->count();

        return view('homeroom.students.index', compact(
            'classroom',
            'students',
            'totalStudents',
            'maleCount',
            'femaleCount'
        ));
    }

    /**
     * Display the specified student's detail profile for the homeroom teacher.
     */
    public function show(Student $student): View
    {
        $classroom = $this->getHomeroomClassroom();

        if (! $classroom || $student->classroom_id !== $classroom->id) {
            abort(403, 'Siswa ini bukan anggota kelas binaan Anda.');
        }

        $student->load(['user', 'attendances' => fn ($q) => $q->latest('date')->take(30)]);

        return view('homeroom.students.show', compact('classroom', 'student'));
    }
}
