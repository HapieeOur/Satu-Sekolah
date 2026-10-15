<?php

namespace App\Contracts\Services;

use App\Models\InternshipAttendance;
use App\Models\InternshipJournal;
use App\Models\InternshipLeaveRequest;
use App\Models\InternshipPlacement;
use App\Models\InternshipTask;
use App\Models\InternshipTaskSubmission;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface InternshipServiceInterface
{
    // Admin Placements
    public function getPlacements(array $filters = []): LengthAwarePaginator;

    public function getPlacement(int $id): InternshipPlacement;

    public function createPlacement(array $data): InternshipPlacement;

    public function updatePlacement(int $id, array $data): InternshipPlacement;

    public function deletePlacement(int $id): bool;

    public function getPlacementFormData(?int $exceptStudentId = null): array;

    // Mentor Access & IDOR Verification
    public function getMentorPlacement(int $userId, int $placementId): InternshipPlacement;

    public function getMentorMentees(int $userId, array $filters = []): Collection;

    public function getMentorDashboardMetrics(int $userId): array;

    // Attendances & Manual Correction
    public function getAttendances(array $filters = []): LengthAwarePaginator;

    public function getMentorAttendances(int $userId, array $filters = []): LengthAwarePaginator;

    public function verifyAttendance(int $userId, int $attendanceId, string $status, ?string $rejectionReason = null): InternshipAttendance;

    public function manuallyCorrectAttendance(int $userId, int $attendanceId, array $data): InternshipAttendance;

    // Journals
    public function getMentorJournals(int $userId, array $filters = []): LengthAwarePaginator;

    public function reviewJournal(int $userId, int $journalId, string $status, ?string $notes = null): InternshipJournal;

    // Leave Requests
    public function getMentorLeaveRequests(int $userId, array $filters = []): LengthAwarePaginator;

    public function reviewLeaveRequest(int $userId, int $leaveRequestId, string $status, ?string $notes = null): InternshipLeaveRequest;

    // Tasks
    public function getMentorTasks(int $userId): Collection;

    public function createMentorTask(int $userId, array $data): InternshipTask;

    public function getTaskWithSubmissions(int $userId, int $taskId): array;

    public function gradeSubmission(int $userId, int $submissionId, int $grade, ?string $feedback = null): InternshipTaskSubmission;
}
