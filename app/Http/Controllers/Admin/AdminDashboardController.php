<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(): View
    {
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'total_teachers' => User::role(['guru', 'wali_kelas', 'guru_pembimbing_pkl'])->distinct()->count(),
            'total_roles' => Role::count(),
        ];

        $recentUsers = User::with('roles')
            ->latest()
            ->take(5)
            ->get();

        $rolesCount = Role::withCount('users')->get();

        return view('dashboard.admin', compact('stats', 'recentUsers', 'rolesCount'));
    }
}
