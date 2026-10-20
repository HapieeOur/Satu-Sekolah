<?php

namespace Tests\Feature;

use App\Enums\AttendanceStatus;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Database\Seeders\DataMasterSeeder;
use Database\Seeders\RoleAndPermissionSeeder;
use Database\Seeders\ScheduleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeacherAttendanceWebTest extends TestCase
{
    use RefreshDatabase;

    protected User $teacherUser;

    protected Teacher $teacher;

    protected Schedule $schedule;

    protected Student $student;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleAndPermissionSeeder::class);
        $this->seed(UserSeeder::class);
        $this->seed(DataMasterSeeder::class);
        $this->seed(ScheduleSeeder::class);

        $this->teacherUser = User::where('email', 'guru@oneschool.sch.id')->first();
        $this->teacher = Teacher::where('user_id', $this->teacherUser->id)->first();
        $this->schedule = Schedule::where('teacher_id', $this->teacher->id)->first();
        $this->student = Student::where('classroom_id', $this->schedule->classroom_id)->first();
    }

    public function test_teacher_can_view_attendance_sheet(): void
    {
        $response = $this->actingAs($this->teacherUser)
            ->get(route('teacher.attendances.index', ['schedule_id' => $this->schedule->id]));

        $response->assertStatus(200);
        $response->assertSee('Presensi Siswa Mata Pelajaran');
        $response->assertSee('Simpan Presensi Sesi Ini');
    }

    public function test_teacher_can_submit_attendance_records_from_web(): void
    {
        $date = now()->toDateString();

        $response = $this->actingAs($this->teacherUser)
            ->post(route('teacher.attendances.store'), [
                'schedule_id' => $this->schedule->id,
                'date' => $date,
                'attendances' => [
                    $this->student->id => [
                        'status' => 'hadir',
                        'notes' => 'Tepat waktu dan aktif berdiskusi',
                    ],
                ],
            ]);

        $response->assertRedirect(route('teacher.attendances.index', [
            'schedule_id' => $this->schedule->id,
            'date' => $date,
        ]));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('attendances', [
            'schedule_id' => $this->schedule->id,
            'student_id' => $this->student->id,
            'status' => AttendanceStatus::Hadir->value,
            'notes' => 'Tepat waktu dan aktif berdiskusi',
        ]);
    }

    public function test_teacher_cannot_submit_attendance_for_other_teachers_schedule(): void
    {
        $otherTeacherUser = User::where('email', 'pembimbing@oneschool.sch.id')->first();

        $response = $this->actingAs($otherTeacherUser)
            ->post(route('teacher.attendances.store'), [
                'schedule_id' => $this->schedule->id,
                'date' => now()->toDateString(),
                'attendances' => [
                    $this->student->id => [
                        'status' => 'hadir',
                    ],
                ],
            ]);

        $response->assertStatus(403);
    }
}
