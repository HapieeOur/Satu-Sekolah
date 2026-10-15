<?php

namespace App\Http\Controllers\InternshipMentor;

use App\Contracts\Services\InternshipServiceInterface;
use App\Enums\InternshipLeaveStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MentorLeaveRequestController extends Controller
{
    public function __construct(
        protected InternshipServiceInterface $internshipService
    ) {}

    public function index(Request $request): View
    {
        $userId = Auth::id();
        $filters = $request->only(['status', 'type']);
        $leaveRequests = $this->internshipService->getMentorLeaveRequests($userId, $filters);
        $statuses = InternshipLeaveStatus::cases();

        return view('internship-mentor.leaves.index', compact('leaveRequests', 'statuses', 'filters'));
    }

    public function review(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'in:approved,rejected'],
            'review_notes' => ['nullable', 'string', 'max:500'],
        ]);

        $this->internshipService->reviewLeaveRequest(
            Auth::id(),
            $id,
            $request->input('status'),
            $request->input('review_notes')
        );

        return back()->with('success', 'Status permohonan izin/sakit PKL berhasil diperbarui.');
    }
}
