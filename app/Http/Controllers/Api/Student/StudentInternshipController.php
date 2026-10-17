<?php

namespace App\Http\Controllers\Api\Student;

use App\Enums\InternshipAttendanceStatus;
use App\Enums\InternshipJournalStatus;
use App\Enums\InternshipLeaveStatus;
use App\Enums\InternshipLeaveType;
use App\Enums\InternshipPlacementStatus;
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
use App\Services\GeofenceService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentInternshipController extends ApiController
{
    /**
     * Get active placement for the authenticated student.
     */
    protected function getActivePlacement(Request $request): ?InternshipPlacement
    {
        $student = $request->user()?->student;
        if (! $student) {
            return null;
        }

        return InternshipPlacement::with(['company', 'teacher.user', 'academicYear', 'student.classroom'])
            ->where('student_id', $student->id)
            ->where('status', InternshipPlacementStatus::Active)
            ->latest()
            ->first();
    }

    /**
     * Get current active placement info.
     */
    public function placement(Request $request): JsonResponse
    {
        $placement = $this->getActivePlacement($request);

        if (! $placement) {
            return $this->respondWithError('Anda belum memiliki penempatan PKL aktif.', 404);
        }

        return $this->respondWithSuccess(new InternshipPlacementResource($placement), 'Data penempatan PKL aktif.');
    }

    /**
     * Record Check-in attendance with GPS geofence calculation and selfie photo.
     */
    public function checkIn(Request $request): JsonResponse
    {
        $placement = $this->getActivePlacement($request);
        if (! $placement) {
            return $this->respondWithError('Anda tidak memiliki penempatan PKL aktif.', 422);
        }

        $validated = $request->validate([
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'photo' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:5120'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $today = Carbon::today()->toDateString();

        $existing = InternshipAttendance::where('internship_placement_id', $placement->id)
            ->whereDate('date', $today)
            ->first();

        if ($existing && $existing->check_in_time) {
            return $this->respondWithError('Anda sudah melakukan presensi masuk hari ini.', 422, [
                'attendance' => new InternshipAttendanceResource($existing),
            ]);
        }

        $company = $placement->company;
        $geofence = GeofenceService::checkGeofence(
            (float) $validated['latitude'],
            (float) $validated['longitude'],
            (float) $company->latitude,
            (float) $company->longitude,
            (int) $company->radius_meters
        );

        $photoPath = $request->file('photo')->store('internship_attendances', 'public');

        $isWithin = $geofence['is_within_radius'];
        $verificationStatus = $isWithin ? InternshipVerificationStatus::Verified : InternshipVerificationStatus::Pending;

        $attendance = InternshipAttendance::updateOrCreate(
            [
                'internship_placement_id' => $placement->id,
                'date' => $today,
            ],
            [
                'status' => InternshipAttendanceStatus::Hadir,
                'check_in_time' => now()->format('H:i:s'),
                'check_in_latitude' => $validated['latitude'],
                'check_in_longitude' => $validated['longitude'],
                'check_in_photo_path' => $photoPath,
                'check_in_distance_meters' => $geofence['distance_meters'],
                'check_in_within_radius' => $isWithin,
                'verification_status' => $verificationStatus,
                'notes' => $validated['notes'] ?? null,
            ]
        );

        $message = $isWithin
            ? 'Presensi masuk berhasil direkam dalam radius kantor (' . round($geofence['distance_meters']) . 'm).'
            : 'Presensi masuk berhasil direkam di luar radius kantor (' . round($geofence['distance_meters']) . 'm) dan menunggu verifikasi pembimbing.';

        return $this->respondWithSuccess(new InternshipAttendanceResource($attendance), $message, 201);
    }

    /**
     * Record Check-out attendance.
     */
    public function checkOut(Request $request): JsonResponse
    {
        $placement = $this->getActivePlacement($request);
        if (! $placement) {
            return $this->respondWithError('Anda tidak memiliki penempatan PKL aktif.', 422);
        }

        $validated = $request->validate([
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:5120'],
        ]);

        $today = Carbon::today()->toDateString();

        $attendance = InternshipAttendance::where('internship_placement_id', $placement->id)
            ->whereDate('date', $today)
            ->first();

        if (! $attendance || ! $attendance->check_in_time) {
            return $this->respondWithError('Anda belum melakukan presensi masuk hari ini.', 422);
        }

        if ($attendance->check_out_time) {
            return $this->respondWithError('Anda sudah melakukan presensi pulang hari ini.', 422, [
                'attendance' => new InternshipAttendanceResource($attendance),
            ]);
        }

        $company = $placement->company;
        $geofence = GeofenceService::checkGeofence(
            (float) $validated['latitude'],
            (float) $validated['longitude'],
            (float) $company->latitude,
            (float) $company->longitude,
            (int) $company->radius_meters
        );

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('internship_attendances', 'public');
        }

        $attendance->update([
            'check_out_time' => now()->format('H:i:s'),
            'check_out_latitude' => $validated['latitude'],
            'check_out_longitude' => $validated['longitude'],
            'check_out_photo_path' => $photoPath ?? $attendance->check_out_photo_path,
            'check_out_distance_meters' => $geofence['distance_meters'],
            'check_out_within_radius' => $geofence['is_within_radius'],
        ]);

        return $this->respondWithSuccess(new InternshipAttendanceResource($attendance), 'Presensi pulang berhasil direkam.');
    }

    /**
     * Get attendance history for the student.
     */
    public function attendances(Request $request): JsonResponse
    {
        $placement = $this->getActivePlacement($request);
        if (! $placement) {
            return $this->respondWithError('Anda tidak memiliki penempatan PKL aktif.', 404);
        }

        $query = InternshipAttendance::where('internship_placement_id', $placement->id)
            ->orderBy('date', 'desc');

        if ($request->filled('month')) {
            $query->whereMonth('date', $request->input('month'));
        }

        if ($request->filled('year')) {
            $query->whereYear('date', $request->input('year'));
        }

        $attendances = $query->paginate(20);

        return $this->respondWithPagination($attendances, InternshipAttendanceResource::class, 'Riwayat presensi PKL.');
    }

    /**
     * Get daily journals for the student.
     */
    public function journals(Request $request): JsonResponse
    {
        $placement = $this->getActivePlacement($request);
        if (! $placement) {
            return $this->respondWithError('Anda tidak memiliki penempatan PKL aktif.', 404);
        }

        $journals = InternshipJournal::with('reviewer')
            ->where('internship_placement_id', $placement->id)
            ->orderBy('date', 'desc')
            ->paginate(15);

        return $this->respondWithPagination($journals, InternshipJournalResource::class, 'Daftar jurnal kegiatan PKL.');
    }

    /**
     * Submit a new daily journal.
     */
    public function storeJournal(Request $request): JsonResponse
    {
        $placement = $this->getActivePlacement($request);
        if (! $placement) {
            return $this->respondWithError('Anda tidak memiliki penempatan PKL aktif.', 422);
        }

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'title' => ['required', 'string', 'max:255'],
            'activity_description' => ['required', 'string'],
            'attachment' => ['nullable', 'file', 'mimes:jpeg,png,jpg,pdf', 'max:10240'],
        ]);

        $existing = InternshipJournal::where('internship_placement_id', $placement->id)
            ->whereDate('date', $validated['date'])
            ->first();

        if ($existing) {
            return $this->respondWithError('Jurnal kegiatan untuk tanggal ini sudah ada. Silakan perbarui jurnal yang sudah dibuat.', 422, [
                'journal' => new InternshipJournalResource($existing),
            ]);
        }

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('internship_journals', 'public');
        }

        $journal = InternshipJournal::create([
            'internship_placement_id' => $placement->id,
            'date' => $validated['date'],
            'title' => $validated['title'],
            'activity_description' => $validated['activity_description'],
            'attachment_path' => $attachmentPath,
            'status' => InternshipJournalStatus::Submitted,
        ]);

        return $this->respondWithSuccess(new InternshipJournalResource($journal), 'Jurnal kegiatan PKL berhasil dikirim.', 201);
    }

    /**
     * Show journal detail.
     */
    public function showJournal(InternshipJournal $journal, Request $request): JsonResponse
    {
        $placement = $this->getActivePlacement($request);
        if (! $placement || $journal->internship_placement_id !== $placement->id) {
            return $this->respondWithError('Jurnal tidak ditemukan atau bukan milik Anda.', 404);
        }

        $journal->load('reviewer');

        return $this->respondWithSuccess(new InternshipJournalResource($journal), 'Detail jurnal PKL.');
    }

    /**
     * Update journal (allowed if submitted or needs revision).
     */
    public function updateJournal(InternshipJournal $journal, Request $request): JsonResponse
    {
        $placement = $this->getActivePlacement($request);
        if (! $placement || $journal->internship_placement_id !== $placement->id) {
            return $this->respondWithError('Jurnal tidak ditemukan atau bukan milik Anda.', 404);
        }

        if ($journal->status === InternshipJournalStatus::Approved) {
            return $this->respondWithError('Jurnal yang telah disetujui tidak dapat diubah.', 422);
        }

        $validated = $request->validate([
            'date' => ['sometimes', 'date'],
            'title' => ['sometimes', 'string', 'max:255'],
            'activity_description' => ['sometimes', 'string'],
            'attachment' => ['nullable', 'file', 'mimes:jpeg,png,jpg,pdf', 'max:10240'],
        ]);

        if ($request->hasFile('attachment')) {
            if ($journal->attachment_path) {
                Storage::disk('public')->delete($journal->attachment_path);
            }
            $validated['attachment_path'] = $request->file('attachment')->store('internship_journals', 'public');
        }

        $validated['status'] = InternshipJournalStatus::Submitted;
        $journal->update($validated);

        return $this->respondWithSuccess(new InternshipJournalResource($journal), 'Jurnal kegiatan PKL berhasil diperbarui.');
    }

    /**
     * List leave/sick requests.
     */
    public function leaves(Request $request): JsonResponse
    {
        $placement = $this->getActivePlacement($request);
        if (! $placement) {
            return $this->respondWithError('Anda tidak memiliki penempatan PKL aktif.', 404);
        }

        $leaves = InternshipLeaveRequest::with('reviewer')
            ->where('internship_placement_id', $placement->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return $this->respondWithPagination($leaves, InternshipLeaveResource::class, 'Daftar pengajuan izin/sakit PKL.');
    }

    /**
     * Submit leave/sick request.
     */
    public function storeLeave(Request $request): JsonResponse
    {
        $placement = $this->getActivePlacement($request);
        if (! $placement) {
            return $this->respondWithError('Anda tidak memiliki penempatan PKL aktif.', 422);
        }

        $validated = $request->validate([
            'type' => ['required', 'string', 'in:izin,sakit'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'reason' => ['required', 'string'],
            'attachment' => ['nullable', 'file', 'mimes:jpeg,png,jpg,pdf', 'max:10240'],
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('internship_leaves', 'public');
        }

        $leave = InternshipLeaveRequest::create([
            'internship_placement_id' => $placement->id,
            'type' => InternshipLeaveType::from($validated['type']),
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'reason' => $validated['reason'],
            'attachment_path' => $attachmentPath,
            'status' => InternshipLeaveStatus::Pending,
        ]);

        return $this->respondWithSuccess(new InternshipLeaveResource($leave), 'Pengajuan izin/sakit berhasil dikirim.', 201);
    }

    /**
     * List PKL tasks assigned to student's company/mentor.
     */
    public function tasks(Request $request): JsonResponse
    {
        $placement = $this->getActivePlacement($request);
        if (! $placement) {
            return $this->respondWithError('Anda tidak memiliki penempatan PKL aktif.', 404);
        }

        $studentId = $placement->student_id;

        $tasks = InternshipTask::with([
            'company',
            'teacher.user',
            'submissions' => fn ($q) => $q->where('student_id', $studentId),
        ])
            ->where('internship_company_id', $placement->internship_company_id)
            ->orderBy('due_date', 'asc')
            ->paginate(15);

        return $this->respondWithPagination($tasks, InternshipTaskResource::class, 'Daftar tugas PKL.');
    }

    /**
     * Show task detail.
     */
    public function showTask(InternshipTask $task, Request $request): JsonResponse
    {
        $placement = $this->getActivePlacement($request);
        if (! $placement || $task->internship_company_id !== $placement->internship_company_id) {
            return $this->respondWithError('Tugas tidak ditemukan untuk lokasi penempatan Anda.', 404);
        }

        $studentId = $placement->student_id;
        $task->load([
            'company',
            'teacher.user',
            'submissions' => fn ($q) => $q->where('student_id', $studentId),
        ]);

        return $this->respondWithSuccess(new InternshipTaskResource($task), 'Detail tugas PKL.');
    }

    /**
     * Submit task work (upload file & notes).
     */
    public function submitTask(InternshipTask $task, Request $request): JsonResponse
    {
        $placement = $this->getActivePlacement($request);
        if (! $placement || $task->internship_company_id !== $placement->internship_company_id) {
            return $this->respondWithError('Tugas tidak ditemukan untuk lokasi penempatan Anda.', 404);
        }

        $validated = $request->validate([
            'submission_file' => ['required', 'file', 'mimes:pdf,zip,rar,doc,docx,jpg,png', 'max:20480'],
            'student_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $filePath = $request->file('submission_file')->store('internship_task_submissions', 'public');

        $submission = InternshipTaskSubmission::updateOrCreate(
            [
                'internship_task_id' => $task->id,
                'student_id' => $placement->student_id,
            ],
            [
                'submission_file_path' => $filePath,
                'student_notes' => $validated['student_notes'] ?? null,
                'submitted_at' => now(),
                'status' => InternshipTaskSubmissionStatus::Submitted,
            ]
        );

        $submission->load(['student.classroom', 'grader']);

        return $this->respondWithSuccess(new InternshipSubmissionResource($submission), 'Tugas berhasil dikumpulkan.', 201);
    }
}
