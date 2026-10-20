<?php

namespace Tests\Feature;

use App\Models\AcademicYear;
use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class HomeroomStudentTest extends TestCase
{
    use RefreshDatabase;

    protected User $walasUser;

    protected Teacher $teacherWalas;

    protected Classroom $myClassroom;

    protected Classroom $otherClassroom;

    protected AcademicYear $academicYear;

    protected function setUp(): void
    {
        parent::setUp();

        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'guru', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'wali_kelas', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'siswa', 'guard_name' => 'web']);

        $this->academicYear = AcademicYear::create([
            'name' => '2026/2027 Ganjil',
            'semester' => 'ganjil',
            'start_date' => '2026-07-15',
            'end_date' => '2026-12-20',
            'is_active' => true,
        ]);

        // Walas setup (both 'guru' and 'wali_kelas' roles)
        $this->walasUser = User::factory()->create([
            'name' => 'Ibu Siti Walas, M.Pd.',
            'email' => 'walas.siti@oneschool.sch.id',
            'is_active' => true,
        ]);
        $this->walasUser->assignRole(['guru', 'wali_kelas']);

        $this->teacherWalas = Teacher::create([
            'user_id' => $this->walasUser->id,
            'nip' => '198705122010012004',
            'gender' => 'P',
        ]);

        // My classroom
        $this->myClassroom = Classroom::create([
            'name' => 'XII RPL 1',
            'grade_level' => 12,
            'major' => 'Rekayasa Perangkat Lunak',
            'academic_year_id' => $this->academicYear->id,
            'teacher_id' => $this->teacherWalas->id,
            'is_active' => true,
        ]);

        // Other teacher and other classroom
        $otherUser = User::factory()->create(['is_active' => true]);
        $otherUser->assignRole('guru');
        $otherTeacher = Teacher::create([
            'user_id' => $otherUser->id,
            'nip' => '198901012015011001',
            'gender' => 'L',
        ]);

        $this->otherClassroom = Classroom::create([
            'name' => 'XII TKJ 1',
            'grade_level' => 12,
            'major' => 'Teknik Komputer dan Jaringan',
            'academic_year_id' => $this->academicYear->id,
            'teacher_id' => $otherTeacher->id,
            'is_active' => true,
        ]);
    }

    private function createStudent(Classroom $classroom, string $name, string $nis, string $nisn, string $gender): Student
    {
        $user = User::factory()->create([
            'name' => $name,
            'email' => strtolower(str_replace(' ', '', $name)).'@siswa.oneschool.sch.id',
            'is_active' => true,
        ]);
        $user->assignRole('siswa');

        return Student::create([
            'user_id' => $user->id,
            'classroom_id' => $classroom->id,
            'academic_year_id' => $this->academicYear->id,
            'name' => $name,
            'nis' => $nis,
            'nisn' => $nisn,
            'gender' => $gender,
            'status' => 'active',
        ]);
    }

    public function test_walas_can_view_students_list_in_their_homeroom_classroom(): void
    {
        $studentA = $this->createStudent($this->myClassroom, 'Ahmad Fauzan', '2401', '0081234567', 'L');
        $studentB = $this->createStudent($this->myClassroom, 'Dewi Lestari', '2402', '0087654321', 'P');
        $studentOther = $this->createStudent($this->otherClassroom, 'Budi Gunawan', '2499', '0089999999', 'L');

        $response = $this->actingAs($this->walasUser)->get(route('homeroom.students.index'));

        $response->assertOk();
        $response->assertSee('Ahmad Fauzan');
        $response->assertSee('Dewi Lestari');
        $response->assertSee('XII RPL 1');
        $response->assertDontSee('Budi Gunawan');
        $response->assertViewHas('totalStudents', 2);
        $response->assertViewHas('maleCount', 1);
        $response->assertViewHas('femaleCount', 1);
    }

    public function test_walas_can_filter_students_by_keyword_and_gender(): void
    {
        $this->createStudent($this->myClassroom, 'Ahmad Fauzan', '2401', '0081234567', 'L');
        $this->createStudent($this->myClassroom, 'Dewi Lestari', '2402', '0087654321', 'P');
        $this->createStudent($this->myClassroom, 'Ahmad Subandi', '2403', '0081112233', 'L');

        // Filter by keyword 'Ahmad'
        $response = $this->actingAs($this->walasUser)->get(route('homeroom.students.index', ['q' => 'Ahmad']));
        $response->assertOk();
        $response->assertSee('Ahmad Fauzan');
        $response->assertSee('Ahmad Subandi');
        $response->assertDontSee('Dewi Lestari');

        // Filter by gender 'P'
        $responseGender = $this->actingAs($this->walasUser)->get(route('homeroom.students.index', ['gender' => 'P']));
        $responseGender->assertOk();
        $responseGender->assertSee('Dewi Lestari');
        $responseGender->assertDontSee('Ahmad Fauzan');
        $responseGender->assertDontSee('Ahmad Subandi');
    }

    public function test_walas_can_view_homeroom_student_detail_profile(): void
    {
        $student = $this->createStudent($this->myClassroom, 'Ahmad Fauzan', '2401', '0081234567', 'L');

        // Create an attendance record
        Attendance::create([
            'student_id' => $student->id,
            'classroom_id' => $this->myClassroom->id,
            'date' => Carbon::today()->toDateString(),
            'check_in_time' => '07:15:00',
            'status' => 'hadir',
        ]);

        $response = $this->actingAs($this->walasUser)->get(route('homeroom.students.show', $student));

        $response->assertOk();
        $response->assertSee('Ahmad Fauzan');
        $response->assertSee('2401');
        $response->assertSee('0081234567');
        $response->assertSee('XII RPL 1');
    }

    public function test_walas_cannot_view_student_profile_belonging_to_another_classroom(): void
    {
        $studentOther = $this->createStudent($this->otherClassroom, 'Budi Gunawan', '2499', '0089999999', 'L');

        $response = $this->actingAs($this->walasUser)->get(route('homeroom.students.show', $studentOther));

        $response->assertForbidden();
    }

    public function test_teacher_without_homeroom_class_sees_empty_state_gracefully(): void
    {
        $teacherWithoutClassUser = User::factory()->create(['is_active' => true]);
        $teacherWithoutClassUser->assignRole('wali_kelas');
        Teacher::create([
            'user_id' => $teacherWithoutClassUser->id,
            'nip' => '199501012020011005',
            'gender' => 'L',
        ]);

        $response = $this->actingAs($teacherWithoutClassUser)->get(route('homeroom.students.index'));

        $response->assertOk();
        $response->assertViewHas('totalStudents', 0);
    }
}
