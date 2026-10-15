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
}
