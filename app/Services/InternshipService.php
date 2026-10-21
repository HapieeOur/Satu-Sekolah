<?php

namespace App\Services;

use App\Contracts\Repositories\InternshipMonitoringRepositoryInterface;
use App\Contracts\Repositories\InternshipPlacementRepositoryInterface;
use App\Contracts\Services\InternshipServiceInterface;
use App\Enums\InternshipJournalStatus;
use App\Enums\InternshipLeaveStatus;
use App\Enums\InternshipPlacementStatus;
use App\Models\AcademicYear;
use App\Models\InternshipAttendance;
use App\Models\InternshipCompany;
use App\Models\InternshipJournal;
use App\Models\InternshipLeaveRequest;
use App\Models\InternshipPlacement;
use App\Models\InternshipTask;
use App\Models\InternshipTaskSubmission;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class InternshipService implements InternshipServiceInterface
{
    public function __construct(
        protected InternshipPlacementRepositoryInterface $placementRepository,
        protected InternshipMonitoringRepositoryInterface $monitoringRepository
    ) {}

    // Admin Placements
    public function getPlacements(array $filters = []): LengthAwarePaginator
    {
        return $this->placementRepository->getPaginated($filters);
    }

    public function getPlacement(int $id): InternshipPlacement
    {
        $placement = $this->placementRepository->findById($id);
        if (! $placement) {
            abort(404, 'Data penempatan PKL tidak ditemukan.');
        }

        return $placement;
    }

    public function createPlacement(array $data): InternshipPlacement
    {
        $placement = $this->placementRepository->create($data);
        $this->ensureTeacherHasMentorRole($placement->teacher_id);

        return $placement;
    }

    public function updatePlacement(int $id, array $data): InternshipPlacement
    {
        $placement = $this->placementRepository->update($id, $data);
        $this->ensureTeacherHasMentorRole($placement->teacher_id);

        return $placement;
    }

    protected function ensureTeacherHasMentorRole(?int $teacherId): void
    {
        if (! $teacherId) {
            return;
        }

        $teacher = Teacher::with('user')->find($teacherId);
        if ($teacher?->user && ! $teacher->user->hasRole('guru_pembimbing_pkl')) {
            $teacher->user->assignRole('guru_pembimbing_pkl');
        }
    }

    public function deletePlacement(int $id): bool
    {
        return $this->placementRepository->delete($id);
    }

    public function getPlacementFormData(?int $exceptStudentId = null): array
    {
        \App\Services\UserService::ensureTeacherProfilesExist();

        $activeYear = AcademicYear::where('is_active', true)->first();
        $academicYearId = $activeYear?->id ?? 0;

        $students = $this->placementRepository->getAvailableStudentsForPlacement($academicYearId, $exceptStudentId);
        $companies = InternshipCompany::orderBy('name')->get();
        $teachers = Teacher::with('user')
            ->whereHas('user', function ($q) {
                $q->where('is_active', true)
                  ->whereHas('roles', fn($r) => $r->where('name', 'guru_pembimbing_pkl'));
            })
            ->get();
        $academicYears = AcademicYear::latest('start_date')->get();

        return compact('students', 'companies', 'teachers', 'academicYears', 'activeYear');
    }

    // Mentor Access & IDOR Verification
    protected function getTeacherByUserId(int $userId): Teacher
    {
        $teacher = Teacher::where('user_id', $userId)->first();
        if (! $teacher) {
            throw new AuthorizationException('Akun Anda tidak terhubung dengan profil guru terdaftar.');
        }

        return $teacher;
    }

    public function getMentorPlacement(int $userId, int $placementId): InternshipPlacement
    {
        $teacher = $this->getTeacherByUserId($userId);
        $placement = $this->placementRepository->findById($placementId);

        if (! $placement) {
            abort(404, 'Penempatan PKL tidak ditemukan.');
        }

        if ($placement->teacher_id !== $teacher->id) {
            throw new AuthorizationException('Anda tidak memiliki izin mengakses data siswa bimbingan guru lain.');
        }

        return $placement;
    }

    public function getMentorMentees(int $userId, array $filters = []): Collection
    {
        $teacher = Teacher::where('user_id', $userId)->first();
        if (! $teacher) {
            return new Collection;
        }

        return $this->placementRepository->getMenteesForTeacher($teacher->id, $filters);
    }

    public function getMentorDashboardMetrics(int $userId): array
    {
        $teacher = Teacher::where('user_id', $userId)->first();
        if (! $teacher) {
            return [
                'totalMentees' => 0,
                'attendanceSummary' => [
                    'total' => 0,
                    'hadir' => 0,
                    'terlambat' => 0,
                    'izin' => 0,
                    'sakit' => 0,
                    'alpa' => 0,
                    'pending_verification' => 0,
                    'rate' => 0.0,
                ],
                'pendingJournalsCount' => 0,
                'pendingLeavesCount' => 0,
                'recentJournals' => new Collection,
            ];
        }

        $today = Carbon::today()->toDateString();

        $activeMentees = $this->placementRepository->getMenteesForTeacher($teacher->id, [
            'status' => InternshipPlacementStatus::Active->value,
        ]);

        $totalMentees = $activeMentees->count();
        $attendanceSummary = $this->monitoringRepository->getAttendanceSummaryForDate($today, $teacher->id);

        $pendingJournalsCount = InternshipJournal::whereHas('placement', function ($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })->where('status', InternshipJournalStatus::Submitted)->count();

        $pendingLeavesCount = InternshipLeaveRequest::whereHas('placement', function ($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })->where('status', InternshipLeaveStatus::Pending)->count();

        $recentJournals = InternshipJournal::with(['placement.student', 'placement.company'])
            ->whereHas('placement', function ($q) use ($teacher) {
                $q->where('teacher_id', $teacher->id);
            })
            ->latest('date')
            ->take(5)
            ->get();

        return [
            'totalMentees' => $totalMentees,
            'attendanceSummary' => $attendanceSummary,
            'pendingJournalsCount' => $pendingJournalsCount,
            'pendingLeavesCount' => $pendingLeavesCount,
            'recentJournals' => $recentJournals,
            'activeMentees' => $activeMentees,
        ];
    }

    // Attendances
    public function getAttendances(array $filters = []): LengthAwarePaginator
    {
        return $this->monitoringRepository->getAttendancesPaginated($filters);
    }

    public function getMentorAttendances(int $userId, array $filters = []): LengthAwarePaginator
    {
        $teacher = $this->getTeacherByUserId($userId);
        $filters['teacher_id'] = $teacher->id;

        return $this->monitoringRepository->getAttendancesPaginated($filters);
    }

    public function verifyAttendance(int $userId, int $attendanceId, string $status, ?string $rejectionReason = null): InternshipAttendance
    {
        $teacher = $this->getTeacherByUserId($userId);
        $attendance = $this->monitoringRepository->findAttendanceById($attendanceId);

        if (! $attendance) {
            abort(404, 'Presensi PKL tidak ditemukan.');
        }

        if ($attendance->placement?->teacher_id !== $teacher->id) {
            throw new AuthorizationException('Anda tidak berwenang memverifikasi presensi siswa yang bukan bimbingan Anda.');
        }

        return $this->monitoringRepository->verifyAttendance($attendanceId, $status, $rejectionReason);
    }

    public function manuallyCorrectAttendance(int $userId, int $attendanceId, array $data): InternshipAttendance
    {
        $attendance = $this->monitoringRepository->findAttendanceById($attendanceId);
        if (! $attendance) {
            abort(404, 'Presensi PKL tidak ditemukan.');
        }

        return $this->monitoringRepository->correctAttendance($attendanceId, $data, $userId);
    }

    // Journals
    public function getMentorJournals(int $userId, array $filters = []): LengthAwarePaginator
    {
        $teacher = $this->getTeacherByUserId($userId);
        $filters['teacher_id'] = $teacher->id;

        return $this->monitoringRepository->getJournalsPaginated($filters);
    }

    public function reviewJournal(int $userId, int $journalId, string $status, ?string $notes = null): InternshipJournal
    {
        $teacher = $this->getTeacherByUserId($userId);
        $journal = $this->monitoringRepository->findJournalById($journalId);

        if (! $journal) {
            abort(404, 'Jurnal PKL tidak ditemukan.');
        }

        if ($journal->placement?->teacher_id !== $teacher->id) {
            throw new AuthorizationException('Anda tidak memiliki wewenang meninjau jurnal siswa bimbingan guru lain.');
        }

        return $this->monitoringRepository->reviewJournal($journalId, $status, $notes, $userId);
    }

    // Leave Requests
    public function getMentorLeaveRequests(int $userId, array $filters = []): LengthAwarePaginator
    {
        $teacher = $this->getTeacherByUserId($userId);
        $filters['teacher_id'] = $teacher->id;

        return $this->monitoringRepository->getLeaveRequestsPaginated($filters);
    }

    public function reviewLeaveRequest(int $userId, int $leaveRequestId, string $status, ?string $notes = null): InternshipLeaveRequest
    {
        $teacher = $this->getTeacherByUserId($userId);
        $leave = $this->monitoringRepository->findLeaveRequestById($leaveRequestId);

        if (! $leave) {
            abort(404, 'Pengajuan izin PKL tidak ditemukan.');
        }

        if ($leave->placement?->teacher_id !== $teacher->id) {
            throw new AuthorizationException('Anda tidak berwenang memproses permohonan izin dari siswa bimbingan lain.');
        }

        return $this->monitoringRepository->reviewLeaveRequest($leaveRequestId, $status, $notes, $userId);
    }

    // Tasks
    public function getMentorTasks(int $userId): Collection
    {
        $teacher = $this->getTeacherByUserId($userId);

        return $this->monitoringRepository->getTasksForTeacher($teacher->id);
    }

    public function createMentorTask(int $userId, array $data): InternshipTask
    {
        $teacher = $this->getTeacherByUserId($userId);
        $data['teacher_id'] = $teacher->id;

        if (isset($data['due_date'])) {
            $parsedDate = Carbon::parse($data['due_date']);
            if (is_string($data['due_date']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', trim($data['due_date']))) {
                $parsedDate = $parsedDate->endOfDay();
            }
            $data['due_date'] = $parsedDate->format('Y-m-d H:i:s');
        }

        return $this->monitoringRepository->createTask($data);
    }

    public function getTaskWithSubmissions(int $userId, int $taskId): array
    {
        $teacher = $this->getTeacherByUserId($userId);
        $task = $this->monitoringRepository->findTaskById($taskId);

        if (! $task) {
            abort(404, 'Tugas PKL tidak ditemukan.');
        }

        if ($task->teacher_id !== $teacher->id) {
            throw new AuthorizationException('Anda tidak memiliki akses ke tugas pembimbing lain.');
        }

        $submissions = $this->monitoringRepository->getSubmissionsForTask($taskId);

        return compact('task', 'submissions');
    }

    public function gradeSubmission(int $userId, int $submissionId, int $grade, ?string $feedback = null): InternshipTaskSubmission
    {
        $teacher = $this->getTeacherByUserId($userId);
        $submission = $this->monitoringRepository->findSubmissionById($submissionId);

        if (! $submission) {
            abort(404, 'Pengumpulan tugas tidak ditemukan.');
        }

        if ($submission->task?->teacher_id !== $teacher->id) {
            throw new AuthorizationException('Anda tidak berwenang menilai pengumpulan tugas guru lain.');
        }

        return $this->monitoringRepository->gradeSubmission($submissionId, $grade, $feedback, $userId);
    }
}
