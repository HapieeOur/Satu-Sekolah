<?php

namespace App\Contracts\Repositories;

use App\Models\InternshipAttendance;
use App\Models\InternshipJournal;
use App\Models\InternshipLeaveRequest;
use App\Models\InternshipTask;
use App\Models\InternshipTaskSubmission;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface InternshipMonitoringRepositoryInterface
{
    // Attendances
    public function getAttendancesPaginated(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function findAttendanceById(int $id): ?InternshipAttendance;

    public function correctAttendance(int $id, array $data, int $correctedByUserId): InternshipAttendance;

    public function verifyAttendance(int $id, string $status, ?string $rejectionReason = null): InternshipAttendance;

    public function getAttendanceSummaryForDate(string $date, ?int $teacherId = null): array;

    // Journals
    public function getJournalsPaginated(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function findJournalById(int $id): ?InternshipJournal;

    public function reviewJournal(int $id, string $status, ?string $mentorNotes, int $reviewerUserId): InternshipJournal;

    // Leave Requests
    public function getLeaveRequestsPaginated(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function findLeaveRequestById(int $id): ?InternshipLeaveRequest;

    public function reviewLeaveRequest(int $id, string $status, ?string $reviewNotes, int $reviewerUserId): InternshipLeaveRequest;

    // Tasks & Submissions
    public function getTasksForTeacher(int $teacherId): Collection;

    public function findTaskById(int $id): ?InternshipTask;

    public function createTask(array $data): InternshipTask;

    public function updateTask(int $id, array $data): InternshipTask;

    public function deleteTask(int $id): bool;

    public function getSubmissionsForTask(int $taskId): Collection;

    public function findSubmissionById(int $id): ?InternshipTaskSubmission;

    public function gradeSubmission(int $id, int $grade, ?string $feedback, int $graderUserId): InternshipTaskSubmission;
}
