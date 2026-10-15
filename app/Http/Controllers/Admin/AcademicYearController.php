<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Services\AcademicYearServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAcademicYearRequest;
use App\Http\Requests\Admin\UpdateAcademicYearRequest;
use App\Models\AcademicYear;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AcademicYearController extends Controller
{
    public function __construct(
        protected AcademicYearServiceInterface $academicYearService
    ) {}

    public function index(): View
    {
        $academicYears = $this->academicYearService->getAll();

        return view('admin.academic-years.index', compact('academicYears'));
    }

    public function create(): View
    {
        return view('admin.academic-years.create');
    }

    public function store(StoreAcademicYearRequest $request): RedirectResponse
    {
        $this->academicYearService->create($request->validated());

        return redirect()->route('admin.academic-years.index')
            ->with('success', 'Tahun ajaran berhasil ditambahkan.');
    }

    public function edit(AcademicYear $academicYear): View
    {
        return view('admin.academic-years.edit', compact('academicYear'));
    }

    public function update(UpdateAcademicYearRequest $request, AcademicYear $academicYear): RedirectResponse
    {
        $this->academicYearService->update($academicYear, $request->validated());

        return redirect()->route('admin.academic-years.index')
            ->with('success', 'Tahun ajaran berhasil diperbarui.');
    }

    public function setActive(AcademicYear $academicYear): RedirectResponse
    {
        $this->academicYearService->setActive($academicYear);

        return redirect()->route('admin.academic-years.index')
            ->with('success', "Tahun ajaran {$academicYear->name} ({$academicYear->semester}) sekarang aktif.");
    }

    public function destroy(AcademicYear $academicYear): RedirectResponse
    {
        $this->academicYearService->delete($academicYear);

        return redirect()->route('admin.academic-years.index')
            ->with('success', 'Tahun ajaran berhasil dihapus.');
    }
}
