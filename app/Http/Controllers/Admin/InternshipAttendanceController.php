<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Services\InternshipServiceInterface;
use App\Enums\InternshipAttendanceStatus;
use App\Enums\InternshipVerificationStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CorrectInternshipAttendanceRequest;
use App\Models\InternshipCompany;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class InternshipAttendanceController extends Controller
{
    public function __construct(
        protected InternshipServiceInterface $internshipService
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['date', 'company_id', 'status', 'verification_status', 'search']);
        $attendances = $this->internshipService->getAttendances($filters);

        $companies = InternshipCompany::orderBy('name')->get();
        $statuses = InternshipAttendanceStatus::cases();
        $verificationStatuses = InternshipVerificationStatus::cases();

        return view('admin.internships.attendances.index', compact(
            'attendances',
            'companies',
            'statuses',
            'verificationStatuses',
            'filters'
        ));
    }

    public function correct(CorrectInternshipAttendanceRequest $request, int $id): RedirectResponse
    {
        $this->internshipService->manuallyCorrectAttendance(Auth::id(), $id, $request->validated());

        return back()->with('success', 'Koreksi presensi PKL berhasil disimpan dengan riwayat jejak audit.');
    }
}
