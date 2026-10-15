<?php

namespace Tests\Feature;

use App\Enums\DayOfWeek;
use App\Enums\InternshipAttendanceStatus;
use App\Enums\InternshipPlacementStatus;
use App\Enums\InternshipVerificationStatus;
use App\Enums\Semester;
use App\Models\AcademicYear;
use App\Models\Classroom;
use App\Models\InternshipAttendance;
use App\Models\InternshipCompany;
use App\Models\InternshipPlacement;
use App\Models\Post;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;

    protected User $guruUser;

    protected Teacher $teacher;

    protected AcademicYear $academicYear;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleAndPermissionSeeder::class);

        $this->adminUser = User::factory()->create(['is_active' => true]);
        $this->adminUser->assignRole('admin');

        $this->guruUser = User::factory()->create(['name' => 'Budi Santoso, M.Pd.', 'is_active' => true]);
        $this->guruUser->assignRole('guru');

        $this->teacher = Teacher::create([
            'user_id' => $this->guruUser->id,
            'nip' => '198501012010011001',
            'nuptk' => '1234567890123456',
            'gender' => 'L',
        ]);

        $this->academicYear = AcademicYear::create([
            'name' => '2026/2027',
            'semester' => Semester::GANJIL,
            'is_active' => true,
        ]);
    }

    public function test_admin_dashboard_displays_real_operational_metrics(): void
    {
        // Setup students, classrooms, company, placements, attendance
        $classroom = Classroom::create([
            'academic_year_id' => $this->academicYear->id,
            'teacher_id' => $this->teacher->id,
            'name' => 'XII RPL 1',
            'grade_level' => 'XII',
            'major' => 'Rekayasa Perangkat Lunak',
        ]);

        $student = Student::create([
            'classroom_id' => $classroom->id,
            'nis' => '10291',
            'nisn' => '0098765432',
            'name' => 'Muhammad Rizki',
            'gender' => 'L',
        ]);

        $company = InternshipCompany::create([
            'name' => 'PT Cloud Inovasi Digital',
            'address' => 'Jl. Merdeka No. 10',
            'contact_person' => 'Dewi',
            'phone' => '08123456789',
            'latitude' => -6.200000,
            'longitude' => 106.816666,
            'radius_meters' => 100,
        ]);

        $placement = InternshipPlacement::create([
            'student_id' => $student->id,
            'internship_company_id' => $company->id,
            'teacher_id' => $this->teacher->id,
            'academic_year_id' => $this->academicYear->id,
            'start_date' => now()->subMonth()->toDateString(),
            'end_date' => now()->addMonths(2)->toDateString(),
            'status' => InternshipPlacementStatus::Active,
        ]);

        InternshipAttendance::create([
            'internship_placement_id' => $placement->id,
            'date' => now()->toDateString(),
            'check_in_time' => '07:45:00',
            'check_in_latitude' => -6.200010,
            'check_in_longitude' => 106.816670,
            'distance_meters' => 15,
            'is_within_radius' => true,
            'status' => InternshipAttendanceStatus::Hadir,
            'verification_status' => InternshipVerificationStatus::Verified,
        ]);

        $response = $this->actingAs($this->adminUser)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Dashboard Administrasi');
        $response->assertSee('Total Siswa');
        $response->assertSee('PT Cloud Inovasi Digital');
        $response->assertSee('Muhammad Rizki');
        $response->assertSee('Penempatan PKL Aktif');
    }

    public function test_teacher_dashboard_displays_assigned_subjects_schedules_and_announcements(): void
    {
        $subject = Subject::create([
            'code' => 'RPL01',
            'name' => 'Pemrograman Web dan Perangkat Bergerak',
        ]);
        $this->teacher->subjects()->attach($subject->id);

        $classroom = Classroom::create([
            'academic_year_id' => $this->academicYear->id,
            'name' => 'XI RPL 2',
            'grade_level' => 'XI',
            'major' => 'Rekayasa Perangkat Lunak',
        ]);

        $room = Room::create([
            'name' => 'Lab Komputer 1',
            'code' => 'LAB-01',
        ]);

        // Map current day
        $dayMapping = [
            1 => DayOfWeek::Senin,
            2 => DayOfWeek::Selasa,
            3 => DayOfWeek::Rabu,
            4 => DayOfWeek::Kamis,
            5 => DayOfWeek::Jumat,
            6 => DayOfWeek::Sabtu,
        ];
        $currentDayEnum = $dayMapping[now()->dayOfWeek] ?? DayOfWeek::Senin;

        $schedule = Schedule::create([
            'academic_year_id' => $this->academicYear->id,
            'semester' => Semester::GANJIL,
            'classroom_id' => $classroom->id,
            'subject_id' => $subject->id,
            'teacher_id' => $this->teacher->id,
            'room_id' => $room->id,
            'day_of_week' => $currentDayEnum->value,
            'start_time' => '08:00:00',
            'end_time' => '10:00:00',
        ]);

        $post = Post::create([
            'user_id' => $this->adminUser->id,
            'title' => 'Pengumuman Ujian Tengah Semester Ganjil',
            'category' => 'pengumuman',
            'excerpt' => 'Jadwal UTS Ganjil telah diterbitkan.',
            'content' => '<p>Pelaksanaan UTS akan diselenggarakan mulai pekan depan.</p>',
            'is_published' => true,
            'published_at' => now()->subDay(),
        ]);

        $response = $this->actingAs($this->guruUser)->get(route('teacher.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Dashboard Guru');
        $response->assertSee('Pemrograman Web dan Perangkat Bergerak');
        $response->assertSee('XI RPL 2');
        $response->assertSee('Lab Komputer 1');
        $response->assertSee('Pengumuman Ujian Tengah Semester Ganjil');
    }

    public function test_teacher_without_assignments_sees_clean_empty_state(): void
    {
        $newGuruUser = User::factory()->create(['name' => 'Guru Baru, S.Pd.', 'is_active' => true]);
        $newGuruUser->assignRole('guru');

        $response = $this->actingAs($newGuruUser)->get(route('teacher.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Dashboard Guru');
        $response->assertSee('Tidak ada agenda mengajar tersisa');
    }
}
