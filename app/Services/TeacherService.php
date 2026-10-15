<?php

namespace App\Services;

use App\Contracts\Services\TeacherServiceInterface;
use App\Models\Teacher;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class TeacherService implements TeacherServiceInterface
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

    public function create(array $data, array $subjectIds = []): Teacher
    {
        return DB::transaction(function () use ($data, $subjectIds) {
            $teacher = Teacher::create([
                'user_id' => $data['user_id'],
                'nip' => $data['nip'] ?? null,
                'nuptk' => $data['nuptk'] ?? null,
                'gender' => $data['gender'] ?? 'L',
                'phone' => $data['phone'] ?? null,
                'address' => $data['address'] ?? null,
            ]);

            if (! empty($subjectIds)) {
                $teacher->subjects()->sync($subjectIds);
            }

            return $teacher;
        });
    }

    public function update(Teacher $teacher, array $data, array $subjectIds = []): Teacher
    {
        return DB::transaction(function () use ($teacher, $data, $subjectIds) {
            $teacher->update([
                'nip' => $data['nip'] ?? null,
                'nuptk' => $data['nuptk'] ?? null,
                'gender' => $data['gender'] ?? 'L',
                'phone' => $data['phone'] ?? null,
                'address' => $data['address'] ?? null,
            ]);

            $teacher->subjects()->sync($subjectIds);

            return $teacher;
        });
    }

    public function delete(Teacher $teacher): bool
    {
        return DB::transaction(function () use ($teacher) {
            $teacher->subjects()->detach();

            return (bool) $teacher->delete();
        });
    }
}
