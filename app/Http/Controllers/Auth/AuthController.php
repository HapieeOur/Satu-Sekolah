<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Display the login view.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $loginInput = trim((string) $request->input('email'));
        $password = (string) $request->input('password');

        // Resolve user by Email, NISN / NIS (User), NISN / NIS (Student), or NIP (Teacher)
        $user = User::where('email', $loginInput)->first();

        if (! $user) {
            $user = User::where('nisn', $loginInput)->orWhere('nis', $loginInput)->first();
        }

        if (! $user) {
            $student = Student::where('nisn', $loginInput)->orWhere('nis', $loginInput)->first();
            if ($student && $student->user) {
                $user = $student->user;
            }
        }

        if (! $user) {
            $teacher = Teacher::where('nip', $loginInput)->first();
            if ($teacher && $teacher->user) {
                $user = $teacher->user;
            }
        }

        if (! $user || ! Auth::attempt(['id' => $user->id, 'password' => $password], $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'Email, NISN, atau password yang Anda masukkan salah.',
            ]);
        }

        $user = Auth::user();

        if (! $user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'Akun Anda sedang dinonaktifkan oleh Administrator.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar dari sistem.');
    }
}
