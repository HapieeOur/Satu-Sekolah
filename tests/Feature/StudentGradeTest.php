<?php

namespace Tests\Feature;

use App\Enums\DayOfWeek;
use App\Models\AcademicYear;
use App\Models\Classroom;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\StudentGrade;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class StudentGradeTest extends TestCase
{
    use RefreshDatabase;

    protected User $guruUser;

    protected Teacher $teacherBudi;

    protected User $walasUser;

    protected Teacher $teacherSiti;

    protected Classroom $classroomRPL;

    protected Classroom $classroomTKJ;

    protected Subject $subjectWeb;

    protected AcademicYear $academicYear;

    protected Student $student1;

    protected Student $student2;

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

        // Regular Guru (Pak Budi)
        $this->guruUser = User::factory()->create([
            'name' => 'Budi Guru, S.Pd.',
            'email' => 'budi.grade@oneschool.sch.id',
            'is_active' => true,
        ]);
        $this->guruUser->assignRole('guru');

        $this->teacherBudi = Teacher::create([
            'user_id' => $this->guruUser->id,
            'nip' => '198501102010011001',
            'gender' => 'L',
        ]);

        // Walas (Bu Siti - has both 'guru' and 'wali_kelas')
        $this->walasUser = User::factory()->create([
            'name' => 'Siti Walas, M.Pd.',
            'email' => 'siti.grade@oneschool.sch.id',
            'is_active' => true,
        ]);
        $this->walasUser->assignRole(['guru', 'wali_kelas']);

        $this->teacherSiti = Teacher::create([
            'user_id' => $this->walasUser->id,
            'nip' => '198705152012022002',
            'gender' => 'P',
        ]);

        // Classroom XI RPL 1 with Wali Kelas Bu Siti
        $this->classroomRPL = Classroom::create([
            'name' => 'XI RPL 1',
            'grade_level' => 11,
            'major' => 'Rekayasa Perangkat Lunak',
            'academic_year_id' => $this->academicYear->id,
            'teacher_id' => $this->teacherSiti->id,
            'is_active' => true,
        ]);

        // Classroom XI TKJ 1
        $this->classroomTKJ = Classroom::create([
            'name' => 'XI TKJ 1',
            'grade_level' => 11,
            'major' => 'Teknik Komputer Jaringan',
            'academic_year_id' => $this->academicYear->id,
            'teacher_id' => $this->teacherBudi->id,
            'is_active' => true,
        ]);

        // Subject
        $this->subjectWeb = Subject::create([
            'name' => 'Pemrograman Web',
            'code' => 'RPL-WEB',
        ]);

        $this->teacherBudi->subjects()->attach($this->subjectWeb->id);

        // Schedule: Pak Budi teaches in XI RPL 1
        Schedule::create([
            'classroom_id' => $this->classroomRPL->id,
            'teacher_id' => $this->teacherBudi->id,
            'subject_id' => $this->subjectWeb->id,
            'academic_year_id' => $this->academicYear->id,
            'semester' => 'ganjil',
            'day_of_week' => DayOfWeek::Senin->value,
            'start_time' => '07:30',
            'end_time' => '09:30',
        ]);

        // Students in XI RPL 1
        $userStudent1 = User::factory()->create(['name' => 'Aditya Pratama', 'is_active' => true]);
        $userStudent1->assignRole('siswa');
        $this->student1 = Student::create([
            'user_id' => $userStudent1->id,
            'classroom_id' => $this->classroomRPL->id,
            'academic_year_id' => $this->academicYear->id,
            'name' => 'Aditya Pratama',
            'nis' => '24101',
            'nisn' => '00891001',
            'gender' => 'L',
            'status' => 'active',
        ]);

        $userStudent2 = User::factory()->create(['name' => 'Bella Cantika', 'is_active' => true]);
        $userStudent2->assignRole('siswa');
        $this->student2 = Student::create([
            'user_id' => $userStudent2->id,
            'classroom_id' => $this->classroomRPL->id,
            'academic_year_id' => $this->academicYear->id,
            'name' => 'Bella Cantika',
            'nis' => '24102',
            'nisn' => '00891002',
            'gender' => 'P',
            'status' => 'active',
        ]);
    }

    public function test_teacher_can_access_gradebook_and_filter(): void
    {
        $response = $this->actingAs($this->guruUser)->get(route('teacher.grades.index', [
            'classroom_id' => $this->classroomRPL->id,
            'subject_id' => $this->subjectWeb->id,
            'type' => 'tugas',
            'title' => 'Tugas 1',
        ]));

        $response->assertOk();
        $response->assertSee('Aditya Pratama');
        $response->assertSee('Bella Cantika');
        $response->assertSee('XI RPL 1');
        $response->assertSee('Pemrograman Web');
    }

    public function test_homeroom_teacher_can_access_gradebook_for_homeroom_classroom(): void
    {
        $response = $this->actingAs($this->walasUser)->get(route('homeroom.grades.index'));

        $response->assertOk();
        $response->assertSee('Buku Nilai Kelas Binaan');
        $response->assertSee('XI RPL 1');
        $response->assertSee('Aditya Pratama');
    }

    public function test_teacher_can_batch_store_grades(): void
    {
        $payload = [
            'classroom_id' => $this->classroomRPL->id,
            'subject_id' => $this->subjectWeb->id,
            'type' => 'tugas',
            'title' => 'Tugas 1 HTML CSS',
            'grades' => [
                [
                    'student_id' => $this->student1->id,
                    'score' => 90,
                    'notes' => 'Sangat rapi',
                ],
                [
                    'student_id' => $this->student2->id,
                    'score' => 82.5,
                    'notes' => 'Baik',
                ],
            ],
        ];

        $response = $this->actingAs($this->guruUser)->post(route('teacher.grades.store'), $payload);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('student_grades', [
            'classroom_id' => $this->classroomRPL->id,
            'subject_id' => $this->subjectWeb->id,
            'student_id' => $this->student1->id,
            'type' => 'tugas',
            'title' => 'Tugas 1 HTML CSS',
            'score' => 90,
        ]);

        $this->assertDatabaseHas('student_grades', [
            'classroom_id' => $this->classroomRPL->id,
            'subject_id' => $this->subjectWeb->id,
            'student_id' => $this->student2->id,
            'type' => 'tugas',
            'title' => 'Tugas 1 HTML CSS',
            'score' => 82.5,
        ]);
    }

    public function test_teacher_can_update_existing_grades_and_clear_scores(): void
    {
        // Pre-create grade for student 1 and 2
        StudentGrade::create([
            'teacher_id' => $this->teacherBudi->id,
            'classroom_id' => $this->classroomRPL->id,
            'subject_id' => $this->subjectWeb->id,
            'student_id' => $this->student1->id,
            'academic_year_id' => $this->academicYear->id,
            'type' => 'ulangan_harian',
            'title' => 'UH 1 CSS Layout',
            'score' => 70,
        ]);

        StudentGrade::create([
            'teacher_id' => $this->teacherBudi->id,
            'classroom_id' => $this->classroomRPL->id,
            'subject_id' => $this->subjectWeb->id,
            'student_id' => $this->student2->id,
            'academic_year_id' => $this->academicYear->id,
            'type' => 'ulangan_harian',
            'title' => 'UH 1 CSS Layout',
            'score' => 65,
        ]);

        // Student 1 updated to 95, Student 2 cleared (score => null)
        $payload = [
            'classroom_id' => $this->classroomRPL->id,
            'subject_id' => $this->subjectWeb->id,
            'type' => 'ulangan_harian',
            'title' => 'UH 1 CSS Layout',
            'grades' => [
                [
                    'student_id' => $this->student1->id,
                    'score' => 95,
                    'notes' => 'Remedial berhasil',
                ],
                [
                    'student_id' => $this->student2->id,
                    'score' => '', // Cleared
                    'notes' => null,
                ],
            ],
        ];

        $response = $this->actingAs($this->guruUser)->post(route('teacher.grades.store'), $payload);
        $response->assertRedirect();

        // Student 1 should have updated score 95
        $this->assertDatabaseHas('student_grades', [
            'student_id' => $this->student1->id,
            'title' => 'UH 1 CSS Layout',
            'score' => 95,
        ]);

        // Student 2 grade should be removed because it was cleared
        $this->assertDatabaseMissing('student_grades', [
            'student_id' => $this->student2->id,
            'title' => 'UH 1 CSS Layout',
        ]);
    }

    public function test_walas_can_store_grades_via_homeroom_route(): void
    {
        $payload = [
            'classroom_id' => $this->classroomRPL->id,
            'subject_id' => $this->subjectWeb->id,
            'type' => 'uts',
            'title' => 'UTS Semester Ganjil',
            'grades' => [
                [
                    'student_id' => $this->student1->id,
                    'score' => 88,
                    'notes' => 'Tuntas',
                ],
            ],
        ];

        $response = $this->actingAs($this->walasUser)->post(route('homeroom.grades.store'), $payload);

        $response->assertRedirect();
        $this->assertDatabaseHas('student_grades', [
            'classroom_id' => $this->classroomRPL->id,
            'subject_id' => $this->subjectWeb->id,
            'student_id' => $this->student1->id,
            'type' => 'uts',
            'title' => 'UTS Semester Ganjil',
            'score' => 88,
        ]);
    }

    public function test_grade_validation_rejects_out_of_bound_scores_and_invalid_types(): void
    {
        $payload = [
            'classroom_id' => $this->classroomRPL->id,
            'subject_id' => $this->subjectWeb->id,
            'type' => 'invalid_type',
            'title' => 'Test',
            'grades' => [
                [
                    'student_id' => $this->student1->id,
                    'score' => 150, // exceeds 100
                ],
            ],
        ];

        $response = $this->actingAs($this->guruUser)->post(route('teacher.grades.store'), $payload);
        $response->assertSessionHasErrors(['type', 'grades.0.score']);
    }
}
