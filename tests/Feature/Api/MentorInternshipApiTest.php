<?php

namespace Tests\Feature\Api;

use App\Enums\InternshipLeaveStatus;
use App\Enums\InternshipLeaveType;
use App\Enums\InternshipTaskSubmissionStatus;
use App\Models\InternshipAttendance;
use App\Models\InternshipCompany;
use App\Models\InternshipJournal;
use App\Models\InternshipLeaveRequest;
use App\Models\InternshipPlacement;
use App\Models\InternshipTaskSubmission;
use App\Models\Teacher;
use App\Models\User;
use Database\Seeders\DataMasterSeeder;
use Database\Seeders\InternshipSeeder;
use Database\Seeders\RoleAndPermissionSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MentorInternshipApiTest extends TestCase
{
    use RefreshDatabase;

    protected User $mentorUser;

    protected Teacher $teacher;

    protected string $token;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleAndPermissionSeeder::class);
        $this->seed(UserSeeder::class);
        $this->seed(DataMasterSeeder::class);
        $this->seed(InternshipSeeder::class);

        $this->mentorUser = User::where('email', 'pembimbing@oneschool.sch.id')->first();
        $this->teacher = $this->mentorUser->teacher;
        $this->token = $this->mentorUser->createToken('test')->plainTextToken;
    }

    public function test_mentor_can_list_mentees(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer '.$this->token)
            ->getJson('/api/v1/mentor/mentees');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'student',
                        'company',
                        'department',
                    ],
                ],
            ]);
    }

    public function test_mentor_can_verify_attendance(): void
    {
        $placement = InternshipPlacement::where('teacher_id', $this->teacher->id)->first();
        $attendance = InternshipAttendance::where('internship_placement_id', $placement->id)->first();

        $response = $this->withHeader('Authorization', 'Bearer '.$this->token)
            ->postJson("/api/v1/mentor/attendances/{$attendance->id}/verify", [
                'action' => 'verify',
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.verification_status', 'verified');
    }

    public function test_mentor_can_reject_attendance_with_reason(): void
    {
        $placement = InternshipPlacement::where('teacher_id', $this->teacher->id)->first();
        $attendance = InternshipAttendance::where('internship_placement_id', $placement->id)->first();

        $response = $this->withHeader('Authorization', 'Bearer '.$this->token)
            ->postJson("/api/v1/mentor/attendances/{$attendance->id}/verify", [
                'action' => 'reject',
                'rejection_reason' => 'Foto selfie tidak jelas dan tidak berada di kantor',
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.verification_status', 'rejected')
            ->assertJsonPath('data.rejection_reason', 'Foto selfie tidak jelas dan tidak berada di kantor');
    }

    public function test_mentor_can_review_journal(): void
    {
        $placement = InternshipPlacement::where('teacher_id', $this->teacher->id)->first();
        $journal = InternshipJournal::where('internship_placement_id', $placement->id)->first();

        // 1. Approve journal
        $response = $this->withHeader('Authorization', 'Bearer '.$this->token)
            ->postJson("/api/v1/mentor/journals/{$journal->id}/review", [
                'action' => 'approve',
                'mentor_notes' => 'Pekerjaan sangat baik dan deskriptif.',
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.status', 'approved');

        // 2. Request revision
        $revisionResponse = $this->withHeader('Authorization', 'Bearer '.$this->token)
            ->postJson("/api/v1/mentor/journals/{$journal->id}/review", [
                'action' => 'revision',
                'mentor_notes' => 'Tolong lampirkan screenshot pull request.',
            ]);

        $revisionResponse->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.status', 'revision_requested');
    }

    public function test_mentor_can_review_leave_request(): void
    {
        $placement = InternshipPlacement::where('teacher_id', $this->teacher->id)->first();
        $leave = InternshipLeaveRequest::where('internship_placement_id', $placement->id)->first();

        if (! $leave) {
            $leave = InternshipLeaveRequest::create([
                'internship_placement_id' => $placement->id,
                'type' => InternshipLeaveType::Izin,
                'start_date' => now()->toDateString(),
                'end_date' => now()->toDateString(),
                'reason' => 'Keperluan keluarga',
                'status' => InternshipLeaveStatus::Pending,
            ]);
        }

        $response = $this->withHeader('Authorization', 'Bearer '.$this->token)
            ->postJson("/api/v1/mentor/leaves/{$leave->id}/review", [
                'action' => 'approve',
                'review_notes' => 'Disetujui oleh pembimbing.',
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.status', 'approved');
    }

    public function test_mentor_can_create_task_and_grade_submission(): void
    {
        $company = InternshipCompany::first();

        // 1. Create task
        $taskResponse = $this->withHeader('Authorization', 'Bearer '.$this->token)
            ->postJson('/api/v1/mentor/tasks', [
                'internship_company_id' => $company->id,
                'title' => 'Tugas Laporan Analisis Kebutuhan Sistem',
                'description' => 'Susun dokumen SRS sederhana untuk sistem yang dikembangkan di industri.',
                'due_date' => now()->addDays(7)->toDateString(),
            ]);

        $taskResponse->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.title', 'Tugas Laporan Analisis Kebutuhan Sistem');

        $taskId = $taskResponse->json('data.id');

        // 2. Mentee submits task
        $placement = InternshipPlacement::where('teacher_id', $this->teacher->id)->first();
        $submission = InternshipTaskSubmission::create([
            'internship_task_id' => $taskId,
            'student_id' => $placement->student_id,
            'student_notes' => 'Dokumen SRS terlampir',
            'submitted_at' => now(),
            'status' => InternshipTaskSubmissionStatus::Submitted,
        ]);

        // 3. Mentor grades submission
        $gradeResponse = $this->withHeader('Authorization', 'Bearer '.$this->token)
            ->postJson("/api/v1/mentor/tasks/submissions/{$submission->id}/grade", [
                'grade' => 95,
                'mentor_feedback' => 'Analisis komprehensif, diagram use case rapi.',
            ]);

        $gradeResponse->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.grade', 95)
            ->assertJsonPath('data.status', 'graded');
    }

    public function test_mentor_can_create_task_with_datetime_deadline_via_api(): void
    {
        $company = InternshipCompany::first();
        $targetDate = now()->addDays(5)->setTime(15, 0, 0);

        $response = $this->withHeader('Authorization', 'Bearer '.$this->token)
            ->postJson('/api/v1/mentor/tasks', [
                'internship_company_id' => $company->id,
                'title' => 'Tugas Review Keamanan API',
                'description' => 'Lakukan penetration testing sederhana dan buat rangkumannya.',
                'due_date' => $targetDate->format('Y-m-d H:i:s'),
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.title', 'Tugas Review Keamanan API')
            ->assertJsonPath('data.due_date', $targetDate->format('Y-m-d H:i:s'))
            ->assertJsonPath('data.due_date_formatted', $targetDate->translatedFormat('d M Y, H:i').' WIB');

        $this->assertDatabaseHas('internship_tasks', [
            'title' => 'Tugas Review Keamanan API',
            'due_date' => $targetDate->format('Y-m-d H:i:00'),
        ]);
    }
}
