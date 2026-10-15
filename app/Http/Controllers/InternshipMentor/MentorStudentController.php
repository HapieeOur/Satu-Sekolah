<?php

namespace App\Http\Controllers\InternshipMentor;

use App\Contracts\Services\InternshipServiceInterface;
use App\Http\Controllers\Controller;
use App\Models\InternshipTaskSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MentorStudentController extends Controller
{
    public function __construct(
        protected InternshipServiceInterface $internshipService
    ) {}

    public function index(Request $request): View
    {
        $userId = Auth::id();
        $filters = $request->only(['status', 'company_id']);
        $mentees = $this->internshipService->getMentorMentees($userId, $filters);

        return view('internship-mentor.students.index', compact('mentees', 'filters'));
    }

    public function show(int $id): View
    {
        $userId = Auth::id();
        $placement = $this->internshipService->getMentorPlacement($userId, $id);

        $attendanceSummary = [
            'total' => $placement->attendances()->count(),
            'hadir' => $placement->attendances()->where('status', 'hadir')->count(),
            'terlambat' => $placement->attendances()->where('status', 'terlambat')->count(),
            'izin' => $placement->attendances()->where('status', 'izin')->count(),
            'sakit' => $placement->attendances()->where('status', 'sakit')->count(),
            'alpa' => $placement->attendances()->where('status', 'alpa')->count(),
        ];

        $journalSummary = [
            'total' => $placement->journals()->count(),
            'approved' => $placement->journals()->where('status', 'approved')->count(),
            'submitted' => $placement->journals()->where('status', 'submitted')->count(),
            'revision_requested' => $placement->journals()->where('status', 'revision_requested')->count(),
            'draft' => $placement->journals()->where('status', 'draft')->count(),
        ];

        $taskSubmissions = InternshipTaskSubmission::with('task')
            ->where('student_id', $placement->student_id)
            ->latest('submitted_at')
            ->get();

        $gradedSubmissions = $taskSubmissions->whereNotNull('grade');
        $averageGrade = $gradedSubmissions->count() > 0 ? round($gradedSubmissions->avg('grade'), 1) : null;

        $recentAttendances = $placement->attendances()->latest('date')->take(5)->get();
        $recentJournals = $placement->journals()->latest('date')->take(5)->get();

        return view('internship-mentor.students.show', compact(
            'placement',
            'attendanceSummary',
            'journalSummary',
            'taskSubmissions',
            'averageGrade',
            'recentAttendances',
            'recentJournals'
        ));
    }
}
