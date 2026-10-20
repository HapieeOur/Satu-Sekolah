<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleAndPermissionSeeder::class);
        $this->seed(UserSeeder::class);
    }

    public function test_login_page_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Satu-Sekolah');
        $response->assertSee('Masuk ke Portal');
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@oneschool.sch.id',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
    }

    public function test_students_can_authenticate_using_nisn(): void
    {
        $studentUser = User::where('email', 'siswa@oneschool.sch.id')->first();
        $this->assertNotNull($studentUser);
        $this->assertEquals('0071234567', $studentUser->nisn);

        $response = $this->post('/login', [
            'email' => '0071234567',
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($studentUser);
        $response->assertRedirect('/dashboard');
    }

    public function test_students_can_authenticate_using_nis(): void
    {
        $studentUser = User::where('email', 'siswa@oneschool.sch.id')->first();
        $this->assertNotNull($studentUser);
        $this->assertEquals('20241001', $studentUser->nis);

        $response = $this->post('/login', [
            'email' => '20241001',
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($studentUser);
        $response->assertRedirect('/dashboard');
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $this->post('/login', [
            'email' => 'admin@oneschool.sch.id',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_inactive_users_can_not_authenticate(): void
    {
        $response = $this->post('/login', [
            'email' => 'nonaktif@oneschool.sch.id',
            'password' => 'password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    public function test_authenticated_user_is_redirected_to_appropriate_dashboard_by_role(): void
    {
        // 1. Admin to admin dashboard
        $admin = User::where('email', 'admin@oneschool.sch.id')->first();
        $this->actingAs($admin)
            ->get('/dashboard')
            ->assertRedirect(route('admin.dashboard'));

        // 2. Guru to teacher dashboard
        $guru = User::where('email', 'guru@oneschool.sch.id')->first();
        $this->actingAs($guru)
            ->get('/dashboard')
            ->assertRedirect(route('teacher.dashboard'));

        // 3. Wali Kelas to homeroom dashboard
        $waliKelas = User::where('email', 'walikelas@oneschool.sch.id')->first();
        $this->actingAs($waliKelas)
            ->get('/dashboard')
            ->assertRedirect(route('homeroom.dashboard'));

        // 4. Pembimbing PKL to internship mentor dashboard
        $pembimbing = User::where('email', 'pembimbing@oneschool.sch.id')->first();
        $this->actingAs($pembimbing)
            ->get('/dashboard')
            ->assertRedirect(route('internship-mentor.dashboard'));

        // 5. Siswa to student dashboard
        $siswa = User::where('email', 'siswa@oneschool.sch.id')->first();
        $this->actingAs($siswa)
            ->get('/dashboard')
            ->assertRedirect(route('student.dashboard'));
    }

    public function test_users_can_logout(): void
    {
        $admin = User::where('email', 'admin@oneschool.sch.id')->first();

        $response = $this->actingAs($admin)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/login');
    }
}
