<?php

namespace Tests\Feature\Api;

use App\Enums\AttendanceStatus;
use App\Enums\InternshipAttendanceStatus;
use App\Models\AcademicYear;
use App\Models\Classroom;
use App\Models\InternshipCompany;
use App\Models\InternshipPlacement;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\DataMasterSeeder;
use Database\Seeders\RoleAndPermissionSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AttendanceTimeRuleTest extends TestCase
{
    use RefreshDatabase;

    protected User $studentUser;

    protected Student $student;

    protected string $token;

    protected InternshipPlacement $placement;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleAndPermissionSeeder::class);
        $this->seed(UserSeeder::class);
        $this->seed(DataMasterSeeder::class);

        $this->studentUser = User::where('email', 'siswa@oneschool.sch.id')->first();
        $this->token = $this->studentUser->createToken('test_token')->plainTextToken;

        $classroom = Classroom::first();
        $this->student = Student::first();
        $this->student->update([
            'user_id' => $this->studentUser->id,
            'classroom_id' => $classroom->id,
        ]);

        $company = InternshipCompany::first();
        $teacher = Teacher::first();
        $academicYear = AcademicYear::where('is_active', true)->first();

        $this->placement = InternshipPlacement::create([
            'student_id' => $this->student->id,
            'internship_company_id' => $company->id,
            'teacher_id' => $teacher->id,
            'academic_year_id' => $academicYear->id,
            'start_date' => now()->subMonth()->toDateString(),
            'end_date' => now()->addMonths(2)->toDateString(),
            'status' => 'active',
        ]);
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();
        parent::tearDown();
    }

    public function test_application_timezone_is_asia_jakarta(): void
    {
        $this->assertEquals('Asia/Jakarta', config('app.timezone'));
    }

    public function test_regular_student_check_in_on_or_before_8_am_is_hadir(): void
    {
        // 07:45 WIB
        Carbon::setTestNow(Carbon::parse('2026-10-20 07:45:00', 'Asia/Jakarta'));

        $response = $this->withHeader('Authorization', 'Bearer '.$this->token)
            ->postJson('/api/v1/student/attendances/check-in', [
                'status' => 'hadir',
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.status', AttendanceStatus::Hadir->value);

        $this->assertDatabaseHas('attendances', [
            'student_id' => $this->student->id,
            'status' => AttendanceStatus::Hadir->value,
            'check_in_time' => '07:45:00',
        ]);
    }

    public function test_regular_student_check_in_after_8_am_is_automatically_marked_terlambat(): void
    {
        // 08:15 WIB
        Carbon::setTestNow(Carbon::parse('2026-10-20 08:15:00', 'Asia/Jakarta'));

        $response = $this->withHeader('Authorization', 'Bearer '.$this->token)
            ->postJson('/api/v1/student/attendances/check-in', [
                'status' => 'hadir',
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.status', AttendanceStatus::Terlambat->value);

        $this->assertDatabaseHas('attendances', [
            'student_id' => $this->student->id,
            'status' => AttendanceStatus::Terlambat->value,
            'check_in_time' => '08:15:00',
        ]);
    }

    public function test_regular_student_cannot_check_in_after_5_pm(): void
    {
        // 17:30 WIB
        Carbon::setTestNow(Carbon::parse('2026-10-20 17:30:00', 'Asia/Jakarta'));

        $response = $this->withHeader('Authorization', 'Bearer '.$this->token)
            ->postJson('/api/v1/student/attendances/check-in', [
                'status' => 'hadir',
            ]);

        $response->assertStatus(422)
            ->assertJsonPath('success', false);
    }

    public function test_regular_student_can_check_out_before_or_at_5_pm(): void
    {
        // Check in at 07:50
        Carbon::setTestNow(Carbon::parse('2026-10-20 07:50:00', 'Asia/Jakarta'));
        $this->withHeader('Authorization', 'Bearer '.$this->token)
            ->postJson('/api/v1/student/attendances/check-in', ['status' => 'hadir'])
            ->assertStatus(201);

        // Check out at 16:30 (before 17:00)
        Carbon::setTestNow(Carbon::parse('2026-10-20 16:30:00', 'Asia/Jakarta'));
        $response = $this->withHeader('Authorization', 'Bearer '.$this->token)
            ->postJson('/api/v1/student/attendances/check-out');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.check_out_time', '16:30:00');

        $this->assertDatabaseHas('attendances', [
            'student_id' => $this->student->id,
            'check_out_time' => '16:30:00',
        ]);
    }

    public function test_regular_student_cannot_check_out_after_5_pm(): void
    {
        // Check in at 07:50
        Carbon::setTestNow(Carbon::parse('2026-10-20 07:50:00', 'Asia/Jakarta'));
        $this->withHeader('Authorization', 'Bearer '.$this->token)
            ->postJson('/api/v1/student/attendances/check-in', ['status' => 'hadir'])
            ->assertStatus(201);

        // Attempt Check out at 17:10 (past 17:00)
        Carbon::setTestNow(Carbon::parse('2026-10-20 17:10:00', 'Asia/Jakarta'));
        $response = $this->withHeader('Authorization', 'Bearer '.$this->token)
            ->postJson('/api/v1/student/attendances/check-out');

        $response->assertStatus(422)
            ->assertJsonPath('success', false);
    }

    public function test_internship_check_in_on_or_before_8_am_is_hadir(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-10-20 07:55:00', 'Asia/Jakarta'));
        $file = UploadedFile::fake()->image('selfie.jpg', 400, 400);

        $response = $this->withHeader('Authorization', 'Bearer '.$this->token)
            ->postJson('/api/v1/student/internship/attendance/check-in', [
                'latitude' => $this->placement->company->latitude,
                'longitude' => $this->placement->company->longitude,
                'photo' => $file,
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.status', InternshipAttendanceStatus::Hadir->value);

        $this->assertDatabaseHas('internship_attendances', [
            'internship_placement_id' => $this->placement->id,
            'status' => InternshipAttendanceStatus::Hadir->value,
            'check_in_time' => '07:55:00',
        ]);
    }

    public function test_internship_check_in_after_8_am_is_terlambat(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-10-20 08:20:00', 'Asia/Jakarta'));
        $file = UploadedFile::fake()->image('selfie.jpg', 400, 400);

        $response = $this->withHeader('Authorization', 'Bearer '.$this->token)
            ->postJson('/api/v1/student/internship/attendance/check-in', [
                'latitude' => $this->placement->company->latitude,
                'longitude' => $this->placement->company->longitude,
                'photo' => $file,
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.status', InternshipAttendanceStatus::Terlambat->value);

        $this->assertDatabaseHas('internship_attendances', [
            'internship_placement_id' => $this->placement->id,
            'status' => InternshipAttendanceStatus::Terlambat->value,
            'check_in_time' => '08:20:00',
        ]);
    }

    public function test_internship_cannot_check_out_after_5_pm(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-10-20 07:50:00', 'Asia/Jakarta'));
        $file = UploadedFile::fake()->image('selfie.jpg', 400, 400);

        $this->withHeader('Authorization', 'Bearer '.$this->token)
            ->postJson('/api/v1/student/internship/attendance/check-in', [
                'latitude' => $this->placement->company->latitude,
                'longitude' => $this->placement->company->longitude,
                'photo' => $file,
            ])->assertStatus(201);

        // Check out attempted at 17:05 (past 17:00)
        Carbon::setTestNow(Carbon::parse('2026-10-20 17:05:00', 'Asia/Jakarta'));
        $response = $this->withHeader('Authorization', 'Bearer '.$this->token)
            ->postJson('/api/v1/student/internship/attendance/check-out', [
                'latitude' => $this->placement->company->latitude,
                'longitude' => $this->placement->company->longitude,
            ]);

        $response->assertStatus(422)
            ->assertJsonPath('success', false);
    }
}
