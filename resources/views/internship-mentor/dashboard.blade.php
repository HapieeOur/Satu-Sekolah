<x-app-layout title="Dashboard Guru Pembimbing PKL">
    <x-slot name="header">
        Dashboard Pembimbing PKL
    </x-slot>

    <x-role-switcher />

    <!-- Top Role & Welcome Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-2">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-[#E5ECFF] text-[#233DFF] border border-[#233DFF]/20">
                    <span class="w-2 h-2 rounded-full bg-[#233DFF] animate-pulse"></span>
                    Portal Pembimbing PKL
                </span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-[#ECEBFA] text-[#171B61] border border-[#171B61]/15">
                    {{ $totalMentees }} Siswa Bimbingan Aktif
                </span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight mt-2">
                Selamat Datang, {{ $user->name }}
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Pusat kendali bimbingan: verifikasi presensi geofence GPS &amp; foto selfie, peninjauan jurnal harian magang, dan evaluasi perizinan siswa di dunia usaha/industri mitra.
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('internship-mentor.attendances.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-[#233DFF] hover:bg-[#1a30d8] shadow-md shadow-[#233DFF]/25 hover:-translate-y-0.5 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Verifikasi Presensi PKL</span>
            </a>
        </div>
    </div>

    <!-- Top Horizontal Mentees & Summary Banner (Reference Image A Style) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Main Blue/Indigo Status Card -->
        <div class="md:col-span-2 relative overflow-hidden rounded-2xl bg-gradient-to-r from-[#171B61] to-[#233DFF] p-6 text-white shadow-lg">
            <div class="relative z-10 flex flex-col justify-between h-full">
                <div class="flex items-start justify-between">
                    <div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-white/20 text-white backdrop-blur-xs">
                            Praktek Kerja Lapangan (PKL)
                        </span>
                        <h2 class="text-2xl font-black tracking-tight mt-2">Monitoring Magang Industri</h2>
                        <p class="text-xs text-indigo-100 mt-0.5">Kelompok Pembimbing {{ $user->name }}</p>
                    </div>
                    <div class="text-right">
                        <span class="text-3xl font-black text-[#F4CF52]">{{ $attendanceSummary['rate'] }}%</span>
                        <p class="text-[10px] text-indigo-200 font-semibold uppercase tracking-wider">Kehadiran Hari Ini</p>
                    </div>
                </div>

                <div class="pt-6 border-t border-white/15 grid grid-cols-3 gap-3">
                    <div>
                        <p class="text-[10px] text-indigo-200 font-semibold uppercase">Total Siswa</p>
                        <p class="text-lg font-black text-white mt-0.5">{{ $totalMentees }} Siswa</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-indigo-200 font-semibold uppercase">Hadir / Di Lokasi</p>
                        <p class="text-lg font-black text-emerald-300 mt-0.5">{{ $attendanceSummary['hadir'] + $attendanceSummary['terlambat'] }} Siswa</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-indigo-200 font-semibold uppercase">Antrean Review</p>
                        <p class="text-lg font-black {{ ($pendingJournalsCount + $pendingLeavesCount) > 0 ? 'text-[#F4CF52]' : 'text-white' }} mt-0.5">
                            {{ $pendingJournalsCount + $pendingLeavesCount }} Pengajuan
                        </p>
                    </div>
                </div>
            </div>
            <div class="absolute -right-8 -bottom-8 w-48 h-48 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>
        </div>

        <!-- Mentor Workload Card -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Antrean Validasi</span>
                    <span class="w-2.5 h-2.5 rounded-full {{ $pendingJournalsCount > 0 ? 'bg-amber-500 animate-pulse' : 'bg-emerald-500' }}"></span>
                </div>
                <h4 class="text-base font-bold text-slate-900">Perhatian Pembimbing</h4>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                    @if($pendingJournalsCount > 0)
                        Terdapat <strong class="text-amber-600">{{ $pendingJournalsCount }} jurnal harian</strong> baru yang menunggu tinjauan dan penilaian Anda.
                    @else
                        Semua jurnal harian siswa bimbingan telah ditinjau dan terverifikasi.
                    @endif
                </p>
            </div>

            <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="text-slate-400">Izin Menunggu:</span>
                <span class="font-bold {{ $pendingLeavesCount > 0 ? 'text-[#233DFF]' : 'text-slate-700' }}">{{ $pendingLeavesCount }} Surat Izin</span>
            </div>
        </div>
    </div>

    <!-- 4 Bento Real Metrics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Stat 1: Siswa Bimbingan Aktif -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:border-[#233DFF]/30 transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Siswa Bimbingan Aktif</span>
                <div class="w-9 h-9 rounded-xl bg-[#E5ECFF] text-[#233DFF] flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
            </div>
            <div class="mt-3 flex items-baseline gap-2">
                <span class="text-2xl font-black text-slate-900">{{ $totalMentees }}</span>
                <span class="text-xs text-slate-400 font-medium">siswa aktif</span>
            </div>
            <p class="mt-1 text-[11px] text-slate-500">Penempatan di mitra industri DUDI</p>
        </div>

        <!-- Stat 2: Presensi Hari Ini -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:border-emerald-300 transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Presensi Hari Ini</span>
                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="mt-3 flex items-baseline gap-2">
                <span class="text-2xl font-black text-emerald-600">{{ $attendanceSummary['rate'] }}%</span>
            </div>
            <p class="mt-1 text-[11px] text-slate-500">{{ $attendanceSummary['hadir'] + $attendanceSummary['terlambat'] }} dari {{ $attendanceSummary['total'] }} siswa hadir</p>
        </div>

        <!-- Stat 3: Jurnal Menunggu Review -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:border-amber-300 transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Jurnal Menunggu Review</span>
                <div class="w-9 h-9 rounded-xl {{ $pendingJournalsCount > 0 ? 'bg-amber-50 text-amber-600' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
            </div>
            <div class="mt-3 flex items-baseline gap-2">
                <span class="text-2xl font-black {{ $pendingJournalsCount > 0 ? 'text-amber-600' : 'text-slate-800' }}">{{ $pendingJournalsCount }}</span>
                <span class="text-xs text-slate-400 font-medium">laporan</span>
            </div>
            <p class="mt-1 text-[11px] {{ $pendingJournalsCount > 0 ? 'text-amber-700 font-semibold' : 'text-slate-500' }}">
                {{ $pendingJournalsCount > 0 ? 'Memerlukan persetujuan pembimbing' : 'Semua jurnal telah ditinjau' }}
            </p>
        </div>

        <!-- Stat 4: Izin / Sakit Menunggu -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:border-indigo-300 transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Izin / Sakit Menunggu</span>
                <div class="w-9 h-9 rounded-xl {{ $pendingLeavesCount > 0 ? 'bg-[#ECEBFA] text-[#171B61]' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
            </div>
            <div class="mt-3 flex items-baseline gap-2">
                <span class="text-2xl font-black {{ $pendingLeavesCount > 0 ? 'text-[#171B61]' : 'text-slate-800' }}">{{ $pendingLeavesCount }}</span>
                <span class="text-xs text-slate-400 font-medium">pengajuan</span>
            </div>
            <p class="mt-1 text-[11px] {{ $pendingLeavesCount > 0 ? 'text-[#171B61] font-semibold' : 'text-slate-500' }}">
                {{ $pendingLeavesCount > 0 ? 'Surat izin perlu diverifikasi' : 'Tidak ada permohonan tertunda' }}
            </p>
        </div>
    </div>

    <!-- Main Content Grid: Left 2 Cols (Journals Table & Action Queue), Right 1 Col (Mentees List & Tools) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left 2 Cols: Recent Journals Table -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Jurnal Harian Siswa Bimbingan Terbaru</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Catatan aktivitas kerja terkini yang diajukan oleh siswa bimbingan Anda</p>
                    </div>
                    <a href="{{ route('internship-mentor.journals.index') }}" class="text-xs font-bold text-[#233DFF] hover:underline flex items-center gap-1">
                        <span>Lihat Seluruh Jurnal</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-[#F4F6FB] border-b border-slate-100 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                            <tr>
                                <th class="py-3 px-4">Tanggal</th>
                                <th class="py-3 px-4">Siswa</th>
                                <th class="py-3 px-4">Mitra PKL</th>
                                <th class="py-3 px-4">Judul Aktivitas</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($recentJournals as $jr)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="py-3 px-4 font-mono text-slate-500">{{ $jr->date->format('d/m/Y') }}</td>
                                    <td class="py-3 px-4">
                                        <p class="font-bold text-slate-900">{{ $jr->placement->student->name }}</p>
                                        <p class="text-[10px] text-slate-400 font-mono">NIS: {{ $jr->placement->student->nis }}</p>
                                    </td>
                                    <td class="py-3 px-4 text-slate-600 font-medium">{{ $jr->placement->company->name }}</td>
                                    <td class="py-3 px-4 font-semibold text-slate-800">{{ $jr->title }}</td>
                                    <td class="py-3 px-4">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $jr->status->badgeClass() }}">
                                            {{ $jr->status->label() }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <a href="{{ route('internship-mentor.journals.index', ['search' => $jr->placement->student->name]) }}"
                                           class="inline-flex items-center gap-1 font-bold text-[#233DFF] hover:underline">
                                            <span>Tinjau</span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-10 text-center text-slate-400">
                                        <p class="font-medium">Belum ada jurnal aktivitas siswa bimbingan yang dikirimkan.</p>
                                        <p class="text-[11px] mt-1">Jurnal yang diajukan siswa magang akan muncul di sini untuk ditinjau.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right 1 Col: Active Mentees List & Quick Tools (Reference Image A Right Panel) -->
        <div class="space-y-4">
            <!-- Mentees List Card -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Siswa Bimbingan</h4>
                    <a href="{{ route('internship-mentor.students.index') }}" class="text-xs font-bold text-[#233DFF] hover:underline">
                        Lihat Semua &rarr;
                    </a>
                </div>

                <div class="space-y-3">
                    @forelse($activeMentees ?? [] as $mentee)
                        <div class="flex items-center justify-between p-3 rounded-xl bg-[#F4F6FB] border border-slate-200/50 hover:border-[#233DFF]/30 transition group">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-[#E5ECFF] text-[#233DFF] flex items-center justify-center font-bold text-xs">
                                    {{ substr($mentee->student->name ?? 'S', 0, 1) }}
                                </div>
                                <div class="overflow-hidden">
                                    <p class="text-xs font-bold text-slate-900 truncate">{{ $mentee->student->name }}</p>
                                    <p class="text-[10px] text-slate-500 truncate">{{ $mentee->company->name ?? 'Mitra PKL' }}</p>
                                </div>
                            </div>
                            <a href="{{ route('internship-mentor.students.show', $mentee->student_id) }}" class="text-xs font-bold text-slate-400 group-hover:text-[#233DFF] transition shrink-0 ml-2">
                                Detail &rarr;
                            </a>
                        </div>
                    @empty
                        <div class="py-6 text-center text-slate-400 text-xs">
                            Belum ada siswa yang ditetapkan ke pembimbing ini.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Quick Action Tools -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Menu Pembimbing</h4>
                <div class="space-y-2">
                    <a href="{{ route('internship-mentor.attendances.index') }}" class="flex items-center justify-between p-3 rounded-xl bg-[#F4F6FB] hover:bg-[#E5ECFF] border border-slate-200/50 hover:border-[#233DFF]/30 transition group">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-[#233DFF] text-white flex items-center justify-center text-xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-900 group-hover:text-[#233DFF]">Presensi &amp; Geofence</p>
                                <p class="text-[10px] text-slate-400">Verifikasi presensi &amp; radius</p>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-[#233DFF] transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>

                    <a href="{{ route('internship-mentor.journals.index') }}" class="flex items-center justify-between p-3 rounded-xl bg-[#F4F6FB] hover:bg-[#ECEBFA] border border-slate-200/50 hover:border-[#171B61]/30 transition group">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-[#171B61] text-white flex items-center justify-center text-xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-900 group-hover:text-[#171B61]">Jurnal Magang</p>
                                <p class="text-[10px] text-slate-400">Review catatan harian siswa</p>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-[#171B61] transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>

                    <a href="{{ route('internship-mentor.leaves.index') }}" class="flex items-center justify-between p-3 rounded-xl bg-[#F4F6FB] hover:bg-amber-50 border border-slate-200/50 hover:border-amber-300 transition group">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-amber-500 text-white flex items-center justify-center text-xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-900 group-hover:text-amber-700">Pengajuan Izin</p>
                                <p class="text-[10px] text-slate-400">Verifikasi surat dokter / izin</p>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-amber-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>

                    <a href="{{ route('internship-mentor.tasks.index') }}" class="flex items-center justify-between p-3 rounded-xl bg-[#F4F6FB] hover:bg-emerald-50 border border-slate-200/50 hover:border-emerald-300 transition group">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white flex items-center justify-center text-xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-900 group-hover:text-emerald-700">Tugas Khusus PKL</p>
                                <p class="text-[10px] text-slate-400">Beri tugas &amp; nilai laporan</p>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
