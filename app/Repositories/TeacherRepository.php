<?php

namespace App\Repositories;

use App\Contracts\Repositories\TeacherRepositoryInterface;
use App\Models\Teacher;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class TeacherRepository implements TeacherRepositoryInterface
{
    public function getPaginated(int $perPage = 15, ?string $search = null): LengthAwarePaginator
    {
        $query = Teacher::with(['user', 'subjects', 'classrooms'])->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nip', 'like', "%{$search}%")
                    ->orWhere('nuptk', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        return $query->paginate($perPage);
    }

    public function getAll(): Collection
    {
        return Teacher::with('user')->get()->sortBy('name')->values();
    }

    public function findById(int $id): ?Teacher
    {
        return Teacher::with(['user', 'subjects'])->find($id);
    }

    public function create(array $data): Teacher
    {
        return Teacher::create($data);
    }

    public function update(Teacher $teacher, array $data): Teacher
    {
        $teacher->update($data);

        return $teacher;
    }

    public function syncSubjects(Teacher $teacher, array $subjectIds): void
    {
        $teacher->subjects()->sync($subjectIds);
    }

    public function delete(Teacher $teacher): bool
    {
        $teacher->subjects()->detach();

        return (bool) $teacher->delete();
    }
}
