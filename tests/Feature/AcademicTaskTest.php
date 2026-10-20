<?php

namespace Tests\Feature;

use App\Enums\DayOfWeek;
use App\Models\AcademicTask;
use App\Models\AcademicTaskSubmission;
use App\Models\AcademicYear;
use App\Models\Classroom;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AcademicTaskTest extends TestCase
{
    use RefreshDatabase;

    protected User $guruUser;

    protected Teacher $teacherBudi;

    protected User $walasUser;

    protected Teacher $teacherSiti;

    protected User $studentUser;

    protected Student $student;

    protected Classroom $classroom;

    protected Subject $subject;

    protected AcademicYear $academicYear;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');

        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'guru', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'wali_kelas', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'siswa', 'guard_name' => 'web']);

        $this->academicYear = AcademicYear::create([
            'name' => '2026/2027 Ganjil',
            'semester' => 'ganjil',
            'start_date' => '2026-07-15',
            'end_date' => '2026-12-20',
            'is_active' => true,
        ]);

        // Regular Guru (Pak Budi - only role 'guru', not 'wali_kelas')
        $this->guruUser = User::factory()->create([
            'name' => 'Budi Santoso, S.Pd.',
            'email' => 'guru.budi@oneschool.sch.id',
            'is_active' => true,
        ]);
        $this->guruUser->assignRole('guru');

        $this->teacherBudi = Teacher::create([
            'user_id' => $this->guruUser->id,
            'nip' => '198501102010011001',
            'nuptk' => '8439201928301928',
            'gender' => 'L',
        ]);

        // Wali Kelas (Bu Siti - roles: 'guru' and 'wali_kelas')
        $this->walasUser = User::factory()->create([
            'name' => 'Siti Rahmawati, M.Pd.',
            'email' => 'siti.walas@oneschool.sch.id',
            'is_active' => true,
        ]);
        $this->walasUser->assignRole(['guru', 'wali_kelas']);

        $this->teacherSiti = Teacher::create([
            'user_id' => $this->walasUser->id,
            'nip' => '198705152012022002',
            'nuptk' => '9482019283910293',
            'gender' => 'P',
        ]);

        // Classroom XI RPL 1 with Wali Kelas Bu Siti
        $this->classroom = Classroom::create([
            'name' => 'XI RPL 1',
            'grade_level' => 11,
            'major' => 'Rekayasa Perangkat Lunak',
            'academic_year_id' => $this->academicYear->id,
            'teacher_id' => $this->teacherSiti->id,
        ]);

        // Subject
        $this->subject = Subject::create([
            'name' => 'Pemrograman Web & Perangkat Bergerak',
            'code' => 'RPL-WEB',
        ]);

        $this->teacherBudi->subjects()->attach($this->subject->id);

        // Schedule: Pak Budi teaches in XI RPL 1
        Schedule::create([
            'academic_year_id' => $this->academicYear->id,
            'semester' => 'ganjil',
            'classroom_id' => $this->classroom->id,
            'subject_id' => $this->subject->id,
            'teacher_id' => $this->teacherBudi->id,
            'day_of_week' => DayOfWeek::Senin->value,
            'start_time' => '07:30',
            'end_time' => '09:30',
        ]);

        // Student in XI RPL 1
        $this->studentUser = User::factory()->create([
            'name' => 'Fajar Pratama',
            'email' => 'fajar@oneschool.sch.id',
            'is_active' => true,
        ]);
        $this->studentUser->assignRole('siswa');

        $this->student = Student::create([
            'user_id' => $this->studentUser->id,
            'classroom_id' => $this->classroom->id,
            'nis' => '20241001',
            'nisn' => '0071234567',
            'name' => 'Fajar Pratama',
            'gender' => 'L',
        ]);
    }

    public function test_regular_teacher_can_access_tasks_page(): void
    {
        $response = $this->actingAs($this->guruUser)->get(route('teacher.tasks.index'));

        $response->assertStatus(200);
        $response->assertSee('Tugas &amp; Penugasan Kelas', false);
        $response->assertSee('Terbitkan Tugas Baru');
    }

    public function test_regular_teacher_not_just_walas_can_create_task_with_exact_datetime_deadline(): void
    {
        $deadline = Carbon::now()->addDays(5)->setTime(21, 30, 0);

        $response = $this->actingAs($this->guruUser)->post(route('teacher.tasks.store'), [
            'classroom_id' => $this->classroom->id,
            'subject_id' => $this->subject->id,
            'title' => 'Tugas Praktik 1: Membuat Layout CSS Flexbox & Grid',
            'description' => 'Susun rancangan halaman profil sekolah yang responsif.',
            'due_date' => $deadline->format('Y-m-d\TH:i'),
        ]);

        $response->assertRedirect(route('teacher.tasks.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('academic_tasks', [
            'teacher_id' => $this->teacherBudi->id,
            'classroom_id' => $this->classroom->id,
            'subject_id' => $this->subject->id,
            'title' => 'Tugas Praktik 1: Membuat Layout CSS Flexbox & Grid',
            'due_date' => $deadline->format('Y-m-d H:i:00'),
        ]);
    }

    public function test_homeroom_teacher_walas_can_also_create_task(): void
    {
        $deadline = Carbon::now()->addDays(4)->setTime(23, 59, 0);

        $response = $this->actingAs($this->walasUser)->post(route('teacher.tasks.store'), [
            'classroom_id' => $this->classroom->id,
            'subject_id' => $this->subject->id,
            'title' => 'Refleksi Pembelajaran Karakter & Kedisiplinan',
            'description' => 'Tuliskan rangkuman rencana target studi semester ini.',
            'due_date' => $deadline->format('Y-m-d\TH:i'),
        ]);

        $response->assertRedirect(route('teacher.tasks.index'));
        $this->assertDatabaseHas('academic_tasks', [
            'teacher_id' => $this->teacherSiti->id,
            'classroom_id' => $this->classroom->id,
            'title' => 'Refleksi Pembelajaran Karakter & Kedisiplinan',
        ]);
    }

    public function test_student_can_view_assigned_tasks_for_their_class(): void
    {
        $task = AcademicTask::create([
            'teacher_id' => $this->teacherBudi->id,
            'classroom_id' => $this->classroom->id,
            'subject_id' => $this->subject->id,
            'title' => 'Tugas Struktur Data Array dan JSON',
            'description' => 'Kerjakan latihan soal pada modul halaman 40-45.',
            'due_date' => Carbon::now()->addDays(3)->setTime(23, 59, 0),
        ]);

        $response = $this->actingAs($this->studentUser)->get(route('student.tasks.index'));

        $response->assertStatus(200);
        $response->assertSee('Tugas Struktur Data Array dan JSON');
        $response->assertSee('Deadline:');
    }

    public function test_student_can_submit_solution_file_and_notes(): void
    {
        $task = AcademicTask::create([
            'teacher_id' => $this->teacherBudi->id,
            'classroom_id' => $this->classroom->id,
            'subject_id' => $this->subject->id,
            'title' => 'Tugas Desain Basis Data Normalisasi 3NF',
            'description' => 'Kumpulkan file ERD dan skema database relasional.',
            'due_date' => Carbon::now()->addDays(2)->setTime(23, 59, 0),
        ]);

        $fakeFile = UploadedFile::fake()->create('jawaban_fajar.pdf', 300, 'application/pdf');

        $response = $this->actingAs($this->studentUser)->post(route('student.tasks.submit', $task->id), [
            'submission_file' => $fakeFile,
            'student_notes' => 'Tugas telah selesai dikerjakan, ERD sudah dalam bentuk 3NF.',
        ]);

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('academic_task_submissions', [
            'academic_task_id' => $task->id,
            'student_id' => $this->student->id,
            'student_notes' => 'Tugas telah selesai dikerjakan, ERD sudah dalam bentuk 3NF.',
            'status' => 'submitted',
        ]);
    }

    public function test_submission_after_deadline_is_marked_as_late(): void
    {
        $pastTask = AcademicTask::create([
            'teacher_id' => $this->teacherBudi->id,
            'classroom_id' => $this->classroom->id,
            'subject_id' => $this->subject->id,
            'title' => 'Tugas Tenggat Kemarin',
            'description' => 'Tugas yang telah lewat batas pengumpulan.',
            'due_date' => Carbon::yesterday()->setTime(23, 59, 0),
        ]);

        $fakeFile = UploadedFile::fake()->create('jawaban_terlambat.pdf', 200, 'application/pdf');

        $response = $this->actingAs($this->studentUser)->post(route('student.tasks.submit', $pastTask->id), [
            'submission_file' => $fakeFile,
            'student_notes' => 'Mohon maaf terlambat karena kendala jaringan internet.',
        ]);

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('academic_task_submissions', [
            'academic_task_id' => $pastTask->id,
            'student_id' => $this->student->id,
            'status' => 'late',
        ]);
    }

    public function test_teacher_can_grade_student_submission(): void
    {
        $task = AcademicTask::create([
            'teacher_id' => $this->teacherBudi->id,
            'classroom_id' => $this->classroom->id,
            'subject_id' => $this->subject->id,
            'title' => 'Tugas Logika Pemrograman',
            'description' => 'Uji algoritma pencarian biner.',
            'due_date' => Carbon::now()->addDays(1)->setTime(23, 59, 0),
        ]);

        $submission = AcademicTaskSubmission::create([
            'academic_task_id' => $task->id,
            'student_id' => $this->student->id,
            'submitted_at' => Carbon::now(),
            'status' => 'submitted',
        ]);

        $response = $this->actingAs($this->guruUser)->post(route('teacher.tasks.submissions.grade', $submission->id), [
            'grade' => 92,
            'feedback' => 'Logika pencarian biner sangat tepat dan efisien.',
        ]);

        $response->assertSessionHas('success');

        $submission->refresh();
        $this->assertEquals(92, $submission->grade);
        $this->assertEquals('Logika pencarian biner sangat tepat dan efisien.', $submission->teacher_feedback);
        $this->assertEquals('graded', $submission->status);
    }

    public function test_teacher_can_create_task_with_photo_attachment_optional(): void
    {
        $deadline = Carbon::now()->addDays(3)->setTime(23, 59, 0);
        $photoFile = UploadedFile::fake()->image('soal_tugas_papan_tulis.jpg', 800, 600);

        $response = $this->actingAs($this->guruUser)->post(route('teacher.tasks.store'), [
            'classroom_id' => $this->classroom->id,
            'subject_id' => $this->subject->id,
            'title' => 'Tugas dengan Foto Papan Tulis',
            'description' => 'Kerjakan soal nomor 1-5 yang tertera di foto papan tulis berikut.',
            'due_date' => $deadline->format('Y-m-d\TH:i'),
            'attachment' => $photoFile,
        ]);

        $response->assertRedirect(route('teacher.tasks.index'));
        $task = AcademicTask::where('title', 'Tugas dengan Foto Papan Tulis')->first();
        $this->assertNotNull($task);
        $this->assertNotNull($task->attachment_path);
        $this->assertTrue($task->isAttachmentImage());
        Storage::disk('public')->assertExists($task->attachment_path);
    }

    public function test_teacher_can_create_task_with_auto_generated_title_when_blank(): void
    {
        $deadline = Carbon::now()->addDays(2)->setTime(17, 0, 0);

        $response = $this->actingAs($this->guruUser)->post(route('teacher.tasks.store'), [
            'classroom_id' => $this->classroom->id,
            'subject_id' => $this->subject->id,
            'title' => '', // blank title
            'description' => 'Kerjakan ringkasan bab 3 pada buku catatan masing-masing.',
            'due_date' => $deadline->format('Y-m-d\TH:i'),
        ]);

        $response->assertRedirect(route('teacher.tasks.index'));
        $task = AcademicTask::latest('id')->first();
        $this->assertNotNull($task);
        $this->assertStringContainsString('Tugas Pemrograman Web & Perangkat Bergerak', $task->title);
    }

    public function test_teacher_can_update_task_details_and_photo(): void
    {
        $task = AcademicTask::create([
            'teacher_id' => $this->teacherBudi->id,
            'classroom_id' => $this->classroom->id,
            'subject_id' => $this->subject->id,
            'title' => 'Tugas Awal',
            'description' => 'Deskripsi lama',
            'due_date' => Carbon::now()->addDays(2),
        ]);

        $newDeadline = Carbon::now()->addDays(5)->setTime(20, 0, 0);
        $newPhoto = UploadedFile::fake()->image('soal_revisi.png', 600, 400);

        $response = $this->actingAs($this->guruUser)->put(route('teacher.tasks.update', $task->id), [
            'classroom_id' => $this->classroom->id,
            'subject_id' => $this->subject->id,
            'title' => 'Tugas Revisi',
            'description' => 'Deskripsi yang sudah diperbarui dengan instruksi lebih lengkap.',
            'due_date' => $newDeadline->format('Y-m-d H:i:s'),
            'attachment' => $newPhoto,
        ]);

        $response->assertRedirect();
        $task->refresh();
        $this->assertEquals('Tugas Revisi', $task->title);
        $this->assertEquals('Deskripsi yang sudah diperbarui dengan instruksi lebih lengkap.', $task->description);
        $this->assertTrue($task->isAttachmentImage());
        Storage::disk('public')->assertExists($task->attachment_path);
    }

    public function test_student_can_submit_photo_as_task_solution(): void
    {
        $task = AcademicTask::create([
            'teacher_id' => $this->teacherBudi->id,
            'classroom_id' => $this->classroom->id,
            'subject_id' => $this->subject->id,
            'title' => 'Tugas Foto Catatan',
            'description' => 'Foto catatan buku kalian lalu kumpulkan di sini.',
            'due_date' => Carbon::now()->addDays(2),
        ]);

        $photoSubmission = UploadedFile::fake()->image('foto_jawaban_catatan.jpg', 1200, 900);

        $response = $this->actingAs($this->studentUser)->post(route('student.tasks.submit', $task->id), [
            'submission_file' => $photoSubmission,
            'student_notes' => 'Berikut foto catatan bab 2 saya pak.',
        ]);

        $response->assertRedirect();
        $submission = AcademicTaskSubmission::where('academic_task_id', $task->id)
            ->where('student_id', $this->student->id)
            ->first();

        $this->assertNotNull($submission);
        $this->assertTrue($submission->isSubmissionImage());
        Storage::disk('public')->assertExists($submission->submission_file_path);
    }

    public function test_teacher_mobile_api_can_create_task_and_list_tasks(): void
    {
        $deadline = Carbon::now()->addDays(3)->setTime(18, 0, 0);

        $response = $this->actingAs($this->guruUser, 'sanctum')->postJson('/api/v1/teacher/tasks', [
            'classroom_id' => $this->classroom->id,
            'subject_id' => $this->subject->id,
            'title' => 'Tugas API Endpoint Guru',
            'description' => 'Uji endpoint REST API via mobile client.',
            'due_date' => $deadline->format('Y-m-d H:i:s'),
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.title', 'Tugas API Endpoint Guru')
            ->assertJsonPath('data.due_date', $deadline->format('Y-m-d H:i:s'));

        // List tasks via API
        $listResponse = $this->actingAs($this->guruUser, 'sanctum')->getJson('/api/v1/teacher/tasks');
        $listResponse->assertStatus(200)
            ->assertJsonPath('success', true);
    }
}
