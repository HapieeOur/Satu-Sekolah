<x-app-layout title="Dashboard Guru">
    <x-slot name="header">
        Dashboard Guru
    </x-slot>

    <!-- Welcome & Identity Card -->
    <div class="bg-surface rounded-xl p-6 border border-border shadow-sm flex flex-col md:flex-row md:items-start justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-semibold bg-blue-50 text-brand border border-blue-200">
                    Portal Tenaga Pendidik
                </span>
                @if($activeAcademicYear)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                        Tahun Ajaran {{ $activeAcademicYear->name }}
                    </span>
                @endif
            </div>
            <h2 class="text-xl font-bold text-navy">Selamat Datang, {{ $user->name }}</h2>
            <p class="text-xs text-slate-500 mt-1">
                @if($teacher)
                    NIP: {{ $teacher->nip ?? '-' }} &bull; NUPTK: {{ $teacher->nuptk ?? '-' }} &bull; {{ $assignedSubjects->count() }} Mata Pelajaran Diampu
                @else
                    Profil pendidik belum terhubung dengan data master guru. Hubungi administrator sekolah.
                @endif
            </p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('teacher.schedules.index') }}" class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-white bg-brand rounded-lg hover:bg-brand-hover shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>Jadwal Mengajar Lengkap</span>
            </a>
            <a href="{{ route('teacher.attendances.index') }}" class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-slate-700 bg-white border border-border rounded-lg hover:bg-slate-50 shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                <span>Presensi Siswa</span>
            </a>
        </div>
    </div>

    <!-- Next Teaching Schedule Callout & Metric Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Next Schedule Callout (Section 5 Requirement) -->
        <div class="lg:col-span-2 bg-surface rounded-xl border border-border shadow-sm p-6 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-3 border-b border-border mb-4">
                    <h3 class="text-xs font-bold text-navy uppercase tracking-wider">Jadwal Mengajar Berikutnya</h3>
                    <span class="text-xs font-medium text-slate-500">
                        {{ now()->translatedFormat('l, d F Y') }}
                    </span>
                </div>

                @if($nextSchedule)
                    <div class="p-4 rounded-xl bg-slate-50 border border-border flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-brand text-white">
                                    {{ $nextSchedule->day_of_week->label() }}
                                </span>
                                <span class="text-xs font-mono font-semibold text-slate-700">
                                    {{ substr($nextSchedule->start_time, 0, 5) }} - {{ substr($nextSchedule->end_time, 0, 5) }} WIB
                                </span>
                            </div>
                            <h4 class="text-base font-bold text-navy mt-1">
                                {{ $nextSchedule->subject->name }}
                            </h4>
                            <p class="text-xs text-slate-600">
                                Kelas: <span class="font-semibold text-navy">{{ $nextSchedule->classroom->name }}</span> &bull; Ruang: <span class="font-semibold text-navy">{{ $nextSchedule->room?->name ?? 'Belum ditentukan' }}</span>
                            </p>
                        </div>
                        <div>
                            <a href="{{ route('teacher.attendances.index', ['schedule_id' => $nextSchedule->id]) }}" class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-semibold text-white bg-brand hover:bg-brand-hover rounded-lg transition shadow-sm">
                                <span>Input Presensi</span>
                                <span>&rarr;</span>
                            </a>
                        </div>
                    </div>
                @else
                    <div class="py-8 text-center text-slate-500">
                        <svg class="w-10 h-10 mx-auto text-slate-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-xs font-semibold text-navy">Tidak ada agenda mengajar tersisa untuk periode ini.</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">Semua sesi mengajar telah selesai atau jadwal belum dikonfigurasi.</p>
                    </div>
                @endif
            </div>

            <!-- Quick Metrics Footer -->
            <div class="grid grid-cols-3 gap-3 pt-4 border-t border-border mt-4 text-center">
                <div class="p-2 rounded-lg bg-canvas border border-border/60">
                    <span class="text-[10px] font-semibold uppercase tracking-wider text-slate-500 block">Jadwal Minggu Ini</span>
                    <span class="text-lg font-bold text-navy">{{ $weeklySchedulesCount }}</span>
                    <span class="text-[10px] text-slate-400 block">sesi</span>
                </div>
                <div class="p-2 rounded-lg bg-canvas border border-border/60">
                    <span class="text-[10px] font-semibold uppercase tracking-wider text-slate-500 block">Mapel Diampu</span>
                    <span class="text-lg font-bold text-navy">{{ $assignedSubjects->count() }}</span>
                    <span class="text-[10px] text-slate-400 block">bidang studi</span>
                </div>
                <div class="p-2 rounded-lg bg-canvas border border-border/60">
                    <span class="text-[10px] font-semibold uppercase tracking-wider text-slate-500 block">Kelas Terhubung</span>
                    <span class="text-lg font-bold text-navy">{{ $assignedClassrooms->count() }}</span>
                    <span class="text-[10px] text-slate-400 block">rombel</span>
                </div>
            </div>
        </div>

        <!-- Assigned Subjects & Classes Summary (Section 5 Requirement) -->
        <div class="bg-surface rounded-xl border border-border shadow-sm p-6 flex flex-col justify-between">
            <div>
                <h3 class="text-xs font-bold text-navy uppercase tracking-wider mb-3">Mata Pelajaran Ditugaskan</h3>
                <div class="space-y-2 mb-6">
                    @forelse($assignedSubjects as $subj)
                        <div class="p-2.5 rounded-lg bg-slate-50 border border-border flex items-center justify-between">
                            <div>
                                <span class="text-xs font-bold text-navy block">{{ $subj->name }}</span>
                                <span class="text-[10px] text-slate-500 font-mono">{{ $subj->code }}</span>
                            </div>
                            <span class="text-[11px] font-semibold px-2 py-0.5 rounded bg-white border border-border text-slate-700">
                                {{ $subj->pivot->created_at ? 'Aktif' : 'Terdaftar' }}
                            </span>
                        </div>
                    @empty
                        <p class="text-xs text-slate-500 py-3 text-center">Belum ada mata pelajaran yang dihubungkan ke akun Anda.</p>
                    @endforelse
                </div>

                <h3 class="text-xs font-bold text-navy uppercase tracking-wider mb-3">Kelas yang Diajar</h3>
                <div class="flex flex-wrap gap-1.5">
                    @forelse($assignedClassrooms as $cls)
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                            {{ $cls->name }}
                        </span>
                    @empty
                        <span class="text-xs text-slate-500">Belum ada kelas terkait di jadwal aktif.</span>
                    @endforelse
                </div>
            </div>

            <div class="mt-4 pt-4 border-t border-border">
                <a href="{{ route('teacher.schedules.index') }}" class="text-xs font-semibold text-brand hover:underline inline-flex items-center gap-1">
                    <span>Lihat Rincian Jadwal Guru</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Bottom Section: Today's Schedule Timeline & School Announcements -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Today's Schedule Table -->
        <div class="bg-surface rounded-xl border border-border shadow-sm overflow-hidden flex flex-col">
            <div class="p-5 border-b border-border flex items-center justify-between">
                <div>
                    <h3 class="text-xs font-bold text-navy uppercase tracking-wider">Jadwal Mengajar Hari Ini</h3>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $todayDay ? $todayDay->label() : 'Hari Libur / Akhir Pekan' }}</p>
                </div>
                <a href="{{ route('teacher.schedules.index') }}" class="text-xs font-semibold text-brand hover:underline">
                    Lihat Semua &rarr;
                </a>
            </div>

            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 border-b border-border text-slate-700 font-semibold uppercase tracking-wider text-[11px]">
                        <tr>
                            <th class="py-3 px-4">Jam</th>
                            <th class="py-3 px-4">Kelas</th>
                            <th class="py-3 px-4">Mata Pelajaran</th>
                            <th class="py-3 px-4">Ruangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse ($todaySchedules as $sch)
                            <tr class="hover:bg-slate-50/75 transition">
                                <td class="py-3 px-4 font-mono font-semibold text-navy">
                                    {{ substr($sch->start_time, 0, 5) }} - {{ substr($sch->end_time, 0, 5) }}
                                </td>
                                <td class="py-3 px-4 font-bold text-navy">
                                    {{ $sch->classroom->name }}
                                </td>
                                <td class="py-3 px-4 text-slate-700">
                                    {{ $sch->subject->name }}
                                </td>
                                <td class="py-3 px-4 text-slate-600">
                                    {{ $sch->room?->name ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-slate-500">
                                    Tidak ada jadwal mengajar pada hari ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- School Announcements & News (Section 5 Requirement) -->
        <div class="bg-surface rounded-xl border border-border shadow-sm overflow-hidden flex flex-col">
            <div class="p-5 border-b border-border flex items-center justify-between">
                <div>
                    <h3 class="text-xs font-bold text-navy uppercase tracking-wider">Pengumuman & Informasi Sekolah</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Pembaruan resmi institusi terkini</p>
                </div>
                <a href="{{ route('public.announcements') }}" target="_blank" class="text-xs font-semibold text-brand hover:underline">
                    Portal Informasi &rarr;
                </a>
            </div>

            <div class="p-5 divide-y divide-border flex-1">
                @forelse ($recentAnnouncements as $post)
                    <div class="py-3 first:pt-0 last:pb-0">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider
                                @if($post->category === 'pengumuman') bg-amber-50 text-amber-800 border border-amber-200
                                @elseif($post->category === 'acara') bg-purple-50 text-purple-800 border border-purple-200
                                @else bg-blue-50 text-brand border border-blue-200 @endif">
                                {{ ucfirst($post->category) }}
                            </span>
                            <span class="text-[11px] text-slate-400">
                                {{ $post->published_at ? $post->published_at->format('d/m/Y') : '-' }}
                            </span>
                        </div>
                        <a href="{{ $post->category === 'pengumuman' ? route('public.announcements.show', $post->slug) : ($post->category === 'acara' ? route('public.events.show', $post->slug) : route('public.news.show', $post->slug)) }}"
                           target="_blank"
                           class="text-xs font-bold text-navy hover:text-brand transition line-clamp-1">
                            {{ $post->title }}
                        </a>
                        <p class="text-[11px] text-slate-500 mt-0.5 line-clamp-2">
                            {{ $post->excerpt ?: Str::limit(strip_tags($post->content), 120) }}
                        </p>
                    </div>
                @empty
                    <div class="py-8 text-center text-slate-500">
                        Belum ada pengumuman resmi yang dipublikasikan.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
