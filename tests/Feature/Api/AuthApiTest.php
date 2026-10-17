<?php

namespace Tests\Feature\Api;

use App\Models\Student;
use App\Models\User;
use Database\Seeders\DataMasterSeeder;
use Database\Seeders\RoleAndPermissionSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleAndPermissionSeeder::class);
        $this->seed(UserSeeder::class);
        $this->seed(DataMasterSeeder::class);
    }

    public function test_student_can_login_with_nis(): void
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'login' => '20261201', // NIS of Fajar Hidayat
            'password' => 'password',
            'device_name' => 'Pixel 8 Pro',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'token',
                    'token_type',
                    'user' => [
                        'id',
                        'name',
                        'email',
                        'roles',
                        'student' => [
                            'id',
                            'nis',
                            'name',
                            'classroom',
                        ],
                    ],
                ],
            ]);

        $this->assertTrue($response->json('success'));
        $this->assertEquals('20261201', $response->json('data.user.student.nis'));
        $this->assertNotEmpty($response->json('data.token'));
    }

    public function test_teacher_can_login_with_email(): void
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'login' => 'guru@oneschool.sch.id',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.user.email', 'guru@oneschool.sch.id');

        $this->assertContains('guru', $response->json('data.user.roles'));
    }

    public function test_invalid_password_returns_422(): void
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'login' => '20261201',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(422)
            ->assertJsonPath('success', false);
    }

    public function test_inactive_user_cannot_login(): void
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'login' => 'nonaktif@oneschool.sch.id',
            'password' => 'password',
        ]);

        $response->assertStatus(403)
            ->assertJsonPath('success', false);
    }

    public function test_authenticated_user_can_get_profile(): void
    {
        $user = User::where('email', 'pembimbing@oneschool.sch.id')->first();
        $token = $user->createToken('test')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/v1/auth/me');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.email', 'pembimbing@oneschool.sch.id');
    }

    public function test_authenticated_user_can_logout(): void
    {
        $user = User::where('email', 'pembimbing@oneschool.sch.id')->first();
        $token = $user->createToken('test')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/v1/auth/logout');

        $response->assertStatus(200)
            ->assertJsonPath('success', true);

        $this->assertCount(0, $user->fresh()->tokens);
    }
}
