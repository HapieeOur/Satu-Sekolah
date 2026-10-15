<?php

namespace App\Contracts\Repositories;

use App\Models\Classroom;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ClassroomRepositoryInterface
{
    public function getPaginated(int $perPage = 15, ?int $academicYearId = null, ?int $gradeLevel = null): LengthAwarePaginator;

    public function getAllForActiveYear(): Collection;

    public function findById(int $id): ?Classroom;

    public function create(array $data): Classroom;

    public function update(Classroom $classroom, array $data): Classroom;

    public function delete(Classroom $classroom): bool;
}
