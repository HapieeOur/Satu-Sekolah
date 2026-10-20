<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected User $guru;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleAndPermissionSeeder::class);
        $this->seed(UserSeeder::class);

        $this->admin = User::where('email', 'admin@oneschool.sch.id')->first();
        $this->guru = User::where('email', 'guru@oneschool.sch.id')->first();
    }

    public function test_admin_can_view_users_list(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.users.index'));

        $response->assertStatus(200);
        $response->assertSee('Daftar Akun Pengguna');
        $response->assertSee($this->admin->email);
        $response->assertSee($this->guru->email);
    }

    public function test_admin_can_search_and_filter_users(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.users.index', ['search' => 'Budi']));

        $response->assertStatus(200);
        $response->assertSee('Budi Santoso');

        $filterResponse = $this->actingAs($this->admin)
            ->get(route('admin.users.index', ['role' => 'wali_kelas']));

        $filterResponse->assertStatus(200);
        $filterResponse->assertSee('Siti Rahmawati');
    }

    public function test_admin_can_search_user_by_nis_or_nisn(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.users.index', ['search' => '0071234567']));

        $response->assertStatus(200);
        $response->assertSee('Aditya Pratama');
        $response->assertSee('NISN: 0071234567');
    }

    public function test_admin_can_create_student_user_with_nis_and_nisn(): void
    {
        $studentData = [
            'name' => 'Siswa Baru Berbakat',
            'email' => 'siswabaru@oneschool.sch.id',
            'phone' => '087711223344',
            'nis' => '20261999',
            'nisn' => '0079998888',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'roles' => ['siswa'],
            'is_active' => '1',
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.users.store'), $studentData);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'email' => 'siswabaru@oneschool.sch.id',
            'nis' => '20261999',
            'nisn' => '0079998888',
        ]);

        $this->assertDatabaseHas('students', [
            'nis' => '20261999',
            'nisn' => '0079998888',
            'name' => 'Siswa Baru Berbakat',
        ]);
    }

    public function test_admin_can_create_new_user(): void
    {
        $userData = [
            'name' => 'Guru Baru, S.Kom',
            'email' => 'gurubaru@oneschool.sch.id',
            'phone' => '089988776655',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'roles' => ['guru', 'wali_kelas'],
            'is_active' => '1',
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.users.store'), $userData);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'email' => 'gurubaru@oneschool.sch.id',
            'name' => 'Guru Baru, S.Kom',
        ]);

        $newUser = User::where('email', 'gurubaru@oneschool.sch.id')->first();
        $this->assertTrue($newUser->hasRole('guru'));
        $this->assertTrue($newUser->hasRole('wali_kelas'));
    }

    public function test_admin_can_update_user(): void
    {
        $updateData = [
            'name' => 'Budi Santoso Update, M.Pd.',
            'email' => 'guru.update@oneschool.sch.id',
            'phone' => '081299999999',
            'roles' => ['guru', 'guru_pembimbing_pkl'],
            'is_active' => '1',
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('admin.users.update', $this->guru), $updateData);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'id' => $this->guru->id,
            'name' => 'Budi Santoso Update, M.Pd.',
            'email' => 'guru.update@oneschool.sch.id',
        ]);

        $freshGuru = $this->guru->fresh();
        $this->assertTrue($freshGuru->hasRole('guru_pembimbing_pkl'));
    }

    public function test_admin_can_toggle_user_status(): void
    {
        $this->assertTrue($this->guru->is_active);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.users.toggle-status', $this->guru));

        $response->assertRedirect();
        $this->assertFalse($this->guru->fresh()->is_active);

        // Toggle back
        $this->actingAs($this->admin)
            ->post(route('admin.users.toggle-status', $this->guru));

        $this->assertTrue($this->guru->fresh()->is_active);
    }

    public function test_admin_cannot_deactivate_or_delete_self(): void
    {
        // Toggle self status is forbidden by Policy
        $this->actingAs($this->admin)
            ->post(route('admin.users.toggle-status', $this->admin))
            ->assertStatus(403);

        $this->assertTrue($this->admin->fresh()->is_active);

        // Delete self is forbidden by Policy
        $this->actingAs($this->admin)
            ->delete(route('admin.users.destroy', $this->admin))
            ->assertStatus(403);

        $this->assertDatabaseHas('users', ['id' => $this->admin->id]);
    }

    public function test_admin_can_delete_other_user(): void
    {
        $response = $this->actingAs($this->admin)
            ->delete(route('admin.users.destroy', $this->guru));

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseMissing('users', ['id' => $this->guru->id]);
    }
}
