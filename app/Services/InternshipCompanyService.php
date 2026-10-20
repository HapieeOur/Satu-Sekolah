<?php

namespace App\Services;

use App\Contracts\Repositories\InternshipCompanyRepositoryInterface;
use App\Contracts\Services\InternshipCompanyServiceInterface;
use App\Models\InternshipCompany;
use App\Models\Teacher;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class InternshipCompanyService implements InternshipCompanyServiceInterface
{
    public function __construct(
        protected InternshipCompanyRepositoryInterface $internshipCompanyRepository
    ) {}

    public function getPaginated(int $perPage = 15, ?string $search = null): LengthAwarePaginator
    {
        return $this->internshipCompanyRepository->getPaginated($perPage, $search);
    }

    public function getAll(): Collection
    {
        return $this->internshipCompanyRepository->getAll();
    }

    public function create(array $data): InternshipCompany
    {
        $company = $this->internshipCompanyRepository->create([
            'teacher_id' => $data['teacher_id'] ?? null,
            'name' => $data['name'],
            'address' => $data['address'],
            'contact_person' => $data['contact_person'] ?? null,
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,
            'radius_meters' => $data['radius_meters'] ?? 100,
        ]);

        if (! empty($data['teacher_id'])) {
            $this->ensureTeacherHasMentorRole((int) $data['teacher_id']);
        }

        return $company;
    }

    public function update(InternshipCompany $internshipCompany, array $data): InternshipCompany
    {
        $company = $this->internshipCompanyRepository->update($internshipCompany, [
            'teacher_id' => $data['teacher_id'] ?? null,
            'name' => $data['name'],
            'address' => $data['address'],
            'contact_person' => $data['contact_person'] ?? null,
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,
            'radius_meters' => $data['radius_meters'] ?? 100,
        ]);

        if (! empty($data['teacher_id'])) {
            $this->ensureTeacherHasMentorRole((int) $data['teacher_id']);
        }

        return $company;
    }

    protected function ensureTeacherHasMentorRole(int $teacherId): void
    {
        $teacher = Teacher::with('user')->find($teacherId);
        if ($teacher?->user && ! $teacher->user->hasRole('guru_pembimbing_pkl')) {
            $teacher->user->assignRole('guru_pembimbing_pkl');
        }
    }

    public function delete(InternshipCompany $internshipCompany): bool
    {
        return $this->internshipCompanyRepository->delete($internshipCompany);
    }
}
