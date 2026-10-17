<x-app-layout title="Dashboard Guru">
    <x-slot name="header">
        Dashboard Guru
    </x-slot>

    <!-- Welcome & Identity Card -->
    <div class="relative bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl border border-slate-800 overflow-hidden flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="absolute -right-16 -top-16 w-64 h-64 bg-emerald-500/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 space-y-2">
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-white/10 text-emerald-300 border border-white/15">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    Portal Tenaga Pendidik
                </span>
                @if($activeAcademicYear)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-indigo-500/20 text-indigo-300 border border-indigo-400/30">
                        T.A. {{ $activeAcademicYear->name }}
                    </span>
                @endif
            </div>
            <h2 class="text-xl sm:text-2xl font-black tracking-tight text-white">
                Selamat Datang, {{ $user->name }}
            </h2>
            <p class="text-xs text-slate-300 max-w-xl leading-relaxed">
                @if($teacher)
                    NIP: <span class="font-mono text-white">{{ $teacher->nip ?? '-' }}</span> &bull; NUPTK: <span class="font-mono text-white">{{ $teacher->nuptk ?? '-' }}</span> &bull; <span class="font-bold text-emerald-300">{{ $assignedSubjects->count() }} Mata Pelajaran</span> Terhubung
                @else
                    Profil pendidik belum terhubung dengan data master guru. Hubungi administrator sekolah.
                @endif
            </p>
        </div>

        <div class="relative z-10 flex flex-wrap items-center gap-2.5">
            <a href="{{ route('teacher.schedules.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-brand to-indigo-600 hover:from-brand-hover hover:to-indigo-700 text-white text-xs font-bold rounded-xl shadow-md hover:shadow-glow hover:-translate-y-0.5 transition-all duration-150">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>Jadwal Mengajar</span>
            </a>
            <a href="{{ route('teacher.attendances.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/10 hover:bg-white/15 text-white border border-white/20 text-xs font-bold rounded-xl shadow-xs hover:-translate-y-0.5 transition-all duration-150">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                <span>Presensi Siswa</span>
            </a>
        </div>
    </div>

    <!-- Next Teaching Schedule Callout & Metric Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Next Schedule Callout (Bento) -->
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200/90 shadow-xs p-6 sm:p-7 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-3.5 border-b border-slate-100 mb-5">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-brand block">Agenda Terdekat</span>
                        <h3 class="text-sm font-extrabold text-navy">Jadwal Mengajar Berikutnya</h3>
                    </div>
                    <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2.5 py-1 rounded-lg">
                        {{ now()->translatedFormat('l, d F Y') }}
                    </span>
                </div>

                @if($nextSchedule)
                    <div class="p-5 rounded-2xl bg-gradient-to-br from-indigo-50/70 via-slate-50 to-white border border-indigo-100/80 flex flex-col sm:flex-row sm:items-center justify-between gap-5">
                        <div class="space-y-2">
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-brand text-white shadow-xs">
                                    {{ $nextSchedule->day_of_week->label() }}
                                </span>
                                <span class="text-xs font-mono font-bold text-slate-700 bg-white px-2 py-0.5 rounded border border-slate-200">
                                    {{ substr($nextSchedule->start_time, 0, 5) }} - {{ substr($nextSchedule->end_time, 0, 5) }} WIB
                                </span>
                            </div>
                            <h4 class="text-lg font-black text-navy mt-1">
                                {{ $nextSchedule->subject->name }}
                            </h4>
                            <p class="text-xs text-slate-600 flex items-center gap-2">
                                <span>Kelas: <strong class="text-navy">{{ $nextSchedule->classroom->name }}</strong></span>
                                <span>&bull;</span>
                                <span>Ruangan: <strong class="text-navy">{{ $nextSchedule->room?->name ?? 'Belum ditentukan' }}</strong></span>
                            </p>
                        </div>
                        <div>
                            <a href="{{ route('teacher.attendances.index', ['schedule_id' => $nextSchedule->id]) }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-xs font-bold text-white bg-gradient-to-r from-brand to-indigo-600 hover:from-brand-hover hover:to-indigo-700 rounded-xl shadow-md hover:shadow-glow transition-all duration-150">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                <span>Input Presensi</span>
                            </a>
                        </div>
                    </div>
                @else
                    <div class="py-10 text-center text-slate-400 bg-slate-50 rounded-2xl border border-slate-100">
                        <svg class="w-10 h-10 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-xs font-bold text-navy">Tidak ada agenda mengajar tersisa untuk periode ini.</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">Semua sesi hari ini telah selesai atau sedang hari libur.</p>
                    </div>
                @endif
            </div>

            <!-- Quick Metrics Footer -->
            <div class="grid grid-cols-3 gap-3 pt-5 border-t border-slate-100 mt-5 text-center">
                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Jadwal Minggu Ini</span>
                    <span class="text-xl font-black text-navy mt-0.5 block">{{ $weeklySchedulesCount }}</span>
                    <span class="text-[10px] text-slate-400">sesi mengajar</span>
                </div>
                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Mapel Diampu</span>
                    <span class="text-xl font-black text-navy mt-0.5 block">{{ $assignedSubjects->count() }}</span>
                    <span class="text-[10px] text-slate-400">bidang studi</span>
                </div>
                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Rombel Terhubung</span>
                    <span class="text-xl font-black text-navy mt-0.5 block">{{ $assignedClassrooms->count() }}</span>
                    <span class="text-[10px] text-slate-400">kelas aktif</span>
                </div>
            </div>
        </div>

        <!-- Assigned Subjects & Classes Summary -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs p-6 sm:p-7 flex flex-col justify-between">
            <div>
                <div class="mb-4">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-indigo-600 block">Beban Mengajar</span>
                    <h3 class="text-sm font-extrabold text-navy">Mata Pelajaran Ditugaskan</h3>
                </div>

                <div class="space-y-2 mb-6">
                    @forelse($assignedSubjects as $subj)
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                            <div>
                                <span class="text-xs font-bold text-navy block">{{ $subj->name }}</span>
                                <span class="text-[10px] text-slate-400 font-mono">{{ $subj->code }}</span>
                            </div>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-indigo-50 border border-indigo-200 text-brand">
                                Aktif
                            </span>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 py-4 text-center">Belum ada mata pelajaran yang dihubungkan ke akun Anda.</p>
                    @endforelse
                </div>

                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Kelas yang Diajar</h3>
                <div class="flex flex-wrap gap-1.5">
                    @forelse($assignedClassrooms as $cls)
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                            {{ $cls->name }}
                        </span>
                    @empty
                        <span class="text-xs text-slate-400">Belum ada kelas terkait di jadwal aktif.</span>
                    @endforelse
                </div>
            </div>

            <div class="mt-5 pt-4 border-t border-slate-100">
                <a href="{{ route('teacher.schedules.index') }}" class="text-xs font-bold text-brand hover:underline inline-flex items-center gap-1.5">
                    <span>Lihat Seluruh Rincian Jadwal Mengajar</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Bottom Section: Today's Schedule Timeline & Announcements -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Today's Schedule Table -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden flex flex-col">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-extrabold text-navy">Jadwal Mengajar Hari Ini</h3>
                    <p class="text-xs text-slate-400 mt-0.5">{{ $todayDay ? $todayDay->label() : 'Hari Libur / Akhir Pekan' }}</p>
                </div>
                <a href="{{ route('teacher.schedules.index') }}" class="text-xs font-bold text-brand hover:underline">
                    Semua Jadwal &rarr;
                </a>
            </div>

            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50/80 border-b border-slate-100 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                        <tr>
                            <th class="py-3 px-4">Jam</th>
                            <th class="py-3 px-4">Kelas</th>
                            <th class="py-3 px-4">Mata Pelajaran</th>
                            <th class="py-3 px-4">Ruangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($todaySchedules as $sch)
                            <tr class="hover:bg-slate-50/75 transition">
                                <td class="py-3.5 px-4 font-mono font-bold text-navy">
                                    {{ substr($sch->start_time, 0, 5) }} - {{ substr($sch->end_time, 0, 5) }}
                                </td>
                                <td class="py-3.5 px-4 font-extrabold text-navy">
                                    {{ $sch->classroom->name }}
                                </td>
                                <td class="py-3.5 px-4 text-slate-700 font-medium">
                                    {{ $sch->subject->name }}
                                </td>
                                <td class="py-3.5 px-4 text-slate-500">
                                    {{ $sch->room?->name ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-10 text-center text-slate-400">
                                    Tidak ada jadwal mengajar pada hari ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- School Announcements & News -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden flex flex-col">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-extrabold text-navy">Pengumuman &amp; Informasi Sekolah</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Pembaruan resmi institusi terkini</p>
                </div>
                <a href="{{ route('public.announcements') }}" target="_blank" class="text-xs font-bold text-brand hover:underline">
                    Portal Informasi &rarr;
                </a>
            </div>

            <div class="p-6 divide-y divide-slate-100 flex-1 space-y-3">
                @forelse ($recentAnnouncements as $post)
                    <div class="pt-3 first:pt-0">
                        <div class="flex items-center gap-2 mb-1.5">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                                @if($post->category === 'pengumuman') bg-amber-50 text-amber-800 border border-amber-200
                                @elseif($post->category === 'acara') bg-purple-50 text-purple-800 border border-purple-200
                                @else bg-indigo-50 text-brand border border-indigo-200 @endif">
                                {{ ucfirst($post->category) }}
                            </span>
                            <span class="text-[11px] text-slate-400 font-mono">
                                {{ $post->published_at ? $post->published_at->format('d/m/Y') : '-' }}
                            </span>
                        </div>
                        <a href="{{ $post->category === 'pengumuman' ? route('public.announcements.show', $post->slug) : ($post->category === 'acara' ? route('public.events.show', $post->slug) : route('public.news.show', $post->slug)) }}"
                           target="_blank"
                           class="text-xs sm:text-sm font-bold text-navy hover:text-brand transition line-clamp-1">
                            {{ $post->title }}
                        </a>
                        <p class="text-xs text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                            {{ $post->excerpt ?: Str::limit(strip_tags($post->content), 120) }}
                        </p>
                    </div>
                @empty
                    <div class="py-10 text-center text-slate-400">
                        Belum ada pengumuman resmi yang dipublikasikan.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
