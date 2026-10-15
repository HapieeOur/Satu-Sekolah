<?php

namespace App\Repositories;

use App\Contracts\Repositories\InternshipMonitoringRepositoryInterface;
use App\Enums\InternshipAttendanceStatus;
use App\Enums\InternshipLeaveStatus;
use App\Enums\InternshipTaskSubmissionStatus;
use App\Enums\InternshipVerificationStatus;
use App\Models\InternshipAttendance;
use App\Models\InternshipJournal;
use App\Models\InternshipLeaveRequest;
use App\Models\InternshipTask;
use App\Models\InternshipTaskSubmission;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class InternshipMonitoringRepository implements InternshipMonitoringRepositoryInterface
{
    // Attendances
    public function getAttendancesPaginated(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = InternshipAttendance::with([
            'placement.student.classroom',
            'placement.company',
            'placement.teacher.user',
            'corrector',
        ]);

        if (! empty($filters['teacher_id'])) {
            $query->whereHas('placement', function ($q) use ($filters) {
                $q->where('teacher_id', $filters['teacher_id']);
            });
        }

        if (! empty($filters['company_id'])) {
            $query->whereHas('placement', function ($q) use ($filters) {
                $q->where('internship_company_id', $filters['company_id']);
            });
        }

        if (! empty($filters['date'])) {
            $query->whereDate('date', $filters['date']);
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['verification_status'])) {
            $query->where('verification_status', $filters['verification_status']);
        }

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->whereHas('placement.student', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        return $query->orderByDesc('date')->orderByDesc('check_in_time')->paginate($perPage)->withQueryString();
    }

    public function findAttendanceById(int $id): ?InternshipAttendance
    {
        return InternshipAttendance::with([
            'placement.student.classroom',
            'placement.company',
            'placement.teacher.user',
            'corrector',
        ])->find($id);
    }

    public function correctAttendance(int $id, array $data, int $correctedByUserId): InternshipAttendance
    {
        $attendance = InternshipAttendance::findOrFail($id);

        $attendance->update([
            'status' => $data['status'],
            'check_in_time' => $data['check_in_time'] ?? $attendance->check_in_time,
            'check_out_time' => $data['check_out_time'] ?? $attendance->check_out_time,
            'verification_status' => InternshipVerificationStatus::Corrected,
            'is_manual_correction' => true,
            'corrected_by' => $correctedByUserId,
            'correction_reason' => $data['correction_reason'],
            'corrected_at' => Carbon::now(),
            'notes' => $data['notes'] ?? $attendance->notes,
        ]);

        return $attendance->fresh(['placement.student', 'placement.company', 'corrector']);
    }

    public function verifyAttendance(int $id, string $status, ?string $rejectionReason = null): InternshipAttendance
    {
        $attendance = InternshipAttendance::findOrFail($id);

        $attendance->update([
            'verification_status' => $status,
            'rejection_reason' => $status === InternshipVerificationStatus::Rejected->value ? $rejectionReason : null,
        ]);

        return $attendance->fresh(['placement.student', 'placement.company']);
    }

    public function getAttendanceSummaryForDate(string $date, ?int $teacherId = null): array
    {
        $query = InternshipAttendance::whereDate('date', $date);

        if ($teacherId) {
            $query->whereHas('placement', function ($q) use ($teacherId) {
                $q->where('teacher_id', $teacherId);
            });
        }

        $records = $query->get();
        $total = $records->count();
        $hadir = $records->where('status', InternshipAttendanceStatus::Hadir)->count();
        $terlambat = $records->where('status', InternshipAttendanceStatus::Terlambat)->count();
        $izin = $records->where('status', InternshipAttendanceStatus::Izin)->count();
        $sakit = $records->where('status', InternshipAttendanceStatus::Sakit)->count();
        $alpa = $records->where('status', InternshipAttendanceStatus::Alpa)->count();
        $pendingVerification = $records->where('verification_status', InternshipVerificationStatus::Pending)->count();

        $presentTotal = $hadir + $terlambat;
        $rate = $total > 0 ? round(($presentTotal / $total) * 100, 1) : 0.0;

        return [
            'total' => $total,
            'hadir' => $hadir,
            'terlambat' => $terlambat,
            'izin' => $izin,
            'sakit' => $sakit,
            'alpa' => $alpa,
            'pending_verification' => $pendingVerification,
            'rate' => $rate,
        ];
    }

    // Journals
    public function getJournalsPaginated(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = InternshipJournal::with(['placement.student.classroom', 'placement.company', 'reviewer']);

        if (! empty($filters['teacher_id'])) {
            $query->whereHas('placement', function ($q) use ($filters) {
                $q->where('teacher_id', $filters['teacher_id']);
            });
        }

        if (! empty($filters['company_id'])) {
            $query->whereHas('placement', function ($q) use ($filters) {
                $q->where('internship_company_id', $filters['company_id']);
            });
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['date'])) {
            $query->whereDate('date', $filters['date']);
        }

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($sub) use ($search) {
                $sub->where('title', 'like', "%{$search}%")
                    ->orWhereHas('placement.student', function ($sq) use ($search) {
                        $sq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        return $query->orderByDesc('date')->latest()->paginate($perPage)->withQueryString();
    }

    public function findJournalById(int $id): ?InternshipJournal
    {
        return InternshipJournal::with(['placement.student.classroom', 'placement.company', 'reviewer'])->find($id);
    }

    public function reviewJournal(int $id, string $status, ?string $mentorNotes, int $reviewerUserId): InternshipJournal
    {
        $journal = InternshipJournal::findOrFail($id);

        $journal->update([
            'status' => $status,
            'mentor_notes' => $mentorNotes,
            'reviewed_by' => $reviewerUserId,
            'reviewed_at' => Carbon::now(),
        ]);

        return $journal->fresh(['placement.student', 'placement.company', 'reviewer']);
    }

    // Leave Requests
    public function getLeaveRequestsPaginated(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = InternshipLeaveRequest::with(['placement.student.classroom', 'placement.company', 'reviewer']);

        if (! empty($filters['teacher_id'])) {
            $query->whereHas('placement', function ($q) use ($filters) {
                $q->where('teacher_id', $filters['teacher_id']);
            });
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        return $query->latest()->paginate($perPage)->withQueryString();
    }

    public function findLeaveRequestById(int $id): ?InternshipLeaveRequest
    {
        return InternshipLeaveRequest::with(['placement.student.classroom', 'placement.company', 'reviewer'])->find($id);
    }

    public function reviewLeaveRequest(int $id, string $status, ?string $reviewNotes, int $reviewerUserId): InternshipLeaveRequest
    {
        $leaveRequest = InternshipLeaveRequest::findOrFail($id);

        $leaveRequest->update([
            'status' => $status,
            'review_notes' => $reviewNotes,
            'reviewed_by' => $reviewerUserId,
            'reviewed_at' => Carbon::now(),
        ]);

        // If approved, automatically create or update attendance entries as izin/sakit
        if ($status === InternshipLeaveStatus::Approved->value) {
            $start = Carbon::parse($leaveRequest->start_date);
            $end = Carbon::parse($leaveRequest->end_date);

            while ($start->lte($end)) {
                InternshipAttendance::updateOrCreate(
                    [
                        'internship_placement_id' => $leaveRequest->internship_placement_id,
                        'date' => $start->toDateString(),
                    ],
                    [
                        'status' => $leaveRequest->type->value,
                        'verification_status' => InternshipVerificationStatus::Verified,
                        'notes' => 'Disetujui dari pengajuan '.$leaveRequest->type->label().': '.$leaveRequest->reason,
                    ]
                );
                $start->addDay();
            }
        }

        return $leaveRequest->fresh(['placement.student', 'placement.company', 'reviewer']);
    }

    // Tasks & Submissions
    public function getTasksForTeacher(int $teacherId): Collection
    {
        return InternshipTask::with(['company', 'submissions.student'])
            ->where('teacher_id', $teacherId)
            ->latest('due_date')
            ->get();
    }

    public function findTaskById(int $id): ?InternshipTask
    {
        return InternshipTask::with(['company', 'teacher.user', 'submissions.student.classroom'])->find($id);
    }

    public function createTask(array $data): InternshipTask
    {
        return InternshipTask::create($data);
    }

    public function updateTask(int $id, array $data): InternshipTask
    {
        $task = InternshipTask::findOrFail($id);
        $task->update($data);

        return $task->fresh(['company']);
    }

    public function deleteTask(int $id): bool
    {
        $task = InternshipTask::findOrFail($id);

        return (bool) $task->delete();
    }

    public function getSubmissionsForTask(int $taskId): Collection
    {
        return InternshipTaskSubmission::with(['student.classroom', 'grader'])
            ->where('internship_task_id', $taskId)
            ->latest('submitted_at')
            ->get();
    }

    public function findSubmissionById(int $id): ?InternshipTaskSubmission
    {
        return InternshipTaskSubmission::with(['task', 'student.classroom', 'grader'])->find($id);
    }

    public function gradeSubmission(int $id, int $grade, ?string $feedback, int $graderUserId): InternshipTaskSubmission
    {
        $submission = InternshipTaskSubmission::findOrFail($id);

        $submission->update([
            'grade' => $grade,
            'mentor_feedback' => $feedback,
            'status' => InternshipTaskSubmissionStatus::Graded,
            'graded_by' => $graderUserId,
            'graded_at' => Carbon::now(),
        ]);

        return $submission->fresh(['task', 'student', 'grader']);
    }
}
