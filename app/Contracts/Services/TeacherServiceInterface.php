<?php

namespace App\Contracts\Services;

use App\Models\Teacher;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface TeacherServiceInterface
{
    public function getPaginated(int $perPage = 15, ?string $search = null): LengthAwarePaginator;

    public function getAll(): Collection;

    public function create(array $data, array $subjectIds = []): Teacher;

    public function update(Teacher $teacher, array $data, array $subjectIds = []): Teacher;

    public function delete(Teacher $teacher): bool;
}
