<?php

use App\Http\Controllers\Api\Admin\AdminAcademicYearController;
use App\Http\Controllers\Api\Admin\AdminClassroomController;
use App\Http\Controllers\Api\Admin\AdminCompanyController;
use App\Http\Controllers\Api\Admin\AdminDashboardController;
use App\Http\Controllers\Api\Admin\AdminPostController;
use App\Http\Controllers\Api\Admin\AdminRoomController;
use App\Http\Controllers\Api\Admin\AdminStudentController;
use App\Http\Controllers\Api\Admin\AdminSubjectController;
use App\Http\Controllers\Api\Admin\AdminTeacherController;
use App\Http\Controllers\Api\Admin\AdminUserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Mentor\MentorInternshipController;
use App\Http\Controllers\Api\PublicContentController;
use App\Http\Controllers\Api\Student\StudentAcademicController;
use App\Http\Controllers\Api\Student\StudentInternshipController;
use App\Http\Controllers\Api\Teacher\TeacherMobileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Mobile REST API Routes (v1)
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {

    // --- 1. Public School Content ---
    Route::get('/posts/news', [PublicContentController::class, 'news']);
    Route::get('/posts/news/{slug}', [PublicContentController::class, 'newsShow']);
    Route::get('/posts/announcements', [PublicContentController::class, 'announcements']);
    Route::get('/posts/announcements/{slug}', [PublicContentController::class, 'announcementShow']);
    Route::get('/posts/events', [PublicContentController::class, 'events']);
    Route::get('/posts/events/{slug}', [PublicContentController::class, 'eventShow']);
    Route::get('/school/profile', [PublicContentController::class, 'schoolProfile']);

    // --- 2. Authentication ---
    Route::post('/auth/login', [AuthController::class, 'login']);

    // --- 3. Authenticated Routes (Bearer Token via Sanctum) ---
    Route::middleware(['auth:sanctum', 'active'])->group(function () {
        Route::get('/auth/me', [AuthController::class, 'me']);
        Route::post('/auth/logout', [AuthController::class, 'logout']);

        // --- 4. Siswa (Student) Area ---
        Route::prefix('student')->group(function () {
            // PKL / Magang
            Route::get('/internship/placement', [StudentInternshipController::class, 'placement']);
            Route::post('/internship/attendance/check-in', [StudentInternshipController::class, 'checkIn']);
            Route::post('/internship/attendance/check-out', [StudentInternshipController::class, 'checkOut']);
            Route::get('/internship/attendances', [StudentInternshipController::class, 'attendances']);

            // Jurnal Harian PKL
            Route::get('/internship/journals', [StudentInternshipController::class, 'journals']);
            Route::post('/internship/journals', [StudentInternshipController::class, 'storeJournal']);
            Route::get('/internship/journals/{journal}', [StudentInternshipController::class, 'showJournal']);
            Route::put('/internship/journals/{journal}', [StudentInternshipController::class, 'updateJournal']);

            // Pengajuan Izin / Sakit PKL
            Route::get('/internship/leaves', [StudentInternshipController::class, 'leaves']);
            Route::post('/internship/leaves', [StudentInternshipController::class, 'storeLeave']);

            // Tugas PKL
            Route::get('/internship/tasks', [StudentInternshipController::class, 'tasks']);
            Route::get('/internship/tasks/{task}', [StudentInternshipController::class, 'showTask']);
            Route::post('/internship/tasks/{task}/submit', [StudentInternshipController::class, 'submitTask']);

            // Akademik
            Route::get('/schedules', [StudentAcademicController::class, 'schedules']);
            Route::get('/attendances', [StudentAcademicController::class, 'attendances']);
            Route::post('/attendances/check-in', [StudentAcademicController::class, 'checkIn']);
            Route::post('/attendances/check-out', [StudentAcademicController::class, 'checkOut']);

            // Tugas Mata Pelajaran Kelas
            Route::get('/tasks', [StudentAcademicController::class, 'tasks']);
            Route::get('/tasks/{task}', [StudentAcademicController::class, 'showTask']);
            Route::post('/tasks/{task}/submit', [StudentAcademicController::class, 'submitTask']);
        });

        // --- 5. Guru Pembimbing PKL (Mentor) Area ---
        Route::prefix('mentor')->group(function () {
            Route::get('/mentees', [MentorInternshipController::class, 'mentees']);
            Route::get('/attendances', [MentorInternshipController::class, 'attendances']);
            Route::post('/attendances/{attendance}/verify', [MentorInternshipController::class, 'verifyAttendance']);

            Route::get('/journals', [MentorInternshipController::class, 'journals']);
            Route::post('/journals/{journal}/review', [MentorInternshipController::class, 'reviewJournal']);

            Route::get('/leaves', [MentorInternshipController::class, 'leaves']);
            Route::post('/leaves/{leave}/review', [MentorInternshipController::class, 'reviewLeave']);

            Route::get('/tasks', [MentorInternshipController::class, 'tasks']);
            Route::post('/tasks', [MentorInternshipController::class, 'storeTask']);
            Route::post('/tasks/submissions/{submission}/grade', [MentorInternshipController::class, 'gradeSubmission']);
        });

        // --- 6. Guru (Teacher) Area ---
        Route::prefix('teacher')->group(function () {
            Route::get('/schedules', [TeacherMobileController::class, 'schedules']);
            Route::get('/classrooms/{classroom}/students', [TeacherMobileController::class, 'studentsByClassroom']);
            Route::post('/attendances', [TeacherMobileController::class, 'storeAttendance']);

            // Tugas & Penugasan Siswa
            Route::get('/tasks', [TeacherMobileController::class, 'tasks']);
            Route::post('/tasks', [TeacherMobileController::class, 'storeTask']);
            Route::post('/tasks/submissions/{submission}/grade', [TeacherMobileController::class, 'gradeTaskSubmission']);
        });

        // --- 7. Admin Area (Web / React API) ---
        Route::prefix('admin')->group(function () {
            // Dashboard Stats
            Route::get('/stats', [AdminDashboardController::class, 'stats']);

            // User Management
            Route::get('/roles', [AdminUserController::class, 'roles']);
            Route::get('/users', [AdminUserController::class, 'index']);
            Route::post('/users', [AdminUserController::class, 'store']);
            Route::put('/users/{user}', [AdminUserController::class, 'update']);
            Route::post('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus']);
            Route::delete('/users/{user}', [AdminUserController::class, 'destroy']);

            // Teacher Management
            Route::get('/teachers/available-users', [AdminTeacherController::class, 'availableUsers']);
            Route::get('/teachers', [AdminTeacherController::class, 'index']);
            Route::post('/teachers', [AdminTeacherController::class, 'store']);
            Route::put('/teachers/{teacher}', [AdminTeacherController::class, 'update']);
            Route::delete('/teachers/{teacher}', [AdminTeacherController::class, 'destroy']);

            // Student Management
            Route::get('/students', [AdminStudentController::class, 'index']);
            Route::post('/students', [AdminStudentController::class, 'store']);
            Route::put('/students/{student}', [AdminStudentController::class, 'update']);
            Route::delete('/students/{student}', [AdminStudentController::class, 'destroy']);

            // Classroom Management
            Route::get('/classrooms', [AdminClassroomController::class, 'index']);
            Route::post('/classrooms', [AdminClassroomController::class, 'store']);
            Route::put('/classrooms/{classroom}', [AdminClassroomController::class, 'update']);
            Route::delete('/classrooms/{classroom}', [AdminClassroomController::class, 'destroy']);

            // Academic Year Management
            Route::get('/academic-years', [AdminAcademicYearController::class, 'index']);
            Route::post('/academic-years', [AdminAcademicYearController::class, 'store']);
            Route::put('/academic-years/{academicYear}', [AdminAcademicYearController::class, 'update']);
            Route::post('/academic-years/{academicYear}/set-active', [AdminAcademicYearController::class, 'setActive']);
            Route::delete('/academic-years/{academicYear}', [AdminAcademicYearController::class, 'destroy']);

            // Subject Management
            Route::get('/subjects', [AdminSubjectController::class, 'index']);
            Route::post('/subjects', [AdminSubjectController::class, 'store']);
            Route::put('/subjects/{subject}', [AdminSubjectController::class, 'update']);
            Route::delete('/subjects/{subject}', [AdminSubjectController::class, 'destroy']);

            // Room Management
            Route::get('/rooms', [AdminRoomController::class, 'index']);
            Route::post('/rooms', [AdminRoomController::class, 'store']);
            Route::put('/rooms/{room}', [AdminRoomController::class, 'update']);
            Route::delete('/rooms/{room}', [AdminRoomController::class, 'destroy']);

            // Company (Mitra DUDI) Management
            Route::get('/companies', [AdminCompanyController::class, 'index']);
            Route::post('/companies', [AdminCompanyController::class, 'store']);
            Route::put('/companies/{company}', [AdminCompanyController::class, 'update']);
            Route::delete('/companies/{company}', [AdminCompanyController::class, 'destroy']);

            // Post (News & Announcements) Management
            Route::get('/posts', [AdminPostController::class, 'index']);
            Route::post('/posts', [AdminPostController::class, 'store']);
            Route::put('/posts/{post}', [AdminPostController::class, 'update']);
            Route::delete('/posts/{post}', [AdminPostController::class, 'destroy']);
        });
    });
});
