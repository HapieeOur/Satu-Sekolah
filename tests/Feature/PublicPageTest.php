<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Database\Seeders\PostSeeder;
use Database\Seeders\RoleAndPermissionSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPageTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected User $guru;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleAndPermissionSeeder::class);
        $this->seed(UserSeeder::class);
        $this->seed(PostSeeder::class);

        $this->admin = User::where('email', 'admin@oneschool.sch.id')->first();
        $this->guru = User::where('email', 'guru@oneschool.sch.id')->first();
    }

    public function test_guest_can_access_home_page(): void
    {
        $response = $this->get(route('public.home'));

        $response->assertStatus(200);
        $response->assertSee('Satu-Sekolah');
        $response->assertSee('Portal Resmi Sistem Informasi Satu-Sekolah');
        $response->assertSee('Masuk Portal Guru & Admin', false);
        $response->assertSee('STATISTIK & KINERJA SATU-SEKOLAH', false);
        $response->assertSee('Peserta Didik Aktif');
        $response->assertSee('Guru &amp; Instruktur Ahli', false);
        $response->assertSee('Mitra Industri Aktif');
        $response->assertSee('Rombel &amp; Laboratorium', false);
    }

    public function test_public_profile_displays_institution_statistics_strip(): void
    {
        $response = $this->get(route('public.profile'));

        $response->assertStatus(200);
        $response->assertSee('Akreditasi A');
        $response->assertSee('Standar Mutu Pendidikan Nasional Unggul');
        $response->assertSee('Siswa Vokasi Berprestasi Terdaftar');
    }

    public function test_authenticated_user_sees_dashboard_link_on_public_home(): void
    {
        $response = $this->actingAs($this->guru)->get(route('public.home'));

        $response->assertStatus(200);
        $response->assertSee('Ke Dashboard');
    }

    public function test_guest_can_access_school_profile_page(): void
    {
        $response = $this->get(route('public.profile'));

        $response->assertStatus(200);
        $response->assertSee('Profil Satu-Sekolah');
        $response->assertSee('Visi Institusi');
        $response->assertSee('Misi Institusi');
        $response->assertSee('Rekayasa Perangkat Lunak (RPL)');
    }

    public function test_guest_can_access_news_listing(): void
    {
        $response = $this->get(route('public.news'));

        $response->assertStatus(200);
        $response->assertSee('Kabar &amp; Berita Sekolah', false);
    }

    public function test_guest_can_view_single_published_news(): void
    {
        $news = Post::create([
            'title' => 'Liputan Kegiatan Prakerin Angkatan 2026',
            'slug' => 'liputan-kegiatan-prakerin-angkatan-2026',
            'category' => 'berita',
            'content' => '<p>Seluruh siswa telah tiba di lokasi magang dengan selamat dan siap belajar.</p>',
            'is_published' => true,
            'published_at' => now(),
            'user_id' => $this->admin->id,
        ]);

        $response = $this->get(route('public.news.show', $news->slug));

        $response->assertStatus(200);
        $response->assertSee('Liputan Kegiatan Prakerin Angkatan 2026');
        $response->assertSee('Seluruh siswa telah tiba di lokasi magang');
    }

    public function test_draft_news_returns_404_for_public(): void
    {
        $draftNews = Post::create([
            'title' => 'Draft Berita Rahasia',
            'slug' => 'draft-berita-rahasia',
            'category' => 'berita',
            'content' => '<p>Konten ini masih berupa draf.</p>',
            'is_published' => false,
            'user_id' => $this->admin->id,
        ]);

        $response = $this->get(route('public.news.show', $draftNews->slug));

        $response->assertStatus(404);
    }

    public function test_guest_can_access_announcements_listing(): void
    {
        $response = $this->get(route('public.announcements'));

        $response->assertStatus(200);
        $response->assertSee('Papan Pengumuman Resmi');
    }

    public function test_guest_can_view_single_published_announcement(): void
    {
        $announcement = Post::create([
            'title' => 'Edaran Libur Semester Ganjil',
            'slug' => 'edaran-libur-semester-ganjil',
            'category' => 'pengumuman',
            'content' => '<p>Diumumkan kepada seluruh sivitas bahwa libur dimulai pekan depan.</p>',
            'is_published' => true,
            'published_at' => now(),
            'user_id' => $this->admin->id,
        ]);

        $response = $this->get(route('public.announcements.show', $announcement->slug));

        $response->assertStatus(200);
        $response->assertSee('Edaran Libur Semester Ganjil');
        $response->assertSee('Diumumkan kepada seluruh sivitas bahwa libur dimulai pekan depan');
    }

    public function test_guest_can_access_events_listing(): void
    {
        $response = $this->get(route('public.events'));

        $response->assertStatus(200);
        $response->assertSee('Agenda &amp; Acara Sekolah', false);
    }

    public function test_guest_can_view_single_published_event(): void
    {
        $event = Post::create([
            'title' => 'Workshop UI UX Pro Max SMK',
            'slug' => 'workshop-ui-ux-pro-max-smk',
            'category' => 'acara',
            'content' => '<p>Pelatihan desain antarmuka bagi siswa jurusan Rekayasa Perangkat Lunak.</p>',
            'event_date' => now()->addDays(14)->toDateString(),
            'event_time' => '09:00:00',
            'event_location' => 'Auditorium Lab Komputer 1',
            'is_published' => true,
            'published_at' => now(),
            'user_id' => $this->admin->id,
        ]);

        $response = $this->get(route('public.events.show', $event->slug));

        $response->assertStatus(200);
        $response->assertSee('Workshop UI UX Pro Max SMK');
        $response->assertSee('Auditorium Lab Komputer 1');
    }
}
