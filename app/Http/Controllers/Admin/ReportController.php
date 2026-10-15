<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Repositories\InternshipPlacementRepositoryInterface;
use App\Enums\AttendanceStatus;
use App\Enums\InternshipPlacementStatus;
use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\InternshipCompany;
use App\Models\InternshipPlacement;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function __construct(
        protected InternshipPlacementRepositoryInterface $placementRepository
    ) {}

    /**
     * Display Academic Attendance and Progress Report for classrooms.
     */
    public function academic(Request $request): View
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());
        $classroomId = $request->input('classroom_id');
        $academicYearId = $request->input('academic_year_id');

        $academicYears = AcademicYear::orderByDesc('is_active')->orderBy('name')->get();
        $classrooms = Classroom::with('academicYear')->orderBy('name')->get();

        $selectedClassroom = null;
        $studentRecaps = collect();
        $classSummary = [
            'total_students' => 0,
            'total_present' => 0,
            'total_late' => 0,
            'total_permit' => 0,
            'total_sick' => 0,
            'total_alpha' => 0,
            'average_rate' => 0.0,
        ];

        if ($classroomId) {
            $selectedClassroom = Classroom::with(['students' => function ($q) {
                $q->orderBy('name');
            }, 'homeroomTeacher.user'])->find($classroomId);

            if ($selectedClassroom) {
                $students = $selectedClassroom->students;
                $classSummary['total_students'] = $students->count();

                $attendances = Attendance::where('classroom_id', $selectedClassroom->id)
                    ->whereDate('date', '>=', $startDate)
                    ->whereDate('date', '<=', $endDate)
                    ->get();

                $studentRecaps = $students->map(function ($student) use ($attendances) {
                    $studentAtts = $attendances->where('student_id', $student->id);
                    $hadir = $studentAtts->where('status', AttendanceStatus::Hadir)->count();
                    $terlambat = $studentAtts->where('status', AttendanceStatus::Terlambat)->count();
                    $izin = $studentAtts->where('status', AttendanceStatus::Izin)->count();
                    $sakit = $studentAtts->where('status', AttendanceStatus::Sakit)->count();
                    $alpa = $studentAtts->where('status', AttendanceStatus::Alpa)->count();
                    $total = $studentAtts->count();
                    $rate = $total > 0 ? round((($hadir + $terlambat) / $total) * 100, 1) : 0.0;

                    return (object) [
                        'student' => $student,
                        'hadir' => $hadir,
                        'terlambat' => $terlambat,
                        'izin' => $izin,
                        'sakit' => $sakit,
                        'alpa' => $alpa,
                        'total' => $total,
                        'rate' => $rate,
                    ];
                });

                $classSummary['total_present'] = $studentRecaps->sum('hadir');
                $classSummary['total_late'] = $studentRecaps->sum('terlambat');
                $classSummary['total_permit'] = $studentRecaps->sum('izin');
                $classSummary['total_sick'] = $studentRecaps->sum('sakit');
                $classSummary['total_alpha'] = $studentRecaps->sum('alpa');

                $totalEvents = $classSummary['total_present'] + $classSummary['total_late'] + $classSummary['total_permit'] + $classSummary['total_sick'] + $classSummary['total_alpha'];
                $classSummary['average_rate'] = $totalEvents > 0
                    ? round((($classSummary['total_present'] + $classSummary['total_late']) / $totalEvents) * 100, 1)
                    : 0.0;
            }
        }

        return view('admin.reports.academic', compact(
            'academicYears',
            'classrooms',
            'selectedClassroom',
            'studentRecaps',
            'classSummary',
            'startDate',
            'endDate',
            'classroomId',
            'academicYearId'
        ));
    }

    /**
     * Display Internship (PKL) Monitoring and Performance Report.
     */
    public function internship(Request $request): View
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $companyId = $request->input('company_id');
        $teacherId = $request->input('teacher_id');
        $status = $request->input('status');

        $companies = InternshipCompany::orderBy('name')->get();
        $teachers = Teacher::with('user')->get();
        $statuses = InternshipPlacementStatus::cases();

        $query = InternshipPlacement::with([
            'student.classroom',
            'company',
            'teacher.user',
            'attendances',
            'journals',
        ]);

        if ($companyId) {
            $query->where('internship_company_id', $companyId);
        }

        if ($teacherId) {
            $query->where('teacher_id', $teacherId);
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($startDate && $endDate) {
            $query->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate]);
            });
        }

        $placements = $query->latest()->paginate(20)->withQueryString();

        // Calculate aggregate statistics for the filtered result set
        $reportMetrics = [
            'total_placements' => $query->count(),
            'active_count' => (clone $query)->where('status', InternshipPlacementStatus::Active)->count(),
            'completed_count' => (clone $query)->where('status', InternshipPlacementStatus::Completed)->count(),
        ];

        return view('admin.reports.internship', compact(
            'placements',
            'companies',
            'teachers',
            'statuses',
            'companyId',
            'teacherId',
            'status',
            'startDate',
            'endDate',
            'reportMetrics'
        ));
    }
}
