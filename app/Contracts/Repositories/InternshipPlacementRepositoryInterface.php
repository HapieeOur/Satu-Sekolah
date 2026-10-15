<?php

namespace App\Contracts\Repositories;

use App\Models\InternshipPlacement;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface InternshipPlacementRepositoryInterface
{
    public function getPaginated(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function findById(int $id): ?InternshipPlacement;

    public function getMenteesForTeacher(int $teacherId, array $filters = []): Collection;

    public function getPlacementsForClassroom(int $classroomId): Collection;

    public function create(array $data): InternshipPlacement;

    public function update(int $id, array $data): InternshipPlacement;

    public function delete(int $id): bool;

    public function getAvailableStudentsForPlacement(int $academicYearId, ?int $exceptStudentId = null): Collection;
}
