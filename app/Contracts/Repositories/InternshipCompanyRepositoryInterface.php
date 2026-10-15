<?php

namespace App\Contracts\Repositories;

use App\Models\InternshipCompany;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface InternshipCompanyRepositoryInterface
{
    public function getPaginated(int $perPage = 15, ?string $search = null): LengthAwarePaginator;

    public function getAll(): Collection;

    public function findById(int $id): ?InternshipCompany;

    public function create(array $data): InternshipCompany;

    public function update(InternshipCompany $company, array $data): InternshipCompany;

    public function delete(InternshipCompany $company): bool;
}
