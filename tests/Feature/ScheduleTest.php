<?php

namespace Tests\Feature;

use App\Enums\DayOfWeek;
use App\Enums\Semester;
use App\Models\AcademicYear;
use App\Models\Classroom;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Database\Seeders\DataMasterSeeder;
use Database\Seeders\RoleAndPermissionSeeder;
use Database\Seeders\ScheduleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScheduleTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected User $guruUser;

    protected Teacher $teacherBudi;

    protected Teacher $teacherSiti;

    protected Teacher $teacherDewi;

    protected Classroom $class11;

    protected Classroom $class12;

    protected Subject $subjectWeb;

    protected Subject $subjectDb;

    protected Subject $subjectMtk;

    protected AcademicYear $academicYear;

    protected Room $roomLab;

    protected Room $room101;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleAndPermissionSeeder::class);
        $this->seed(UserSeeder::class);
        $this->seed(DataMasterSeeder::class);
        $this->seed(ScheduleSeeder::class);

        $this->admin = User::where('email', 'admin@oneschool.sch.id')->first();
        $this->guruUser = User::where('email', 'guru@oneschool.sch.id')->first();

        $this->teacherBudi = Teacher::where('nip', '198501102010011001')->first();
        $this->teacherSiti = Teacher::where('nip', '198705152012022002')->first();
        $this->teacherDewi = Teacher::where('nip', '199208182018022004')->first();

        $this->class11 = Classroom::where('name', 'XI RPL 1')->first();
        $this->class12 = Classroom::where('name', 'XII RPL 1')->first();

        $this->subjectWeb = Subject::where('code', 'RPL-WEB')->first();
        $this->subjectDb = Subject::where('code', 'RPL-DB')->first();
        $this->subjectMtk = Subject::where('code', 'UMUM-MTK')->first();

        $this->academicYear = AcademicYear::where('is_active', true)->first();
        $this->roomLab = Room::where('code', 'LAB-RPL')->first();
        $this->room101 = Room::where('code', 'R-101')->first();
    }

    public function test_admin_can_view_schedule_index_with_classroom_filter(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.schedules.index', [
            'classroom_id' => $this->class11->id,
            'academic_year_id' => $this->academicYear->id,
            'semester' => 'ganjil',
        ]));

        $response->assertStatus(200);
        $response->assertSee('Jadwal Pelajaran');
        $response->assertSee($this->class11->name);
        $response->assertSee($this->subjectWeb->name);
    }

    public function test_admin_can_view_create_schedule_form(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.schedules.create', [
            'classroom_id' => $this->class11->id,
        ]));

        $response->assertStatus(200);
        $response->assertSee('Tambah Jadwal Pelajaran');
        $response->assertSee('Ketentuan Anti-Bentrok');
    }

    public function test_admin_can_create_a_valid_schedule(): void
    {
        $payload = [
            'academic_year_id' => $this->academicYear->id,
            'semester' => Semester::GANJIL->value,
            'classroom_id' => $this->class11->id,
            'subject_id' => $this->subjectWeb->id,
            'teacher_id' => $this->teacherBudi->id,
            'room_id' => $this->roomLab->id,
            'day_of_week' => DayOfWeek::Kamis->value,
            'start_time' => '10:00',
            'end_time' => '12:00',
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.schedules.store'), $payload);

        $response->assertRedirect(route('admin.schedules.index', [
            'academic_year_id' => $this->academicYear->id,
            'semester' => Semester::GANJIL->value,
            'classroom_id' => $this->class11->id,
        ]));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('schedules', [
            'classroom_id' => $this->class11->id,
            'subject_id' => $this->subjectWeb->id,
            'teacher_id' => $this->teacherBudi->id,
            'day_of_week' => DayOfWeek::Kamis->value,
        ]);
    }

    public function test_schedule_fails_if_end_time_is_not_after_start_time(): void
    {
        $payload = [
            'academic_year_id' => $this->academicYear->id,
            'semester' => Semester::GANJIL->value,
            'classroom_id' => $this->class11->id,
            'subject_id' => $this->subjectWeb->id,
            'teacher_id' => $this->teacherBudi->id,
            'room_id' => $this->roomLab->id,
            'day_of_week' => DayOfWeek::Jumat->value,
            'start_time' => '10:00',
            'end_time' => '09:00', // invalid: end before start
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.schedules.store'), $payload);

        $response->assertSessionHasErrors(['end_time']);
    }

    public function test_schedule_fails_if_teacher_does_not_teach_subject(): void
    {
        // Teacher Dewi teaches MTK, not RPL-WEB
        $payload = [
            'academic_year_id' => $this->academicYear->id,
            'semester' => Semester::GANJIL->value,
            'classroom_id' => $this->class11->id,
            'subject_id' => $this->subjectWeb->id,
            'teacher_id' => $this->teacherDewi->id,
            'room_id' => $this->roomLab->id,
            'day_of_week' => DayOfWeek::Jumat->value,
            'start_time' => '07:30',
            'end_time' => '09:00',
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.schedules.store'), $payload);

        $response->assertSessionHasErrors(['teacher_id']);
    }

    public function test_schedule_fails_if_classroom_has_conflicting_schedule(): void
    {
        // XI RPL 1 already has schedule on Senin 07:30 - 09:30 (from ScheduleSeeder)
        // Trying to schedule on Senin 08:30 - 10:00 (overlapping)
        $payload = [
            'academic_year_id' => $this->academicYear->id,
            'semester' => Semester::GANJIL->value,
            'classroom_id' => $this->class11->id,
            'subject_id' => $this->subjectDb->id,
            'teacher_id' => $this->teacherSiti->id,
            'room_id' => $this->room101->id,
            'day_of_week' => DayOfWeek::Senin->value,
            'start_time' => '08:30',
            'end_time' => '10:00',
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.schedules.store'), $payload);

        $response->assertSessionHasErrors(['start_time']);
    }

    public function test_schedule_fails_if_teacher_has_conflicting_schedule(): void
    {
        // Teacher Budi is already teaching XI RPL 1 on Senin 07:30 - 09:30
        // Trying to schedule Teacher Budi in class XII RPL 1 on Senin 08:00 - 09:30
        $payload = [
            'academic_year_id' => $this->academicYear->id,
            'semester' => Semester::GANJIL->value,
            'classroom_id' => $this->class12->id,
            'subject_id' => $this->subjectWeb->id,
            'teacher_id' => $this->teacherBudi->id,
            'room_id' => $this->room101->id,
            'day_of_week' => DayOfWeek::Senin->value,
            'start_time' => '08:00',
            'end_time' => '09:30',
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.schedules.store'), $payload);

        $response->assertSessionHasErrors(['teacher_id']);
    }

    public function test_schedule_fails_if_room_has_conflicting_schedule(): void
    {
        // LAB-RPL is used by XI RPL 1 on Senin 07:30 - 09:30
        // Trying to schedule class XII RPL 1 with Teacher Siti in LAB-RPL on Senin 08:00 - 09:30
        $payload = [
            'academic_year_id' => $this->academicYear->id,
            'semester' => Semester::GANJIL->value,
            'classroom_id' => $this->class12->id,
            'subject_id' => $this->subjectDb->id,
            'teacher_id' => $this->teacherSiti->id,
            'room_id' => $this->roomLab->id,
            'day_of_week' => DayOfWeek::Senin->value,
            'start_time' => '08:00',
            'end_time' => '09:30',
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.schedules.store'), $payload);

        $response->assertSessionHasErrors(['room_id']);
    }

    public function test_adjacent_schedules_at_exact_boundary_are_allowed(): void
    {
        // XI RPL 1 has schedule on Senin 07:30 - 09:30
        // Schedule on Senin 09:30 - 11:00 starts exactly when the previous ends -> allowed!
        // (Note: Seeder already has 09:30 - 11:30 for class11, let's schedule on Selasa after 10:30)
        // In Seeder: Selasa 08:00 - 10:30 (RPL-DB with teacher Siti)
        // Let's create adjacent schedule on Selasa starting exactly at 10:30 to 12:00
        $payload = [
            'academic_year_id' => $this->academicYear->id,
            'semester' => Semester::GANJIL->value,
            'classroom_id' => $this->class11->id,
            'subject_id' => $this->subjectWeb->id,
            'teacher_id' => $this->teacherBudi->id,
            'room_id' => $this->roomLab->id,
            'day_of_week' => DayOfWeek::Selasa->value,
            'start_time' => '10:30', // exact boundary
            'end_time' => '12:00',
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.schedules.store'), $payload);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('schedules', [
            'classroom_id' => $this->class11->id,
            'day_of_week' => DayOfWeek::Selasa->value,
        ]);
    }

    public function test_admin_can_update_schedule_without_self_conflict(): void
    {
        $schedule = Schedule::where('classroom_id', $this->class11->id)
            ->where('day_of_week', DayOfWeek::Senin->value)
            ->first();

        $payload = [
            'academic_year_id' => $schedule->academic_year_id,
            'semester' => $schedule->semester->value,
            'classroom_id' => $schedule->classroom_id,
            'subject_id' => $schedule->subject_id,
            'teacher_id' => $schedule->teacher_id,
            'room_id' => $schedule->room_id,
            'day_of_week' => $schedule->day_of_week->value,
            'start_time' => '07:30',
            'end_time' => '09:00', // shortened from 09:30
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.schedules.update', $schedule), $payload);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('schedules', [
            'id' => $schedule->id,
            'classroom_id' => $schedule->classroom_id,
        ]);
        $this->assertStringStartsWith('09:00', (string) $schedule->fresh()->end_time);
    }

    public function test_admin_can_delete_schedule(): void
    {
        $schedule = Schedule::where('classroom_id', $this->class11->id)->first();

        $response = $this->actingAs($this->admin)->delete(route('admin.schedules.destroy', $schedule));

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('schedules', ['id' => $schedule->id]);
    }

    public function test_teacher_can_view_their_own_teaching_schedule(): void
    {
        // Login as guruUser (Budi Santoso, nip 198501102010011001)
        $response = $this->actingAs($this->guruUser)->get(route('teacher.schedules.index'));

        $response->assertStatus(200);
        $response->assertSee('Jadwal Mengajar Saya');
        $response->assertSee($this->guruUser->name);
        $response->assertSee($this->subjectWeb->name);
    }

    public function test_non_admin_cannot_manage_schedules(): void
    {
        $response = $this->actingAs($this->guruUser)->get(route('admin.schedules.index'));
        $response->assertStatus(403);

        $response = $this->actingAs($this->guruUser)->post(route('admin.schedules.store'), []);
        $response->assertStatus(403);
    }

    public function test_api_teachers_by_subject_returns_assigned_teachers(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.schedules.teachers-by-subject', $this->subjectWeb));

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $this->teacherBudi->id,
            'name' => $this->teacherBudi->name,
        ]);
    }
}
