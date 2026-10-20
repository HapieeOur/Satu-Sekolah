<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Api\ApiController;
use App\Models\AcademicTask;
use App\Models\AcademicTaskSubmission;
use App\Models\AcademicYear;
use App\Models\Attendance;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentAcademicController extends ApiController
{
    /**
     * Get class timetable for the authenticated student.
     */
    public function schedules(Request $request): JsonResponse
    {
        $student = $request->user()?->student;
        if (! $student || ! $student->classroom_id) {
            return $this->respondWithError('Data kelas siswa tidak ditemukan.', 404);
        }

        $academicYear = AcademicYear::where('is_active', true)->first();

        $query = Schedule::with(['subject', 'teacher.user', 'room'])
            ->where('classroom_id', $student->classroom_id);

        if ($academicYear) {
            $query->where('academic_year_id', $academicYear->id);
        }

        if ($request->filled('day')) {
            $query->where('day_of_week', $request->input('day'));
        }

        $schedules = $query->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get()
            ->map(fn ($s) => [
                'id' => $s->id,
                'day_of_week' => $s->day_of_week?->value ?? $s->day_of_week,
                'day_label' => method_exists($s->day_of_week, 'label') ? $s->day_of_week->label() : ucfirst($s->day_of_week?->value ?? (string) $s->day_of_week),
                'start_time' => substr((string) $s->start_time, 0, 5),
                'end_time' => substr((string) $s->end_time, 0, 5),
                'time_range' => $s->time_range,
                'subject' => $s->subject ? [
                    'id' => $s->subject->id,
                    'name' => $s->subject->name,
                    'code' => $s->subject->code,
                ] : null,
                'teacher' => $s->teacher && $s->teacher->user ? [
                    'id' => $s->teacher->id,
                    'name' => $s->teacher->user->name,
                ] : null,
                'room' => $s->room ? [
                    'id' => $s->room->id,
                    'name' => $s->room->name,
                    'code' => $s->room->code,
                ] : null,
            ]);

        return $this->respondWithSuccess([
            'classroom' => [
                'id' => $student->classroom->id,
                'name' => $student->classroom->name,
                'major' => $student->classroom->major,
            ],
            'schedules' => $schedules,
        ], 'Jadwal pelajaran kelas siswa.');
    }

    /**
     * Get academic classroom attendance history.
     */
    public function attendances(Request $request): JsonResponse
    {
        $student = $request->user()?->student;
        if (! $student) {
            return $this->respondWithError('Data siswa tidak ditemukan.', 404);
        }

        $attendances = Attendance::with(['schedule.subject', 'classroom'])
            ->where('student_id', $student->id)
            ->orderBy('date', 'desc')
            ->paginate(20);

        return $this->respondWithPagination($attendances, null, 'Riwayat presensi kelas.');
    }

    /**
     * Record daily classroom attendance for authenticated student.
     */
    public function checkIn(Request $request): JsonResponse
    {
        $student = $request->user()?->student;
        if (! $student) {
            return $this->respondWithError('Data siswa tidak ditemukan.', 404);
        }

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:hadir,terlambat,izin,sakit,alpa'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $today = Carbon::today()->toDateString();
        $currentTime = Carbon::now()->format('H:i:s');
        $minCheckIn = '06:00:00';
        $maxCheckIn = config('attendance.check_in_max_time', '08:00:00');

        // Presensi masuk dibuka mulai pukul 06:00 WIB
        if ($currentTime < $minCheckIn) {
            return $this->respondWithError('Presensi masuk belum dibuka (dibuka mulai pukul '.substr($minCheckIn, 0, 5).' WIB).', 422);
        }

        $existing = Attendance::where('student_id', $student->id)
            ->whereDate('date', $today)
            ->first();

        if ($existing) {
            return $this->respondWithError('Anda sudah melakukan presensi kelas hari ini.', 422, [
                'attendance' => $existing,
            ]);
        }

        // Tentukan status: jika memilih hadir namun lewat pukul 08:00, otomatis tercatat terlambat
        $status = $validated['status'];
        $notes = $validated['notes'] ?? null;

        if ($status === 'hadir' && $currentTime > $maxCheckIn) {
            $status = 'terlambat';
            if (empty($notes)) {
                $notes = 'Terlambat masuk (pukul '.substr($currentTime, 0, 5).' WIB, batas maks '.substr($maxCheckIn, 0, 5).' WIB)';
            }
        }

        $attendance = Attendance::create([
            'student_id' => $student->id,
            'classroom_id' => $student->classroom_id,
            'date' => $today,
            'status' => $status,
            'check_in_time' => $currentTime,
            'notes' => $notes,
        ]);

        $attendance->load(['classroom']);

        $message = $status === 'terlambat'
            ? 'Presensi harian tercatat: Terlambat (lewat pukul '.substr($maxCheckIn, 0, 5).' WIB).'
            : 'Presensi harian berhasil dicatat.';

        return $this->respondWithSuccess([
            'id' => $attendance->id,
            'student_id' => $attendance->student_id,
            'classroom_id' => $attendance->classroom_id,
            'date' => $attendance->date->toDateString(),
            'status' => $attendance->status->value,
            'check_in_time' => $attendance->check_in_time,
            'notes' => $attendance->notes,
            'classroom' => $attendance->classroom ? [
                'id' => $attendance->classroom->id,
                'name' => $attendance->classroom->name,
                'major' => $attendance->classroom->major,
            ] : null,
        ], $message, 201);
    }

    /**
     * Record daily classroom check-out attendance for authenticated student.
     */
    public function checkOut(Request $request): JsonResponse
    {
        $student = $request->user()?->student;
        if (! $student) {
            return $this->respondWithError('Data siswa tidak ditemukan.', 404);
        }

        $today = Carbon::today()->toDateString();
        $currentTime = Carbon::now()->format('H:i:s');
        $minCheckOut = '15:00:00';
        $maxCheckOut = config('attendance.check_out_max_time', '17:00:00');

        $attendance = Attendance::where('student_id', $student->id)
            ->whereDate('date', $today)
            ->first();

        if (! $attendance || ! $attendance->check_in_time) {
            return $this->respondWithError('Anda belum melakukan presensi masuk hari ini.', 422);
        }

        // Cek jeda minimal 4 jam dari waktu presensi masuk
        $checkInCarbon = Carbon::parse($attendance->check_in_time);
        if (Carbon::now()->diffInMinutes($checkInCarbon) < 240) {
            $canCheckOutAt = $checkInCarbon->copy()->addHours(4)->format('H:i');

            return $this->respondWithError('Belum dapat melakukan presensi pulang. Harus menunggu jeda minimal 4 jam setelah presensi masuk (tersedia mulai pukul '.$canCheckOutAt.' WIB).', 422);
        }

        // Presensi pulang dibuka mulai pukul 15:00 WIB
        if ($currentTime < $minCheckOut) {
            return $this->respondWithError('Presensi pulang belum dibuka (dibuka mulai pukul '.substr($minCheckOut, 0, 5).' WIB).', 422);
        }

        if ($attendance->check_out_time) {
            return $this->respondWithError('Anda sudah melakukan presensi pulang hari ini.', 422, [
                'attendance' => $attendance,
            ]);
        }

        $notes = $attendance->notes;
        $isLateCheckOut = $currentTime > $maxCheckOut;
        if ($isLateCheckOut) {
            $lateNote = 'Terlambat pulang (pukul '.substr($currentTime, 0, 5).' WIB, batas maks '.substr($maxCheckOut, 0, 5).' WIB)';
            $notes = ! empty($notes) ? $notes.' | '.$lateNote : $lateNote;
        }

        $attendance->update([
            'check_out_time' => $currentTime,
            'notes' => $notes,
        ]);

        $message = $isLateCheckOut
            ? 'Presensi pulang tercatat: Telat (pukul '.substr($currentTime, 0, 5).' WIB, batas maks '.substr($maxCheckOut, 0, 5).' WIB).'
            : 'Presensi pulang berhasil dicatat (pukul '.substr($currentTime, 0, 5).' WIB).';

        return $this->respondWithSuccess([
            'id' => $attendance->id,
            'student_id' => $attendance->student_id,
            'date' => $attendance->date->toDateString(),
            'status' => $attendance->status->value,
            'check_in_time' => $attendance->check_in_time,
            'check_out_time' => $attendance->check_out_time,
            'notes' => $attendance->notes,
        ], $message);
    }

    /**
     * Get tasks for student's classroom.
     */
    public function tasks(Request $request): JsonResponse
    {
        $student = $request->user()?->student;
        if (! $student || ! $student->classroom_id) {
            return $this->respondWithError('Data kelas siswa tidak ditemukan.', 404);
        }

        $tasks = AcademicTask::with([
            'teacher.user',
            'subject',
            'submissions' => fn ($q) => $q->where('student_id', $student->id),
        ])
            ->where('classroom_id', $student->classroom_id)
            ->orderBy('due_date', 'asc')
            ->paginate(15);

        return $this->respondWithPagination($tasks, null, 'Daftar tugas mata pelajaran kelas.');
    }

    /**
     * Show task detail.
     */
    public function showTask(AcademicTask $task, Request $request): JsonResponse
    {
        $student = $request->user()?->student;
        if (! $student || $task->classroom_id !== $student->classroom_id) {
            return $this->respondWithError('Tugas tidak ditemukan untuk kelas Anda.', 404);
        }

        $task->load(['teacher.user', 'subject', 'classroom']);
        $submission = AcademicTaskSubmission::where('academic_task_id', $task->id)
            ->where('student_id', $student->id)
            ->first();

        return $this->respondWithSuccess([
            'id' => $task->id,
            'title' => $task->title,
            'description' => $task->description,
            'due_date' => $task->due_date->format('Y-m-d H:i:s'),
            'due_date_formatted' => $task->due_date->translatedFormat('d M Y, H:i').' WIB',
            'subject' => $task->subject?->name,
            'teacher' => $task->teacher?->user?->name,
            'attachment_url' => $task->attachment_path ? asset('storage/'.$task->attachment_path) : null,
            'submission' => $submission ? [
                'id' => $submission->id,
                'submitted_at' => $submission->submitted_at->format('Y-m-d H:i:s'),
                'submission_file_url' => $submission->submission_file_path ? asset('storage/'.$submission->submission_file_path) : null,
                'student_notes' => $submission->student_notes,
                'status' => $submission->status,
                'grade' => $submission->grade,
                'teacher_feedback' => $submission->teacher_feedback,
                'graded_at' => $submission->graded_at?->format('Y-m-d H:i:s'),
            ] : null,
        ], 'Detail tugas mata pelajaran.');
    }

    /**
     * Submit task solution.
     */
    public function submitTask(AcademicTask $task, Request $request): JsonResponse
    {
        $student = $request->user()?->student;
        if (! $student || $task->classroom_id !== $student->classroom_id) {
            return $this->respondWithError('Tugas tidak ditemukan untuk kelas Anda.', 404);
        }

        $validated = $request->validate([
            'submission_file' => ['required', 'file', 'mimes:pdf,doc,docx,zip,rar,xls,xlsx,ppt,pptx,jpg,png', 'max:20480'],
            'student_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $filePath = $request->file('submission_file')->store('academic_submissions', 'public');
        $isLate = now()->gt($task->due_date);

        $submission = AcademicTaskSubmission::updateOrCreate(
            [
                'academic_task_id' => $task->id,
                'student_id' => $student->id,
            ],
            [
                'submission_file_path' => $filePath,
                'student_notes' => $validated['student_notes'] ?? null,
                'submitted_at' => now(),
                'status' => $isLate ? 'late' : 'submitted',
            ]
        );

        return $this->respondWithSuccess([
            'id' => $submission->id,
            'academic_task_id' => $submission->academic_task_id,
            'submitted_at' => $submission->submitted_at->format('Y-m-d H:i:s'),
            'status' => $submission->status,
            'submission_file_url' => asset('storage/'.$submission->submission_file_path),
            'student_notes' => $submission->student_notes,
        ], 'Tugas berhasil dikumpulkan.', 201);
    }
}
