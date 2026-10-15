<?php

namespace App\Contracts\Services;

use App\Models\Subject;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface SubjectServiceInterface
{
    public function getPaginated(int $perPage = 15, ?string $search = null): LengthAwarePaginator;

    public function getAll(): Collection;

    public function create(array $data, array $teacherIds = []): Subject;

    public function update(Subject $subject, array $data, array $teacherIds = []): Subject;

    public function delete(Subject $subject): bool;
}
