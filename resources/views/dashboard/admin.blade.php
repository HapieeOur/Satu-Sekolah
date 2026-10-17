<x-app-layout title="Admin Dashboard">
    <x-slot name="header">
        Dashboard Administrasi
    </x-slot>

    <!-- Welcome & Quick Actions Banner -->
    <div class="relative bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl border border-slate-800 overflow-hidden flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <!-- Ambient Glow -->
        <div class="absolute -right-16 -top-16 w-64 h-64 bg-brand/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 space-y-2">
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-white/10 text-indigo-300 border border-white/15">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    Sistem Informasi Akademik &amp; PKL
                </span>
                <span class="text-xs text-slate-400 font-medium hidden sm:inline">
                    {{ now()->translatedFormat('l, d F Y') }}
                </span>
            </div>
            <h2 class="text-xl sm:text-2xl font-black tracking-tight text-white">
                Selamat Datang, {{ Auth::user()->name }}
            </h2>
            <p class="text-xs text-slate-300 max-w-xl leading-relaxed">
                Ringkasan operasional akademik terpadu, pemantauan presensi DUDI PKL real-time, dan status manajemen pengguna.
            </p>
        </div>

        <div class="relative z-10 flex flex-wrap items-center gap-2.5">
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-brand to-indigo-600 hover:from-brand-hover hover:to-indigo-700 text-white text-xs font-bold rounded-xl shadow-md hover:shadow-glow hover:-translate-y-0.5 transition-all duration-150">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Tambah Pengguna</span>
            </a>
            <a href="{{ route('admin.internships.placements.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/10 hover:bg-white/15 text-white border border-white/20 text-xs font-bold rounded-xl shadow-xs hover:-translate-y-0.5 transition-all duration-150">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                <span>Penempatan Siswa</span>
            </a>
            <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/10 hover:bg-white/15 text-white border border-white/20 text-xs font-bold rounded-xl shadow-xs hover:-translate-y-0.5 transition-all duration-150">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <span>Tulis Berita / Acara</span>
            </a>
        </div>
    </div>

    <!-- Core Operational Stats (Bento 4-Column) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Stat 1 -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs hover:shadow-card hover:-translate-y-0.5 transition-all duration-200">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Siswa</span>
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 text-white flex items-center justify-center shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg>
                </div>
            </div>
            <div class="mt-3 flex items-baseline gap-2">
                <p class="text-3xl font-black text-navy">{{ $stats['total_students'] }}</p>
                <span class="text-xs text-slate-400 font-medium">terdaftar</span>
            </div>
            <p class="text-[11px] text-slate-500 mt-1 flex items-center gap-1">
                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                <span>Peserta didik aktif</span>
            </p>
        </div>

        <!-- Stat 2 -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs hover:shadow-card hover:-translate-y-0.5 transition-all duration-200">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Tenaga Pendidik</span>
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 text-white flex items-center justify-center shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </div>
            </div>
            <div class="mt-3 flex items-baseline gap-2">
                <p class="text-3xl font-black text-navy">{{ $stats['total_teachers'] }}</p>
                <span class="text-xs text-slate-400 font-medium">guru &amp; mentor</span>
            </div>
            <p class="text-[11px] text-slate-500 mt-1 flex items-center gap-1">
                <span class="w-1.5 h-1.5 rounded-full bg-violet-500"></span>
                <span>Pengajar terakreditasi</span>
            </p>
        </div>

        <!-- Stat 3 -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs hover:shadow-card hover:-translate-y-0.5 transition-all duration-200">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Rombel Kelas</span>
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
            </div>
            <div class="mt-3 flex items-baseline gap-2">
                <p class="text-3xl font-black text-navy">{{ $stats['total_classrooms'] }}</p>
                <span class="text-xs text-slate-400 font-medium">rombel</span>
            </div>
            <p class="text-[11px] text-slate-500 mt-1 flex items-center gap-1">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                <span>Rombongan belajar</span>
            </p>
        </div>

        <!-- Stat 4 -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs hover:shadow-card hover:-translate-y-0.5 transition-all duration-200">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Penempatan PKL Aktif</span>
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 text-white flex items-center justify-center shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
            </div>
            <div class="mt-3 flex items-baseline gap-2">
                <p class="text-3xl font-black text-navy">{{ $stats['active_placements'] }}</p>
                <span class="text-xs text-slate-400 font-medium">siswa di DUDI</span>
            </div>
            <p class="text-[11px] text-slate-500 mt-1 flex items-center gap-1">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                <span>Aktif di industri</span>
            </p>
        </div>
    </div>

    <!-- PKL Operational Health & Pending Action Items -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- PKL Daily Attendance Rate -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs p-6 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600 block">Monitoring Hari Ini</span>
                        <h3 class="text-sm font-extrabold text-navy">Presensi PKL Siswa</h3>
                    </div>
                    <span class="text-xs font-mono font-semibold px-2 py-0.5 rounded-md bg-slate-100 text-slate-600">{{ now()->format('d/m/Y') }}</span>
                </div>

                <div class="flex items-baseline gap-2 mb-3">
                    <span class="text-4xl font-black text-emerald-600">{{ $pklAttendanceSummary['rate'] }}%</span>
                    <span class="text-xs text-slate-500">kehadiran tercatat</span>
                </div>

                <!-- Progress Bar with Gradient -->
                <div class="w-full bg-slate-100 rounded-full h-3 mb-5 overflow-hidden p-0.5 border border-slate-200/60">
                    <div class="bg-gradient-to-r from-emerald-500 to-teal-500 h-full rounded-full transition-all duration-500" style="width: {{ $pklAttendanceSummary['rate'] }}%"></div>
                </div>

                <div class="grid grid-cols-2 gap-2 text-xs">
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Hadir / Terlambat</span>
                        <span class="font-bold text-navy text-sm">{{ $pklAttendanceSummary['hadir'] }} / {{ $pklAttendanceSummary['terlambat'] }}</span>
                    </div>
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Izin / Sakit</span>
                        <span class="font-bold text-navy text-sm">{{ $pklAttendanceSummary['izin'] }} / {{ $pklAttendanceSummary['sakit'] }}</span>
                    </div>
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Alpa (Tanpa Ket.)</span>
                        <span class="font-bold {{ $pklAttendanceSummary['alpa'] > 0 ? 'text-rose-600' : 'text-slate-700' }} text-sm">{{ $pklAttendanceSummary['alpa'] }}</span>
                    </div>
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Total Presensi</span>
                        <span class="font-bold text-slate-700 text-sm">{{ $pklAttendanceSummary['total'] }} data</span>
                    </div>
                </div>
            </div>

            <div class="mt-5 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.internships.attendances.index') }}" class="text-xs font-bold text-brand hover:underline inline-flex items-center gap-1.5">
                    <span>Lihat Rincian Presensi &amp; Koordinat GPS</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>

        <!-- Pending Items Awaiting Review -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs p-6 flex flex-col justify-between">
            <div>
                <div class="mb-4">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-amber-600 block">Antrean Tugas</span>
                    <h3 class="text-sm font-extrabold text-navy">Item Menunggu Tindak Lanjut</h3>
                </div>
                
                <div class="space-y-3">
                    <div class="p-3.5 rounded-2xl border border-slate-100 bg-slate-50/80 flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-navy block">Pengajuan Izin / Sakit PKL</span>
                            <span class="text-[11px] text-slate-400">Verifikasi surat izin siswa</span>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $pendingLeavesCount > 0 ? 'bg-amber-100 text-amber-800 border border-amber-200' : 'bg-slate-100 text-slate-500' }}">
                            {{ $pendingLeavesCount }} pending
                        </span>
                    </div>

                    <div class="p-3.5 rounded-2xl border border-slate-100 bg-slate-50/80 flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-navy block">Jurnal Harian Siswa</span>
                            <span class="text-[11px] text-slate-400">Laporan kegiatan harian PKL</span>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $pendingJournalsCount > 0 ? 'bg-indigo-100 text-brand border border-indigo-200' : 'bg-slate-100 text-slate-500' }}">
                            {{ $pendingJournalsCount }} masuk
                        </span>
                    </div>

                    <div class="p-3.5 rounded-2xl border border-slate-100 bg-slate-50/80 flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-navy block">Akun Pengguna Aktif</span>
                            <span class="text-[11px] text-slate-400">Rasio akun aktif sistem</span>
                        </div>
                        <span class="text-xs font-extrabold text-navy font-mono">
                            {{ $stats['active_users'] }} / {{ $stats['total_users'] }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="mt-5 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.internships.placements.index') }}" class="text-xs font-bold text-brand hover:underline inline-flex items-center gap-1.5">
                    <span>Kelola Penempatan PKL Siswa</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>

        <!-- System Administration Status -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs p-6 flex flex-col justify-between">
            <div>
                <div class="mb-4">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-brand block">Sistem &amp; Keamanan</span>
                    <h3 class="text-sm font-extrabold text-navy">Konfigurasi Hak Akses RBAC</h3>
                </div>
                
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-50 border border-slate-100 text-xs">
                        <span class="font-semibold text-slate-700">Role Sistem Aktif</span>
                        <span class="font-bold text-navy">{{ $stats['total_roles'] }} Peran</span>
                    </div>
                    <div class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-50 border border-slate-100 text-xs">
                        <span class="font-semibold text-slate-700">Akun Nonaktif</span>
                        <span class="font-bold {{ ($stats['total_users'] - $stats['active_users']) > 0 ? 'text-rose-600' : 'text-slate-500' }}">
                            {{ $stats['total_users'] - $stats['active_users'] }} Akun
                        </span>
                    </div>
                    <div class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-50 border border-slate-100 text-xs">
                        <span class="font-semibold text-slate-700">Audit Koreksi Presensi</span>
                        <span class="font-bold text-emerald-700 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Tercatat Log
                        </span>
                    </div>
                </div>
            </div>

            <div class="mt-5 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.users.index') }}" class="text-xs font-bold text-brand hover:underline inline-flex items-center gap-1.5">
                    <span>Manajemen Hak Akses &amp; Pengguna</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Real Activity Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Recent PKL Attendances -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden flex flex-col">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-extrabold text-navy">Log Presensi PKL Hari Ini</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Catatan check-in mobile terbaru siswa</p>
                </div>
                <a href="{{ route('admin.internships.attendances.index') }}" class="text-xs font-bold text-brand hover:underline">
                    Semua Presensi &rarr;
                </a>
            </div>

            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50/80 border-b border-slate-100 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                        <tr>
                            <th class="py-3 px-4">Siswa</th>
                            <th class="py-3 px-4">Mitra PKL</th>
                            <th class="py-3 px-4">Waktu</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4">Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($recentPklAttendances as $att)
                            <tr class="hover:bg-slate-50/75 transition">
                                <td class="py-3.5 px-4 font-bold text-navy">
                                    {{ $att->placement->student->name }}
                                </td>
                                <td class="py-3.5 px-4 text-slate-600 font-medium">
                                    {{ $att->placement->company->name }}
                                </td>
                                <td class="py-3.5 px-4 font-mono text-slate-500">
                                    {{ $att->check_in_time ? substr($att->check_in_time, 0, 5) : '-' }}
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $att->status->badgeClass() }}">
                                        {{ $att->status->label() }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $att->verification_status->badgeClass() }}">
                                        {{ $att->verification_status->label() }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-10 text-center text-slate-400">
                                    Belum ada catatan presensi PKL hari ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Placements -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden flex flex-col">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-extrabold text-navy">Penempatan PKL Terbaru</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Penugasan siswa di mitra industri</p>
                </div>
                <a href="{{ route('admin.internships.placements.index') }}" class="text-xs font-bold text-brand hover:underline">
                    Semua Penempatan &rarr;
                </a>
            </div>

            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50/80 border-b border-slate-100 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                        <tr>
                            <th class="py-3 px-4">Siswa</th>
                            <th class="py-3 px-4">Mitra Perusahaan</th>
                            <th class="py-3 px-4">Pembimbing</th>
                            <th class="py-3 px-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($recentPlacements as $placement)
                            <tr class="hover:bg-slate-50/75 transition">
                                <td class="py-3.5 px-4">
                                    <span class="font-bold text-navy block">{{ $placement->student->name }}</span>
                                    <span class="text-[10px] text-slate-400 font-mono">NIS: {{ $placement->student->nis }}</span>
                                </td>
                                <td class="py-3.5 px-4 text-slate-600 font-medium">
                                    {{ $placement->company->name }}
                                </td>
                                <td class="py-3.5 px-4 text-slate-500">
                                    {{ $placement->teacher->user->name ?? '-' }}
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $placement->status->badgeClass() }}">
                                        {{ $placement->status->label() }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-10 text-center text-slate-400">
                                    Belum ada data penempatan PKL terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Users Table -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-extrabold text-navy">Pengguna Terbaru</h3>
                <p class="text-xs text-slate-400 mt-0.5">5 akun terakhir yang didaftarkan pada sistem</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="text-xs font-bold text-brand hover:underline">
                Kelola Semua Pengguna &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50/80 border-b border-slate-100 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="py-3 px-4">Nama Lengkap</th>
                        <th class="py-3 px-4">Email</th>
                        <th class="py-3 px-4">Peran</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($recentUsers as $user)
                        <tr class="hover:bg-slate-50/75 transition">
                            <td class="py-3.5 px-4 font-bold text-navy">{{ $user->name }}</td>
                            <td class="py-3.5 px-4 font-mono text-slate-500">{{ $user->email }}</td>
                            <td class="py-3.5 px-4">
                                <div class="flex flex-wrap gap-1">
                                    @foreach ($user->roles as $role)
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                            {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                @if ($user->is_active)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <a href="{{ route('admin.users.edit', $user) }}" class="font-bold text-brand hover:underline">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-10 text-center text-slate-400">
                                Belum ada pengguna terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
