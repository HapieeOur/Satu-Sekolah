<?php

namespace App\Http\Controllers\Public;

use App\Contracts\Services\PostServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PublicPageController extends Controller
{
    /**
     * Dependency injection of PostServiceInterface (DIP).
     */
    public function __construct(
        protected PostServiceInterface $postService
    ) {}

    /**
     * Display public landing page.
     */
    public function home(): View
    {
        $latestNews = $this->postService->getLatestNews(3);
        $announcements = $this->postService->getLatestAnnouncements(4);
        $upcomingEvents = $this->postService->getLatestUpcomingEvents(3);

        return view('public.home', compact('latestNews', 'announcements', 'upcomingEvents'));
    }

    /**
     * Display school profile page.
     */
    public function profile(): View
    {
        return view('public.profile');
    }

    /**
     * Display published news listing.
     */
    public function news(): View
    {
        $newsList = $this->postService->getPublishedNews(6);

        return view('public.news.index', compact('newsList'));
    }

    /**
     * Display single news article.
     */
    public function newsShow(string $slug): View
    {
        $post = $this->postService->findPublishedBySlugOrFail($slug, 'berita');

        return view('public.news.show', compact('post'));
    }

    /**
     * Display public announcements listing.
     */
    public function announcements(): View
    {
        $announcements = $this->postService->getPublishedAnnouncements(10);

        return view('public.announcements.index', compact('announcements'));
    }

    /**
     * Display single announcement.
     */
    public function announcementShow(string $slug): View
    {
        $post = $this->postService->findPublishedBySlugOrFail($slug, 'pengumuman');

        return view('public.announcements.show', compact('post'));
    }

    /**
     * Display school events listing.
     */
    public function events(): View
    {
        $events = $this->postService->getUpcomingEvents(9);

        return view('public.events.index', compact('events'));
    }

    /**
     * Display single school event detail.
     */
    public function eventShow(string $slug): View
    {
        $post = $this->postService->findPublishedBySlugOrFail($slug, 'acara');

        return view('public.events.show', compact('post'));
    }
}
