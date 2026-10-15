<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected User $guru;

    protected User $waliKelas;

    protected User $pembimbing;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleAndPermissionSeeder::class);
        $this->seed(UserSeeder::class);

        $this->admin = User::where('email', 'admin@oneschool.sch.id')->first();
        $this->guru = User::where('email', 'guru@oneschool.sch.id')->first();
        $this->waliKelas = User::where('email', 'walikelas@oneschool.sch.id')->first();
        $this->pembimbing = User::where('email', 'pembimbing@oneschool.sch.id')->first();
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
        $this->get('/admin/dashboard')->assertRedirect('/login');
        $this->get('/admin/users')->assertRedirect('/login');
        $this->get('/teacher/dashboard')->assertRedirect('/login');
        $this->get('/homeroom/dashboard')->assertRedirect('/login');
        $this->get('/internship-mentor/dashboard')->assertRedirect('/login');
    }

    public function test_guru_cannot_access_admin_dashboard_or_users_management(): void
    {
        $this->actingAs($this->guru)
            ->get('/admin/dashboard')
            ->assertStatus(403);

        $this->actingAs($this->guru)
            ->get('/admin/users')
            ->assertStatus(403);

        $this->actingAs($this->guru)
            ->post('/admin/users', ['name' => 'Hack'])
            ->assertStatus(403);
    }

    public function test_wali_kelas_can_access_homeroom_dashboard(): void
    {
        $this->actingAs($this->waliKelas)
            ->get('/homeroom/dashboard')
            ->assertStatus(200)
            ->assertSee('Portal Wali Kelas');

        // But cannot access admin
        $this->actingAs($this->waliKelas)
            ->get('/admin/dashboard')
            ->assertStatus(403);
    }

    public function test_pembimbing_can_access_mentor_dashboard(): void
    {
        $this->actingAs($this->pembimbing)
            ->get('/internship-mentor/dashboard')
            ->assertStatus(200)
            ->assertSee('Portal Pembimbing PKL');

        // But cannot access admin
        $this->actingAs($this->pembimbing)
            ->get('/admin/dashboard')
            ->assertStatus(403);
    }

    public function test_authenticated_inactive_user_is_logged_out_by_middleware(): void
    {
        $this->guru->update(['is_active' => false]);

        $response = $this->actingAs($this->guru)
            ->get('/teacher/dashboard');

        $this->assertGuest();
        $response->assertRedirect('/login');
    }
}
