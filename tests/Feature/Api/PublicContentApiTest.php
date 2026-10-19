<?php

namespace Tests\Feature\Api;

use App\Models\Post;
use Database\Seeders\DataMasterSeeder;
use Database\Seeders\PostSeeder;
use Database\Seeders\RoleAndPermissionSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicContentApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleAndPermissionSeeder::class);
        $this->seed(UserSeeder::class);
        $this->seed(DataMasterSeeder::class);
        $this->seed(PostSeeder::class);
    }

    public function test_can_list_published_news(): void
    {
        $response = $this->getJson('/api/v1/posts/news');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'slug',
                        'category',
                        'published_at',
                    ],
                ],
                'meta' => [
                    'current_page',
                    'total',
                ],
            ]);
    }

    public function test_can_get_single_news_by_slug(): void
    {
        $news = Post::published()->news()->first();

        $response = $this->getJson("/api/v1/posts/news/{$news->slug}");

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.slug', $news->slug)
            ->assertJsonPath('data.title', $news->title);
    }

    public function test_can_list_announcements(): void
    {
        $response = $this->getJson('/api/v1/posts/announcements');

        $response->assertStatus(200)
            ->assertJsonPath('success', true);
    }

    public function test_can_list_events(): void
    {
        $response = $this->getJson('/api/v1/posts/events');

        $response->assertStatus(200)
            ->assertJsonPath('success', true);
    }

    public function test_can_get_school_profile_and_stats(): void
    {
        $response = $this->getJson('/api/v1/school/profile');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'data' => [
                    'school_name',
                    'academic_year',
                    'statistics' => [
                        'total_students',
                        'total_teachers',
                        'total_classrooms',
                        'total_companies',
                    ],
                ],
            ]);
    }
}
