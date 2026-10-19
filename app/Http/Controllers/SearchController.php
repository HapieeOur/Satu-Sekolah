<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\InternshipCompany;
use App\Models\Post;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SearchController extends Controller
{
    /**
     * Display the global search results page.
     */
    public function index(Request $request): View
    {
        $query = trim((string) $request->input('q', ''));
        $user = Auth::user();

        $results = [
            'students' => collect(),
            'teachers' => collect(),
            'classrooms' => collect(),
            'subjects' => collect(),
            'posts' => collect(),
            'companies' => collect(),
        ];

        $totalCount = 0;

        if (strlen($query) >= 2) {
            // 1. Students
            $results['students'] = Student::with('classroom')
                ->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                        ->orWhere('nis', 'like', "%{$query}%");
                })
                ->take(10)
                ->get();

            // 2. Teachers
            $results['teachers'] = Teacher::with('subjects')
                ->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                        ->orWhere('nip', 'like', "%{$query}%");
                })
                ->take(10)
                ->get();

            // 3. Classrooms
            $results['classrooms'] = Classroom::with('homeroomTeacher')
                ->where('name', 'like', "%{$query}%")
                ->take(10)
                ->get();

            // 4. Subjects
            $results['subjects'] = Subject::where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('code', 'like', "%{$query}%");
            })
                ->take(10)
                ->get();

            // 5. Posts (News, Announcements, Events)
            $results['posts'] = Post::where('title', 'like', "%{$query}%")
                ->latest()
                ->take(10)
                ->get();

            // 6. Companies (PKL)
            $results['companies'] = InternshipCompany::where('name', 'like', "%{$query}%")
                ->orWhere('address', 'like', "%{$query}%")
                ->take(10)
                ->get();

            foreach ($results as $itemCollection) {
                $totalCount += $itemCollection->count();
            }
        }

        return view('search.index', compact('query', 'results', 'totalCount', 'user'));
    }

    /**
     * Provide JSON results for instant autocomplete in topbar/command palette.
     */
    public function api(Request $request): JsonResponse
    {
        $query = trim((string) $request->input('q', ''));
        $user = Auth::user();

        if (strlen($query) < 2) {
            return response()->json(['items' => []]);
        }

        $items = collect();

        // Students
        $students = Student::with('classroom')
            ->where('name', 'like', "%{$query}%")
            ->orWhere('nis', 'like', "%{$query}%")
            ->take(5)
            ->get();

        foreach ($students as $s) {
            $url = $user->hasRole('admin')
                ? route('admin.students.edit', $s->id)
                : ($user->hasRole('guru_pembimbing_pkl') ? route('internship-mentor.students.show', $s->id) : route('search.index', ['q' => $s->name]));

            $items->push([
                'title' => $s->name,
                'subtitle' => 'Siswa NIS: '.$s->nis.($s->classroom ? ' ('.$s->classroom->name.')' : ''),
                'category' => 'Siswa',
                'url' => $url,
            ]);
        }

        // Teachers
        $teachers = Teacher::where('name', 'like', "%{$query}%")
            ->orWhere('nip', 'like', "%{$query}%")
            ->take(5)
            ->get();

        foreach ($teachers as $t) {
            $url = $user->hasRole('admin')
                ? route('admin.teachers.edit', $t->id)
                : route('search.index', ['q' => $t->name]);

            $items->push([
                'title' => $t->name,
                'subtitle' => 'Guru NIP: '.($t->nip ?: '-'),
                'category' => 'Guru',
                'url' => $url,
            ]);
        }

        // Classrooms
        $classrooms = Classroom::where('name', 'like', "%{$query}%")->take(5)->get();
        foreach ($classrooms as $c) {
            $url = $user->hasRole('admin')
                ? route('admin.classrooms.edit', $c->id)
                : ($user->hasRole('wali_kelas') ? route('homeroom.dashboard') : route('search.index', ['q' => $c->name]));

            $items->push([
                'title' => 'Kelas '.$c->name,
                'subtitle' => 'Tingkat '.$c->level.' '.$c->major,
                'category' => 'Kelas',
                'url' => $url,
            ]);
        }

        // Posts
        $posts = Post::where('title', 'like', "%{$query}%")->take(5)->get();
        foreach ($posts as $p) {
            $postUrl = match ($p->category) {
                'berita' => route('public.news.show', $p->slug),
                'pengumuman' => route('public.announcements.show', $p->slug),
                'acara' => route('public.events.show', $p->slug),
                default => route('public.news.show', $p->slug),
            };

            $items->push([
                'title' => $p->title,
                'subtitle' => ucfirst((string) $p->category).' - '.($p->published_at ? $p->published_at->format('d M Y') : 'Draft'),
                'category' => 'Publikasi',
                'url' => $postUrl,
            ]);
        }

        return response()->json(['items' => $items->take(12)]);
    }
}
