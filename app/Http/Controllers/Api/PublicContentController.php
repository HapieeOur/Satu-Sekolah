<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\PostResource;
use App\Models\AcademicYear;
use App\Models\Classroom;
use App\Models\InternshipCompany;
use App\Models\Post;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublicContentController extends ApiController
{
    /**
     * Get published school news.
     */
    public function news(Request $request): JsonResponse
    {
        $query = Post::with('author')
            ->published()
            ->news()
            ->latest('published_at');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $news = $query->paginate(10);

        return $this->respondWithPagination($news, PostResource::class, 'Daftar berita sekolah.');
    }

    /**
     * Get single news item by slug.
     */
    public function newsShow(string $slug): JsonResponse
    {
        $post = Post::with('author')
            ->published()
            ->news()
            ->where('slug', $slug)
            ->first();

        if (! $post) {
            return $this->respondWithError('Berita tidak ditemukan.', 404);
        }

        return $this->respondWithSuccess(new PostResource($post), 'Detail berita sekolah.');
    }

    /**
     * Get published announcements.
     */
    public function announcements(Request $request): JsonResponse
    {
        $query = Post::with('author')
            ->published()
            ->announcements()
            ->latest('published_at');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $announcements = $query->paginate(10);

        return $this->respondWithPagination($announcements, PostResource::class, 'Daftar pengumuman sekolah.');
    }

    /**
     * Get single announcement by slug.
     */
    public function announcementShow(string $slug): JsonResponse
    {
        $post = Post::with('author')
            ->published()
            ->announcements()
            ->where('slug', $slug)
            ->first();

        if (! $post) {
            return $this->respondWithError('Pengumuman tidak ditemukan.', 404);
        }

        return $this->respondWithSuccess(new PostResource($post), 'Detail pengumuman sekolah.');
    }

    /**
     * Get school events agenda.
     */
    public function events(Request $request): JsonResponse
    {
        $query = Post::with('author')
            ->published()
            ->events();

        if ($request->boolean('upcoming_only', false)) {
            $query->where(function ($q) {
                $q->where('event_date', '>=', now()->toDateString())
                    ->orWhereNull('event_date');
            })->orderBy('event_date', 'asc');
        } else {
            $query->latest('published_at');
        }

        $events = $query->paginate(10);

        return $this->respondWithPagination($events, PostResource::class, 'Daftar agenda kegiatan sekolah.');
    }

    /**
     * Get single event by slug.
     */
    public function eventShow(string $slug): JsonResponse
    {
        $post = Post::with('author')
            ->published()
            ->events()
            ->where('slug', $slug)
            ->first();

        if (! $post) {
            return $this->respondWithError('Agenda kegiatan tidak ditemukan.', 404);
        }

        return $this->respondWithSuccess(new PostResource($post), 'Detail agenda kegiatan.');
    }

    /**
     * Get school general profile & statistics.
     */
    public function schoolProfile(): JsonResponse
    {
        $activeYear = AcademicYear::where('is_active', true)->first();

        $stats = [
            'total_students' => Student::where('status', 'aktif')->count(),
            'total_teachers' => Teacher::count(),
            'total_classrooms' => Classroom::count(),
            'total_companies' => InternshipCompany::count(),
        ];

        return $this->respondWithSuccess([
            'school_name' => config('app.name', 'OneSchool'),
            'app_version' => '1.0.0',
            'academic_year' => $activeYear ? [
                'id' => $activeYear->id,
                'name' => $activeYear->name,
                'semester' => $activeYear->semester,
            ] : null,
            'statistics' => $stats,
        ], 'Informasi profil sekolah.');
    }
}
