<?php

namespace App\Services;

use App\Contracts\Services\ClassroomServiceInterface;
use App\Models\Classroom;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ClassroomService implements ClassroomServiceInterface
{
    public function getPaginated(int $perPage = 15, ?int $academicYearId = null, ?int $gradeLevel = null): LengthAwarePaginator
    {
        $query = Classroom::with(['academicYear', 'homeroomTeacher.user', 'students'])->latest();

        if ($academicYearId) {
            $query->where('academic_year_id', $academicYearId);
        }

        if ($gradeLevel) {
            $query->where('grade_level', $gradeLevel);
        }

        return $query->paginate($perPage);
    }

    public function getAllForActiveYear(): Collection
    {
        return Classroom::whereHas('academicYear', function ($q) {
            $q->where('is_active', true);
        })->orderBy('grade_level')->orderBy('name')->get();
    }

    public function create(array $data): Classroom
    {
        return Classroom::create([
            'name' => $data['name'],
            'grade_level' => $data['grade_level'],
            'major' => $data['major'],
            'academic_year_id' => $data['academic_year_id'],
            'teacher_id' => $data['teacher_id'] ?? null,
        ]);
    }

    public function update(Classroom $classroom, array $data): Classroom
    {
        $classroom->update([
            'name' => $data['name'],
            'grade_level' => $data['grade_level'],
            'major' => $data['major'],
            'academic_year_id' => $data['academic_year_id'],
            'teacher_id' => $data['teacher_id'] ?? null,
        ]);

        return $classroom;
    }

    public function delete(Classroom $classroom): bool
    {
        return (bool) $classroom->delete();
    }
}
