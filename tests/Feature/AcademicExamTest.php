<?php

namespace Tests\Feature;

use App\Enums\DayOfWeek;
use App\Models\AcademicExam;
use App\Models\AcademicExamScore;
use App\Models\AcademicYear;
use App\Models\Classroom;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AcademicExamTest extends TestCase
{
    use RefreshDatabase;

    protected User $guruUser;

    protected Teacher $teacherBudi;

    protected User $otherGuruUser;

    protected Teacher $teacherOther;

    protected User $studentUser;

    protected Student $student;

    protected Classroom $classroom;

    protected Subject $subject;

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

        // Regular Guru (Pak Budi)
        $this->guruUser = User::factory()->create([
            'name' => 'Budi Santoso, S.Pd.',
            'email' => 'budi.guru@oneschool.sch.id',
            'is_active' => true,
        ]);
        $this->guruUser->assignRole('guru');

        $this->teacherBudi = Teacher::create([
            'user_id' => $this->guruUser->id,
            'nip' => '198501102010011001',
            'nuptk' => '8439201928301928',
            'gender' => 'L',
        ]);

        // Other Guru
        $this->otherGuruUser = User::factory()->create([
            'name' => 'Ahmad Guru Lain, S.Pd.',
            'email' => 'ahmad.guru@oneschool.sch.id',
            'is_active' => true,
        ]);
        $this->otherGuruUser->assignRole('guru');

        $this->teacherOther = Teacher::create([
            'user_id' => $this->otherGuruUser->id,
            'nip' => '199001102015011002',
            'nuptk' => '8439201928301999',
            'gender' => 'L',
        ]);

        // Classroom XI RPL 1
        $this->classroom = Classroom::create([
            'name' => 'XI RPL 1',
            'grade_level' => 11,
            'major' => 'Rekayasa Perangkat Lunak',
            'academic_year_id' => $this->academicYear->id,
            'teacher_id' => $this->teacherBudi->id,
            'is_active' => true,
        ]);

        // Subject
        $this->subject = Subject::create([
            'name' => 'Pemrograman Berorientasi Objek',
            'code' => 'RPL-PBO',
        ]);

        $this->teacherBudi->subjects()->attach($this->subject->id);

        // Schedule
        Schedule::create([
            'classroom_id' => $this->classroom->id,
            'teacher_id' => $this->teacherBudi->id,
            'subject_id' => $this->subject->id,
            'academic_year_id' => $this->academicYear->id,
            'semester' => 'ganjil',
            'day_of_week' => DayOfWeek::Senin->value,
            'start_time' => '07:30',
            'end_time' => '09:30',
        ]);

        // Student
        $this->studentUser = User::factory()->create([
            'name' => 'Rian Hidayat',
            'email' => 'rian@siswa.oneschool.sch.id',
            'is_active' => true,
        ]);
        $this->studentUser->assignRole('siswa');

        $this->student = Student::create([
            'user_id' => $this->studentUser->id,
            'classroom_id' => $this->classroom->id,
            'academic_year_id' => $this->academicYear->id,
            'name' => 'Rian Hidayat',
            'nis' => '241101',
            'nisn' => '0089102938',
            'gender' => 'L',
            'status' => 'active',
        ]);
    }

    public function test_teacher_can_create_daily_exam(): void
    {
        $examDate = Carbon::now()->addDays(2)->format('Y-m-d H:i:s');

        $payload = [
            'classroom_id' => $this->classroom->id,
            'subject_id' => $this->subject->id,
            'title' => 'Ulangan Harian 1: Konsep OOP dan Enkapsulasi',
            'description' => 'Materi Bab 1 - 2. Kerjakan di lembar jawaban dengan teliti.',
            'exam_date' => $examDate,
            'duration_minutes' => 90,
            'passing_score' => 75,
        ];

        $response = $this->actingAs($this->guruUser)->post(route('teacher.exams.store'), $payload);

        $response->assertRedirect(route('teacher.exams.index'));
        $this->assertDatabaseHas('academic_exams', [
            'teacher_id' => $this->teacherBudi->id,
            'classroom_id' => $this->classroom->id,
            'subject_id' => $this->subject->id,
            'title' => 'Ulangan Harian 1: Konsep OOP dan Enkapsulasi',
            'duration_minutes' => 90,
            'passing_score' => 75,
            'status' => 'scheduled',
        ]);
    }

    public function test_teacher_cannot_create_exam_with_invalid_data(): void
    {
        $payload = [
            'classroom_id' => $this->classroom->id,
            'subject_id' => $this->subject->id,
            'title' => '',
            'exam_date' => 'invalid-date',
            'duration_minutes' => 5, // min is 15
            'passing_score' => 150, // max is 100
        ];

        $response = $this->actingAs($this->guruUser)->post(route('teacher.exams.store'), $payload);
        $response->assertSessionHasErrors(['title', 'exam_date', 'duration_minutes', 'passing_score']);
    }

    public function test_teacher_can_view_exam_detail_with_student_roster(): void
    {
        $exam = AcademicExam::create([
            'teacher_id' => $this->teacherBudi->id,
            'classroom_id' => $this->classroom->id,
            'subject_id' => $this->subject->id,
            'academic_year_id' => $this->academicYear->id,
            'title' => 'Ulangan Harian Bab 1',
            'exam_date' => Carbon::now()->addDay()->format('Y-m-d 08:00:00'),
            'duration_minutes' => 60,
            'passing_score' => 75,
            'status' => 'scheduled',
        ]);

        $response = $this->actingAs($this->guruUser)->get(route('teacher.exams.show', $exam));

        $response->assertOk();
        $response->assertSee('Ulangan Harian Bab 1');
        $response->assertSee('Rian Hidayat');
    }

    public function test_teacher_cannot_view_or_modify_other_teachers_exam(): void
    {
        $examOther = AcademicExam::create([
            'teacher_id' => $this->teacherOther->id,
            'classroom_id' => $this->classroom->id,
            'subject_id' => $this->subject->id,
            'academic_year_id' => $this->academicYear->id,
            'title' => 'Ujian Guru Lain',
            'exam_date' => Carbon::now()->addDay()->format('Y-m-d 08:00:00'),
            'duration_minutes' => 60,
            'passing_score' => 75,
            'status' => 'scheduled',
        ]);

        $responseShow = $this->actingAs($this->guruUser)->get(route('teacher.exams.show', $examOther));
        $responseShow->assertForbidden();

        $responseScores = $this->actingAs($this->guruUser)->post(route('teacher.exams.scores.store', $examOther), [
            'scores' => [
                ['student_id' => $this->student->id, 'score' => 80],
            ],
        ]);
        $responseScores->assertForbidden();

        $responseDelete = $this->actingAs($this->guruUser)->delete(route('teacher.exams.destroy', $examOther));
        $responseDelete->assertForbidden();
    }

    public function test_teacher_can_batch_save_student_scores(): void
    {
        $exam = AcademicExam::create([
            'teacher_id' => $this->teacherBudi->id,
            'classroom_id' => $this->classroom->id,
            'subject_id' => $this->subject->id,
            'academic_year_id' => $this->academicYear->id,
            'title' => 'UH 1 PBO',
            'exam_date' => Carbon::now()->format('Y-m-d 08:00:00'),
            'duration_minutes' => 60,
            'passing_score' => 75,
            'status' => 'scheduled',
        ]);

        // Student 1 passes (score 85 >= 75)
        // Create second student who fails (score 60 < 75)
        $studentUser2 = User::factory()->create(['name' => 'Siti Ayu', 'is_active' => true]);
        $studentUser2->assignRole('siswa');
        $student2 = Student::create([
            'user_id' => $studentUser2->id,
            'classroom_id' => $this->classroom->id,
            'academic_year_id' => $this->academicYear->id,
            'name' => 'Siti Ayu',
            'nis' => '241102',
            'nisn' => '0089102939',
            'gender' => 'P',
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->guruUser)->post(route('teacher.exams.scores.store', $exam), [
            'scores' => [
                [
                    'student_id' => $this->student->id,
                    'score' => 85,
                    'notes' => 'Sangat baik',
                ],
                [
                    'student_id' => $student2->id,
                    'score' => 60,
                    'notes' => 'Perlu remedial bagian inheritance',
                ],
            ],
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        // Check scores in DB
        $this->assertDatabaseHas('academic_exam_scores', [
            'academic_exam_id' => $exam->id,
            'student_id' => $this->student->id,
            'score' => 85,
            'is_remedial' => false,
        ]);

        $this->assertDatabaseHas('academic_exam_scores', [
            'academic_exam_id' => $exam->id,
            'student_id' => $student2->id,
            'score' => 60,
            'is_remedial' => true,
        ]);

        // Exam status updated to completed
        $this->assertEquals('completed', $exam->fresh()->status);
    }

    public function test_student_can_view_exams_for_their_classroom_and_see_their_score(): void
    {
        $exam = AcademicExam::create([
            'teacher_id' => $this->teacherBudi->id,
            'classroom_id' => $this->classroom->id,
            'subject_id' => $this->subject->id,
            'academic_year_id' => $this->academicYear->id,
            'title' => 'UH Konsep MVC',
            'exam_date' => Carbon::now()->addDays(1)->format('Y-m-d 09:00:00'),
            'duration_minutes' => 60,
            'passing_score' => 75,
            'status' => 'completed',
        ]);

        AcademicExamScore::create([
            'academic_exam_id' => $exam->id,
            'student_id' => $this->student->id,
            'score' => 88.5,
            'is_remedial' => false,
            'graded_at' => now(),
        ]);

        $response = $this->actingAs($this->studentUser)->get(route('student.exams.index'));

        $response->assertOk();
        $response->assertSee('UH Konsep MVC');
        $response->assertSee('88.5');
        $response->assertSee('Tuntas');
    }

    public function test_teacher_can_delete_their_exam(): void
    {
        $exam = AcademicExam::create([
            'teacher_id' => $this->teacherBudi->id,
            'classroom_id' => $this->classroom->id,
            'subject_id' => $this->subject->id,
            'academic_year_id' => $this->academicYear->id,
            'title' => 'UH Dibatalkan',
            'exam_date' => Carbon::now()->addDays(3)->format('Y-m-d 08:00:00'),
            'duration_minutes' => 60,
            'passing_score' => 75,
            'status' => 'scheduled',
        ]);

        $response = $this->actingAs($this->guruUser)->delete(route('teacher.exams.destroy', $exam));

        $response->assertRedirect(route('teacher.exams.index'));
        $this->assertDatabaseMissing('academic_exams', ['id' => $exam->id]);
    }
}
