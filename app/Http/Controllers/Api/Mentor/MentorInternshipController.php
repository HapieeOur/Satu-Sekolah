<?php

namespace App\Http\Controllers\Api\Mentor;

use App\Enums\InternshipJournalStatus;
use App\Enums\InternshipLeaveStatus;
use App\Enums\InternshipTaskSubmissionStatus;
use App\Enums\InternshipVerificationStatus;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\InternshipAttendanceResource;
use App\Http\Resources\InternshipJournalResource;
use App\Http\Resources\InternshipLeaveResource;
use App\Http\Resources\InternshipPlacementResource;
use App\Http\Resources\InternshipSubmissionResource;
use App\Http\Resources\InternshipTaskResource;
use App\Models\InternshipAttendance;
use App\Models\InternshipJournal;
use App\Models\InternshipLeaveRequest;
use App\Models\InternshipPlacement;
use App\Models\InternshipTask;
use App\Models\InternshipTaskSubmission;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MentorInternshipController extends ApiController
{
    /**
     * Get the teacher profile of authenticated user.
     */
    protected function getTeacher(Request $request)
    {
        return $request->user()?->teacher;
    }

    /**
     * List all students supervised by the mentor (mentees).
     */
    public function mentees(Request $request): JsonResponse
    {
        $teacher = $this->getTeacher($request);
        if (! $teacher) {
            return $this->respondWithError('Profil guru tidak ditemukan untuk akun ini.', 403);
        }

        $placements = InternshipPlacement::with(['student.classroom', 'company', 'academicYear'])
            ->where('teacher_id', $teacher->id)
            ->orderBy('status', 'asc')
            ->get();

        return $this->respondWithSuccess(InternshipPlacementResource::collection($placements), 'Daftar siswa bimbingan PKL.');
    }

    /**
     * List attendance records of supervised mentees.
     */
    public function attendances(Request $request): JsonResponse
    {
        $teacher = $this->getTeacher($request);
        if (! $teacher) {
            return $this->respondWithError('Profil guru tidak ditemukan.', 403);
        }

        $placementIds = InternshipPlacement::where('teacher_id', $teacher->id)->pluck('id');

        $query = InternshipAttendance::with(['placement.student.classroom', 'placement.company'])
            ->whereIn('internship_placement_id', $placementIds)
            ->orderBy('date', 'desc');

        if ($request->filled('date')) {
            $query->whereDate('date', $request->input('date'));
        }

        if ($request->filled('verification_status')) {
            $query->where('verification_status', $request->input('verification_status'));
        }

        $attendances = $query->paginate(20);

        return $this->respondWithPagination($attendances, InternshipAttendanceResource::class, 'Daftar presensi siswa bimbingan PKL.');
    }

    /**
     * Verify or reject mentee attendance.
     */
    public function verifyAttendance(InternshipAttendance $attendance, Request $request): JsonResponse
    {
        $teacher = $this->getTeacher($request);
        if (! $teacher || $attendance->placement->teacher_id !== $teacher->id) {
            return $this->respondWithError('Data presensi tidak ditemukan pada siswa bimbingan Anda.', 403);
        }

        $validated = $request->validate([
            'action' => ['required', 'string', 'in:verify,reject'],
            'rejection_reason' => ['required_if:action,reject', 'nullable', 'string', 'max:500'],
        ]);

        $status = $validated['action'] === 'verify'
            ? InternshipVerificationStatus::Verified
            : InternshipVerificationStatus::Rejected;

        $attendance->update([
            'verification_status' => $status,
            'rejection_reason' => $validated['action'] === 'reject' ? $validated['rejection_reason'] : null,
        ]);

        $attendance->load(['placement.student.classroom', 'placement.company']);

        return $this->respondWithSuccess(
            new InternshipAttendanceResource($attendance),
            $validated['action'] === 'verify' ? 'Presensi berhasil diverifikasi.' : 'Presensi berhasil ditolak.'
        );
    }

    /**
     * List daily journals from mentees.
     */
    public function journals(Request $request): JsonResponse
    {
        $teacher = $this->getTeacher($request);
        if (! $teacher) {
            return $this->respondWithError('Profil guru tidak ditemukan.', 403);
        }

        $placementIds = InternshipPlacement::where('teacher_id', $teacher->id)->pluck('id');

        $query = InternshipJournal::with(['placement.student.classroom', 'reviewer'])
            ->whereIn('internship_placement_id', $placementIds)
            ->orderBy('date', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $journals = $query->paginate(15);

        return $this->respondWithPagination($journals, InternshipJournalResource::class, 'Daftar jurnal kegiatan siswa bimbingan.');
    }

    /**
     * Review journal (approve or request revision).
     */
    public function reviewJournal(InternshipJournal $journal, Request $request): JsonResponse
    {
        $teacher = $this->getTeacher($request);
        if (! $teacher || $journal->placement->teacher_id !== $teacher->id) {
            return $this->respondWithError('Jurnal tidak ditemukan pada siswa bimbingan Anda.', 403);
        }

        $validated = $request->validate([
            'action' => ['required', 'string', 'in:approve,revision'],
            'mentor_notes' => ['required_if:action,revision', 'nullable', 'string', 'max:1000'],
        ]);

        $status = $validated['action'] === 'approve'
            ? InternshipJournalStatus::Approved
            : InternshipJournalStatus::RevisionRequested;

        $journal->update([
            'status' => $status,
            'mentor_notes' => $validated['mentor_notes'] ?? null,
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
        ]);

        $journal->load(['placement.student.classroom', 'reviewer']);

        return $this->respondWithSuccess(
            new InternshipJournalResource($journal),
            $validated['action'] === 'approve' ? 'Jurnal berhasil disetujui.' : 'Catatan revisi jurnal berhasil dikirim.'
        );
    }

    /**
     * List leave requests from mentees.
     */
    public function leaves(Request $request): JsonResponse
    {
        $teacher = $this->getTeacher($request);
        if (! $teacher) {
            return $this->respondWithError('Profil guru tidak ditemukan.', 403);
        }

        $placementIds = InternshipPlacement::where('teacher_id', $teacher->id)->pluck('id');

        $query = InternshipLeaveRequest::with(['placement.student.classroom', 'reviewer'])
            ->whereIn('internship_placement_id', $placementIds)
            ->orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $leaves = $query->paginate(15);

        return $this->respondWithPagination($leaves, InternshipLeaveResource::class, 'Daftar pengajuan izin/sakit siswa bimbingan.');
    }

    /**
     * Review leave request (approve or reject).
     */
    public function reviewLeave(InternshipLeaveRequest $leave, Request $request): JsonResponse
    {
        $teacher = $this->getTeacher($request);
        if (! $teacher || $leave->placement->teacher_id !== $teacher->id) {
            return $this->respondWithError('Pengajuan izin tidak ditemukan pada siswa bimbingan Anda.', 403);
        }

        $validated = $request->validate([
            'action' => ['required', 'string', 'in:approve,reject'],
            'review_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $status = $validated['action'] === 'approve'
            ? InternshipLeaveStatus::Approved
            : InternshipLeaveStatus::Rejected;

        $leave->update([
            'status' => $status,
            'review_notes' => $validated['review_notes'] ?? null,
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
        ]);

        $leave->load(['placement.student.classroom', 'reviewer']);

        return $this->respondWithSuccess(
            new InternshipLeaveResource($leave),
            $validated['action'] === 'approve' ? 'Pengajuan izin disetujui.' : 'Pengajuan izin ditolak.'
        );
    }

    /**
     * List tasks created by this mentor.
     */
    public function tasks(Request $request): JsonResponse
    {
        $teacher = $this->getTeacher($request);
        if (! $teacher) {
            return $this->respondWithError('Profil guru tidak ditemukan.', 403);
        }

        $tasks = InternshipTask::with(['company', 'submissions.student.classroom'])
            ->withCount('submissions')
            ->where('teacher_id', $teacher->id)
            ->orderBy('due_date', 'desc')
            ->paginate(15);

        return $this->respondWithPagination($tasks, InternshipTaskResource::class, 'Daftar tugas bimbingan PKL.');
    }

    /**
     * Create a new task for mentees at a company.
     */
    public function storeTask(Request $request): JsonResponse
    {
        $teacher = $this->getTeacher($request);
        if (! $teacher) {
            return $this->respondWithError('Profil guru tidak ditemukan.', 403);
        }

        $validated = $request->validate([
            'internship_company_id' => ['required', 'exists:internship_companies,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'due_date' => ['required', 'date'],
            'attachment' => ['nullable', 'file', 'mimes:pdf,zip,rar,doc,docx,jpg,png', 'max:10240'],
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('internship_tasks', 'public');
        }

        $dueDate = Carbon::parse($validated['due_date']);
        if (is_string($validated['due_date']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', trim($validated['due_date']))) {
            $dueDate = $dueDate->endOfDay();
        }

        $task = InternshipTask::create([
            'teacher_id' => $teacher->id,
            'internship_company_id' => $validated['internship_company_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'due_date' => $dueDate->format('Y-m-d H:i:s'),
            'attachment_path' => $attachmentPath,
        ]);

        $task->load(['company', 'teacher.user']);

        return $this->respondWithSuccess(new InternshipTaskResource($task), 'Tugas PKL berhasil dibuat.', 201);
    }

    /**
     * Grade a mentee's task submission.
     */
    public function gradeSubmission(InternshipTaskSubmission $submission, Request $request): JsonResponse
    {
        $teacher = $this->getTeacher($request);
        if (! $teacher || $submission->task->teacher_id !== $teacher->id) {
            return $this->respondWithError('Pengumpulan tugas tidak ditemukan pada bimbingan Anda.', 403);
        }

        $validated = $request->validate([
            'grade' => ['required', 'integer', 'min:0', 'max:100'],
            'mentor_feedback' => ['nullable', 'string', 'max:1000'],
        ]);

        $submission->update([
            'grade' => $validated['grade'],
            'mentor_feedback' => $validated['mentor_feedback'] ?? null,
            'status' => InternshipTaskSubmissionStatus::Graded,
            'graded_by' => $request->user()->id,
            'graded_at' => now(),
        ]);

        $submission->load(['student.classroom', 'grader']);

        return $this->respondWithSuccess(new InternshipSubmissionResource($submission), 'Penilaian tugas berhasil disimpan.');
    }
}
