<?php

namespace App\Services;

use App\Contracts\Repositories\AcademicYearRepositoryInterface;
use App\Contracts\Services\AcademicYearServiceInterface;
use App\Models\AcademicYear;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class AcademicYearService implements AcademicYearServiceInterface
{
    public function __construct(
        protected AcademicYearRepositoryInterface $academicYearRepository
    ) {}

    public function getAll(): Collection
    {
        return $this->academicYearRepository->getAll();
    }

    public function create(array $data): AcademicYear
    {
        return DB::transaction(function () use ($data) {
            if (! empty($data['is_active'])) {
                $this->academicYearRepository->deactivateAll();
            }

            return $this->academicYearRepository->create([
                'name' => $data['name'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'semester' => $data['semester'],
                'is_active' => ! empty($data['is_active']),
            ]);
        });
    }

    public function update(AcademicYear $academicYear, array $data): AcademicYear
    {
        return DB::transaction(function () use ($academicYear, $data) {
            if (! empty($data['is_active'])) {
                $this->academicYearRepository->deactivateAll();
            }

            return $this->academicYearRepository->update($academicYear, [
                'name' => $data['name'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'semester' => $data['semester'],
                'is_active' => ! empty($data['is_active']),
            ]);
        });
    }

    public function setActive(AcademicYear $academicYear): AcademicYear
    {
        return DB::transaction(function () use ($academicYear) {
            $this->academicYearRepository->deactivateAll();

            return $this->academicYearRepository->update($academicYear, [
                'is_active' => true,
            ]);
        });
    }

    public function delete(AcademicYear $academicYear): bool
    {
        return $this->academicYearRepository->delete($academicYear);
    }
}
