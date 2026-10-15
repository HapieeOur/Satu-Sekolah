<?php

namespace App\Http\Controllers\Internship;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class InternshipMentorDashboardController extends Controller
{
    /**
     * Display the internship mentor dashboard.
     */
    public function index(): View
    {
        $user = Auth::user();

        return view('dashboard.internship-mentor', compact('user'));
    }
}
