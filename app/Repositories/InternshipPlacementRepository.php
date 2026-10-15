<?php

namespace App\Repositories;

use App\Contracts\Repositories\InternshipPlacementRepositoryInterface;
use App\Models\InternshipPlacement;
use App\Models\Student;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class InternshipPlacementRepository implements InternshipPlacementRepositoryInterface
{
    public function getPaginated(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = InternshipPlacement::with(['student.classroom', 'company', 'teacher.user', 'academicYear']);

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        if (! empty($filters['company_id'])) {
            $query->where('internship_company_id', $filters['company_id']);
        }

        if (! empty($filters['teacher_id'])) {
            $query->where('teacher_id', $filters['teacher_id']);
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['academic_year_id'])) {
            $query->where('academic_year_id', $filters['academic_year_id']);
        }

        return $query->latest()->paginate($perPage)->withQueryString();
    }

    public function findById(int $id): ?InternshipPlacement
    {
        return InternshipPlacement::with(['student.classroom', 'company', 'teacher.user', 'academicYear'])->find($id);
    }

    public function getMenteesForTeacher(int $teacherId, array $filters = []): Collection
    {
        $query = InternshipPlacement::with(['student.classroom', 'company', 'academicYear'])
            ->where('teacher_id', $teacherId);

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['company_id'])) {
            $query->where('internship_company_id', $filters['company_id']);
        }

        return $query->get();
    }

    public function getPlacementsForClassroom(int $classroomId): Collection
    {
        return InternshipPlacement::with(['student', 'company', 'teacher.user'])
            ->whereHas('student', function ($q) use ($classroomId) {
                $q->where('classroom_id', $classroomId);
            })
            ->get();
    }

    public function create(array $data): InternshipPlacement
    {
        return InternshipPlacement::create($data);
    }

    public function update(int $id, array $data): InternshipPlacement
    {
        $placement = InternshipPlacement::findOrFail($id);
        $placement->update($data);

        return $placement->fresh(['student.classroom', 'company', 'teacher.user', 'academicYear']);
    }

    public function delete(int $id): bool
    {
        $placement = InternshipPlacement::findOrFail($id);

        return (bool) $placement->delete();
    }

    public function getAvailableStudentsForPlacement(int $academicYearId, ?int $exceptStudentId = null): Collection
    {
        $placedStudentIds = InternshipPlacement::where('academic_year_id', $academicYearId)
            ->when($exceptStudentId, function ($q) use ($exceptStudentId) {
                $q->where('student_id', '!=', $exceptStudentId);
            })
            ->pluck('student_id');

        return Student::with('classroom')
            ->where('status', 'aktif')
            ->whereNotIn('id', $placedStudentIds)
            ->orderBy('name')
            ->get();
    }
}
