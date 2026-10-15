<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Repositories\InternshipMonitoringRepositoryInterface;
use App\Enums\InternshipJournalStatus;
use App\Enums\InternshipLeaveStatus;
use App\Enums\InternshipPlacementStatus;
use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\InternshipAttendance;
use App\Models\InternshipJournal;
use App\Models\InternshipLeaveRequest;
use App\Models\InternshipPlacement;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class AdminDashboardController extends Controller
{
    public function __construct(
        protected InternshipMonitoringRepositoryInterface $internshipMonitoringRepository
    ) {}

    /**
     * Display the admin dashboard with real operational school & PKL data.
     */
    public function index(): View
    {
        $today = Carbon::today()->toDateString();

        $stats = [
            'total_students' => Student::count(),
            'total_teachers' => Teacher::count(),
            'total_classrooms' => Classroom::count(),
            'active_placements' => InternshipPlacement::where('status', InternshipPlacementStatus::Active)->count(),
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'total_roles' => Role::count(),
        ];

        // Today's PKL Attendance Summary
        $pklAttendanceSummary = $this->internshipMonitoringRepository->getAttendanceSummaryForDate($today);

        // Action items awaiting review
        $pendingLeavesCount = InternshipLeaveRequest::where('status', InternshipLeaveStatus::Pending)->count();
        $pendingJournalsCount = InternshipJournal::where('status', InternshipJournalStatus::Submitted)->count();

        // Real activities from database
        $recentPlacements = InternshipPlacement::with(['student', 'company', 'teacher.user'])
            ->latest()
            ->take(5)
            ->get();

        $recentPklAttendances = InternshipAttendance::with(['placement.student', 'placement.company'])
            ->whereDate('date', $today)
            ->latest('check_in_time')
            ->take(5)
            ->get();

        $recentUsers = User::with('roles')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.admin', compact(
            'stats',
            'pklAttendanceSummary',
            'pendingLeavesCount',
            'pendingJournalsCount',
            'recentPlacements',
            'recentPklAttendances',
            'recentUsers'
        ));
    }
}
