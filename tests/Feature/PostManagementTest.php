<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Database\Seeders\PostSeeder;
use Database\Seeders\RoleAndPermissionSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostManagementTest extends TestCase
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

    public function test_guest_cannot_access_admin_posts(): void
    {
        $response = $this->get(route('admin.posts.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_user_without_permission_cannot_access_admin_posts(): void
    {
        $response = $this->actingAs($this->guru)->get(route('admin.posts.index'));

        $response->assertStatus(403);
    }

    public function test_admin_can_view_posts_index(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.posts.index'));

        $response->assertStatus(200);
        $response->assertSee('Berita, Pengumuman');
        $response->assertSee('Tulis Konten Baru');
    }

    public function test_admin_can_create_news_post(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.posts.store'), [
            'title' => 'Siswa SMK Raih Juara 1 LKS Tingkat Nasional',
            'category' => 'berita',
            'excerpt' => 'Prestasi membanggakan kembali ditorehkan oleh siswa SMK Satu Sekolah.',
            'content' => 'Konten lengkap mengenai kemenangan dalam ajang LKS bidang Web Technologies.',
            'is_published' => true,
        ]);

        $response->assertRedirect(route('admin.posts.index'));
        $this->assertDatabaseHas('posts', [
            'title' => 'Siswa SMK Raih Juara 1 LKS Tingkat Nasional',
            'category' => 'berita',
            'is_published' => true,
        ]);
    }

    public function test_admin_can_create_event_post(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.posts.store'), [
            'title' => 'Workshop Industri: Cloud Computing bersama AWS',
            'category' => 'acara',
            'excerpt' => 'Pelatihan intensif cloud computing bagi siswa tingkat akhir.',
            'content' => 'Uraian agenda workshop teknis dari pengenalan EC2 hingga S3.',
            'event_date' => now()->addDays(14)->toDateString(),
            'event_time' => '09:00',
            'event_location' => 'Laboratorium Cloud Computing',
            'is_published' => true,
        ]);

        $response->assertRedirect(route('admin.posts.index'));
        $this->assertDatabaseHas('posts', [
            'title' => 'Workshop Industri: Cloud Computing bersama AWS',
            'category' => 'acara',
            'event_location' => 'Laboratorium Cloud Computing',
        ]);
    }

    public function test_admin_can_edit_post(): void
    {
        $post = Post::first();
        $this->assertNotNull($post);

        $response = $this->actingAs($this->admin)->put(route('admin.posts.update', $post->id), [
            'title' => 'Judul Konten Diperbarui',
            'category' => $post->category,
            'content' => 'Konten baru yang sudah direvisi.',
            'is_published' => $post->is_published,
        ]);

        $response->assertRedirect(route('admin.posts.index'));
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Judul Konten Diperbarui',
        ]);
    }

    public function test_admin_can_toggle_publish_status(): void
    {
        $post = Post::where('is_published', true)->first();
        $this->assertNotNull($post);

        // Toggle to unpublished
        $response = $this->actingAs($this->admin)->post(route('admin.posts.toggle-publish', $post->id));
        $response->assertSessionHas('success');

        $post->refresh();
        $this->assertFalse($post->is_published);
        $this->assertNull($post->published_at);

        // Toggle back to published
        $response = $this->actingAs($this->admin)->post(route('admin.posts.toggle-publish', $post->id));
        $response->assertSessionHas('success');

        $post->refresh();
        $this->assertTrue($post->is_published);
        $this->assertNotNull($post->published_at);
    }

    public function test_admin_can_delete_post(): void
    {
        $post = Post::first();
        $this->assertNotNull($post);

        $response = $this->actingAs($this->admin)->delete(route('admin.posts.destroy', $post->id));

        $response->assertRedirect(route('admin.posts.index'));
        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
        ]);
    }
}
