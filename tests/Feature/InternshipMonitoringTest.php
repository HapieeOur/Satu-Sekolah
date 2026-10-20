<?php

namespace Tests\Feature;

use App\Enums\InternshipAttendanceStatus;
use App\Enums\InternshipJournalStatus;
use App\Enums\InternshipLeaveStatus;
use App\Enums\InternshipPlacementStatus;
use App\Enums\InternshipVerificationStatus;
use App\Models\AcademicYear;
use App\Models\InternshipAttendance;
use App\Models\InternshipCompany;
use App\Models\InternshipJournal;
use App\Models\InternshipLeaveRequest;
use App\Models\InternshipPlacement;
use App\Models\InternshipTask;
use App\Models\InternshipTaskSubmission;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\AttendanceSeeder;
use Database\Seeders\DataMasterSeeder;
use Database\Seeders\InternshipSeeder;
use Database\Seeders\RoleAndPermissionSeeder;
use Database\Seeders\ScheduleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InternshipMonitoringTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected User $pembimbingUser;

    protected User $guruBiasaUser;

    protected Teacher $teacherFauzi;

    protected Teacher $teacherBudi;

    protected Student $studentFajar;

    protected Student $studentGita;

    protected Student $studentAditya;

    protected InternshipCompany $companyCyber;

    protected AcademicYear $academicYear;

    protected InternshipPlacement $placementFajar;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleAndPermissionSeeder::class);
        $this->seed(UserSeeder::class);
        $this->seed(DataMasterSeeder::class);
        $this->seed(ScheduleSeeder::class);
        $this->seed(AttendanceSeeder::class);
        $this->seed(InternshipSeeder::class);

        $this->admin = User::where('email', 'admin@oneschool.sch.id')->first();
        $this->pembimbingUser = User::where('email', 'pembimbing@oneschool.sch.id')->first();
        $this->guruBiasaUser = User::where('email', 'guru@oneschool.sch.id')->first();

        $this->teacherFauzi = Teacher::where('user_id', $this->pembimbingUser->id)->first();
        $this->teacherBudi = Teacher::where('user_id', $this->guruBiasaUser->id)->first();

        $this->studentFajar = Student::where('nis', '20261201')->first();
        $this->studentGita = Student::where('nis', '20261202')->first();
        $this->studentAditya = Student::where('nis', '20261101')->first();

        $this->companyCyber = InternshipCompany::where('name', 'PT Inovasi Teknologi Nusantara')->first();
        $this->academicYear = AcademicYear::where('is_active', true)->first();

        $this->placementFajar = InternshipPlacement::where('student_id', $this->studentFajar->id)->first();
    }

    public function test_admin_can_view_placements_index(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.internships.placements.index'));

        $response->assertStatus(200);
        $response->assertSee('Penempatan Siswa PKL');
        $response->assertSee('Fajar Hidayat');
        $response->assertSee('PT Inovasi Teknologi Nusantara');
    }

    public function test_admin_can_create_new_placement(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.internships.placements.store'), [
            'student_id' => $this->studentAditya->id,
            'internship_company_id' => $this->companyCyber->id,
            'teacher_id' => $this->teacherFauzi->id,
            'academic_year_id' => $this->academicYear->id,
            'start_date' => Carbon::now()->toDateString(),
            'end_date' => Carbon::now()->addMonths(3)->toDateString(),
            'department' => 'Network & Security',
            'status' => InternshipPlacementStatus::Active->value,
            'notes' => 'Testing placement creation',
        ]);

        $response->assertRedirect(route('admin.internships.placements.index'));
        $this->assertDatabaseHas('internship_placements', [
            'student_id' => $this->studentAditya->id,
            'department' => 'Network & Security',
        ]);
    }

    public function test_admin_cannot_duplicate_student_placement_in_same_academic_year(): void
    {
        // Fajar already has placement in active academic year
        $response = $this->actingAs($this->admin)->post(route('admin.internships.placements.store'), [
            'student_id' => $this->studentFajar->id,
            'internship_company_id' => $this->companyCyber->id,
            'teacher_id' => $this->teacherFauzi->id,
            'academic_year_id' => $this->academicYear->id,
            'start_date' => Carbon::now()->toDateString(),
            'end_date' => Carbon::now()->addMonths(3)->toDateString(),
            'status' => InternshipPlacementStatus::Active->value,
        ]);

        $response->assertSessionHasErrors(['student_id']);
    }

    public function test_admin_can_manually_correct_attendance_with_audit_trail(): void
    {
        $attendance = InternshipAttendance::where('internship_placement_id', $this->placementFajar->id)->first();
        $this->assertNotNull($attendance);

        $response = $this->actingAs($this->admin)->post(route('admin.internships.attendances.correct', $attendance->id), [
            'status' => InternshipAttendanceStatus::Hadir->value,
            'check_in_time' => '07:30',
            'check_out_time' => '16:00',
            'correction_reason' => 'Siswa hadir tepat waktu, verifikasi langsung dengan HRD mitra karena gangguan jaringan seluler.',
            'notes' => 'Koreksi terverifikasi oleh Admin',
        ]);

        $response->assertSessionHas('success');

        $attendance->refresh();
        $this->assertTrue($attendance->is_manual_correction);
        $this->assertEquals($this->admin->id, $attendance->corrected_by);
        $this->assertEquals(InternshipVerificationStatus::Corrected, $attendance->verification_status);
        $this->assertStringContainsString('gangguan jaringan', $attendance->correction_reason);
    }

    public function test_mentor_can_access_dashboard_with_real_metrics(): void
    {
        $response = $this->actingAs($this->pembimbingUser)->get(route('internship-mentor.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Portal Pembimbing PKL');
        $response->assertSee('Siswa Bimbingan Aktif');
        $response->assertSee('Jurnal Menunggu Review');
    }

    public function test_mentor_can_view_assigned_mentees_list(): void
    {
        $response = $this->actingAs($this->pembimbingUser)->get(route('internship-mentor.students.index'));

        $response->assertStatus(200);
        $response->assertSee('Siswa Bimbingan PKL');
        $response->assertSee('Fajar Hidayat');
    }

    public function test_mentor_cannot_inspect_placement_of_another_mentor_idor_prevention(): void
    {
        // Create placement under teacherBudi
        $otherPlacement = InternshipPlacement::create([
            'student_id' => $this->studentAditya->id,
            'internship_company_id' => $this->companyCyber->id,
            'teacher_id' => $this->teacherBudi->id,
            'academic_year_id' => $this->academicYear->id,
            'start_date' => Carbon::now()->toDateString(),
            'end_date' => Carbon::now()->addMonths(3)->toDateString(),
            'status' => InternshipPlacementStatus::Active,
        ]);

        // Pembimbing (Pak Fauzi) attempts to inspect student assigned to Pak Budi
        $response = $this->actingAs($this->pembimbingUser)->get(route('internship-mentor.students.show', $otherPlacement->id));

        $response->assertStatus(403);
    }

    public function test_mentor_can_verify_mentee_attendance(): void
    {
        $pendingAttendance = InternshipAttendance::where('verification_status', InternshipVerificationStatus::Pending)->first();
        $this->assertNotNull($pendingAttendance);

        $response = $this->actingAs($this->pembimbingUser)->post(route('internship-mentor.attendances.verify', $pendingAttendance->id), [
            'status' => 'verified',
        ]);

        $response->assertSessionHas('success');
        $pendingAttendance->refresh();
        $this->assertEquals(InternshipVerificationStatus::Verified, $pendingAttendance->verification_status);
    }

    public function test_mentor_can_approve_mentee_journal(): void
    {
        $submittedJournal = InternshipJournal::where('status', InternshipJournalStatus::Submitted)->first();
        $this->assertNotNull($submittedJournal);

        $response = $this->actingAs($this->pembimbingUser)->post(route('internship-mentor.journals.review', $submittedJournal->id), [
            'status' => 'approved',
            'mentor_notes' => 'Aktivitas sangat memuaskan dan relevan dengan kompetensi keahlian.',
        ]);

        $response->assertSessionHas('success');
        $submittedJournal->refresh();
        $this->assertEquals(InternshipJournalStatus::Approved, $submittedJournal->status);
        $this->assertEquals($this->pembimbingUser->id, $submittedJournal->reviewed_by);
    }

    public function test_mentor_can_request_revision_for_journal(): void
    {
        $submittedJournal = InternshipJournal::where('status', InternshipJournalStatus::Submitted)->first();
        $this->assertNotNull($submittedJournal);

        $response = $this->actingAs($this->pembimbingUser)->post(route('internship-mentor.journals.review', $submittedJournal->id), [
            'status' => 'revision_requested',
            'mentor_notes' => 'Lengkapi dengan dokumentasi screenshot implementasi endpoint.',
        ]);

        $response->assertSessionHas('success');
        $submittedJournal->refresh();
        $this->assertEquals(InternshipJournalStatus::RevisionRequested, $submittedJournal->status);
    }

    public function test_mentor_can_approve_leave_request_and_system_creates_attendance_record(): void
    {
        $leave = InternshipLeaveRequest::where('status', InternshipLeaveStatus::Pending)->first();
        $this->assertNotNull($leave);

        $response = $this->actingAs($this->pembimbingUser)->post(route('internship-mentor.leaves.review', $leave->id), [
            'status' => 'approved',
            'review_notes' => 'Izin disetujui, surat tugas lomba resmi terlampir.',
        ]);

        $response->assertSessionHas('success');
        $leave->refresh();
        $this->assertEquals(InternshipLeaveStatus::Approved, $leave->status);

        // Verify attendance record generated for that date
        $generatedAttendance = InternshipAttendance::where('internship_placement_id', $leave->internship_placement_id)
            ->whereDate('date', $leave->start_date)
            ->first();

        $this->assertNotNull($generatedAttendance);
        $this->assertEquals($leave->type->value, $generatedAttendance->status->value);
        $this->assertEquals(InternshipVerificationStatus::Verified, $generatedAttendance->verification_status);
    }

    public function test_mentor_can_create_task_and_grade_submission(): void
    {
        $task = InternshipTask::create([
            'teacher_id' => $this->teacherFauzi->id,
            'title' => 'Eksplorasi Framework Vue.js 3',
            'description' => 'Pelajari komponen reactivity dan buat aplikasi todo list.',
            'due_date' => Carbon::now()->addDays(7)->toDateString(),
        ]);

        $submission = InternshipTaskSubmission::create([
            'internship_task_id' => $task->id,
            'student_id' => $this->studentFajar->id,
            'submitted_at' => Carbon::now(),
            'status' => 'submitted',
        ]);

        $response = $this->actingAs($this->pembimbingUser)->post(route('internship-mentor.tasks.submissions.grade', $submission->id), [
            'grade' => 95,
            'feedback' => 'Hasil implementasi reactive store sangat rapi dan optimal.',
        ]);

        $response->assertSessionHas('success');
        $submission->refresh();
        $this->assertEquals(95, $submission->grade);
        $this->assertEquals($this->pembimbingUser->id, $submission->graded_by);
    }

    public function test_mentor_can_store_task_with_exact_datetime_deadline(): void
    {
        $deadline = Carbon::now()->addDays(3)->setTime(16, 30, 0);

        $response = $this->actingAs($this->pembimbingUser)->post(route('internship-mentor.tasks.store'), [
            'title' => 'Tugas Analisis Endpoint REST API',
            'description' => 'Susun dokumentasi OpenAPI dan uji endpoint menggunakan Postman.',
            'due_date' => $deadline->format('Y-m-d\TH:i'),
            'internship_company_id' => $this->companyCyber->id,
        ]);

        $response->assertRedirect(route('internship-mentor.tasks.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('internship_tasks', [
            'teacher_id' => $this->teacherFauzi->id,
            'title' => 'Tugas Analisis Endpoint REST API',
            'due_date' => $deadline->format('Y-m-d H:i:00'),
        ]);
    }

    public function test_unauthorized_user_cannot_access_mentor_portal(): void
    {
        // Guru biasa (without role guru_pembimbing_pkl) is blocked with 403
        $response = $this->actingAs($this->guruBiasaUser)->get(route('internship-mentor.dashboard'));

        $response->assertStatus(403);
    }
}
