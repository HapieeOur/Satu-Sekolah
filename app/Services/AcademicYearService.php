<?php

namespace App\Services;

use App\Contracts\Services\AcademicYearServiceInterface;
use App\Models\AcademicYear;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class AcademicYearService implements AcademicYearServiceInterface
{
    public function getAll(): Collection
    {
        return AcademicYear::withCount('classrooms')
            ->orderBy('is_active', 'desc')
            ->latest('start_date')
            ->get();
    }

    public function create(array $data): AcademicYear
    {
        return DB::transaction(function () use ($data) {
            $isActive = ! empty($data['is_active']);

            if ($isActive) {
                AcademicYear::query()->update(['is_active' => false]);
            }

            return AcademicYear::create([
                'name' => $data['name'],
                'semester' => $data['semester'],
                'is_active' => $isActive,
                'start_date' => $data['start_date'] ?? null,
                'end_date' => $data['end_date'] ?? null,
            ]);
        });
    }

    public function update(AcademicYear $academicYear, array $data): AcademicYear
    {
        return DB::transaction(function () use ($academicYear, $data) {
            $isActive = ! empty($data['is_active']);

            if ($isActive && ! $academicYear->is_active) {
                AcademicYear::where('id', '!=', $academicYear->id)->update(['is_active' => false]);
            }

            $academicYear->update([
                'name' => $data['name'],
                'semester' => $data['semester'],
                'is_active' => $isActive,
                'start_date' => $data['start_date'] ?? null,
                'end_date' => $data['end_date'] ?? null,
            ]);

            return $academicYear;
        });
    }

    public function setActive(AcademicYear $academicYear): AcademicYear
    {
        return DB::transaction(function () use ($academicYear) {
            AcademicYear::where('id', '!=', $academicYear->id)->update(['is_active' => false]);
            $academicYear->update(['is_active' => true]);

            return $academicYear;
        });
    }

    public function delete(AcademicYear $academicYear): bool
    {
        return (bool) $academicYear->delete();
    }
}
