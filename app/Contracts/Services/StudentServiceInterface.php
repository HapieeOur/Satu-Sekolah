<?php

namespace App\Contracts\Services;

use App\Models\Student;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface StudentServiceInterface
{
    public function getPaginated(int $perPage = 15, ?string $search = null, ?int $classroomId = null, ?string $status = null): LengthAwarePaginator;

    public function create(array $data): Student;

    public function update(Student $student, array $data): Student;

    public function delete(Student $student): bool;
}
