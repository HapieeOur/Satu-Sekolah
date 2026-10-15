<?php

use App\Http\Controllers\Admin\AcademicYearController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ClassroomController;
use App\Http\Controllers\Admin\InternshipAttendanceController as AdminInternshipAttendanceController;
use App\Http\Controllers\Admin\InternshipCompanyController;
use App\Http\Controllers\Admin\InternshipPlacementController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Homeroom\HomeroomAttendanceController;
use App\Http\Controllers\Homeroom\HomeroomDashboardController;
use App\Http\Controllers\InternshipMentor\MentorAttendanceController;
use App\Http\Controllers\InternshipMentor\MentorDashboardController;
use App\Http\Controllers\InternshipMentor\MentorJournalController;
use App\Http\Controllers\InternshipMentor\MentorLeaveRequestController;
use App\Http\Controllers\InternshipMentor\MentorStudentController;
use App\Http\Controllers\InternshipMentor\MentorTaskController;
use App\Http\Controllers\Public\PublicPageController;
use App\Http\Controllers\Teacher\TeacherAttendanceController;
use App\Http\Controllers\Teacher\TeacherDashboardController;
use App\Http\Controllers\Teacher\TeacherScheduleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes (Accessible without authentication)
Route::get('/', [PublicPageController::class, 'home'])->name('public.home');
Route::get('/profil', [PublicPageController::class, 'profile'])->name('public.profile');
Route::get('/berita', [PublicPageController::class, 'news'])->name('public.news');
Route::get('/berita/{slug}', [PublicPageController::class, 'newsShow'])->name('public.news.show');
Route::get('/pengumuman', [PublicPageController::class, 'announcements'])->name('public.announcements');
Route::get('/pengumuman/{slug}', [PublicPageController::class, 'announcementShow'])->name('public.announcements.show');
Route::get('/acara', [PublicPageController::class, 'events'])->name('public.events');
Route::get('/acara/{slug}', [PublicPageController::class, 'eventShow'])->name('public.events.show');

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Authenticated Routes
Route::middleware(['auth', 'active'])->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Smart Dashboard Router
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Area
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // User Management
        Route::resource('users', UserController::class);
        Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

        // Data Master
        Route::resource('academic-years', AcademicYearController::class);
        Route::post('/academic-years/{academic_year}/set-active', [AcademicYearController::class, 'setActive'])->name('academic-years.set-active');

        Route::resource('teachers', TeacherController::class);
        Route::resource('classrooms', ClassroomController::class);
        Route::resource('students', StudentController::class);
        Route::resource('subjects', SubjectController::class);
        Route::resource('rooms', RoomController::class);
        Route::resource('internship-companies', InternshipCompanyController::class);

        // Jadwal Pelajaran
        Route::get('/schedules/teachers-by-subject/{subject}', [ScheduleController::class, 'teachersBySubject'])->name('schedules.teachers-by-subject');
        Route::resource('schedules', ScheduleController::class);

        // Monitoring PKL (Admin)
        Route::resource('internships/placements', InternshipPlacementController::class)->names('internships.placements');
        Route::get('internships/attendances', [AdminInternshipAttendanceController::class, 'index'])->name('internships.attendances.index');
        Route::post('internships/attendances/{attendance}/correct', [AdminInternshipAttendanceController::class, 'correct'])->name('internships.attendances.correct');
    });

    // Guru Area
    Route::prefix('teacher')->name('teacher.')->middleware('role:guru')->group(function () {
        Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');
        Route::get('/schedules', [TeacherScheduleController::class, 'index'])->name('schedules.index');
        Route::get('/attendances', [TeacherAttendanceController::class, 'index'])->name('attendances.index');
    });

    // Wali Kelas Area
    Route::prefix('homeroom')->name('homeroom.')->middleware('role:wali_kelas')->group(function () {
        Route::get('/dashboard', [HomeroomDashboardController::class, 'index'])->name('dashboard');
        Route::get('/attendances', [HomeroomAttendanceController::class, 'index'])->name('attendances.index');
    });

    // Guru Pembimbing PKL Area
    Route::prefix('internship-mentor')->name('internship-mentor.')->middleware('role:guru_pembimbing_pkl')->group(function () {
        Route::get('/dashboard', [MentorDashboardController::class, 'index'])->name('dashboard');
        Route::get('/students', [MentorStudentController::class, 'index'])->name('students.index');
        Route::get('/students/{student}', [MentorStudentController::class, 'show'])->name('students.show');

        // Presensi Siswa Bimbingan
        Route::get('/attendances', [MentorAttendanceController::class, 'index'])->name('attendances.index');
        Route::post('/attendances/{attendance}/verify', [MentorAttendanceController::class, 'verify'])->name('attendances.verify');

        // Jurnal Harian
        Route::get('/journals', [MentorJournalController::class, 'index'])->name('journals.index');
        Route::post('/journals/{journal}/review', [MentorJournalController::class, 'review'])->name('journals.review');

        // Pengajuan Izin / Sakit
        Route::get('/leaves', [MentorLeaveRequestController::class, 'index'])->name('leaves.index');
        Route::post('/leaves/{leave}/review', [MentorLeaveRequestController::class, 'review'])->name('leaves.review');

        // Tugas PKL
        Route::get('/tasks', [MentorTaskController::class, 'index'])->name('tasks.index');
        Route::post('/tasks', [MentorTaskController::class, 'store'])->name('tasks.store');
        Route::get('/tasks/{task}', [MentorTaskController::class, 'show'])->name('tasks.show');
        Route::post('/tasks/submissions/{submission}/grade', [MentorTaskController::class, 'grade'])->name('tasks.submissions.grade');
    });
});
