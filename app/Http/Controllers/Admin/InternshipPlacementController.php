<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Services\InternshipServiceInterface;
use App\Enums\InternshipPlacementStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreInternshipPlacementRequest;
use App\Http\Requests\Admin\UpdateInternshipPlacementRequest;
use App\Models\InternshipCompany;
use App\Models\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InternshipPlacementController extends Controller
{
    public function __construct(
        protected InternshipServiceInterface $internshipService
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'company_id', 'teacher_id', 'status', 'academic_year_id']);
        $placements = $this->internshipService->getPlacements($filters);

        $companies = InternshipCompany::orderBy('name')->get();
        $teachers = Teacher::with('user')
            ->whereHas('user', function ($q) {
                $q->where('is_active', true);
            })
            ->get();
        $statuses = InternshipPlacementStatus::cases();

        return view('admin.internships.placements.index', compact(
            'placements',
            'companies',
            'teachers',
            'statuses',
            'filters'
        ));
    }

    public function create(): View
    {
        $formData = $this->internshipService->getPlacementFormData();
        $statuses = InternshipPlacementStatus::cases();

        return view('admin.internships.placements.create', array_merge($formData, compact('statuses')));
    }

    public function store(StoreInternshipPlacementRequest $request): RedirectResponse
    {
        $this->internshipService->createPlacement($request->validated());

        return redirect()
            ->route('admin.internships.placements.index')
            ->with('success', 'Penempatan PKL siswa berhasil didaftarkan.');
    }

    public function edit(int $id): View
    {
        $placement = $this->internshipService->getPlacement($id);
        $formData = $this->internshipService->getPlacementFormData($placement->student_id);
        $statuses = InternshipPlacementStatus::cases();

        return view('admin.internships.placements.edit', array_merge(
            $formData,
            compact('placement', 'statuses')
        ));
    }

    public function update(UpdateInternshipPlacementRequest $request, int $id): RedirectResponse
    {
        $this->internshipService->updatePlacement($id, $request->validated());

        return redirect()
            ->route('admin.internships.placements.index')
            ->with('success', 'Data penempatan PKL siswa berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->internshipService->deletePlacement($id);

        return redirect()
            ->route('admin.internships.placements.index')
            ->with('success', 'Penempatan PKL berhasil dihapus dari sistem.');
    }
}
