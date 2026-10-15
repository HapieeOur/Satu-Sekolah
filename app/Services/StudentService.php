<?php

namespace App\Services;

use App\Contracts\Repositories\StudentRepositoryInterface;
use App\Contracts\Services\StudentServiceInterface;
use App\Models\Student;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class StudentService implements StudentServiceInterface
{
    public function __construct(
        protected StudentRepositoryInterface $studentRepository
    ) {}

    public function getPaginated(int $perPage = 15, ?string $search = null, ?int $classroomId = null, ?string $status = null): LengthAwarePaginator
    {
        return $this->studentRepository->getPaginated($perPage, $search, $classroomId, $status);
    }

    public function create(array $data): Student
    {
        return $this->studentRepository->create([
            'nis' => $data['nis'],
            'nisn' => $data['nisn'] ?? null,
            'name' => $data['name'],
            'gender' => $data['gender'] ?? 'L',
            'classroom_id' => $data['classroom_id'] ?? null,
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'parent_name' => $data['parent_name'] ?? null,
            'parent_phone' => $data['parent_phone'] ?? null,
            'status' => $data['status'] ?? 'aktif',
        ]);
    }

    public function update(Student $student, array $data): Student
    {
        return $this->studentRepository->update($student, [
            'nis' => $data['nis'],
            'nisn' => $data['nisn'] ?? null,
            'name' => $data['name'],
            'gender' => $data['gender'] ?? 'L',
            'classroom_id' => $data['classroom_id'] ?? null,
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'parent_name' => $data['parent_name'] ?? null,
            'parent_phone' => $data['parent_phone'] ?? null,
            'status' => $data['status'] ?? 'aktif',
        ]);
    }

    public function delete(Student $student): bool
    {
        return $this->studentRepository->delete($student);
    }
}
