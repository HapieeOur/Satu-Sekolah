<?php

namespace App\Contracts\Repositories;

use App\Models\Subject;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface SubjectRepositoryInterface
{
    public function getPaginated(int $perPage = 15, ?string $search = null): LengthAwarePaginator;

    public function getAll(): Collection;

    public function findById(int $id): ?Subject;

    public function findByCode(string $code): ?Subject;

    public function create(array $data): Subject;

    public function update(Subject $subject, array $data): Subject;

    public function syncTeachers(Subject $subject, array $teacherIds): void;

    public function delete(Subject $subject): bool;
}
