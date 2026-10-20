<x-app-layout title="Portal Siswa">
    <x-slot name="header">
        Portal Siswa &mdash; Beranda Akademik
    </x-slot>

    <div class="space-y-6">
        <!-- Student Welcome Hero Banner -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#171B61] via-[#1D2275] to-[#233DFF] text-white p-6 sm:p-8 shadow-xl shadow-indigo-950/20 border border-indigo-500/20">
            <div class="absolute -right-12 -top-12 w-64 h-64 rounded-full bg-blue-500/10 blur-3xl pointer-events-none"></div>
            <div class="absolute right-1/4 -bottom-12 w-48 h-48 rounded-full bg-indigo-400/10 blur-2xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-[11px] font-bold text-amber-300">
                        <span>🎓 Peserta Didik Aktif</span>
                        <span>&bull;</span>
                        <span>{{ $student?->classroom?->name ?? 'Kelas Belum Ditentukan' }}</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white drop-shadow-sm">
                        Halo, {{ $student?->name ?? $user->name }}!
                    </h1>
                    <p class="text-xs sm:text-sm text-indigo-100/90 max-w-xl font-medium">
                        Selamat datang di portal akademik sekolah. Pantau jadwal mata pelajaran harian, statistik presensi kehadiran, dan informasi penempatan PKL Anda di sini.
                    </p>
                    <div class="flex flex-wrap items-center gap-3 pt-2 text-xs text-indigo-200">
                        <span class="inline-flex items-center gap-1 font-mono">
                            <strong class="text-white">NISN:</strong> {{ $student?->nisn ?? $user->nisn ?? '-' }}
                        </span>
                        <span>&bull;</span>
                        <span class="inline-flex items-center gap-1 font-mono">
                            <strong class="text-white">NIS:</strong> {{ $student?->nis ?? $user->nis ?? '-' }}
                        </span>
                        <span>&bull;</span>
                        <span class="inline-flex items-center gap-1">
                            <strong class="text-white">Tahun Ajaran:</strong> {{ $activeAcademicYear?->name ?? '-' }} ({{ ucfirst($activeAcademicYear?->semester?->value ?? 'Ganjil') }})
                        </span>
                    </div>
                </div>

                <!-- Quick Action Buttons -->
                <div class="flex flex-row md:flex-col gap-2 shrink-0">
                    <a href="{{ route('student.schedules.index') }}" class="px-4 py-2.5 rounded-xl bg-white text-[#171B61] hover:bg-indigo-50 font-black text-xs transition shadow-md flex items-center justify-center gap-1.5 cursor-pointer">
                        <svg class="w-4 h-4 text-[#233DFF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Jadwal Lengkap</span>
                    </a>
                    <a href="{{ route('student.attendances.index') }}" class="px-4 py-2.5 rounded-xl bg-indigo-900/50 hover:bg-indigo-900/80 text-white border border-indigo-400/30 font-bold text-xs transition flex items-center justify-center gap-1.5 cursor-pointer">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Presensi Saya</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- 4 Key Stat Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- 1. Tingkat Kehadiran -->
            <div class="bg-white rounded-3xl border border-slate-200/90 p-5 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Tingkat Kehadiran</span>
                    <div class="flex items-baseline gap-1 mt-0.5">
                        <span class="text-2xl font-black text-navy">{{ $attendancesSummary['rate'] }}%</span>
                    </div>
                    <span class="text-[10px] text-emerald-600 font-semibold">{{ $attendancesSummary['hadir'] }}x Hadir dari {{ $attendancesSummary['total'] }} sesi</span>
                </div>
            </div>

            <!-- 2. Sesi Hari Ini -->
            <div class="bg-white rounded-3xl border border-slate-200/90 p-5 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-[#233DFF] flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Jadwal Hari Ini</span>
                    <div class="flex items-baseline gap-1 mt-0.5">
                        <span class="text-2xl font-black text-navy">{{ $todaySchedules->count() }}</span>
                        <span class="text-xs text-slate-500 font-bold">Mapel</span>
                    </div>
                    <span class="text-[10px] text-indigo-600 font-semibold">{{ $todayDay ? $todayDay->label() : 'Hari Libur' }}</span>
                </div>
            </div>

            <!-- 3. Wali Kelas -->
            <div class="bg-white rounded-3xl border border-slate-200/90 p-5 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div class="min-w-0">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Wali Kelas</span>
                    <p class="text-xs font-black text-navy truncate mt-0.5">{{ $student?->classroom?->teacher?->user?->name ?? 'Belum Ditugaskan' }}</p>
                    <span class="text-[10px] text-slate-400 truncate block">{{ $student?->classroom?->name ?? '-' }}</span>
                </div>
            </div>

            <!-- 4. Status PKL / DUDI -->
            <div class="bg-white rounded-3xl border border-slate-200/90 p-5 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl {{ $activePlacement ? 'bg-sky-50 text-sky-600' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div class="min-w-0">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Status PKL / Magang</span>
                    @if ($activePlacement)
                        <p class="text-xs font-black text-sky-700 truncate mt-0.5">{{ $activePlacement->company->name }}</p>
                        <span class="text-[10px] text-sky-600 font-semibold block">Magang Aktif</span>
                    @else
                        <p class="text-xs font-black text-slate-600 mt-0.5">KBM Reguler</p>
                        <span class="text-[10px] text-slate-400 block">Belum Terjadwal PKL</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- 2 Column Layout: Left (Schedule & Attendance), Right (PKL & Announcements) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left 2 Cols -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Jadwal Hari Ini -->
                <div class="bg-white rounded-3xl border border-slate-200/90 p-6 shadow-xs">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                        <div>
                            <h2 class="text-base font-black text-navy">Jadwal Pelajaran Hari Ini</h2>
                            <p class="text-xs text-slate-500">
                                {{ $todayDay ? $todayDay->label() . ', ' . now()->translatedFormat('d F Y') : now()->translatedFormat('l, d F Y') }}
                            </p>
                        </div>
                        <a href="{{ route('student.schedules.index') }}" class="text-xs font-bold text-brand hover:underline flex items-center gap-1">
                            Lihat Semua Hari &rarr;
                        </a>
                    </div>

                    @if ($todaySchedules->isEmpty())
                        <div class="text-center py-8">
                            <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <p class="text-xs font-bold text-navy">Tidak Ada Jadwal Pelajaran Hari Ini</p>
                            <p class="text-[11px] text-slate-400 mt-0.5">Nikmati waktu belajar mandiri atau kegiatan ekstrakurikuler Anda.</p>
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach ($todaySchedules as $sched)
                                <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50/60 hover:bg-slate-50 hover:border-slate-200 transition flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                    <div class="flex items-center gap-3.5">
                                        <div class="w-10 h-10 rounded-xl bg-indigo-50 border border-indigo-100 text-[#233DFF] flex items-center justify-center font-mono font-bold text-xs shrink-0">
                                            {{ substr((string) $sched->start_time, 0, 5) }}
                                        </div>
                                        <div>
                                            <h3 class="text-xs sm:text-sm font-extrabold text-navy">{{ $sched->subject->name }}</h3>
                                            <p class="text-[11px] text-slate-500 mt-0.5 flex items-center gap-2">
                                                <span>Pengajar: <strong>{{ $sched->teacher?->user?->name ?? 'Guru Mapel' }}</strong></span>
                                                <span>&bull;</span>
                                                <span>Ruang: <strong>{{ $sched->room ? $sched->room->name : 'Kelas' }}</strong></span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="shrink-0 flex items-center gap-2">
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-indigo-50 text-brand border border-indigo-200">
                                            {{ $sched->time_range }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Riwayat Presensi Terkini -->
                <div class="bg-white rounded-3xl border border-slate-200/90 p-6 shadow-xs">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                        <div>
                            <h2 class="text-base font-black text-navy">Riwayat Presensi Terbaru</h2>
                            <p class="text-xs text-slate-500">Catatan kehadiran Anda pada mata pelajaran sebelumnya.</p>
                        </div>
                        <a href="{{ route('student.attendances.index') }}" class="text-xs font-bold text-brand hover:underline flex items-center gap-1">
                            Rekap Lengkap &rarr;
                        </a>
                    </div>

                    @if ($recentAttendances->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-xs font-semibold text-slate-400">Belum ada catatan presensi yang tercatat pada sistem.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs">
                                <thead class="bg-slate-50/50 text-slate-400 uppercase font-bold text-[10px] border-b border-slate-100">
                                    <tr>
                                        <th class="py-2.5 px-4">Tanggal</th>
                                        <th class="py-2.5 px-4">Mata Pelajaran</th>
                                        <th class="py-2.5 px-4">Waktu</th>
                                        <th class="py-2.5 px-4">Status</th>
                                        <th class="py-2.5 px-4">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach ($recentAttendances as $att)
                                        <tr class="hover:bg-slate-50/50">
                                            <td class="py-3 px-4 font-mono font-medium text-slate-600">
                                                {{ \Carbon\Carbon::parse($att->date)->format('d/m/Y') }}
                                            </td>
                                            <td class="py-3 px-4 font-bold text-navy">
                                                {{ $att->schedule?->subject?->name ?? 'Sesi Mapel' }}
                                            </td>
                                            <td class="py-3 px-4 font-mono text-slate-500">
                                                {{ $att->check_in_time ? substr((string) $att->check_in_time, 0, 5) : '-' }}
                                            </td>
                                            <td class="py-3 px-4">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $att->status->badgeClass() }}">
                                                    {{ $att->status->label() }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-4 text-slate-400">
                                                {{ $att->notes ?? '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Column: PKL Portal & School News -->
            <div class="space-y-6">
                <!-- Kartu Status Penempatan PKL -->
                <div class="bg-white rounded-3xl border border-slate-200/90 p-6 shadow-xs">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                        <h2 class="text-sm font-black text-navy flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            <span>Praktik Kerja Lapangan (PKL)</span>
                        </h2>
                        @if ($activePlacement)
                            <a href="{{ route('student.internship.index') }}" class="text-[11px] font-bold text-sky-600 hover:underline">
                                Detail &rarr;
                            </a>
                        @endif
                    </div>

                    @if ($activePlacement)
                        <div class="space-y-3.5">
                            <div class="p-3.5 rounded-2xl bg-sky-50/60 border border-sky-100">
                                <span class="text-[10px] font-bold text-sky-600 uppercase tracking-wider block">Mitra Perusahaan DUDI</span>
                                <h3 class="text-xs font-black text-navy mt-0.5">{{ $activePlacement->company->name }}</h3>
                                <p class="text-[11px] text-slate-500 mt-1 line-clamp-2">{{ $activePlacement->company->address }}</p>
                            </div>

                            <div class="space-y-2 text-xs">
                                <div class="flex items-center justify-between py-1 border-b border-slate-100">
                                    <span class="text-slate-400">Pembimbing Sekolah:</span>
                                    <strong class="text-navy">{{ $activePlacement->teacher?->user?->name ?? 'Belum Ditugaskan' }}</strong>
                                </div>
                                <div class="flex items-center justify-between py-1 border-b border-slate-100">
                                    <span class="text-slate-400">Periode Magang:</span>
                                    <span class="font-mono text-slate-700 text-[11px]">
                                        {{ \Carbon\Carbon::parse($activePlacement->start_date)->format('d M') }} &ndash; {{ \Carbon\Carbon::parse($activePlacement->end_date)->format('d M Y') }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between py-1">
                                    <span class="text-slate-400">Radius GPS Presensi:</span>
                                    <span class="font-bold text-emerald-700 text-[11px]">{{ $activePlacement->company->radius_meters }} meter</span>
                                </div>
                            </div>

                            <a href="{{ route('student.internship.index') }}" class="w-full py-2.5 rounded-xl bg-sky-600 hover:bg-sky-700 text-white font-bold text-xs flex items-center justify-center gap-1.5 transition shadow-sm cursor-pointer block text-center">
                                Masuk Portal PKL Siswa
                            </a>
                        </div>
                    @else
                        <div class="py-6 text-center">
                            <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <p class="text-xs font-bold text-navy">Belum Ada Penempatan PKL</p>
                            <p class="text-[11px] text-slate-400 mt-0.5">Penempatan magang industri akan ditampilkan saat jadwal PKL semester Anda tiba.</p>
                        </div>
                    @endif
                </div>

                <!-- Warta & Pengumuman Sekolah -->
                <div class="bg-white rounded-3xl border border-slate-200/90 p-6 shadow-xs">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                        <h2 class="text-sm font-black text-navy flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            <span>Warta &amp; Pengumuman</span>
                        </h2>
                        <a href="{{ route('public.announcements') }}" target="_blank" class="text-[11px] font-bold text-brand hover:underline">
                            Semua &rarr;
                        </a>
                    </div>

                    @if ($announcements->isEmpty())
                        <p class="text-xs text-slate-400 text-center py-4">Belum ada pengumuman terbaru.</p>
                    @else
                        <div class="divide-y divide-slate-100">
                            @foreach ($announcements as $post)
                                <div class="py-2.5 first:pt-0 last:pb-0">
                                    <span class="inline-block px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider {{ $post->type === 'announcement' ? 'bg-amber-50 text-amber-800 border border-amber-200' : 'bg-indigo-50 text-indigo-800 border border-indigo-200' }}">
                                        {{ $post->type }}
                                    </span>
                                    <h3 class="text-xs font-extrabold text-navy mt-1 hover:text-brand transition line-clamp-1">
                                        {{ $post->title }}
                                    </h3>
                                    <p class="text-[10px] text-slate-400 mt-0.5">
                                        {{ \Carbon\Carbon::parse($post->published_at)->diffForHumans() }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
