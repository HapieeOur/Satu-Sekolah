<?php

namespace App\Http\Controllers\InternshipMentor;

use App\Contracts\Services\InternshipServiceInterface;
use App\Enums\InternshipAttendanceStatus;
use App\Enums\InternshipVerificationStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MentorAttendanceController extends Controller
{
    public function __construct(
        protected InternshipServiceInterface $internshipService
    ) {}

    public function index(Request $request): View
    {
        $userId = Auth::id();
        $filters = $request->only(['date', 'status', 'verification_status', 'search']);
        $attendances = $this->internshipService->getMentorAttendances($userId, $filters);

        $statuses = InternshipAttendanceStatus::cases();
        $verificationStatuses = InternshipVerificationStatus::cases();

        return view('internship-mentor.attendances.index', compact(
            'attendances',
            'statuses',
            'verificationStatuses',
            'filters'
        ));
    }

    public function verify(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'in:verified,rejected'],
            'rejection_reason' => ['nullable', 'required_if:status,rejected', 'string', 'max:255'],
        ]);

        $this->internshipService->verifyAttendance(
            Auth::id(),
            $id,
            $request->input('status'),
            $request->input('rejection_reason')
        );

        return back()->with('success', 'Status verifikasi presensi berhasil diperbarui.');
    }
}
