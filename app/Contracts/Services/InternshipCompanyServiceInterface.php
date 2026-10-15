<?php

namespace App\Contracts\Services;

use App\Models\InternshipCompany;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface InternshipCompanyServiceInterface
{
    public function getPaginated(int $perPage = 15, ?string $search = null): LengthAwarePaginator;

    public function getAll(): Collection;

    public function create(array $data): InternshipCompany;

    public function update(InternshipCompany $internshipCompany, array $data): InternshipCompany;

    public function delete(InternshipCompany $internshipCompany): bool;
}
