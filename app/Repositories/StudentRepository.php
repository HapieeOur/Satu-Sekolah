<?php

namespace App\Repositories;

use App\Contracts\Repositories\StudentRepositoryInterface;
use App\Models\Student;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class StudentRepository implements StudentRepositoryInterface
{
    public function getPaginated(int $perPage = 15, ?string $search = null, ?int $classroomId = null, ?string $status = null): LengthAwarePaginator
    {
        $query = Student::with('classroom.academicYear')->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%")
                    ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        if ($classroomId) {
            $query->where('classroom_id', $classroomId);
        }

        if ($status) {
            $query->where('status', $status);
        }

        return $query->paginate($perPage);
    }

    public function findById(int $id): ?Student
    {
        return Student::with('classroom.academicYear')->find($id);
    }

    public function findByNis(string $nis): ?Student
    {
        return Student::where('nis', $nis)->first();
    }

    public function create(array $data): Student
    {
        return Student::create($data);
    }

    public function update(Student $student, array $data): Student
    {
        $student->update($data);

        return $student;
    }

    public function delete(Student $student): bool
    {
        return (bool) $student->delete();
    }
}
