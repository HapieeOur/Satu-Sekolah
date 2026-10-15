<?php

namespace App\Services;

use App\Contracts\Services\PostServiceInterface;
use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class PostService implements PostServiceInterface
{
    /**
     * Get paginated published news.
     */
    public function getPublishedNews(int $perPage = 6): LengthAwarePaginator
    {
        return Post::published()
            ->news()
            ->latest('published_at')
            ->paginate($perPage);
    }

    /**
     * Get latest published news for home page.
     */
    public function getLatestNews(int $limit = 3): Collection
    {
        return Post::published()
            ->news()
            ->latest('published_at')
            ->take($limit)
            ->get();
    }

    /**
     * Get paginated published announcements.
     */
    public function getPublishedAnnouncements(int $perPage = 10): LengthAwarePaginator
    {
        return Post::published()
            ->announcements()
            ->latest('published_at')
            ->paginate($perPage);
    }

    /**
     * Get latest published announcements for home page.
     */
    public function getLatestAnnouncements(int $limit = 4): Collection
    {
        return Post::published()
            ->announcements()
            ->latest('published_at')
            ->take($limit)
            ->get();
    }

    /**
     * Get paginated upcoming school events.
     */
    public function getUpcomingEvents(int $perPage = 9): LengthAwarePaginator
    {
        return Post::published()
            ->upcomingEvents()
            ->paginate($perPage);
    }

    /**
     * Get latest upcoming school events for home page.
     */
    public function getLatestUpcomingEvents(int $limit = 3): Collection
    {
        return Post::published()
            ->upcomingEvents()
            ->take($limit)
            ->get();
    }

    /**
     * Find a published post by slug and optional category, aborting 404 if not found or unpublished.
     */
    public function findPublishedBySlugOrFail(string $slug, ?string $category = null): Post
    {
        $query = Post::published()->where('slug', $slug);

        if ($category !== null) {
            $query->category($category);
        }

        return $query->firstOrFail();
    }

    public function getAdminPosts(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Post::with('author');

        if (! empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        if (isset($filters['is_published']) && $filters['is_published'] !== '') {
            $query->where('is_published', (bool) $filters['is_published']);
        }

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        return $query->latest()->paginate($perPage)->withQueryString();
    }

    public function findPostById(int $id): Post
    {
        return Post::with('author')->findOrFail($id);
    }

    public function createPost(array $data, int $authorUserId): Post
    {
        $data['user_id'] = $authorUserId;

        if (! empty($data['is_published']) && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        return Post::create($data);
    }

    public function updatePost(int $id, array $data): Post
    {
        $post = Post::findOrFail($id);

        if (! empty($data['is_published']) && empty($post->published_at)) {
            $data['published_at'] = now();
        } elseif (isset($data['is_published']) && ! $data['is_published']) {
            $data['published_at'] = null;
        }

        $post->update($data);

        return $post->fresh('author');
    }

    public function deletePost(int $id): bool
    {
        $post = Post::findOrFail($id);

        return (bool) $post->delete();
    }

    public function togglePublish(int $id): Post
    {
        $post = Post::findOrFail($id);
        $newStatus = ! $post->is_published;

        $post->update([
            'is_published' => $newStatus,
            'published_at' => $newStatus ? ($post->published_at ?? now()) : null,
        ]);

        return $post;
    }
}
