<?php

namespace Tests\Feature\Api;

use App\Models\InternshipPlacement;
use App\Models\Student;
use App\Models\User;
use Database\Seeders\DataMasterSeeder;
use Database\Seeders\InternshipSeeder;
use Database\Seeders\RoleAndPermissionSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StudentInternshipApiTest extends TestCase
{
    use RefreshDatabase;

    protected User $studentUser;

    protected Student $student;

    protected string $token;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');

        $this->seed(RoleAndPermissionSeeder::class);
        $this->seed(UserSeeder::class);
        $this->seed(DataMasterSeeder::class);
        $this->seed(InternshipSeeder::class);

        $this->student = Student::where('nis', '20261201')->first();
        $this->studentUser = $this->student->user;
        $this->token = $this->studentUser->createToken('test')->plainTextToken;
    }

    public function test_student_can_get_active_placement(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer '.$this->token)
            ->getJson('/api/v1/student/internship/placement');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'department',
                    'company' => [
                        'id',
                        'name',
                        'latitude',
                        'longitude',
                        'radius_meters',
                    ],
                    'mentor' => [
                        'id',
                        'name',
                    ],
                ],
            ]);
    }

    public function test_student_can_check_in_within_radius(): void
    {
        $placement = InternshipPlacement::where('student_id', $this->student->id)->first();
        // Clear today attendance if seeded
        $placement->attendances()->whereDate('date', now()->toDateString())->delete();

        $company = $placement->company;

        $file = UploadedFile::fake()->image('selfie.jpg', 600, 600);

        // Coordinates very close to company (within radius)
        $response = $this->withHeader('Authorization', 'Bearer '.$this->token)
            ->postJson('/api/v1/student/internship/attendance/check-in', [
                'latitude' => $company->latitude,
                'longitude' => $company->longitude,
                'photo' => $file,
                'notes' => 'Tiba tepat waktu di kantor',
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.check_in_within_radius', true)
            ->assertJsonPath('data.verification_status', 'verified');

        $this->assertDatabaseHas('internship_attendances', [
            'internship_placement_id' => $placement->id,
            'check_in_within_radius' => true,
        ]);
    }

    public function test_student_check_in_outside_radius_is_pending_verification(): void
    {
        $placement = InternshipPlacement::where('student_id', $this->student->id)->first();
        $placement->attendances()->whereDate('date', now()->toDateString())->delete();

        $file = UploadedFile::fake()->image('selfie_far.jpg', 600, 600);

        // Coordinates 5 km away from Jakarta office
        $response = $this->withHeader('Authorization', 'Bearer '.$this->token)
            ->postJson('/api/v1/student/internship/attendance/check-in', [
                'latitude' => -6.175392,
                'longitude' => 106.827153,
                'photo' => $file,
                'notes' => 'Di luar kantor karena tugas dinas luar',
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.check_in_within_radius', false)
            ->assertJsonPath('data.verification_status', 'pending');
    }

    public function test_student_can_check_out(): void
    {
        $placement = InternshipPlacement::where('student_id', $this->student->id)->first();
        $placement->attendances()->whereDate('date', now()->toDateString())->delete();

        $file = UploadedFile::fake()->image('selfie.jpg', 600, 600);

        // First check in
        $this->withHeader('Authorization', 'Bearer '.$this->token)
            ->postJson('/api/v1/student/internship/attendance/check-in', [
                'latitude' => $placement->company->latitude,
                'longitude' => $placement->company->longitude,
                'photo' => $file,
            ])->assertStatus(201);

        // Then check out
        $response = $this->withHeader('Authorization', 'Bearer '.$this->token)
            ->postJson('/api/v1/student/internship/attendance/check-out', [
                'latitude' => $placement->company->latitude,
                'longitude' => $placement->company->longitude,
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('success', true);

        $this->assertNotNull($response->json('data.check_out_time'));
    }

    public function test_student_can_submit_daily_journal(): void
    {
        $placement = InternshipPlacement::where('student_id', $this->student->id)->first();
        $placement->journals()->whereDate('date', now()->toDateString())->delete();

        $file = UploadedFile::fake()->image('journal_proof.jpg', 800, 600);

        $response = $this->withHeader('Authorization', 'Bearer '.$this->token)
            ->postJson('/api/v1/student/internship/journals', [
                'date' => now()->toDateString(),
                'title' => 'Implementasi REST API & Otentikasi Sanctum',
                'activity_description' => 'Mengerjakan pembuatan endpoint auth dan pengujian token pada aplikasi mobile.',
                'attachment' => $file,
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.title', 'Implementasi REST API & Otentikasi Sanctum')
            ->assertJsonPath('data.status', 'submitted');
    }

    public function test_student_can_submit_leave_request(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer '.$this->token)
            ->postJson('/api/v1/student/internship/leaves', [
                'type' => 'izin',
                'start_date' => now()->addDays(2)->toDateString(),
                'end_date' => now()->addDays(2)->toDateString(),
                'reason' => 'Mengikuti kegiatan lomba kompetensi kejuruan tingkat provinsi',
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.type', 'izin')
            ->assertJsonPath('data.status', 'pending');
    }

    public function test_student_can_view_tasks_and_submit_solution(): void
    {
        // 1. View tasks
        $tasksResponse = $this->withHeader('Authorization', 'Bearer '.$this->token)
            ->getJson('/api/v1/student/internship/tasks');

        $tasksResponse->assertStatus(200)
            ->assertJsonPath('success', true);

        $tasks = $tasksResponse->json('data');
        if (count($tasks) > 0) {
            $taskId = $tasks[0]['id'];

            // 2. Submit solution
            $file = UploadedFile::fake()->create('submission.pdf', 500, 'application/pdf');

            $submitResponse = $this->withHeader('Authorization', 'Bearer '.$this->token)
                ->postJson("/api/v1/student/internship/tasks/{$taskId}/submit", [
                    'submission_file' => $file,
                    'student_notes' => 'Laporan tugas telah selesai disusun sesuai arahan mentor.',
                ]);

            $submitResponse->assertStatus(201)
                ->assertJsonPath('success', true)
                ->assertJsonPath('data.status', 'submitted');
        }
    }
}
