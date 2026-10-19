<?php

namespace App\Http\Controllers;

use App\Models\InternshipJournal;
use App\Models\InternshipLeaveRequest;
use App\Models\Post;
use App\Models\Schedule;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Display the notification center with real contextual items.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $tab = $request->query('tab', 'all');

        $notifications = self::getUserNotifications($user);

        if ($tab === 'announcements') {
            $notifications = $notifications->where('category', 'announcement');
        } elseif ($tab === 'academic') {
            $notifications = $notifications->where('category', 'academic');
        } elseif ($tab === 'pkl') {
            $notifications = $notifications->where('category', 'pkl');
        }

        $unreadCount = $notifications->where('is_unread', true)->count();

        return view('notifications.index', compact('notifications', 'tab', 'unreadCount'));
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllRead(): RedirectResponse
    {
        session(['last_notifications_read_at' => Carbon::now()]);

        return redirect()->back()->with('success', 'Semua notifikasi berhasil ditandai telah dibaca.');
    }

    /**
     * Build contextual notifications based on user roles and real database activities.
     */
    public static function getUserNotifications($user): Collection
    {
        $items = collect();
        $lastRead = session('last_notifications_read_at', Carbon::now()->subDays(1));

        // 1. Published Announcements & School News
        $posts = Post::published()->latest('published_at')->take(5)->get();
        foreach ($posts as $post) {
            $url = match ($post->category) {
                'berita' => route('public.news.show', $post->slug),
                'pengumuman' => route('public.announcements.show', $post->slug),
                'acara' => route('public.events.show', $post->slug),
                default => route('public.news.show', $post->slug),
            };

            $items->push([
                'id' => 'post-'.$post->id,
                'title' => $post->title,
                'description' => $post->excerpt ?: 'Publikasi resmi sekolah kategori '.ucfirst((string) $post->category).'.',
                'category' => 'announcement',
                'category_label' => ucfirst((string) $post->category),
                'icon' => 'announcement',
                'time' => $post->published_at,
                'url' => $url,
                'is_unread' => $post->published_at?->isAfter($lastRead) ?? false,
            ]);
        }

        // 2. Role: Guru & Wali Kelas - Teaching Schedules & Attendance alerts
        if ($user->hasAnyRole(['guru', 'wali_kelas'])) {
            $teacher = Teacher::where('user_id', $user->id)->first();
            if ($teacher) {
                $daysMap = [
                    1 => 'senin',
                    2 => 'selasa',
                    3 => 'rabu',
                    4 => 'kamis',
                    5 => 'jumat',
                    6 => 'sabtu',
                    7 => 'minggu',
                ];
                $todayDay = $daysMap[Carbon::now()->dayOfWeekIso] ?? 'senin';
                $schedulesToday = Schedule::with(['classroom', 'subject', 'room'])
                    ->where('teacher_id', $teacher->id)
                    ->where('day_of_week', $todayDay)
                    ->take(3)
                    ->get();

                foreach ($schedulesToday as $sched) {
                    $items->push([
                        'id' => 'sched-'.$sched->id,
                        'title' => 'Jadwal Mengajar Hari Ini: '.$sched->subject->name,
                        'description' => 'Kelas '.$sched->classroom->name.' pukul '.$sched->time_range.' di '.($sched->room->name ?? 'Ruang Kelas').'.',
                        'category' => 'academic',
                        'category_label' => 'Jadwal Mengajar',
                        'icon' => 'academic',
                        'time' => Carbon::now()->startOfDay()->addHours(7),
                        'url' => route('teacher.attendances.index', ['schedule_id' => $sched->id]),
                        'is_unread' => true,
                    ]);
                }
            }
        }

        // 3. Role: Pembimbing PKL & Admin - Pending Journals & Leaves
        if ($user->hasRole('guru_pembimbing_pkl')) {
            $teacher = Teacher::where('user_id', $user->id)->first();
            if ($teacher) {
                $pendingJournals = InternshipJournal::with(['placement.student', 'placement.company'])
                    ->whereHas('placement', function ($q) use ($teacher) {
                        $q->where('teacher_id', $teacher->id);
                    })
                    ->latest('date')
                    ->take(3)
                    ->get();

                foreach ($pendingJournals as $jr) {
                    $items->push([
                        'id' => 'jr-'.$jr->id,
                        'title' => 'Laporan Jurnal PKL: '.$jr->placement->student->name,
                        'description' => 'Aktivitas "'.$jr->title.'" di '.$jr->placement->company->name.' menunggu review.',
                        'category' => 'pkl',
                        'category_label' => 'Jurnal PKL',
                        'icon' => 'pkl',
                        'time' => $jr->created_at ?? $jr->date,
                        'url' => route('internship-mentor.journals.index', ['search' => $jr->placement->student->name]),
                        'is_unread' => true,
                    ]);
                }

                $pendingLeaves = InternshipLeaveRequest::with(['placement.student'])
                    ->whereHas('placement', function ($q) use ($teacher) {
                        $q->where('teacher_id', $teacher->id);
                    })
                    ->take(2)
                    ->get();

                foreach ($pendingLeaves as $lv) {
                    $items->push([
                        'id' => 'lv-'.$lv->id,
                        'title' => 'Pengajuan Izin Siswa: '.$lv->placement->student->name,
                        'description' => 'Permohonan izin tanggal '.$lv->start_date->format('d/m/Y').' memerlukan verifikasi pembimbing.',
                        'category' => 'pkl',
                        'category_label' => 'Izin PKL',
                        'icon' => 'pkl',
                        'time' => $lv->created_at ?? Carbon::now(),
                        'url' => route('internship-mentor.leaves.index'),
                        'is_unread' => true,
                    ]);
                }
            }
        }

        // 4. Role: Admin - System Notifications
        if ($user->hasRole('admin')) {
            $items->push([
                'id' => 'sys-sync',
                'title' => 'Sinkronisasi Presensi & Geofence GPS Aktif',
                'description' => 'Sistem monitoring presensi real-time berjalan normal pada seluruh instansi mitra industri.',
                'category' => 'academic',
                'category_label' => 'Sistem Informasi',
                'icon' => 'system',
                'time' => Carbon::now()->subHours(2),
                'url' => route('admin.internships.attendances.index'),
                'is_unread' => false,
            ]);
        }

        return $items->sortByDesc('time')->values();
    }
}
