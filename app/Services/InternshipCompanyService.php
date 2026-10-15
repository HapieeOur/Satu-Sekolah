<?php

namespace App\Services;

use App\Contracts\Services\InternshipCompanyServiceInterface;
use App\Models\InternshipCompany;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class InternshipCompanyService implements InternshipCompanyServiceInterface
{
    public function getPaginated(int $perPage = 15, ?string $search = null): LengthAwarePaginator
    {
        $query = InternshipCompany::latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('contact_person', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            });
        }

        return $query->paginate($perPage);
    }

    public function getAll(): Collection
    {
        return InternshipCompany::orderBy('name')->get();
    }

    public function create(array $data): InternshipCompany
    {
        return InternshipCompany::create([
            'name' => $data['name'],
            'address' => $data['address'],
            'contact_person' => $data['contact_person'] ?? null,
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,
            'radius_meters' => $data['radius_meters'] ?? 100,
        ]);
    }

    public function update(InternshipCompany $internshipCompany, array $data): InternshipCompany
    {
        $internshipCompany->update([
            'name' => $data['name'],
            'address' => $data['address'],
            'contact_person' => $data['contact_person'] ?? null,
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,
            'radius_meters' => $data['radius_meters'] ?? 100,
        ]);

        return $internshipCompany;
    }

    public function delete(InternshipCompany $internshipCompany): bool
    {
        return (bool) $internshipCompany->delete();
    }
}
