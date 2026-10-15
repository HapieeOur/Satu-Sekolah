<?php

namespace App\Http\Controllers\InternshipMentor;

use App\Contracts\Services\InternshipServiceInterface;
use App\Enums\InternshipJournalStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MentorJournalController extends Controller
{
    public function __construct(
        protected InternshipServiceInterface $internshipService
    ) {}

    public function index(Request $request): View
    {
        $userId = Auth::id();
        $filters = $request->only(['status', 'date', 'search']);
        $journals = $this->internshipService->getMentorJournals($userId, $filters);
        $statuses = InternshipJournalStatus::cases();

        return view('internship-mentor.journals.index', compact('journals', 'statuses', 'filters'));
    }

    public function review(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'in:approved,revision_requested'],
            'mentor_notes' => ['nullable', 'required_if:status,revision_requested', 'string', 'max:500'],
        ]);

        $this->internshipService->reviewJournal(
            Auth::id(),
            $id,
            $request->input('status'),
            $request->input('mentor_notes')
        );

        return back()->with('success', 'Ulasan jurnal harian siswa berhasil disimpan.');
    }
}
