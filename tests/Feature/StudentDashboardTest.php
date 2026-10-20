<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\User;
use Database\Seeders\DataMasterSeeder;
use Database\Seeders\RoleAndPermissionSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected User $studentUser;

    protected Student $student;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleAndPermissionSeeder::class);
        $this->seed(UserSeeder::class);
        $this->seed(DataMasterSeeder::class);

        $this->studentUser = User::where('email', 'siswa@oneschool.sch.id')->first();
        $this->student = Student::first();
        $this->student->update(['user_id' => $this->studentUser->id]);
    }

    public function test_student_can_access_student_dashboard(): void
    {
        $response = $this->actingAs($this->studentUser)
            ->get(route('student.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Portal Siswa');
        $response->assertSee($this->studentUser->name);
        $response->assertSee('Tingkat Kehadiran');
    }

    public function test_student_can_view_schedules(): void
    {
        $response = $this->actingAs($this->studentUser)
            ->get(route('student.schedules.index'));

        $response->assertStatus(200);
        $response->assertSee('Jadwal Pelajaran Kelas');
    }

    public function test_student_can_view_attendances(): void
    {
        $response = $this->actingAs($this->studentUser)
            ->get(route('student.attendances.index'));

        $response->assertStatus(200);
        $response->assertSee('Riwayat Presensi Siswa');
    }

    public function test_student_can_view_internship_information(): void
    {
        $response = $this->actingAs($this->studentUser)
            ->get(route('student.internship.index'));

        $response->assertStatus(200);
        $response->assertSee('Informasi Praktik Kerja Lapangan');
    }

    public function test_non_student_cannot_access_student_dashboard(): void
    {
        $guru = User::where('email', 'guru@oneschool.sch.id')->first();

        $response = $this->actingAs($guru)
            ->get(route('student.dashboard'));

        $response->assertStatus(403);
    }
}
