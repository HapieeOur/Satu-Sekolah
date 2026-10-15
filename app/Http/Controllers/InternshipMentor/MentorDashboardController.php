<?php

namespace App\Http\Controllers\InternshipMentor;

use App\Contracts\Services\InternshipServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MentorDashboardController extends Controller
{
    public function __construct(
        protected InternshipServiceInterface $internshipService
    ) {}

    public function index(): View
    {
        $userId = Auth::id();
        $metrics = $this->internshipService->getMentorDashboardMetrics($userId);
        $user = Auth::user();

        return view('internship-mentor.dashboard', array_merge($metrics, compact('user')));
    }
}
