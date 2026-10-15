<?php

namespace App\Repositories;

use App\Contracts\Repositories\SubjectRepositoryInterface;
use App\Models\Subject;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class SubjectRepository implements SubjectRepositoryInterface
{
    public function getPaginated(int $perPage = 15, ?string $search = null): LengthAwarePaginator
    {
        $query = Subject::with('teachers.user')->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        return $query->paginate($perPage);
    }

    public function getAll(): Collection
    {
        return Subject::orderBy('name')->get();
    }

    public function findById(int $id): ?Subject
    {
        return Subject::with('teachers.user')->find($id);
    }

    public function findByCode(string $code): ?Subject
    {
        return Subject::where('code', $code)->first();
    }

    public function create(array $data): Subject
    {
        return Subject::create($data);
    }

    public function update(Subject $subject, array $data): Subject
    {
        $subject->update($data);

        return $subject;
    }

    public function syncTeachers(Subject $subject, array $teacherIds): void
    {
        $subject->teachers()->sync($teacherIds);
    }

    public function delete(Subject $subject): bool
    {
        $subject->teachers()->detach();

        return (bool) $subject->delete();
    }
}
