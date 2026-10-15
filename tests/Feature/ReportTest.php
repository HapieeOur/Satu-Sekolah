<?php

namespace Tests\Feature;

use App\Enums\AttendanceStatus;
use App\Enums\InternshipAttendanceStatus;
use App\Enums\InternshipPlacementStatus;
use App\Enums\Semester;
use App\Models\AcademicYear;
use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\InternshipAttendance;
use App\Models\InternshipCompany;
use App\Models\InternshipPlacement;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;

    protected User $guruUser;

    protected Classroom $classroom;

    protected Student $student;

    protected Teacher $teacher;

    protected AcademicYear $academicYear;

    protected InternshipCompany $company;

    protected InternshipPlacement $placement;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleAndPermissionSeeder::class);

        $this->adminUser = User::factory()->create(['is_active' => true]);
        $this->adminUser->assignRole('admin');

        $this->guruUser = User::factory()->create(['is_active' => true]);
        $this->guruUser->assignRole('guru');

        $this->teacher = Teacher::create([
            'user_id' => $this->guruUser->id,
            'nip' => '198701012015011002',
            'gender' => 'L',
        ]);

        $this->academicYear = AcademicYear::create([
            'name' => '2026/2027',
            'semester' => Semester::GANJIL,
            'is_active' => true,
        ]);

        $this->classroom = Classroom::create([
            'academic_year_id' => $this->academicYear->id,
            'teacher_id' => $this->teacher->id,
            'name' => 'XII TKJ 1',
            'grade_level' => 'XII',
            'major' => 'Teknik Komputer dan Jaringan',
        ]);

        $this->student = Student::create([
            'classroom_id' => $this->classroom->id,
            'nis' => '10482',
            'nisn' => '0081234567',
            'name' => 'Ahmad Dahlan',
            'gender' => 'L',
        ]);

        $this->company = InternshipCompany::create([
            'name' => 'PT Telekomunikasi Solusindo',
            'address' => 'Jl. Pemuda No. 45',
            'contact_person' => 'Bambang',
            'phone' => '08129876543',
            'latitude' => -6.200000,
            'longitude' => 106.816666,
            'radius_meters' => 150,
        ]);

        $this->placement = InternshipPlacement::create([
            'student_id' => $this->student->id,
            'internship_company_id' => $this->company->id,
            'teacher_id' => $this->teacher->id,
            'academic_year_id' => $this->academicYear->id,
            'start_date' => now()->subMonth()->toDateString(),
            'end_date' => now()->addMonths(2)->toDateString(),
            'status' => InternshipPlacementStatus::Active,
        ]);
    }

    public function test_admin_can_access_academic_report_page(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('admin.reports.academic'));

        $response->assertStatus(200);
        $response->assertSee('Rekapitulasi Kehadiran Akademik');
        $response->assertSee('XII TKJ 1');
    }

    public function test_admin_can_generate_academic_report_for_selected_classroom(): void
    {
        // Seed attendance
        Attendance::create([
            'student_id' => $this->student->id,
            'classroom_id' => $this->classroom->id,
            'date' => now()->toDateString(),
            'status' => AttendanceStatus::Hadir,
            'check_in_time' => '07:15:00',
        ]);

        $response = $this->actingAs($this->adminUser)->get(route('admin.reports.academic', [
            'classroom_id' => $this->classroom->id,
            'start_date' => now()->startOfMonth()->toDateString(),
            'end_date' => now()->toDateString(),
        ]));

        $response->assertStatus(200);
        $response->assertSee('Rincian Presensi Siswa Kelas XII TKJ 1');
        $response->assertSee('Ahmad Dahlan');
        $response->assertSee('10482');
        $response->assertSee('100%');
    }

    public function test_admin_can_access_internship_report_page_and_filter_data(): void
    {
        InternshipAttendance::create([
            'internship_placement_id' => $this->placement->id,
            'date' => now()->toDateString(),
            'check_in_time' => '07:50:00',
            'check_in_latitude' => -6.200010,
            'check_in_longitude' => 106.816670,
            'distance_meters' => 10,
            'is_within_radius' => true,
            'status' => InternshipAttendanceStatus::Hadir,
        ]);

        $response = $this->actingAs($this->adminUser)->get(route('admin.reports.internship', [
            'company_id' => $this->company->id,
        ]));

        $response->assertStatus(200);
        $response->assertSee('Rekapitulasi Monitoring Praktik Kerja Lapangan');
        $response->assertSee('PT Telekomunikasi Solusindo');
        $response->assertSee('Ahmad Dahlan');
    }

    public function test_non_admin_cannot_access_admin_reports(): void
    {
        $this->actingAs($this->guruUser)
            ->get(route('admin.reports.academic'))
            ->assertStatus(403);

        $this->actingAs($this->guruUser)
            ->get(route('admin.reports.internship'))
            ->assertStatus(403);
    }
}
