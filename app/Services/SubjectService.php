<?php

namespace App\Services;

use App\Contracts\Repositories\SubjectRepositoryInterface;
use App\Contracts\Services\SubjectServiceInterface;
use App\Models\Subject;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class SubjectService implements SubjectServiceInterface
{
    public function __construct(
        protected SubjectRepositoryInterface $subjectRepository
    ) {}

    public function getPaginated(int $perPage = 15, ?string $search = null): LengthAwarePaginator
    {
        return $this->subjectRepository->getPaginated($perPage, $search);
    }

    public function getAll(): Collection
    {
        return $this->subjectRepository->getAll();
    }

    public function create(array $data, array $teacherIds = []): Subject
    {
        return DB::transaction(function () use ($data, $teacherIds) {
            $subject = $this->subjectRepository->create([
                'code' => $data['code'],
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
            ]);

            if (! empty($teacherIds)) {
                $this->subjectRepository->syncTeachers($subject, $teacherIds);
            }

            return $subject;
        });
    }

    public function update(Subject $subject, array $data, array $teacherIds = []): Subject
    {
        return DB::transaction(function () use ($subject, $data, $teacherIds) {
            $subject = $this->subjectRepository->update($subject, [
                'code' => $data['code'],
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
            ]);

            $this->subjectRepository->syncTeachers($subject, $teacherIds);

            return $subject;
        });
    }

    public function delete(Subject $subject): bool
    {
        return DB::transaction(function () use ($subject) {
            return $this->subjectRepository->delete($subject);
        });
    }
}
