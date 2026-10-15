<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Homeroom\HomeroomDashboardController;
use App\Http\Controllers\Internship\InternshipMentorDashboardController;
use App\Http\Controllers\Public\PublicPageController;
use App\Http\Controllers\Teacher\TeacherDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes (Accessible by Anyone Without Login)
Route::get('/', [PublicPageController::class, 'home'])->name('home');
Route::get('/profil', [PublicPageController::class, 'profile'])->name('public.profile');

Route::prefix('berita')->name('public.news.')->group(function () {
    Route::get('/', [PublicPageController::class, 'news'])->name('index');
    Route::get('/{slug}', [PublicPageController::class, 'newsShow'])->name('show');
});

Route::prefix('pengumuman')->name('public.announcements.')->group(function () {
    Route::get('/', [PublicPageController::class, 'announcements'])->name('index');
    Route::get('/{slug}', [PublicPageController::class, 'announcementShow'])->name('show');
});

Route::prefix('acara')->name('public.events.')->group(function () {
    Route::get('/', [PublicPageController::class, 'events'])->name('index');
    Route::get('/{slug}', [PublicPageController::class, 'eventShow'])->name('show');
});

// Guest Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Authenticated Internal Management Routes (Admin & Guru)
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
    });

    // Guru Area
    Route::prefix('teacher')->name('teacher.')->middleware('role:guru')->group(function () {
        Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');
    });

    // Wali Kelas Area
    Route::prefix('homeroom')->name('homeroom.')->middleware('role:wali_kelas')->group(function () {
        Route::get('/dashboard', [HomeroomDashboardController::class, 'index'])->name('dashboard');
    });

    // Guru Pembimbing PKL Area
    Route::prefix('internship-mentor')->name('internship-mentor.')->middleware('role:guru_pembimbing_pkl')->group(function () {
        Route::get('/dashboard', [InternshipMentorDashboardController::class, 'index'])->name('dashboard');
    });
});
