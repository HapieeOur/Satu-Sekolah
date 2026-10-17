<x-app-layout title="Dashboard Guru Pembimbing PKL">
    <x-slot name="header">
        Dashboard Pembimbing PKL
    </x-slot>

    <!-- Welcome Card -->
    <div class="relative bg-gradient-to-r from-slate-900 via-sky-950 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl border border-slate-800 overflow-hidden flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="absolute -right-16 -top-16 w-64 h-64 bg-sky-500/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 space-y-2">
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-white/10 text-sky-300 border border-white/15">
                    <span class="w-1.5 h-1.5 rounded-full bg-sky-400"></span>
                    Portal Pembimbing PKL
                </span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-sky-500/20 text-sky-200 border border-sky-400/30">
                    {{ $totalMentees }} Siswa Bimbingan
                </span>
            </div>
            <h2 class="text-xl sm:text-2xl font-black tracking-tight text-white">
                Selamat Datang, {{ $user->name }}
            </h2>
            <p class="text-xs text-slate-300 max-w-xl leading-relaxed">
                Pusat kendali bimbingan: verifikasi presensi geofence GPS &amp; foto, peninjauan jurnal harian magang, dan evaluasi izin siswa di industri mitra.
            </p>
        </div>

        <div class="relative z-10 flex items-center gap-2.5">
            <a href="{{ route('internship-mentor.attendances.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-xs font-bold text-white bg-gradient-to-r from-sky-600 to-indigo-600 hover:from-sky-700 hover:to-indigo-700 rounded-xl shadow-md hover:shadow-glow hover:-translate-y-0.5 transition-all duration-150">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Verifikasi Presensi PKL</span>
            </a>
        </div>
    </div>

    <!-- Real Statistics Metrics (Bento 4-Column) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Stat 1 -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs hover:shadow-card hover:-translate-y-0.5 transition-all duration-200">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Siswa Bimbingan Aktif</span>
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 text-white flex items-center justify-center shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
            </div>
            <div class="mt-3 flex items-baseline gap-2">
                <span class="text-3xl font-black text-navy">{{ $totalMentees }}</span>
                <span class="text-xs text-slate-400 font-medium">siswa aktif</span>
            </div>
            <p class="mt-1 text-[11px] text-slate-500">Penempatan di mitra industri</p>
        </div>

        <!-- Stat 2 -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs hover:shadow-card hover:-translate-y-0.5 transition-all duration-200">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Presensi Hari Ini</span>
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="mt-3 flex items-baseline gap-2">
                <span class="text-3xl font-black text-emerald-600">{{ $attendanceSummary['rate'] }}%</span>
            </div>
            <p class="mt-1 text-[11px] text-slate-500">{{ $attendanceSummary['hadir'] + $attendanceSummary['terlambat'] }} dari {{ $attendanceSummary['total'] }} siswa hadir</p>
        </div>

        <!-- Stat 3 -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs hover:shadow-card hover:-translate-y-0.5 transition-all duration-200">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Jurnal Menunggu Review</span>
                <div class="w-10 h-10 rounded-xl {{ $pendingJournalsCount > 0 ? 'bg-gradient-to-br from-amber-500 to-orange-600' : 'bg-slate-200' }} text-white flex items-center justify-center shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
            </div>
            <div class="mt-3 flex items-baseline gap-2">
                <span class="text-3xl font-black {{ $pendingJournalsCount > 0 ? 'text-amber-600' : 'text-slate-800' }}">{{ $pendingJournalsCount }}</span>
                <span class="text-xs text-slate-400 font-medium">laporan</span>
            </div>
            <p class="mt-1 text-[11px] {{ $pendingJournalsCount > 0 ? 'text-amber-700 font-semibold' : 'text-slate-500' }}">
                {{ $pendingJournalsCount > 0 ? 'Memerlukan persetujuan pembimbing' : 'Semua jurnal telah ditinjau' }}
            </p>
        </div>

        <!-- Stat 4 -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs hover:shadow-card hover:-translate-y-0.5 transition-all duration-200">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Izin / Sakit Menunggu</span>
                <div class="w-10 h-10 rounded-xl {{ $pendingLeavesCount > 0 ? 'bg-gradient-to-br from-sky-500 to-indigo-600' : 'bg-slate-200' }} text-white flex items-center justify-center shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
            </div>
            <div class="mt-3 flex items-baseline gap-2">
                <span class="text-3xl font-black {{ $pendingLeavesCount > 0 ? 'text-sky-600' : 'text-slate-800' }}">{{ $pendingLeavesCount }}</span>
                <span class="text-xs text-slate-400 font-medium">pengajuan</span>
            </div>
            <p class="mt-1 text-[11px] {{ $pendingLeavesCount > 0 ? 'text-sky-700 font-semibold' : 'text-slate-500' }}">
                {{ $pendingLeavesCount > 0 ? 'Surat izin perlu diverifikasi' : 'Tidak ada permohonan tertunda' }}
            </p>
        </div>
    </div>

    <!-- Recent Journals Table -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-extrabold text-navy">Jurnal Harian Siswa Bimbingan Terbaru</h3>
                <p class="text-xs text-slate-400 mt-0.5">Catatan aktivitas kerja terkini yang diajukan oleh siswa bimbingan Anda</p>
            </div>
            <a href="{{ route('internship-mentor.journals.index') }}" class="text-xs font-bold text-brand hover:underline">
                Lihat Seluruh Jurnal &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50/80 border-b border-slate-100 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
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
                        <tr class="hover:bg-slate-50/75 transition">
                            <td class="py-3.5 px-4 font-mono text-slate-500">{{ $jr->date->format('d/m/Y') }}</td>
                            <td class="py-3.5 px-4">
                                <p class="font-bold text-navy">{{ $jr->placement->student->name }}</p>
                                <p class="text-[10px] text-slate-400 font-mono">NIS: {{ $jr->placement->student->nis }}</p>
                            </td>
                            <td class="py-3.5 px-4 text-slate-600 font-medium">{{ $jr->placement->company->name }}</td>
                            <td class="py-3.5 px-4 font-semibold text-slate-800">{{ $jr->title }}</td>
                            <td class="py-3.5 px-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $jr->status->badgeClass() }}">
                                    {{ $jr->status->label() }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <a href="{{ route('internship-mentor.journals.index', ['search' => $jr->placement->student->name]) }}"
                                   class="font-bold text-brand hover:underline">
                                    Tinjau &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-slate-400">
                                Belum ada jurnal aktivitas siswa bimbingan yang dikirimkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
