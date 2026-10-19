<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class OAuthController extends Controller
{
    /**
     * Redirect the user to Google OAuth consent screen.
     */
    public function redirectToGoogle(): RedirectResponse
    {
        $clientId = config('services.google.client_id');
        $redirectUri = url(config('services.google.redirect', '/auth/google/callback'));

        if (empty($clientId)) {
            return redirect()->route('login')->with('info', 'Google Single Sign-On memerlukan konfigurasi GOOGLE_CLIENT_ID dan GOOGLE_CLIENT_SECRET pada file .env.');
        }

        $state = Str::random(40);
        session(['oauth_google_state' => $state]);

        $query = http_build_query([
            'client_id' => $clientId,
            'redirect_uri' => $redirectUri,
            'response_type' => 'code',
            'scope' => 'openid email profile',
            'access_type' => 'offline',
            'state' => $state,
            'prompt' => 'select_account',
        ]);

        return redirect()->away('https://accounts.google.com/o/oauth2/v2/auth?'.$query);
    }

    /**
     * Handle the callback returned from Google OAuth.
     */
    public function handleGoogleCallback(Request $request): RedirectResponse
    {
        if ($request->has('error')) {
            return redirect()->route('login')->withErrors(['email' => 'Proses masuk dengan Google dibatalkan atau terjadi kesalahan.']);
        }

        $storedState = session('oauth_google_state');
        session()->forget('oauth_google_state');

        if (empty($storedState) || $storedState !== $request->input('state')) {
            return redirect()->route('login')->withErrors(['email' => 'Sesi autentikasi Google tidak valid atau telah kedaluwarsa.']);
        }

        $code = $request->input('code');
        if (empty($code)) {
            return redirect()->route('login')->withErrors(['email' => 'Kode otorisasi Google tidak ditemukan.']);
        }

        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');
        $redirectUri = url(config('services.google.redirect', '/auth/google/callback'));

        try {
            $tokenResponse = Http::asForm()->timeout(10)->post('https://oauth2.googleapis.com/token', [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'redirect_uri' => $redirectUri,
                'grant_type' => 'authorization_code',
                'code' => $code,
            ]);

            if (! $tokenResponse->successful()) {
                return redirect()->route('login')->withErrors(['email' => 'Gagal menukar kode otorisasi Google dengan token akses.']);
            }

            $accessToken = $tokenResponse->json('access_token');
            $userResponse = Http::withToken($accessToken)->timeout(10)->get('https://www.googleapis.com/oauth2/v3/userinfo');

            if (! $userResponse->successful()) {
                return redirect()->route('login')->withErrors(['email' => 'Gagal mengambil data profil dari Google.']);
            }

            $googleUser = $userResponse->json();
            $email = $googleUser['email'] ?? null;

            if (empty($email)) {
                return redirect()->route('login')->withErrors(['email' => 'Alamat email tidak ditemukan pada profil Google Anda.']);
            }

            $user = User::where('email', $email)->first();

            if (! $user) {
                return redirect()->route('login')->withErrors([
                    'email' => "Alamat email Google ({$email}) belum terdaftar di sistem Satu-Sekolah. Silakan hubungi staf IT atau administrator sekolah.",
                ]);
            }

            if (! $user->is_active) {
                return redirect()->route('login')->withErrors([
                    'email' => 'Akun Anda berstatus nonaktif. Silakan hubungi staf sekolah untuk mengaktifkannya kembali.',
                ]);
            }

            Auth::login($user, true);

            return redirect()->intended(route('dashboard'))->with('success', 'Berhasil masuk ke portal melalui akun Google.');
        } catch (\Throwable $e) {
            return redirect()->route('login')->withErrors(['email' => 'Terjadi kesalahan saat berkomunikasi dengan server Google.']);
        }
    }
}
