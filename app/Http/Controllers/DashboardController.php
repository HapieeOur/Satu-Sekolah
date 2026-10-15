<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Smart routing to role-specific dashboard.
     */
    public function index(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRole('wali_kelas')) {
            return redirect()->route('homeroom.dashboard');
        }

        if ($user->hasRole('guru_pembimbing_pkl')) {
            return redirect()->route('internship-mentor.dashboard');
        }

        if ($user->hasRole('guru')) {
            return redirect()->route('teacher.dashboard');
        }

        Auth::logout();

        return redirect()->route('login')->withErrors([
            'email' => 'Akun Anda belum memiliki hak akses yang valid.',
        ]);
    }
}
