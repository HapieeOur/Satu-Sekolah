<?php

namespace Tests\Feature;

use App\Models\AcademicYear;
use App\Models\Classroom;
use App\Models\Room;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Database\Seeders\DataMasterSeeder;
use Database\Seeders\RoleAndPermissionSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DataMasterTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected User $guru;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleAndPermissionSeeder::class);
        $this->seed(UserSeeder::class);
        $this->seed(DataMasterSeeder::class);

        $this->admin = User::where('email', 'admin@oneschool.sch.id')->first();
        $this->guru = User::where('email', 'guru@oneschool.sch.id')->first();
    }

    public function test_admin_can_view_all_data_master_indexes(): void
    {
        $routes = [
            'admin.academic-years.index',
            'admin.teachers.index',
            'admin.classrooms.index',
            'admin.students.index',
            'admin.subjects.index',
            'admin.rooms.index',
            'admin.internship-companies.index',
        ];

        foreach ($routes as $route) {
            $response = $this->actingAs($this->admin)->get(route($route));
            $response->assertStatus(200);
        }
    }

    public function test_non_admin_cannot_access_data_master(): void
    {
        $response = $this->actingAs($this->guru)->get(route('admin.academic-years.index'));
        $response->assertStatus(403);
    }

    public function test_admin_can_create_and_set_active_academic_year(): void
    {
        $data = [
            'name' => '2027/2028',
            'start_date' => '2027-07-15',
            'end_date' => '2027-12-20',
            'semester' => 'ganjil',
            'is_active' => '1',
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.academic-years.store'), $data);

        $response->assertRedirect(route('admin.academic-years.index'));
        $this->assertDatabaseHas('academic_years', [
            'name' => '2027/2028',
            'is_active' => true,
        ]);

        // Previous active academic year should be deactivated
        $previousYear = AcademicYear::where('name', '2026/2027')->first();
        $this->assertFalse((bool) $previousYear->is_active);

        // Can switch active back
        $setActiveResponse = $this->actingAs($this->admin)
            ->post(route('admin.academic-years.set-active', $previousYear));
        $setActiveResponse->assertRedirect(route('admin.academic-years.index'));
        $this->assertTrue((bool) $previousYear->fresh()->is_active);
    }

    public function test_admin_can_create_and_update_teacher(): void
    {
        // Create a new guru user
        $newGuruUser = User::create([
            'name' => 'Drs. Hendro Wibowo',
            'email' => 'hendro@oneschool.sch.id',
            'password' => bcrypt('password'),
            'is_active' => true,
        ]);
        $newGuruUser->assignRole('guru');

        $subject = Subject::first();

        $createData = [
            'user_id' => $newGuruUser->id,
            'nip' => '198501012010011005',
            'nuptk' => '8765432198765432',
            'gender' => 'L',
            'phone' => '081234567899',
            'address' => 'Jl. Pahlawan No. 45',
            'subject_ids' => [$subject->id],
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.teachers.store'), $createData);

        $response->assertRedirect(route('admin.teachers.index'));
        $this->assertDatabaseHas('teachers', [
            'user_id' => $newGuruUser->id,
            'nip' => '198501012010011005',
        ]);

        $createdTeacher = Teacher::where('user_id', $newGuruUser->id)->first();
        $this->assertTrue($createdTeacher->subjects->contains($subject->id));

        // Update
        $updateData = [
            'nip' => '198501012010011005',
            'nuptk' => '8765432198765432',
            'gender' => 'L',
            'phone' => '08999999999',
            'address' => 'Jl. Pahlawan No. 99 Baru',
            'subject_ids' => [],
        ];

        $updateResponse = $this->actingAs($this->admin)
            ->put(route('admin.teachers.update', $createdTeacher), $updateData);

        $updateResponse->assertRedirect(route('admin.teachers.index'));
        $this->assertDatabaseHas('teachers', [
            'id' => $createdTeacher->id,
            'phone' => '08999999999',
            'address' => 'Jl. Pahlawan No. 99 Baru',
        ]);
        $this->assertCount(0, $createdTeacher->fresh()->subjects);
    }

    public function test_admin_can_create_and_update_classroom(): void
    {
        $year = AcademicYear::first();
        $teacher = Teacher::first();

        $data = [
            'name' => 'X MM 1',
            'grade_level' => 10,
            'major' => 'Multimedia',
            'academic_year_id' => $year->id,
            'teacher_id' => $teacher->id,
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.classrooms.store'), $data);

        $response->assertRedirect(route('admin.classrooms.index'));
        $this->assertDatabaseHas('classrooms', [
            'name' => 'X MM 1',
            'major' => 'Multimedia',
            'teacher_id' => $teacher->id,
        ]);

        $classroom = Classroom::where('name', 'X MM 1')->first();

        // Update
        $updateResponse = $this->actingAs($this->admin)
            ->put(route('admin.classrooms.update', $classroom), [
                'name' => 'X MM 1 (Unggulan)',
                'grade_level' => 10,
                'major' => 'Multimedia',
                'academic_year_id' => $year->id,
                'teacher_id' => null,
            ]);

        $updateResponse->assertRedirect(route('admin.classrooms.index'));
        $this->assertDatabaseHas('classrooms', [
            'id' => $classroom->id,
            'name' => 'X MM 1 (Unggulan)',
            'teacher_id' => null,
        ]);
    }

    public function test_admin_can_create_and_manage_students(): void
    {
        $classroom = Classroom::first();

        $studentData = [
            'nis' => '99001',
            'nisn' => '0099887766',
            'name' => 'Ahmad Fajar Pratama',
            'gender' => 'L',
            'classroom_id' => $classroom->id,
            'phone' => '081233344455',
            'address' => 'Jl. Merpati No. 12',
            'parent_name' => 'Bambang Pratama',
            'parent_phone' => '081299988877',
            'status' => 'aktif',
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.students.store'), $studentData);

        $response->assertRedirect(route('admin.students.index'));
        $this->assertDatabaseHas('students', [
            'nis' => '99001',
            'name' => 'Ahmad Fajar Pratama',
            'classroom_id' => $classroom->id,
        ]);

        $student = Student::where('nis', '99001')->first();

        // Update status to alumni
        $updateResponse = $this->actingAs($this->admin)
            ->put(route('admin.students.update', $student), array_merge($studentData, ['status' => 'alumni']));

        $updateResponse->assertRedirect(route('admin.students.index'));
        $this->assertEquals('alumni', $student->fresh()->status);
    }

    public function test_admin_can_create_and_update_subject(): void
    {
        $teachers = Teacher::take(2)->get();

        $subjectData = [
            'code' => 'AI-01',
            'name' => 'Dasar Artificial Intelligence',
            'description' => 'Mata pelajaran pengenalan kecerdasan buatan',
            'teacher_ids' => $teachers->pluck('id')->toArray(),
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.subjects.store'), $subjectData);

        $response->assertRedirect(route('admin.subjects.index'));
        $this->assertDatabaseHas('subjects', [
            'code' => 'AI-01',
            'name' => 'Dasar Artificial Intelligence',
        ]);

        $subject = Subject::where('code', 'AI-01')->first();
        $this->assertCount(2, $subject->teachers);
    }

    public function test_admin_can_create_and_update_room(): void
    {
        $roomData = [
            'code' => 'LAB-AI',
            'name' => 'Laboratorium Artificial Intelligence',
            'capacity' => 40,
            'description' => 'Komputer GPU RTX 4090',
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.rooms.store'), $roomData);

        $response->assertRedirect(route('admin.rooms.index'));
        $this->assertDatabaseHas('rooms', [
            'code' => 'LAB-AI',
            'capacity' => 40,
        ]);

        $room = Room::where('code', 'LAB-AI')->first();

        $deleteResponse = $this->actingAs($this->admin)
            ->delete(route('admin.rooms.destroy', $room));
        $deleteResponse->assertRedirect(route('admin.rooms.index'));
        $this->assertDatabaseMissing('rooms', ['id' => $room->id]);
    }

    public function test_admin_can_create_and_update_internship_company(): void
    {
        $companyData = [
            'name' => 'PT Google Cloud Indonesia',
            'address' => 'Gedung Pacific Century Place Lt. 45, SCBD Jakarta',
            'contact_person' => 'Dewi Lestari',
            'phone' => '02155667788',
            'email' => 'id-careers@google.com',
            'latitude' => -6.2255000,
            'longitude' => 106.8094000,
            'radius_meters' => 150,
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.internship-companies.store'), $companyData);

        $response->assertRedirect(route('admin.internship-companies.index'));
        $this->assertDatabaseHas('internship_companies', [
            'name' => 'PT Google Cloud Indonesia',
            'radius_meters' => 150,
        ]);
    }

    public function test_validation_prevents_duplicate_codes_and_nis(): void
    {
        // Existing subject code
        $existingSubject = Subject::first();
        $response = $this->actingAs($this->admin)
            ->post(route('admin.subjects.store'), [
                'code' => $existingSubject->code,
                'name' => 'Mapel Duplikat',
            ]);
        $response->assertSessionHasErrors('code');

        // Existing student NIS
        $existingStudent = Student::first();
        $studentResponse = $this->actingAs($this->admin)
            ->post(route('admin.students.store'), [
                'nis' => $existingStudent->nis,
                'name' => 'Siswa Duplikat',
                'gender' => 'L',
                'status' => 'aktif',
            ]);
        $studentResponse->assertSessionHasErrors('nis');
    }
}
