<?php

namespace Tests\Feature\Api;

use App\Models\Classroom;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\User;
use Database\Seeders\AttendanceSeeder;
use Database\Seeders\DataMasterSeeder;
use Database\Seeders\RoleAndPermissionSeeder;
use Database\Seeders\ScheduleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AcademicScheduleApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleAndPermissionSeeder::class);
        $this->seed(UserSeeder::class);
        $this->seed(DataMasterSeeder::class);
        $this->seed(ScheduleSeeder::class);
        $this->seed(AttendanceSeeder::class);
    }

    public function test_student_can_view_class_timetable(): void
    {
        $student = Student::where('nis', '20261101')->first();
        $token = $student->user->createToken('test')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/v1/student/schedules');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'data' => [
                    'classroom' => [
                        'id',
                        'name',
                        'major',
                    ],
                    'schedules',
                ],
            ]);
    }

    public function test_teacher_can_view_teaching_timetable(): void
    {
        $teacherUser = User::where('email', 'guru@oneschool.sch.id')->first();
        $token = $teacherUser->createToken('test')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/v1/teacher/schedules');

        $response->assertStatus(200)
            ->assertJsonPath('success', true);
    }

    public function test_teacher_can_record_classroom_attendance(): void
    {
        $teacherUser = User::where('email', 'guru@oneschool.sch.id')->first();
        $token = $teacherUser->createToken('test')->plainTextToken;
        $teacher = $teacherUser->teacher;

        $schedule = Schedule::where('teacher_id', $teacher->id)->first();
        $classroom = $schedule->classroom;
        $students = Student::where('classroom_id', $classroom->id)->get();

        $attendancesData = [];
        foreach ($students as $student) {
            $attendancesData[] = [
                'student_id' => $student->id,
                'status' => 'hadir',
                'notes' => 'Hadir tepat waktu',
            ];
        }

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/v1/teacher/attendances', [
                'schedule_id' => $schedule->id,
                'classroom_id' => $classroom->id,
                'date' => now()->toDateString(),
                'attendances' => $attendancesData,
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.recorded_count', count($attendancesData));
    }
}
