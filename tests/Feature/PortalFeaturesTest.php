<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortalFeaturesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleAndPermissionSeeder::class);
        $this->seed(UserSeeder::class);
    }

    public function test_all_account_roles_can_access_own_profile(): void
    {
        $roles = [
            'admin@oneschool.sch.id',
            'guru@oneschool.sch.id',
            'walikelas@oneschool.sch.id',
            'pembimbing@oneschool.sch.id',
        ];

        foreach ($roles as $email) {
            $user = User::where('email', $email)->first();
            $response = $this->actingAs($user)->get(route('profile.show'));

            $response->assertStatus(200);
            $response->assertSee('Profil Akun Saya');
            $response->assertSee($user->name);
        }
    }

    public function test_user_can_update_profile_information(): void
    {
        $user = User::where('email', 'admin@oneschool.sch.id')->first();

        $response = $this->actingAs($user)->put(route('profile.update'), [
            'name' => 'Administrator Utama Updated',
            'email' => 'admin_updated@oneschool.sch.id',
        ]);

        $response->assertRedirect(route('profile.show'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Administrator Utama Updated',
            'email' => 'admin_updated@oneschool.sch.id',
        ]);
    }

    public function test_all_roles_can_access_notifications_center(): void
    {
        $user = User::where('email', 'guru@oneschool.sch.id')->first();

        $response = $this->actingAs($user)->get(route('notifications.index'));

        $response->assertStatus(200);
        $response->assertSee('Pusat Notifikasi');
        $response->assertSee('Pengumuman');
    }

    public function test_user_can_mark_notifications_as_read(): void
    {
        $user = User::where('email', 'admin@oneschool.sch.id')->first();

        $response = $this->actingAs($user)->post(route('notifications.mark-all-read'));

        $response->assertSessionHas('success');
        $this->assertNotNull(session('last_notifications_read_at'));
    }

    public function test_search_page_and_api_return_results(): void
    {
        $user = User::where('email', 'admin@oneschool.sch.id')->first();

        // 1. Search Page
        $pageResponse = $this->actingAs($user)->get(route('search.index', ['q' => 'Admin']));
        $pageResponse->assertStatus(200);
        $pageResponse->assertSee('Pencarian Data Portal');

        // 2. Search Autocomplete API
        $apiResponse = $this->actingAs($user)->get(route('search.api', ['q' => 'Guru']));
        $apiResponse->assertStatus(200);
        $apiResponse->assertJsonStructure(['items']);
    }

    public function test_login_page_renders_with_high_contrast_and_proper_assets(): void
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertSee('images/logo/logo.png');
        $response->assertSee('images/logo/icon.png');
        $response->assertSee('Masuk ke Portal');
        $response->assertSee('A Unified Hub for Smarter School Decision-Making');
    }
}
