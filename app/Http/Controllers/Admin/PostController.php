<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Services\PostServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePostRequest;
use App\Http\Requests\Admin\UpdatePostRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PostController extends Controller
{
    public function __construct(
        protected PostServiceInterface $postService
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['category', 'is_published', 'search']);
        $posts = $this->postService->getAdminPosts($filters);

        return view('admin.posts.index', compact('posts', 'filters'));
    }

    public function create(): View
    {
        return view('admin.posts.create');
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        $this->postService->createPost($request->validated(), Auth::id());

        return redirect()->route('admin.posts.index')->with('success', 'Konten publikasi berhasil dibuat.');
    }

    public function edit(int $id): View
    {
        $post = $this->postService->findPostById($id);

        return view('admin.posts.edit', compact('post'));
    }

    public function update(UpdatePostRequest $request, int $id): RedirectResponse
    {
        $this->postService->updatePost($id, $request->validated());

        return redirect()->route('admin.posts.index')->with('success', 'Konten publikasi berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->postService->deletePost($id);

        return redirect()->route('admin.posts.index')->with('success', 'Konten publikasi berhasil dihapus.');
    }

    public function togglePublish(int $id): RedirectResponse
    {
        $post = $this->postService->togglePublish($id);
        $statusText = $post->is_published ? 'diterbitkan secara publik' : 'diarsipkan (draf)';

        return back()->with('success', "Status konten '{$post->title}' berhasil diubah menjadi {$statusText}.");
    }
}
