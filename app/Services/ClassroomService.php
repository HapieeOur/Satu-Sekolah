<?php

namespace App\Services;

use App\Contracts\Repositories\ClassroomRepositoryInterface;
use App\Contracts\Services\ClassroomServiceInterface;
use App\Models\Classroom;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ClassroomService implements ClassroomServiceInterface
{
    public function __construct(
        protected ClassroomRepositoryInterface $classroomRepository
    ) {}

    public function getPaginated(int $perPage = 15, ?int $academicYearId = null, ?int $gradeLevel = null): LengthAwarePaginator
    {
        return $this->classroomRepository->getPaginated($perPage, $academicYearId, $gradeLevel);
    }

    public function getAllForActiveYear(): Collection
    {
        return $this->classroomRepository->getAllForActiveYear();
    }

    public function create(array $data): Classroom
    {
        return $this->classroomRepository->create([
            'name' => $data['name'],
            'grade_level' => $data['grade_level'],
            'major' => $data['major'],
            'academic_year_id' => $data['academic_year_id'],
            'teacher_id' => $data['teacher_id'] ?? null,
        ]);
    }

    public function update(Classroom $classroom, array $data): Classroom
    {
        return $this->classroomRepository->update($classroom, [
            'name' => $data['name'],
            'grade_level' => $data['grade_level'],
            'major' => $data['major'],
            'academic_year_id' => $data['academic_year_id'],
            'teacher_id' => $data['teacher_id'] ?? null,
        ]);
    }

    public function delete(Classroom $classroom): bool
    {
        return $this->classroomRepository->delete($classroom);
    }
}
