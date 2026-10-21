<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminPostController extends AdminBaseController
{
    /**
     * Display a listing of posts.
     */
    public function index(Request $request): JsonResponse
    {
        $this->authorizeAdmin();

        $query = Post::with('user')->latest();

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $perPage = (int) $request->input('per_page', 50);
        $posts = $query->paginate($perPage);

        $formatted = $posts->getCollection()->map(function ($p) {
            return [
                'id' => $p->id,
                'title' => $p->title,
                'slug' => $p->slug,
                'category' => $p->category,
                'excerpt' => $p->excerpt ?? Str::limit(strip_tags($p->content), 120),
                'content' => $p->content,
                'is_published' => (bool) $p->is_published,
                'published_at' => $p->published_at?->format('Y-m-d H:i') ?? $p->created_at?->format('Y-m-d H:i'),
                'author' => $p->user?->name ?? 'Admin Sekolah',
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Daftar pos berita & pengumuman berhasil diambil.',
            'data' => $formatted,
            'meta' => [
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'per_page' => $posts->perPage(),
                'total' => $posts->total(),
            ],
        ]);
    }

    /**
     * Store post.
     */
    public function store(Request $request): JsonResponse
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:berita,pengumuman,agenda'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'is_published' => ['nullable', 'boolean'],
            'event_date' => ['nullable', 'date'],
            'event_time' => ['nullable', 'string'],
            'event_location' => ['nullable', 'string', 'max:255'],
        ]);

        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $counter = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        $isPublished = $validated['is_published'] ?? true;

        $post = Post::create([
            'user_id' => $this->currentUser()?->id,
            'title' => $validated['title'],
            'slug' => $slug,
            'category' => $validated['category'],
            'excerpt' => $validated['excerpt'] ?? null,
            'content' => $validated['content'],
            'is_published' => $isPublished,
            'published_at' => $isPublished ? now() : null,
            'event_date' => $validated['event_date'] ?? null,
            'event_time' => $validated['event_time'] ?? null,
            'event_location' => $validated['event_location'] ?? null,
        ]);

        return $this->respondWithSuccess([
            'id' => $post->id,
            'title' => $post->title,
            'slug' => $post->slug,
            'category' => $post->category,
        ], 'Publikasi berhasil diterbitkan.', 201);
    }

    /**
     * Delete post.
     */
    public function destroy(Post $post): JsonResponse
    {
        $this->authorizeAdmin();

        $title = $post->title;
        $post->delete();

        return $this->respondWithSuccess(null, "Publikasi \"{$title}\" berhasil dihapus.");
    }
}
