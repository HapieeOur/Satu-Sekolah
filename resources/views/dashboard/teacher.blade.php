<x-app-layout title="Dashboard Guru">
    <x-slot name="header">
        Dashboard Guru
    </x-slot>

    <div class="space-y-7">
        <!-- Top Class Row: "Ihre Klassen" / "Kelas Anda" (Reference Image A) -->
        <div>
            <div class="flex items-center justify-between mb-3.5">
                <div class="flex items-center gap-2">
                    <h2 class="text-base font-extrabold text-[#171B61] tracking-tight">Kelas yang Diampu</h2>
                    <span class="text-xs font-semibold text-slate-400">({{ $assignedClassrooms->count() }} Rombel Aktif)</span>
                </div>
                <a href="{{ route('teacher.schedules.index') }}" class="text-xs font-bold text-[#233DFF] hover:underline flex items-center gap-1">
                    <span>Lihat Jadwal Lengkap</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <!-- Horizontal Carousel of Class Cards (Reference Image A) -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                @forelse($assignedClassrooms as $classroom)
                    <div class="rounded-3xl p-5 bg-[#2F3DB6] hover:bg-[#2532A6] text-white shadow-md shadow-indigo-950/10 flex flex-col justify-between transition-all duration-200 group">
                        <div class="space-y-3">
                            <div class="flex items-start justify-between">
                                <h3 class="text-2xl font-black tracking-tight group-hover:scale-105 transition-transform">
                                    {{ $classroom->name }}
                                </h3>
                                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                            </div>

                            <!-- Metrics: Bell & Building Percentage (Reference Image A) -->
                            <div class="flex items-center gap-3 text-xs text-indigo-100/90 font-medium">
                                <div class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-amber-300" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/></svg>
                                    <span class="font-bold">2</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-blue-200" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10.496 2.132a1 1 0 00-.992 0l-7 4A1 1 0 002 7v10a1 1 0 001 1h14a1 1 0 001-1V7a1 1 0 00-.504-.868l-7-4zM10 4.236l5 2.857V16H5V7.093l5-2.857zM8 11a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"/></svg>
                                    <span class="font-bold">95%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Footer: Student Count with Avatars (Reference Image A) -->
                        <div class="pt-4 mt-3 border-t border-white/15 flex items-center justify-between text-xs">
                            <div class="flex -space-x-1.5 overflow-hidden">
                                <div class="w-6 h-6 rounded-full bg-indigo-200 text-indigo-900 font-bold text-[10px] flex items-center justify-center ring-2 ring-indigo-700">A</div>
                                <div class="w-6 h-6 rounded-full bg-blue-200 text-blue-900 font-bold text-[10px] flex items-center justify-center ring-2 ring-indigo-700">R</div>
                            </div>
                            <span class="text-[11px] text-indigo-100 font-semibold">{{ $classroom->students->count() ?? 28 }} Siswa</span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full p-6 text-center bg-white rounded-3xl border border-slate-200/80">
                        <p class="text-xs font-bold text-[#171B61]">Belum ada rombongan belajar yang terhubung.</p>
                        <p class="text-[11px] text-slate-400 mt-1">Jadwal mengajar belum ditetapkan oleh administrator.</p>
                    </div>
                @endforelse

                <!-- Add / Quick Info Card (Reference Image A Plus Card) -->
                <a href="{{ route('teacher.attendances.index') }}" class="rounded-3xl p-5 border-2 border-dashed border-indigo-200 bg-[#ECEBFA]/40 hover:bg-[#ECEBFA] flex flex-col items-center justify-center text-center gap-2 group transition-all duration-150 cursor-pointer">
                    <div class="w-10 h-10 rounded-2xl bg-white text-[#233DFF] flex items-center justify-center shadow-xs group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    </div>
                    <span class="text-xs font-bold text-[#171B61] leading-tight">Input Presensi<br>Harian</span>
                </a>
            </div>
        </div>

        <!-- Multi-Column Grid: Notifications + Tasks (Left 2 cols) + Schedule Panel (Right col) (Reference Image A) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            <!-- Left & Middle: Benachrichtigungen + Heute zu erledigen (8 Cols) -->
            <div class="lg:col-span-7 xl:col-span-8 grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Column 1: "Benachrichtigungen" (Pengumuman & Notifikasi) -->
                <div class="space-y-4">
                    <h3 class="text-sm font-extrabold text-[#171B61] tracking-tight">Notifikasi &amp; Warta</h3>

                    <!-- Top Highlight Card (Reference Image A: Active Blue Unterrichtszeit card) -->
                    @if($nextSchedule)
                        <div class="rounded-3xl p-5 bg-[#233DFF] text-white shadow-lg shadow-indigo-600/25 relative overflow-hidden">
                            <div class="flex items-start gap-3.5">
                                <div class="w-10 h-10 rounded-2xl bg-white/20 text-white flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                </div>
                                <div>
                                    <span class="text-[11px] font-bold uppercase tracking-wider text-amber-300 block">Sesi Pembelajaran Aktif!</span>
                                    <p class="text-sm font-black mt-0.5 leading-snug">
                                        {{ $nextSchedule->subject->name }}
                                    </p>
                                    <p class="text-xs text-indigo-100 mt-1">
                                        Kelas {{ $nextSchedule->classroom->name }} &bull; {{ substr($nextSchedule->start_time, 0, 5) }} - {{ substr($nextSchedule->end_time, 0, 5) }} WIB
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Notification Cards List (Reference Image A) -->
                    <div class="space-y-3">
                        @forelse($recentAnnouncements as $post)
                            <div class="rounded-2xl p-4 bg-white border border-slate-200/80 shadow-xs hover:shadow-md transition-all flex items-start gap-3">
                                <div class="w-9 h-9 rounded-xl bg-[#ECEBFA] text-[#233DFF] flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h4 class="text-xs font-bold text-[#171B61] hover:text-[#233DFF] transition truncate">
                                        {{ $post->title }}
                                    </h4>
                                    <p class="text-[11px] text-slate-500 mt-0.5 line-clamp-1">
                                        {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 70) }}
                                    </p>
                                    <span class="text-[10px] text-slate-400 mt-1 block">
                                        {{ $post->published_at ? $post->published_at->translatedFormat('d M Y') : '-' }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center bg-white rounded-2xl border border-slate-200/80">
                                <p class="text-xs text-slate-400">Tidak ada warta sekolah terbaru saat ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Column 2: "Heute zu erledigen" (Agenda & Tugas Hari Ini) -->
                <div class="space-y-4">
                    <h3 class="text-sm font-extrabold text-[#171B61] tracking-tight">Tugas &amp; Agenda Hari Ini</h3>

                    <div class="space-y-3">
                        @if($nextSchedule)
                            <div class="rounded-2xl p-4 bg-white border border-slate-200/80 shadow-xs flex items-center justify-between gap-3">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="text-xs font-bold text-[#171B61] truncate">Input Presensi Kelas</h4>
                                        <p class="text-[11px] text-slate-500 truncate">{{ $nextSchedule->classroom->name }} &bull; {{ $nextSchedule->subject->name }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('teacher.attendances.index', ['schedule_id' => $nextSchedule->id]) }}" class="px-3 py-1.5 rounded-xl bg-[#233DFF] text-white text-[11px] font-bold hover:bg-[#1B30D9] shrink-0 transition">
                                    Input
                                </a>
                            </div>
                        @endif

                        <div class="rounded-2xl p-4 bg-white border border-slate-200/80 shadow-xs flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-[#E5ECFF] text-[#233DFF] flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            </div>
                            <div class="min-w-0">
                                <h4 class="text-xs font-bold text-[#171B61]">Persiapan Materi &amp; Evaluasi</h4>
                                <p class="text-[11px] text-slate-500">{{ $assignedSubjects->count() }} Mata Pelajaran Terhubung</p>
                            </div>
                        </div>

                        <div class="rounded-2xl p-4 bg-white border border-slate-200/80 shadow-xs flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <h4 class="text-xs font-bold text-[#171B61]">Sinkronisasi Kalender Akademik</h4>
                                <p class="text-[11px] text-slate-500">Tahun Ajaran {{ $activeAcademicYear->name ?? '2026/2027' }} Aktif</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Panel: "Stundenplan" / Daily Schedule Panel (Reference Image A) -->
            <div class="lg:col-span-5 xl:col-span-4 bg-white rounded-3xl border border-slate-200/80 p-6 shadow-xs space-y-5">
                <div class="flex items-center justify-between pb-3.5 border-b border-slate-100">
                    <div>
                        <h3 class="text-sm font-extrabold text-[#171B61]">Jadwal Pelajaran Hari Ini</h3>
                        <p class="text-[11px] text-slate-400">{{ now()->translatedFormat('l, d F Y') }}</p>
                    </div>
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-[#E5ECFF] text-[#233DFF]">
                        Stundenplan
                    </span>
                </div>

                <!-- Timetable Stream (Reference Image A) -->
                @if($todaySchedules->count() > 0)
                    <div class="space-y-4">
                        @foreach($todaySchedules as $schedule)
                            @php
                                $isActive = $nextSchedule && $nextSchedule->id === $schedule->id;
                            @endphp
                            <div class="flex items-start gap-4">
                                <!-- Time Label (Reference Image A: 8:00, 9:00, 10:00) -->
                                <span class="w-12 text-xs font-mono font-bold text-slate-400 pt-3 text-right shrink-0">
                                    {{ substr($schedule->start_time, 0, 5) }}
                                </span>

                                <!-- Schedule Block -->
                                <div class="flex-1 {{ $isActive ? 'p-4 rounded-2xl bg-[#233DFF] text-white shadow-md shadow-indigo-600/30' : 'p-3.5 rounded-2xl bg-[#F4F6FB] border border-slate-200/80 text-slate-800' }}">
                                    <div class="flex items-center justify-between">
                                        <h4 class="text-xs font-bold {{ $isActive ? 'text-white' : 'text-[#171B61]' }}">
                                            {{ $schedule->subject->name }}
                                        </h4>
                                        @if($isActive)
                                            <span class="text-[10px] font-extrabold uppercase tracking-wider text-amber-300">
                                                Sekarang
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-[11px] mt-0.5 {{ $isActive ? 'text-indigo-100' : 'text-slate-500' }}">
                                        {{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }} WIB &bull; Kelas {{ $schedule->classroom->name }}
                                    </p>
                                    <p class="text-[10px] mt-0.5 {{ $isActive ? 'text-indigo-200' : 'text-slate-400' }}">
                                        Ruang: {{ $schedule->room?->name ?? 'Lab Komputer 1' }}
                                    </p>

                                    @if($isActive)
                                        <div class="mt-3 pt-3 border-t border-white/20">
                                            <a href="{{ route('teacher.attendances.index', ['schedule_id' => $schedule->id]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white text-[#233DFF] text-xs font-extrabold hover:bg-indigo-50 shadow-xs transition">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                                <span>Input Presensi</span>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-12 text-center text-slate-400 bg-[#F4F6FB] rounded-2xl border border-slate-100">
                        <svg class="w-10 h-10 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-xs font-bold text-[#171B61]">Tidak ada agenda mengajar tersisa untuk periode ini.</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">Semua sesi hari ini telah selesai atau sedang hari libur.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
