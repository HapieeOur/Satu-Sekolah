<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Services\InternshipCompanyServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreInternshipCompanyRequest;
use App\Http\Requests\Admin\UpdateInternshipCompanyRequest;
use App\Models\InternshipCompany;
use App\Models\Teacher;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InternshipCompanyController extends Controller
{
    public function __construct(
        protected InternshipCompanyServiceInterface $internshipCompanyService
    ) {}

    public function index(Request $request): View
    {
        $search = $request->input('search');
        $companies = $this->internshipCompanyService->getPaginated(15, $search)->withQueryString();

        return view('admin.internship-companies.index', compact('companies'));
    }

    public function create(): View
    {
        UserService::ensureTeacherProfilesExist();

        $teachers = Teacher::with('user')
            ->whereHas('user', function ($q) {
                $q->where('is_active', true)
                  ->whereHas('roles', fn($r) => $r->where('name', 'guru_pembimbing_pkl'));
            })
            ->get();

        return view('admin.internship-companies.create', compact('teachers'));
    }

    public function store(StoreInternshipCompanyRequest $request): RedirectResponse
    {
        $this->internshipCompanyService->create($request->validated());

        return redirect()->route('admin.internship-companies.index')
            ->with('success', 'Data mitra PKL berhasil ditambahkan.');
    }

    public function edit(InternshipCompany $internshipCompany): View
    {
        UserService::ensureTeacherProfilesExist();

        $teachers = Teacher::with('user')
            ->whereHas('user', function ($q) use ($internshipCompany) {
                $q->where('is_active', true)
                  ->where(function ($sub) use ($internshipCompany) {
                      $sub->whereHas('roles', fn($r) => $r->where('name', 'guru_pembimbing_pkl'));
                      if ($internshipCompany->teacher_id) {
                          $sub->orWhere('id', $internshipCompany->teacher?->user_id);
                      }
                  });
            })
            ->get();

        return view('admin.internship-companies.edit', compact('internshipCompany', 'teachers'));
    }

    public function update(UpdateInternshipCompanyRequest $request, InternshipCompany $internshipCompany): RedirectResponse
    {
        $this->internshipCompanyService->update($internshipCompany, $request->validated());

        return redirect()->route('admin.internship-companies.index')
            ->with('success', 'Data mitra PKL berhasil diperbarui.');
    }

    public function destroy(InternshipCompany $internshipCompany): RedirectResponse
    {
        $this->internshipCompanyService->delete($internshipCompany);

        return redirect()->route('admin.internship-companies.index')
            ->with('success', 'Data mitra PKL berhasil dihapus.');
    }
}
