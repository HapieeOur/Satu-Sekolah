<?php

namespace App\Services;

use App\Contracts\Services\SubjectServiceInterface;
use App\Models\Subject;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class SubjectService implements SubjectServiceInterface
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

    public function create(array $data, array $teacherIds = []): Subject
    {
        return DB::transaction(function () use ($data, $teacherIds) {
            $subject = Subject::create([
                'code' => $data['code'],
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
            ]);

            if (! empty($teacherIds)) {
                $subject->teachers()->sync($teacherIds);
            }

            return $subject;
        });
    }

    public function update(Subject $subject, array $data, array $teacherIds = []): Subject
    {
        return DB::transaction(function () use ($subject, $data, $teacherIds) {
            $subject->update([
                'code' => $data['code'],
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
            ]);

            $subject->teachers()->sync($teacherIds);

            return $subject;
        });
    }

    public function delete(Subject $subject): bool
    {
        return DB::transaction(function () use ($subject) {
            $subject->teachers()->detach();

            return (bool) $subject->delete();
        });
    }
}
