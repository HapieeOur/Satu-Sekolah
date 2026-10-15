<?php

namespace App\Http\Controllers\InternshipMentor;

use App\Contracts\Services\InternshipServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MentorStudentController extends Controller
{
    public function __construct(
        protected InternshipServiceInterface $internshipService
    ) {}

    public function index(Request $request): View
    {
        $userId = Auth::id();
        $filters = $request->only(['status', 'company_id']);
        $mentees = $this->internshipService->getMentorMentees($userId, $filters);

        return view('internship-mentor.students.index', compact('mentees', 'filters'));
    }

    public function show(int $id): View
    {
        $userId = Auth::id();
        $placement = $this->internshipService->getMentorPlacement($userId, $id);

        return view('internship-mentor.students.show', compact('placement'));
    }
}
