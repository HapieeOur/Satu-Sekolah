<?php

namespace Tests\Feature;

use App\Mail\PasswordChangedMail;
use App\Mail\ResetPasswordOtpMail;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleAndPermissionSeeder::class);
        $this->seed(UserSeeder::class);
    }

    public function test_forgot_password_page_can_be_rendered(): void
    {
        $response = $this->get(route('password.request'));

        $response->assertStatus(200);
        $response->assertSee('Lupa Kata Sandi?');
        $response->assertSee('Kirim Kode OTP');
    }

    public function test_cannot_request_otp_for_unregistered_email(): void
    {
        $response = $this->post(route('password.email'), [
            'email' => 'tidakada@sekolah.sch.id',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_user_can_request_otp_and_receive_email(): void
    {
        Mail::fake();

        $user = User::where('email', 'admin@oneschool.sch.id')->first();

        $response = $this->post(route('password.email'), [
            'email' => $user->email,
        ]);

        $response->assertRedirect(route('password.otp'));
        $this->assertEquals($user->email, session('password_reset_email'));

        // Assert OTP stored in database
        $record = DB::table('password_reset_tokens')->where('email', $user->email)->first();
        $this->assertNotNull($record);
        $this->assertEquals(6, strlen($record->token));

        // Assert mail was sent
        Mail::assertSent(ResetPasswordOtpMail::class, function ($mail) use ($user, $record) {
            return $mail->hasTo($user->email) && $mail->otp === $record->token;
        });
    }

    public function test_verify_otp_fails_with_invalid_otp(): void
    {
        $user = User::where('email', 'admin@oneschool.sch.id')->first();

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            ['token' => '123456', 'created_at' => now()]
        );

        $response = $this->withSession(['password_reset_email' => $user->email])
            ->post(route('password.verify-otp'), [
                'otp' => '999999',
            ]);

        $response->assertSessionHasErrors('otp');
    }

    public function test_user_can_resend_otp(): void
    {
        Mail::fake();

        $user = User::where('email', 'admin@oneschool.sch.id')->first();

        $response = $this->withSession(['password_reset_email' => $user->email])
            ->post(route('password.resend-otp'));

        $response->assertSessionHas('success');

        Mail::assertSent(ResetPasswordOtpMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    public function test_user_can_verify_valid_otp_and_reset_password(): void
    {
        Mail::fake();

        $user = User::where('email', 'guru@oneschool.sch.id')->first();
        $otp = '456789';

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            ['token' => $otp, 'created_at' => now()]
        );

        // 1. Verify OTP
        $verifyResponse = $this->withSession(['password_reset_email' => $user->email])
            ->post(route('password.verify-otp'), [
                'otp' => $otp,
            ]);

        $this->assertTrue(session('password_reset_verified'));
        $resetToken = session('password_reset_token');
        $this->assertNotEmpty($resetToken);
        $verifyResponse->assertRedirect(route('password.reset', ['token' => $resetToken]));

        // 2. Open reset password form
        $formResponse = $this->withSession(['password_reset_email' => $user->email])
            ->get(route('password.reset', ['token' => $resetToken]));
        $formResponse->assertStatus(200);
        $formResponse->assertSee('Buat Kata Sandi Baru');

        // 3. Submit new password
        $resetResponse = $this->post(route('password.update'), [
            'token' => $resetToken,
            'email' => $user->email,
            'password' => 'PasswordBaru123!',
            'password_confirmation' => 'PasswordBaru123!',
        ]);

        $resetResponse->assertRedirect(route('login'));
        $resetResponse->assertSessionHas('success');

        // Assert user password has changed
        $user->refresh();
        $this->assertTrue(Hash::check('PasswordBaru123!', $user->password));

        // Assert confirmation email sent
        Mail::assertSent(PasswordChangedMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });

        // Assert token was deleted
        $this->assertDatabaseMissing('password_reset_tokens', ['email' => $user->email]);

        // 4. User can authenticate with the new password
        $loginResponse = $this->post(route('login.post'), [
            'email' => $user->email,
            'password' => 'PasswordBaru123!',
        ]);
        $this->assertAuthenticatedAs($user);
        $loginResponse->assertRedirect(route('dashboard'));
    }

    public function test_cannot_reset_password_using_the_same_previous_password(): void
    {
        $user = User::where('email', 'admin@oneschool.sch.id')->first();
        $resetToken = 'valid-test-token-456';

        DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => $resetToken,
            'created_at' => now(),
        ]);

        // Attempt to reset with existing password ('password')
        $response = $this->post(route('password.update'), [
            'token' => $resetToken,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertEquals(
            'Kata sandi baru tidak boleh sama dengan kata sandi lama Anda saat ini. Silakan buat kata sandi yang berbeda.',
            session('errors')->first('password')
        );

        // Password remains unchanged
        $user->refresh();
        $this->assertTrue(Hash::check('password', $user->password));
    }

    public function test_login_page_has_no_demo_buttons_or_oauth_and_has_forgot_password(): void
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertDontSee('Akun Demo');
        $response->assertDontSee('fillCredentials');
        $response->assertDontSee('Masuk dengan Google');
        $response->assertSee('Lupa kata sandi?');
    }
}
