<?php

namespace App\Http\Controllers\Api\Admin;

use App\Contracts\Services\InternshipCompanyServiceInterface;
use App\Models\InternshipCompany;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminCompanyController extends AdminBaseController
{
    public function __construct(
        protected InternshipCompanyServiceInterface $companyService
    ) {}

    /**
     * Display a listing of internship companies.
     */
    public function index(Request $request): JsonResponse
    {
        $this->authorizeAdmin();

        $companies = InternshipCompany::with('teacher.user')->latest()->get()->map(function ($c) {
            return [
                'id' => $c->id,
                'name' => $c->name,
                'address' => $c->address,
                'contact_person' => $c->contact_person ?? '-',
                'phone' => $c->phone ?? '-',
                'email' => $c->email ?? '-',
                'teacher_id' => $c->teacher_id,
                'mentor_name' => $c->teacher?->user?->name ?? 'Belum Ditentukan',
                'radius_meters' => $c->radius_meters,
            ];
        });

        return $this->respondWithSuccess($companies, 'Daftar mitra DUDI berhasil diambil.');
    }

    /**
     * Store a newly created company.
     */
    public function store(Request $request): JsonResponse
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:25'],
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'teacher_id' => ['nullable', 'exists:teachers,id'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'radius_meters' => ['nullable', 'integer', 'min:10'],
        ]);

        $company = $this->companyService->create($validated);
        $company->load('teacher.user');

        return $this->respondWithSuccess([
            'id' => $company->id,
            'name' => $company->name,
            'address' => $company->address,
            'contact_person' => $company->contact_person,
            'mentor_name' => $company->teacher?->user?->name ?? 'Belum Ditentukan',
        ], 'Mitra DUDI / Industri berhasil ditambahkan.', 201);
    }

    /**
     * Update company.
     */
    public function update(Request $request, InternshipCompany $company): JsonResponse
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:25'],
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'teacher_id' => ['nullable', 'exists:teachers,id'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'radius_meters' => ['nullable', 'integer', 'min:10'],
        ]);

        $company->update($validated);
        $company->load('teacher.user');

        return $this->respondWithSuccess([
            'id' => $company->id,
            'name' => $company->name,
            'address' => $company->address,
            'contact_person' => $company->contact_person,
            'mentor_name' => $company->teacher?->user?->name ?? 'Belum Ditentukan',
        ], 'Mitra DUDI / Industri berhasil diperbarui.');
    }

    /**
     * Delete company.
     */
    public function destroy(InternshipCompany $company): JsonResponse
    {
        $this->authorizeAdmin();

        $name = $company->name;
        $company->delete();

        return $this->respondWithSuccess(null, "Mitra DUDI {$name} berhasil dihapus.");
    }
}
