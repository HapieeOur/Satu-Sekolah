<?php

namespace App\Contracts\Services;

use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface PostServiceInterface
{
    /**
     * Get paginated published news.
     */
    public function getPublishedNews(int $perPage = 6): LengthAwarePaginator;

    /**
     * Get latest published news for home page.
     */
    public function getLatestNews(int $limit = 3): Collection;

    /**
     * Get paginated published announcements.
     */
    public function getPublishedAnnouncements(int $perPage = 10): LengthAwarePaginator;

    /**
     * Get latest published announcements for home page.
     */
    public function getLatestAnnouncements(int $limit = 4): Collection;

    /**
     * Get paginated upcoming school events.
     */
    public function getUpcomingEvents(int $perPage = 9): LengthAwarePaginator;

    /**
     * Get latest upcoming school events for home page.
     */
    public function getLatestUpcomingEvents(int $limit = 3): Collection;

    /**
     * Find a published post by slug and optional category, aborting 404 if not found or unpublished.
     */
    public function findPublishedBySlugOrFail(string $slug, ?string $category = null): Post;
}
