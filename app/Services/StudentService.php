<?php

namespace App\Services;

use App\Contracts\Services\StudentServiceInterface;
use App\Models\Student;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class StudentService implements StudentServiceInterface
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

    public function create(array $data): Student
    {
        return Student::create([
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
        $student->update([
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

        return $student;
    }

    public function delete(Student $student): bool
    {
        return (bool) $student->delete();
    }
}
