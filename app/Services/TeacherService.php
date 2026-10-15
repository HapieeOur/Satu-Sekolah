<?php

namespace App\Services;

use App\Contracts\Repositories\TeacherRepositoryInterface;
use App\Contracts\Services\TeacherServiceInterface;
use App\Models\Teacher;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class TeacherService implements TeacherServiceInterface
{
    public function __construct(
        protected TeacherRepositoryInterface $teacherRepository
    ) {}

    public function getPaginated(int $perPage = 15, ?string $search = null): LengthAwarePaginator
    {
        return $this->teacherRepository->getPaginated($perPage, $search);
    }

    public function getAll(): Collection
    {
        return $this->teacherRepository->getAll();
    }

    public function create(array $data, array $subjectIds = []): Teacher
    {
        return DB::transaction(function () use ($data, $subjectIds) {
            $teacher = $this->teacherRepository->create([
                'user_id' => $data['user_id'],
                'nip' => $data['nip'] ?? null,
                'nuptk' => $data['nuptk'] ?? null,
                'gender' => $data['gender'] ?? 'L',
                'phone' => $data['phone'] ?? null,
                'address' => $data['address'] ?? null,
            ]);

            if (! empty($subjectIds)) {
                $this->teacherRepository->syncSubjects($teacher, $subjectIds);
            }

            return $teacher;
        });
    }

    public function update(Teacher $teacher, array $data, array $subjectIds = []): Teacher
    {
        return DB::transaction(function () use ($teacher, $data, $subjectIds) {
            $teacher = $this->teacherRepository->update($teacher, [
                'nip' => $data['nip'] ?? null,
                'nuptk' => $data['nuptk'] ?? null,
                'gender' => $data['gender'] ?? 'L',
                'phone' => $data['phone'] ?? null,
                'address' => $data['address'] ?? null,
            ]);

            $this->teacherRepository->syncSubjects($teacher, $subjectIds);

            return $teacher;
        });
    }

    public function delete(Teacher $teacher): bool
    {
        return DB::transaction(function () use ($teacher) {
            return $this->teacherRepository->delete($teacher);
        });
    }
}
