<?php

namespace App\Http\Controllers\Api\Admin;

use App\Contracts\Services\AcademicYearServiceInterface;
use App\Models\AcademicYear;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminAcademicYearController extends AdminBaseController
{
    public function __construct(
        protected AcademicYearServiceInterface $academicYearService
    ) {}

    /**
     * Display a listing of academic years.
     */
    public function index(): JsonResponse
    {
        $this->authorizeAdmin();

        $years = AcademicYear::withCount('classrooms')->latest()->get()->map(function ($y) {
            return [
                'id' => $y->id,
                'name' => $y->name,
                'semester' => $y->semester,
                'is_active' => (bool) $y->is_active,
                'start_date' => $y->start_date?->format('Y-m-d'),
                'end_date' => $y->end_date?->format('Y-m-d'),
                'classrooms_count' => $y->classrooms_count,
            ];
        });

        return $this->respondWithSuccess($years, 'Daftar tahun ajaran berhasil diambil.');
    }

    /**
     * Store academic year.
     */
    public function store(Request $request): JsonResponse
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'semester' => ['required', 'in:ganjil,genap'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        return DB::transaction(function () use ($validated) {
            if (! empty($validated['is_active'])) {
                AcademicYear::query()->update(['is_active' => false]);
            }

            $academicYear = AcademicYear::create([
                'name' => $validated['name'],
                'semester' => $validated['semester'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'is_active' => ! empty($validated['is_active']),
            ]);

            return $this->respondWithSuccess([
                'id' => $academicYear->id,
                'name' => $academicYear->name,
                'semester' => $academicYear->semester,
                'is_active' => (bool) $academicYear->is_active,
            ], 'Tahun ajaran berhasil ditambahkan.', 201);
        });
    }

    /**
     * Set active academic year.
     */
    public function setActive(AcademicYear $academicYear): JsonResponse
    {
        $this->authorizeAdmin();

        DB::transaction(function () use ($academicYear) {
            AcademicYear::query()->update(['is_active' => false]);
            $academicYear->update(['is_active' => true]);
        });

        return $this->respondWithSuccess(null, "Tahun ajaran {$academicYear->name} sekarang berstatus aktif.");
    }

    /**
     * Delete academic year.
     */
    public function destroy(AcademicYear $academicYear): JsonResponse
    {
        $this->authorizeAdmin();

        $name = $academicYear->name;
        $academicYear->delete();

        return $this->respondWithSuccess(null, "Tahun ajaran {$name} berhasil dihapus.");
    }
}
