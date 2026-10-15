<?php

namespace App\Http\Controllers\Homeroom;

use App\Contracts\Services\AttendanceServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HomeroomAttendanceController extends Controller
{
    public function __construct(
        protected AttendanceServiceInterface $attendanceService
    ) {}

    /**
     * Display classroom attendance for the homeroom teacher.
     */
    public function index(Request $request): View
    {
        $userId = Auth::id();
        $tab = $request->input('tab', 'harian');
        $date = $request->input('date', now()->toDateString());

        if (in_array($tab, ['rekap', 'recap'], true)) {
            $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
            $endDate = $request->input('end_date', now()->toDateString());

            $data = $this->attendanceService->getHomeroomRecap($userId, $startDate, $endDate);

            return view('homeroom.attendances.index', [
                'tab' => 'rekap',
                'classroom' => $data['classroom'],
                'studentRecap' => $data['studentRecap'],
                'startDate' => $startDate,
                'endDate' => $endDate,
                'date' => $date,
                'summary' => [
                    'total' => 0,
                    'hadir' => 0,
                    'terlambat' => 0,
                    'izin' => 0,
                    'sakit' => 0,
                    'alpa' => 0,
                    'attendance_rate' => 0.0,
                ],
                'attendances' => collect(),
            ]);
        }

        $data = $this->attendanceService->getHomeroomAttendance($userId, $date);

        return view('homeroom.attendances.index', [
            'tab' => 'harian',
            'classroom' => $data['classroom'],
            'attendances' => $data['attendances'],
            'summary' => $data['summary'],
            'date' => $date,
            'startDate' => now()->startOfMonth()->toDateString(),
            'endDate' => now()->toDateString(),
            'studentRecap' => collect(),
        ]);
    }
}
