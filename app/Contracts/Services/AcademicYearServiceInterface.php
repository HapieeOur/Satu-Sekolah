<?php

namespace App\Contracts\Services;

use App\Models\AcademicYear;
use Illuminate\Database\Eloquent\Collection;

interface AcademicYearServiceInterface
{
    public function getAll(): Collection;

    public function create(array $data): AcademicYear;

    public function update(AcademicYear $academicYear, array $data): AcademicYear;

    public function setActive(AcademicYear $academicYear): AcademicYear;

    public function delete(AcademicYear $academicYear): bool;
}
