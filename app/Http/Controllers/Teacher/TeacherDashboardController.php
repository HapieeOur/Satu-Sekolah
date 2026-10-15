<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TeacherDashboardController extends Controller
{
    /**
     * Display the teacher dashboard.
     */
    public function index(): View
    {
        $user = Auth::user();

        return view('dashboard.teacher', compact('user'));
    }
}
