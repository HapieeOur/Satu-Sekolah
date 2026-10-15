<?php

namespace App\Repositories;

use App\Contracts\Repositories\AcademicYearRepositoryInterface;
use App\Models\AcademicYear;
use Illuminate\Database\Eloquent\Collection;

class AcademicYearRepository implements AcademicYearRepositoryInterface
{
    public function getAll(): Collection
    {
        return AcademicYear::orderByDesc('start_date')->get();
    }

    public function getActive(): ?AcademicYear
    {
        return AcademicYear::where('is_active', true)->first();
    }

    public function findById(int $id): ?AcademicYear
    {
        return AcademicYear::find($id);
    }

    public function create(array $data): AcademicYear
    {
        return AcademicYear::create($data);
    }

    public function update(AcademicYear $academicYear, array $data): AcademicYear
    {
        $academicYear->update($data);

        return $academicYear;
    }

    public function deactivateAll(): void
    {
        AcademicYear::where('is_active', true)->update(['is_active' => false]);
    }

    public function delete(AcademicYear $academicYear): bool
    {
        return (bool) $academicYear->delete();
    }
}
