<?php

namespace App\Repositories;

use App\Contracts\Repositories\InternshipCompanyRepositoryInterface;
use App\Models\InternshipCompany;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class InternshipCompanyRepository implements InternshipCompanyRepositoryInterface
{
    public function getPaginated(int $perPage = 15, ?string $search = null): LengthAwarePaginator
    {
        $query = InternshipCompany::with('teacher.user')->latest();

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
        return InternshipCompany::with('teacher.user')->orderBy('name')->get();
    }

    public function findById(int $id): ?InternshipCompany
    {
        return InternshipCompany::find($id);
    }

    public function create(array $data): InternshipCompany
    {
        return InternshipCompany::create($data);
    }

    public function update(InternshipCompany $company, array $data): InternshipCompany
    {
        $company->update($data);

        return $company;
    }

    public function delete(InternshipCompany $company): bool
    {
        return (bool) $company->delete();
    }
}
