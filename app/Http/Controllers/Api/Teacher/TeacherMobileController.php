<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Enums\AttendanceStatus;
use App\Http\Controllers\Api\ApiController;
use App\Models\AcademicTask;
use App\Models\AcademicTaskSubmission;
use App\Models\AcademicYear;
use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TeacherMobileController extends ApiController
{
    /**
     * Get teacher profile.
     */
    protected function getTeacher(Request $request)
    {
        return $request->user()?->teacher;
    }

    /**
     * Get teaching schedule for the authenticated teacher.
     */
    public function schedules(Request $request): JsonResponse
    {
        $teacher = $this->getTeacher($request);
        if (! $teacher) {
            return $this->respondWithError('Profil guru tidak ditemukan.', 403);
        }

        $academicYear = AcademicYear::where('is_active', true)->first();

        $query = Schedule::with(['subject', 'classroom', 'room'])
            ->where('teacher_id', $teacher->id);

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
                'classroom' => $s->classroom ? [
                    'id' => $s->classroom->id,
                    'name' => $s->classroom->name,
                    'major' => $s->classroom->major,
                ] : null,
                'room' => $s->room ? [
                    'id' => $s->room->id,
                    'name' => $s->room->name,
                    'code' => $s->room->code,
                ] : null,
            ]);

        return $this->respondWithSuccess($schedules, 'Jadwal mengajar guru.');
    }

    /**
     * Get students list for a schedule / classroom to take attendance.
     */
    public function studentsByClassroom(int $classroomId): JsonResponse
    {
        $students = Student::where('classroom_id', $classroomId)
            ->active()
            ->orderBy('name')
            ->get(['id', 'nis', 'nisn', 'name', 'gender']);

        return $this->respondWithSuccess($students, 'Daftar siswa di kelas.');
    }

    /**
     * Store classroom attendance batch from teacher.
     */
    public function storeAttendance(Request $request): JsonResponse
    {
        $teacher = $this->getTeacher($request);
        if (! $teacher) {
            return $this->respondWithError('Profil guru tidak ditemukan.', 403);
        }

        $validated = $request->validate([
            'schedule_id' => ['required', 'exists:schedules,id'],
            'classroom_id' => ['required', 'exists:classrooms,id'],
            'date' => ['required', 'date'],
            'attendances' => ['required', 'array', 'min:1'],
            'attendances.*.student_id' => ['required', 'exists:students,id'],
            'attendances.*.status' => ['required', 'string', 'in:hadir,izin,sakit,alpa'],
            'attendances.*.notes' => ['nullable', 'string', 'max:255'],
        ]);

        $schedule = Schedule::findOrFail($validated['schedule_id']);
        if ($schedule->teacher_id !== $teacher->id) {
            return $this->respondWithError('Jadwal pelajaran ini bukan milik Anda.', 403);
        }

        $dateFormatted = Carbon::parse($validated['date'])->format('Y-m-d');
        $records = [];

        foreach ($validated['attendances'] as $item) {
            $record = Attendance::where('schedule_id', $schedule->id)
                ->where('student_id', $item['student_id'])
                ->whereDate('date', $dateFormatted)
                ->first();

            $data = [
                'classroom_id' => $validated['classroom_id'],
                'status' => AttendanceStatus::from($item['status']),
                'check_in_time' => now()->format('H:i:s'),
                'notes' => $item['notes'] ?? null,
            ];

            if ($record) {
                $record->update($data);
            } else {
                $record = Attendance::create(array_merge([
                    'schedule_id' => $schedule->id,
                    'student_id' => $item['student_id'],
                    'date' => $dateFormatted,
                ], $data));
            }

            $records[] = $record;
        }

        return $this->respondWithSuccess([
            'recorded_count' => count($records),
            'date' => $dateFormatted,
            'schedule_id' => $schedule->id,
        ], 'Presensi kelas berhasil disimpan.');
    }

    /**
     * Get tasks created by authenticated teacher.
     */
    public function tasks(Request $request): JsonResponse
    {
        $teacher = $this->getTeacher($request);
        if (! $teacher) {
            return $this->respondWithError('Profil guru tidak ditemukan.', 403);
        }

        $tasks = AcademicTask::with(['classroom', 'subject', 'submissions'])
            ->where('teacher_id', $teacher->id)
            ->latest('due_date')
            ->paginate(15);

        return $this->respondWithPagination($tasks, null, 'Daftar tugas mata pelajaran.');
    }

    /**
     * Store new task.
     */
    public function storeTask(Request $request): JsonResponse
    {
        $teacher = $this->getTeacher($request);
        if (! $teacher) {
            return $this->respondWithError('Profil guru tidak ditemukan.', 403);
        }

        $validated = $request->validate([
            'classroom_id' => ['required', 'exists:classrooms,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'due_date' => ['required', 'date'],
            'attachment' => ['nullable', 'file', 'mimes:pdf,doc,docx,zip,rar,xls,xlsx,ppt,pptx,jpg,png', 'max:10240'],
        ]);

        $dueDate = Carbon::parse($validated['due_date']);
        if (is_string($validated['due_date']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', trim($validated['due_date']))) {
            $dueDate = $dueDate->endOfDay();
        }

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('academic_tasks', 'public');
        }

        $academicYear = AcademicYear::where('is_active', true)->first();

        $task = AcademicTask::create([
            'teacher_id' => $teacher->id,
            'classroom_id' => $validated['classroom_id'],
            'subject_id' => $validated['subject_id'],
            'academic_year_id' => $academicYear?->id,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'due_date' => $dueDate->format('Y-m-d H:i:s'),
            'attachment_path' => $attachmentPath,
        ]);

        $task->load(['classroom', 'subject']);

        return $this->respondWithSuccess([
            'id' => $task->id,
            'title' => $task->title,
            'description' => $task->description,
            'due_date' => $task->due_date->format('Y-m-d H:i:s'),
            'due_date_formatted' => $task->due_date->translatedFormat('d M Y, H:i').' WIB',
            'classroom' => $task->classroom?->name,
            'subject' => $task->subject?->name,
            'attachment_url' => $task->attachment_path ? asset('storage/'.$task->attachment_path) : null,
        ], 'Tugas mata pelajaran berhasil diterbitkan.', 201);
    }

    /**
     * Grade student submission.
     */
    public function gradeTaskSubmission(Request $request, AcademicTaskSubmission $submission): JsonResponse
    {
        $teacher = $this->getTeacher($request);
        if (! $teacher || $submission->task->teacher_id !== $teacher->id) {
            return $this->respondWithError('Anda tidak berwenang menilai tugas guru lain.', 403);
        }

        $validated = $request->validate([
            'grade' => ['required', 'integer', 'min:0', 'max:100'],
            'feedback' => ['nullable', 'string', 'max:1000'],
        ]);

        $submission->update([
            'grade' => $validated['grade'],
            'teacher_feedback' => $validated['feedback'] ?? null,
            'graded_at' => now(),
            'status' => 'graded',
        ]);

        return $this->respondWithSuccess([
            'id' => $submission->id,
            'grade' => $submission->grade,
            'teacher_feedback' => $submission->teacher_feedback,
            'graded_at' => $submission->graded_at->format('Y-m-d H:i:s'),
            'status' => $submission->status,
        ], 'Penilaian tugas berhasil disimpan.');
    }
}
