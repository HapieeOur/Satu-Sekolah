<?php

namespace App\Repositories;

use App\Contracts\Repositories\ClassroomRepositoryInterface;
use App\Models\Classroom;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ClassroomRepository implements ClassroomRepositoryInterface
{
    public function getPaginated(int $perPage = 15, ?int $academicYearId = null, ?int $gradeLevel = null): LengthAwarePaginator
    {
        $query = Classroom::with(['academicYear', 'homeroomTeacher.user', 'students'])->latest();

        if ($academicYearId) {
            $query->where('academic_year_id', $academicYearId);
        }

        if ($gradeLevel) {
            $query->where('grade_level', $gradeLevel);
        }

        return $query->paginate($perPage);
    }

    public function getAllForActiveYear(): Collection
    {
        return Classroom::whereHas('academicYear', function ($q) {
            $q->where('is_active', true);
        })->orderBy('grade_level')->orderBy('name')->get();
    }

    public function findById(int $id): ?Classroom
    {
        return Classroom::with(['academicYear', 'homeroomTeacher.user', 'students'])->find($id);
    }

    public function create(array $data): Classroom
    {
        return Classroom::create($data);
    }

    public function update(Classroom $classroom, array $data): Classroom
    {
        $classroom->update($data);

        return $classroom;
    }

    public function delete(Classroom $classroom): bool
    {
        return (bool) $classroom->delete();
    }
}
