<?php

namespace App\Http\Controllers\Homeroom;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HomeroomDashboardController extends Controller
{
    /**
     * Display the homeroom teacher dashboard.
     */
    public function index(): View
    {
        $user = Auth::user();

        return view('dashboard.homeroom', compact('user'));
    }
}
