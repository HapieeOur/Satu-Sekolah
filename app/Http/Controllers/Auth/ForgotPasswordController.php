<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordChangedMail;
use App\Mail\ResetPasswordOtpMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ForgotPasswordController extends Controller
{
    /**
     * Display the email input form to request OTP.
     */
    public function showForgotPasswordForm(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Send 6-digit OTP to user's registered email address.
     */
    public function sendOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()->withInput()->withErrors([
                'email' => 'Alamat email tidak terdaftar dalam sistem Satu-Sekolah.',
            ]);
        }

        if (! $user->is_active) {
            return back()->withInput()->withErrors([
                'email' => 'Akun Anda berstatus nonaktif. Silakan hubungi administrator sekolah.',
            ]);
        }

        // Generate 6-digit numeric OTP
        $otp = sprintf('%06d', random_int(100000, 999999));

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => $otp,
                'created_at' => now(),
            ]
        );

        session(['password_reset_email' => $user->email]);

        try {
            Mail::to($user->email)->send(new ResetPasswordOtpMail($otp, $user->name));
        } catch (\Throwable $e) {
            Log::error('Gagal mengirimkan email OTP: '.$e->getMessage());
        }

        return redirect()->route('password.otp')->with(
            'success',
            'Kode OTP 6-digit telah dikirimkan ke email '.Str::mask($user->email, '*', 3, -4).'. Silakan periksa kotak masuk atau spam.'
        );
    }

    /**
     * Display the OTP verification screen.
     */
    public function showVerifyOtpForm(): View|RedirectResponse
    {
        $email = session('password_reset_email');

        if (! $email) {
            return redirect()->route('password.request')->withErrors([
                'email' => 'Silakan masukkan alamat email Anda terlebih dahulu.',
            ]);
        }

        return view('auth.verify-otp', compact('email'));
    }

    /**
     * Verify the 6-digit OTP provided by the user.
     */
    public function verifyOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.size' => 'Kode OTP harus berupa 6 digit angka.',
        ]);

        $email = session('password_reset_email');

        if (! $email) {
            return redirect()->route('password.request')->withErrors([
                'email' => 'Sesi pemulihan telah berakhir. Silakan masukkan email Anda kembali.',
            ]);
        }

        $record = DB::table('password_reset_tokens')->where('email', $email)->first();

        if (! $record) {
            return back()->withErrors([
                'otp' => 'Permintaan kode OTP tidak ditemukan. Silakan ajukan ulang.',
            ]);
        }

        // Check if OTP has expired (10 minutes)
        if (Carbon::parse($record->created_at)->addMinutes(10)->isPast()) {
            return back()->withErrors([
                'otp' => 'Kode OTP telah kedaluwarsa (lebih dari 10 menit). Silakan kirim ulang kode OTP baru.',
            ]);
        }

        // Validate OTP match
        if (trim($record->token) !== trim($request->otp)) {
            return back()->withErrors([
                'otp' => 'Kode OTP yang Anda masukkan salah. Silakan periksa kembali email Anda.',
            ]);
        }

        // Generate verified token for the reset password step
        $resetToken = Str::random(64);
        DB::table('password_reset_tokens')->where('email', $email)->update([
            'token' => $resetToken,
            'created_at' => now(),
        ]);

        session([
            'password_reset_verified' => true,
            'password_reset_token' => $resetToken,
        ]);

        return redirect()->route('password.reset', ['token' => $resetToken])
            ->with('success', 'Kode OTP berhasil diverifikasi! Silakan buat kata sandi baru untuk akun Anda.');
    }

    /**
     * Resend a fresh OTP to the user's email.
     */
    public function resendOtp(): RedirectResponse
    {
        $email = session('password_reset_email');

        if (! $email) {
            return redirect()->route('password.request')->withErrors([
                'email' => 'Sesi telah berakhir. Silakan masukkan alamat email Anda kembali.',
            ]);
        }

        $user = User::where('email', $email)->first();

        if (! $user) {
            return redirect()->route('password.request')->withErrors([
                'email' => 'Pengguna tidak ditemukan.',
            ]);
        }

        $otp = sprintf('%06d', random_int(100000, 999999));

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'token' => $otp,
                'created_at' => now(),
            ]
        );

        try {
            Mail::to($email)->send(new ResetPasswordOtpMail($otp, $user->name));
        } catch (\Throwable $e) {
            Log::error('Gagal mengirim ulang OTP: '.$e->getMessage());
        }

        return back()->with('success', 'Kode OTP baru telah dikirimkan ke email Anda.');
    }

    /**
     * Display the create new password screen.
     */
    public function showResetPasswordForm(string $token): View|RedirectResponse
    {
        $email = session('password_reset_email');

        $record = DB::table('password_reset_tokens')
            ->where('token', $token)
            ->when($email, fn ($q) => $q->where('email', $email))
            ->first();

        if (! $record) {
            return redirect()->route('password.request')->withErrors([
                'email' => 'Token reset kata sandi tidak valid atau telah digunakan.',
            ]);
        }

        if (Carbon::parse($record->created_at)->addMinutes(30)->isPast()) {
            return redirect()->route('password.request')->withErrors([
                'email' => 'Sesi pengaturan ulang kata sandi telah kedaluwarsa. Silakan ulangi proses.',
            ]);
        }

        return view('auth.reset-password', [
            'token' => $token,
            'email' => $record->email,
        ]);
    }

    /**
     * Save the new password and notify user via email.
     */
    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ], [
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak sesuai.',
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (! $record) {
            return back()->withErrors([
                'email' => 'Token reset kata sandi tidak valid atau telah digunakan.',
            ]);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        // Validasi agar kata sandi baru tidak sama dengan kata sandi lama / saat ini
        if (Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Kata sandi baru tidak boleh sama dengan kata sandi lama Anda saat ini. Silakan buat kata sandi yang berbeda.',
            ]);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // Clean up token and session
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        session()->forget(['password_reset_email', 'password_reset_verified', 'password_reset_token']);

        // Send confirmation email
        try {
            Mail::to($user->email)->send(new PasswordChangedMail(
                $user->name,
                now()->translatedFormat('d F Y, H:i').' WIB'
            ));
        } catch (\Throwable $e) {
            Log::error('Gagal mengirimkan email konfirmasi perubahan kata sandi: '.$e->getMessage());
        }

        return redirect()->route('login')->with(
            'success',
            'Kata sandi Anda berhasil diperbarui! Pemberitahuan telah dikirimkan ke email Anda. Silakan masuk dengan kata sandi baru.'
        );
    }
}
