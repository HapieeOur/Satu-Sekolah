<?php

namespace Tests\Feature;

use App\Models\Classroom;
use App\Models\Schedule;
use App\Models\Teacher;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\AttendanceSeeder;
use Database\Seeders\DataMasterSeeder;
use Database\Seeders\RoleAndPermissionSeeder;
use Database\Seeders\ScheduleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttendanceTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected User $guruUser;

    protected User $walasUser;

    protected Teacher $teacherBudi;

    protected Teacher $teacherSiti;

    protected Classroom $class11;

    protected Classroom $class12;

    protected Schedule $scheduleWeb11;

    protected Schedule $scheduleWeb12;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleAndPermissionSeeder::class);
        $this->seed(UserSeeder::class);
        $this->seed(DataMasterSeeder::class);
        $this->seed(ScheduleSeeder::class);
        $this->seed(AttendanceSeeder::class);

        $this->admin = User::where('email', 'admin@oneschool.sch.id')->first();
        $this->guruUser = User::where('email', 'guru@oneschool.sch.id')->first();
        $this->walasUser = User::where('email', 'walikelas@oneschool.sch.id')->first();

        $this->teacherBudi = Teacher::where('nip', '198501102010011001')->first();
        $this->teacherSiti = Teacher::where('nip', '198705152012022002')->first();

        $this->class11 = Classroom::where('name', 'XI RPL 1')->first();
        $this->class12 = Classroom::where('name', 'XII RPL 1')->first();

        $this->scheduleWeb11 = Schedule::where('classroom_id', $this->class11->id)
            ->where('teacher_id', $this->teacherBudi->id)
            ->first();

        $this->scheduleWeb12 = Schedule::where('classroom_id', $this->class12->id)
            ->where('teacher_id', $this->teacherBudi->id)
            ->first();
    }

    public function test_guest_cannot_access_homeroom_attendances(): void
    {
        $response = $this->get(route('homeroom.attendances.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_guest_cannot_access_teacher_attendances(): void
    {
        $response = $this->get(route('teacher.attendances.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_user_without_walas_role_cannot_access_homeroom_attendances(): void
    {
        // Guru user only has 'guru' role, not 'wali_kelas'
        $response = $this->actingAs($this->guruUser)->get(route('homeroom.attendances.index'));

        $response->assertStatus(403);
    }

    public function test_homeroom_teacher_can_view_daily_attendance_of_assigned_class(): void
    {
        // $this->walasUser is teacherSiti, who is homeroom teacher for XI RPL 1
        $today = Carbon::today()->format('Y-m-d');

        $response = $this->actingAs($this->walasUser)->get(route('homeroom.attendances.index', [
            'date' => $today,
        ]));

        $response->assertStatus(200);
        $response->assertSee('Presensi Siswa Kelas Binaan');
        $response->assertSee('XI RPL 1');
        $response->assertSee('Aditya Pratama');
        $response->assertSee('Tingkat Kehadiran');
    }

    public function test_homeroom_teacher_can_view_student_recap_tab(): void
    {
        $response = $this->actingAs($this->walasUser)->get(route('homeroom.attendances.index', [
            'tab' => 'rekap',
        ]));

        $response->assertStatus(200);
        $response->assertSee('Rekapitulasi Kehadiran Siswa Binaan');
        $response->assertSee('Aditya Pratama');
        $response->assertSee('% Kehadiran');
    }

    public function test_homeroom_teacher_can_filter_daily_attendance_by_date(): void
    {
        $yesterday = Carbon::yesterday()->format('Y-m-d');

        $response = $this->actingAs($this->walasUser)->get(route('homeroom.attendances.index', [
            'date' => $yesterday,
        ]));

        $response->assertStatus(200);
        $response->assertSee($yesterday);
    }

    public function test_teacher_can_view_their_teaching_schedules_list(): void
    {
        // $this->guruUser is teacherBudi
        $response = $this->actingAs($this->guruUser)->get(route('teacher.attendances.index'));

        $response->assertStatus(200);
        $response->assertSee('Presensi Siswa Mata Pelajaran');
        $response->assertSee('Pemrograman Web & Perangkat Bergerak');
        $response->assertSee('Pilih Sesi Mengajar');
    }

    public function test_teacher_can_view_attendance_for_their_own_schedule(): void
    {
        $today = Carbon::today()->format('Y-m-d');

        $response = $this->actingAs($this->guruUser)->get(route('teacher.attendances.index', [
            'schedule_id' => $this->scheduleWeb11->id,
            'date' => $today,
        ]));

        $response->assertStatus(200);
        $response->assertSee('Presensi Siswa Mata Pelajaran');
        $response->assertSee('XI RPL 1');
        $response->assertSee('Aditya Pratama');
    }

    public function test_teacher_cannot_inspect_attendance_of_another_teachers_schedule_idor_prevention(): void
    {
        // Schedule taught by teacherDewi (Matematika Terapan)
        $scheduleDewi = Schedule::where('teacher_id', '!=', $this->teacherBudi->id)->first();
        $this->assertNotNull($scheduleDewi);

        $response = $this->actingAs($this->guruUser)->get(route('teacher.attendances.index', [
            'schedule_id' => $scheduleDewi->id,
        ]));

        // Must be forbidden (403) due to AuthorizationException
        $response->assertStatus(403);
    }

    public function test_homeroom_dashboard_displays_real_attendance_rate(): void
    {
        $response = $this->actingAs($this->walasUser)->get(route('homeroom.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Dashboard Wali Kelas');
        $response->assertSee('XI RPL 1');
        $response->assertSee('Tingkat Kehadiran Hari Ini');
    }
}
