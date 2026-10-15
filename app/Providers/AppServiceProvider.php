<?php

namespace App\Providers;

use App\Contracts\Repositories\AcademicYearRepositoryInterface;
use App\Contracts\Repositories\ClassroomRepositoryInterface;
use App\Contracts\Repositories\InternshipCompanyRepositoryInterface;
use App\Contracts\Repositories\RoomRepositoryInterface;
use App\Contracts\Repositories\StudentRepositoryInterface;
use App\Contracts\Repositories\SubjectRepositoryInterface;
use App\Contracts\Repositories\TeacherRepositoryInterface;
use App\Contracts\Services\AcademicYearServiceInterface;
use App\Contracts\Services\ClassroomServiceInterface;
use App\Contracts\Services\InternshipCompanyServiceInterface;
use App\Contracts\Services\PostServiceInterface;
use App\Contracts\Services\RoomServiceInterface;
use App\Contracts\Services\StudentServiceInterface;
use App\Contracts\Services\SubjectServiceInterface;
use App\Contracts\Services\TeacherServiceInterface;
use App\Contracts\Services\UserServiceInterface;
use App\Models\User;
use App\Policies\UserPolicy;
use App\Repositories\AcademicYearRepository;
use App\Repositories\ClassroomRepository;
use App\Repositories\InternshipCompanyRepository;
use App\Repositories\RoomRepository;
use App\Repositories\StudentRepository;
use App\Repositories\SubjectRepository;
use App\Repositories\TeacherRepository;
use App\Services\AcademicYearService;
use App\Services\ClassroomService;
use App\Services\InternshipCompanyService;
use App\Services\PostService;
use App\Services\RoomService;
use App\Services\StudentService;
use App\Services\SubjectService;
use App\Services\TeacherService;
use App\Services\UserService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserServiceInterface::class,
            UserService::class
        );

        $this->app->bind(
            PostServiceInterface::class,
            PostService::class
        );

        $this->app->bind(
            AcademicYearServiceInterface::class,
            AcademicYearService::class
        );

        $this->app->bind(
            TeacherServiceInterface::class,
            TeacherService::class
        );

        $this->app->bind(
            ClassroomServiceInterface::class,
            ClassroomService::class
        );

        $this->app->bind(
            StudentServiceInterface::class,
            StudentService::class
        );

        $this->app->bind(
            SubjectServiceInterface::class,
            SubjectService::class
        );

        $this->app->bind(
            RoomServiceInterface::class,
            RoomService::class
        );

        $this->app->bind(
            InternshipCompanyServiceInterface::class,
            InternshipCompanyService::class
        );

        // Repositories
        $this->app->bind(
            AcademicYearRepositoryInterface::class,
            AcademicYearRepository::class
        );

        $this->app->bind(
            TeacherRepositoryInterface::class,
            TeacherRepository::class
        );

        $this->app->bind(
            ClassroomRepositoryInterface::class,
            ClassroomRepository::class
        );

        $this->app->bind(
            StudentRepositoryInterface::class,
            StudentRepository::class
        );

        $this->app->bind(
            SubjectRepositoryInterface::class,
            SubjectRepository::class
        );

        $this->app->bind(
            RoomRepositoryInterface::class,
            RoomRepository::class
        );

        $this->app->bind(
            InternshipCompanyRepositoryInterface::class,
            InternshipCompanyRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(User::class, UserPolicy::class);
    }
}
