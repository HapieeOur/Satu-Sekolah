<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Database\Seeders\PostSeeder;
use Database\Seeders\RoleAndPermissionSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleAndPermissionSeeder::class);
        $this->seed(UserSeeder::class);
        $this->seed(PostSeeder::class);
    }

    public function test_public_home_page_can_be_rendered_without_authentication(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Satu-Sekolah');
        $response->assertSee('Portal Resmi Institusi Pendidikan');
        $response->assertSee('Kabar & Berita Terkini', false);
        $response->assertSee('Pengumuman');
        $response->assertSee('Agenda Acara Sekolah');
    }

    public function test_public_profile_page_can_be_rendered(): void
    {
        $response = $this->get('/profil');

        $response->assertStatus(200);
        $response->assertSee('Profil Institusi Sekolah');
        $response->assertSee('Visi Institusi');
        $response->assertSee('Misi Utama');
    }

    public function test_public_news_listing_and_detail_can_be_accessed(): void
    {
        $response = $this->get('/berita');
        $response->assertStatus(200);
        $response->assertSee('Kabar & Berita Terkini', false);

        $news = Post::published()->news()->first();
        $detailResponse = $this->get('/berita/'.$news->slug);
        $detailResponse->assertStatus(200);
        $detailResponse->assertSee($news->title);
    }

    public function test_public_announcements_listing_and_detail_can_be_accessed(): void
    {
        $response = $this->get('/pengumuman');
        $response->assertStatus(200);
        $response->assertSee('Pengumuman Sekolah');

        $announcement = Post::published()->announcements()->first();
        $detailResponse = $this->get('/pengumuman/'.$announcement->slug);
        $detailResponse->assertStatus(200);
        $detailResponse->assertSee($announcement->title);
    }

    public function test_public_events_listing_and_detail_can_be_accessed(): void
    {
        $response = $this->get('/acara');
        $response->assertStatus(200);
        $response->assertSee('Agenda Acara Sekolah');

        $event = Post::published()->events()->first();
        $detailResponse = $this->get('/acara/'.$event->slug);
        $detailResponse->assertStatus(200);
        $detailResponse->assertSee($event->title);
    }

    public function test_unpublished_draft_posts_are_never_visible_to_public(): void
    {
        $draft = Post::where('is_published', false)->first();
        $this->assertNotNull($draft);

        // Should return 404
        $this->get('/pengumuman/'.$draft->slug)->assertStatus(404);
        $this->get('/berita/'.$draft->slug)->assertStatus(404);

        // Should not appear on public home page
        $this->get('/')->assertDontSee($draft->title);
    }

    public function test_future_scheduled_posts_are_never_visible_to_public(): void
    {
        $future = Post::where('published_at', '>', Carbon::now())->first();
        $this->assertNotNull($future);

        // Should return 404
        $this->get('/berita/'.$future->slug)->assertStatus(404);

        // Should not appear on public home page
        $this->get('/')->assertDontSee($future->title);
    }

    public function test_authenticated_user_sees_dashboard_button_in_navbar(): void
    {
        $admin = User::where('email', 'admin@oneschool.sch.id')->first();

        $response = $this->actingAs($admin)->get('/');

        $response->assertStatus(200);
        $response->assertSee('Buka Dashboard');
    }

    public function test_guest_cannot_access_internal_dashboard_directly(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
        $this->get('/admin/dashboard')->assertRedirect('/login');
    }
}
