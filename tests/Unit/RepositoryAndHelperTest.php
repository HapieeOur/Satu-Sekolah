<?php

namespace Tests\Unit;

use App\Contracts\Repositories\AcademicYearRepositoryInterface;
use App\Contracts\Repositories\ClassroomRepositoryInterface;
use App\Contracts\Repositories\InternshipCompanyRepositoryInterface;
use App\Contracts\Repositories\RoomRepositoryInterface;
use App\Contracts\Repositories\StudentRepositoryInterface;
use App\Contracts\Repositories\SubjectRepositoryInterface;
use App\Contracts\Repositories\TeacherRepositoryInterface;
use App\Enums\Gender;
use App\Enums\Semester;
use App\Enums\StudentStatus;
use App\Helpers\SchoolHelper;
use App\Repositories\AcademicYearRepository;
use App\Repositories\ClassroomRepository;
use App\Repositories\InternshipCompanyRepository;
use App\Repositories\RoomRepository;
use App\Repositories\StudentRepository;
use App\Repositories\SubjectRepository;
use App\Repositories\TeacherRepository;
use Tests\TestCase;

class RepositoryAndHelperTest extends TestCase
{
    public function test_school_helper_formats_nip(): void
    {
        $formatted = SchoolHelper::formatNip('198001012005011001');
        $this->assertEquals('19800101 200501 1 001', $formatted);

        $short = SchoolHelper::formatNip('12345');
        $this->assertEquals('12345', $short);

        $null = SchoolHelper::formatNip(null);
        $this->assertEquals('-', $null);
    }

    public function test_school_helper_calculates_distance_in_meters(): void
    {
        // Distance between Monas Jakarta (-6.175392, 106.827153) and Istiqlal Mosque (-6.170170, 106.831388) is ~750-800m
        $distance = SchoolHelper::calculateDistanceMeters(-6.175392, 106.827153, -6.170170, 106.831388);
        $this->assertGreaterThan(700, $distance);
        $this->assertLessThan(900, $distance);
    }

    public function test_enums_provide_correct_labels(): void
    {
        $this->assertEquals('Semester Ganjil (1)', Semester::GANJIL->label());
        $this->assertEquals('Semester Genap (2)', Semester::GENAP->label());

        $this->assertEquals('Aktif', StudentStatus::AKTIF->label());
        $this->assertStringContainsString('emerald', StudentStatus::AKTIF->badgeClass());

        $this->assertEquals('Laki-laki', Gender::MALE->label());
        $this->assertEquals('Perempuan', Gender::FEMALE->label());
    }

    public function test_repositories_are_properly_bound_in_container(): void
    {
        $this->assertInstanceOf(AcademicYearRepository::class, app(AcademicYearRepositoryInterface::class));
        $this->assertInstanceOf(TeacherRepository::class, app(TeacherRepositoryInterface::class));
        $this->assertInstanceOf(ClassroomRepository::class, app(ClassroomRepositoryInterface::class));
        $this->assertInstanceOf(StudentRepository::class, app(StudentRepositoryInterface::class));
        $this->assertInstanceOf(SubjectRepository::class, app(SubjectRepositoryInterface::class));
        $this->assertInstanceOf(RoomRepository::class, app(RoomRepositoryInterface::class));
        $this->assertInstanceOf(InternshipCompanyRepository::class, app(InternshipCompanyRepositoryInterface::class));
    }
}
