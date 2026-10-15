<?php

namespace App\Contracts\Repositories;

use App\Models\AcademicYear;
use Illuminate\Database\Eloquent\Collection;

interface AcademicYearRepositoryInterface
{
    public function getAll(): Collection;

    public function getActive(): ?AcademicYear;

    public function findById(int $id): ?AcademicYear;

    public function create(array $data): AcademicYear;

    public function update(AcademicYear $academicYear, array $data): AcademicYear;

    public function deactivateAll(): void;

    public function delete(AcademicYear $academicYear): bool;
}
