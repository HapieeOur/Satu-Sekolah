<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\AcademicYear;
use App\Models\Classroom;
use App\Models\InternshipCompany;
use App\Models\Room;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminDashboardController extends AdminBaseController
{
    /**
     * Get operational summary statistics for dashboard.
     */
    public function stats(Request $request): JsonResponse
    {
        $this->authorizeAdmin();

        $activeYear = AcademicYear::where('is_active', true)->first();

        $data = [
            'total_students' => Student::count(),
            'total_teachers' => Teacher::count(),
            'total_classrooms' => Classroom::count(),
            'total_companies' => InternshipCompany::count(),
            'total_users' => User::count(),
            'total_subjects' => Subject::count(),
            'total_rooms' => Room::count(),
            'active_academic_year' => $activeYear ? $activeYear->name.' ('.$activeYear->semester.')' : 'Belum Diatur',
        ];

        return $this->respondWithSuccess($data, 'Statistik operasional berhasil diambil.');
    }
}
