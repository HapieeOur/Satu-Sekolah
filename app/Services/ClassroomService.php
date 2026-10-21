<?php

namespace App\Services;

use App\Contracts\Repositories\ClassroomRepositoryInterface;
use App\Contracts\Services\ClassroomServiceInterface;
use App\Models\Classroom;
use App\Models\Teacher;
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

    public function getAll(): Collection
    {
        return $this->classroomRepository->getAll();
    }

    public function getAllForActiveYear(): Collection
    {
        return $this->classroomRepository->getAllForActiveYear();
    }

    public function create(array $data): Classroom
    {
        $classroom = $this->classroomRepository->create([
            'name' => $data['name'],
            'grade_level' => $data['grade_level'],
            'major' => $data['major'],
            'academic_year_id' => $data['academic_year_id'],
            'teacher_id' => $data['teacher_id'] ?? null,
        ]);

        if (! empty($data['teacher_id'])) {
            $this->ensureTeacherHasWalasRole((int) $data['teacher_id']);
        }

        return $classroom;
    }

    public function update(Classroom $classroom, array $data): Classroom
    {
        $classroom = $this->classroomRepository->update($classroom, [
            'name' => $data['name'],
            'grade_level' => $data['grade_level'],
            'major' => $data['major'],
            'academic_year_id' => $data['academic_year_id'],
            'teacher_id' => $data['teacher_id'] ?? null,
        ]);

        if (! empty($data['teacher_id'])) {
            $this->ensureTeacherHasWalasRole((int) $data['teacher_id']);
        }

        return $classroom;
    }

    protected function ensureTeacherHasWalasRole(int $teacherId): void
    {
        $teacher = Teacher::with('user')->find($teacherId);
        if ($teacher?->user && ! $teacher->user->hasRole('wali_kelas')) {
            $teacher->user->assignRole('wali_kelas');
        }
    }

    public function delete(Classroom $classroom): bool
    {
        return $this->classroomRepository->delete($classroom);
    }
}
