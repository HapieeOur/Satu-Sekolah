<?php

namespace App\Contracts\Repositories;

use App\Models\Teacher;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface TeacherRepositoryInterface
{
    public function getPaginated(int $perPage = 15, ?string $search = null): LengthAwarePaginator;

    public function getAll(): Collection;

    public function findById(int $id): ?Teacher;

    public function create(array $data): Teacher;

    public function update(Teacher $teacher, array $data): Teacher;

    public function syncSubjects(Teacher $teacher, array $subjectIds): void;

    public function delete(Teacher $teacher): bool;
}
