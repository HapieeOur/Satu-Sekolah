<x-app-layout title="Admin Dashboard">
    <x-slot name="header">
        Dashboard Administrasi
    </x-slot>

    <!-- Welcome & Quick Actions Banner -->
    <div class="bg-surface rounded-xl p-6 border border-border shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1.5">
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-blue-50 text-brand border border-blue-200">
                    Sistem Informasi Sekolah
                </span>
                <span class="text-xs text-slate-500 font-medium">
                    {{ now()->translatedFormat('l, d F Y') }}
                </span>
            </div>
            <h2 class="text-xl font-bold text-navy">Selamat Datang, {{ Auth::user()->name }}</h2>
            <p class="text-xs text-slate-500 mt-0.5">Ringkasan operasional akademik, status penempatan, dan monitoring presensi institusi.</p>
        </div>
        <div class="flex flex-wrap items-center gap-2.5">
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 px-3.5 py-2 bg-brand hover:bg-brand-hover text-white text-xs font-semibold rounded-lg shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Tambah Pengguna</span>
            </a>
            <a href="{{ route('admin.internships.placements.create') }}" class="inline-flex items-center gap-2 px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-border text-xs font-semibold rounded-lg shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                <span>Tempatkan Siswa PKL</span>
            </a>
            <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center gap-2 px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-border text-xs font-semibold rounded-lg shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <span>Buat Berita/Pengumuman</span>
            </a>
        </div>
    </div>

    <!-- Core Operational Stats (Section 5 Requirement: Total Siswa, Guru, Kelas, Penempatan PKL Aktif) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-surface p-5 rounded-xl border border-border shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Siswa</span>
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-brand flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg>
                </div>
            </div>
            <p class="mt-3 text-2xl font-bold text-navy">{{ $stats['total_students'] }}</p>
            <p class="text-xs text-slate-500 mt-1">Siswa aktif terdaftar</p>
        </div>

        <div class="bg-surface p-5 rounded-xl border border-border shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Tenaga Pendidik</span>
                <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-700 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </div>
            </div>
            <p class="mt-3 text-2xl font-bold text-navy">{{ $stats['total_teachers'] }}</p>
            <p class="text-xs text-slate-500 mt-1">Guru & Pembimbing aktif</p>
        </div>

        <div class="bg-surface p-5 rounded-xl border border-border shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Rombel Kelas</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
            </div>
            <p class="mt-3 text-2xl font-bold text-navy">{{ $stats['total_classrooms'] }}</p>
            <p class="text-xs text-slate-500 mt-1">Rombongan belajar terdaftar</p>
        </div>

        <div class="bg-surface p-5 rounded-xl border border-border shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Penempatan PKL Aktif</span>
                <div class="w-8 h-8 rounded-lg bg-purple-50 text-purple-700 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
            </div>
            <p class="mt-3 text-2xl font-bold text-navy">{{ $stats['active_placements'] }}</p>
            <p class="text-xs text-slate-500 mt-1">Siswa di industri mitra</p>
        </div>
    </div>

    <!-- PKL Operational Health & Pending Action Items -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- PKL Daily Attendance Rate -->
        <div class="bg-surface rounded-xl border border-border shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xs font-bold text-navy uppercase tracking-wider">Presensi PKL Hari Ini</h3>
                <span class="text-xs font-medium text-slate-500">{{ now()->format('d/m/Y') }}</span>
            </div>

            <div class="flex items-baseline gap-2 mb-4">
                <span class="text-3xl font-extrabold text-navy">{{ $pklAttendanceSummary['rate'] }}%</span>
                <span class="text-xs text-slate-500">kehadiran siswa PKL</span>
            </div>

            <div class="w-full bg-slate-100 rounded-full h-2 mb-4 overflow-hidden">
                <div class="bg-emerald-600 h-2 rounded-full" style="width: {{ $pklAttendanceSummary['rate'] }}%"></div>
            </div>

            <div class="grid grid-cols-2 gap-2 text-xs">
                <div class="p-2.5 rounded-lg bg-slate-50 border border-border">
                    <span class="text-slate-500 block text-[11px]">Hadir / Terlambat</span>
                    <span class="font-bold text-navy">{{ $pklAttendanceSummary['hadir'] }} / {{ $pklAttendanceSummary['terlambat'] }}</span>
                </div>
                <div class="p-2.5 rounded-lg bg-slate-50 border border-border">
                    <span class="text-slate-500 block text-[11px]">Izin / Sakit</span>
                    <span class="font-bold text-navy">{{ $pklAttendanceSummary['izin'] }} / {{ $pklAttendanceSummary['sakit'] }}</span>
                </div>
                <div class="p-2.5 rounded-lg bg-slate-50 border border-border">
                    <span class="text-slate-500 block text-[11px]">Alpa (Tanpa Ket.)</span>
                    <span class="font-bold {{ $pklAttendanceSummary['alpa'] > 0 ? 'text-rose-700' : 'text-slate-800' }}">{{ $pklAttendanceSummary['alpa'] }}</span>
                </div>
                <div class="p-2.5 rounded-lg bg-slate-50 border border-border">
                    <span class="text-slate-500 block text-[11px]">Total Presensi PKL</span>
                    <span class="font-bold text-slate-700">{{ $pklAttendanceSummary['total'] }} tercatat</span>
                </div>
            </div>

            <div class="mt-4 pt-4 border-t border-border">
                <a href="{{ route('admin.internships.attendances.index') }}" class="text-xs font-semibold text-brand hover:underline inline-flex items-center gap-1">
                    <span>Monitoring Seluruh Presensi PKL</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>

        <!-- Pending Items Awaiting Review -->
        <div class="bg-surface rounded-xl border border-border shadow-sm p-6 flex flex-col justify-between">
            <div>
                <h3 class="text-xs font-bold text-navy uppercase tracking-wider mb-4">Item Menunggu Tindak Lanjut</h3>
                
                <div class="space-y-3">
                    <div class="p-3.5 rounded-lg border border-border bg-canvas flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-navy block">Pengajuan Izin / Sakit PKL</span>
                            <span class="text-[11px] text-slate-500">Menunggu persetujuan pembimbing</span>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $pendingLeavesCount > 0 ? 'bg-amber-100 text-amber-800 border border-amber-200' : 'bg-slate-100 text-slate-600' }}">
                            {{ $pendingLeavesCount }} pending
                        </span>
                    </div>

                    <div class="p-3.5 rounded-lg border border-border bg-canvas flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-navy block">Jurnal Harian Siswa</span>
                            <span class="text-[11px] text-slate-500">Menunggu verifikasi laporan aktivitas</span>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $pendingJournalsCount > 0 ? 'bg-blue-100 text-brand border border-blue-200' : 'bg-slate-100 text-slate-600' }}">
                            {{ $pendingJournalsCount }} dikirim
                        </span>
                    </div>

                    <div class="p-3.5 rounded-lg border border-border bg-canvas flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-navy block">Pengguna Sistem Aktif</span>
                            <span class="text-[11px] text-slate-500">Rasio akun aktif vs total terdaftar</span>
                        </div>
                        <span class="text-xs font-bold text-navy">
                            {{ $stats['active_users'] }} / {{ $stats['total_users'] }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-4 border-t border-border">
                <a href="{{ route('admin.internships.placements.index') }}" class="text-xs font-semibold text-brand hover:underline inline-flex items-center gap-1">
                    <span>Kelola Penempatan PKL Siswa</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>

        <!-- System Administration Status -->
        <div class="bg-surface rounded-xl border border-border shadow-sm p-6 flex flex-col justify-between">
            <div>
                <h3 class="text-xs font-bold text-navy uppercase tracking-wider mb-4">Konfigurasi Hak Akses & Akun</h3>
                
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 rounded-lg bg-slate-50 border border-border">
                        <span class="text-xs font-semibold text-slate-700">Role Sistem RBAC</span>
                        <span class="text-xs font-bold text-navy">{{ $stats['total_roles'] }} role</span>
                    </div>
                    <div class="flex items-center justify-between p-3 rounded-lg bg-slate-50 border border-border">
                        <span class="text-xs font-semibold text-slate-700">Akun Nonaktif</span>
                        <span class="text-xs font-bold {{ ($stats['total_users'] - $stats['active_users']) > 0 ? 'text-rose-700' : 'text-slate-600' }}">
                            {{ $stats['total_users'] - $stats['active_users'] }} akun
                        </span>
                    </div>
                    <div class="flex items-center justify-between p-3 rounded-lg bg-slate-50 border border-border">
                        <span class="text-xs font-semibold text-slate-700">Otorisasi Koreksi Manual</span>
                        <span class="text-xs font-semibold text-emerald-700">Tercatat Audit Log</span>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-4 border-t border-border">
                <a href="{{ route('admin.users.index') }}" class="text-xs font-semibold text-brand hover:underline inline-flex items-center gap-1">
                    <span>Manajemen Seluruh Akun Pengguna</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Real Activity Tables (Section 5 Requirement: Aktivitas terbaru yang benar-benar berasal dari database) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent PKL Attendances -->
        <div class="bg-surface rounded-xl border border-border shadow-sm overflow-hidden flex flex-col">
            <div class="p-5 border-b border-border flex items-center justify-between">
                <div>
                    <h3 class="text-xs font-bold text-navy uppercase tracking-wider">Log Presensi PKL Hari Ini</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Aktivitas presensi mobile terbaru</p>
                </div>
                <a href="{{ route('admin.internships.attendances.index') }}" class="text-xs font-semibold text-brand hover:underline">
                    Semua Presensi &rarr;
                </a>
            </div>

            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 border-b border-border text-slate-700 font-semibold uppercase tracking-wider text-[11px]">
                        <tr>
                            <th class="py-3 px-4">Siswa</th>
                            <th class="py-3 px-4">Mitra Perusahaan</th>
                            <th class="py-3 px-4">Waktu</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4">Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse ($recentPklAttendances as $att)
                            <tr class="hover:bg-slate-50/75 transition">
                                <td class="py-3 px-4 font-semibold text-navy">
                                    {{ $att->placement->student->name }}
                                </td>
                                <td class="py-3 px-4 text-slate-700">
                                    {{ $att->placement->company->name }}
                                </td>
                                <td class="py-3 px-4 font-mono text-slate-600">
                                    {{ $att->check_in_time ? substr($att->check_in_time, 0, 5) : '-' }}
                                </td>
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold {{ $att->status->badgeClass() }}">
                                        {{ $att->status->label() }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold border {{ $att->verification_status->badgeClass() }}">
                                        {{ $att->verification_status->label() }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-500">
                                    Belum ada catatan presensi PKL hari ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Placements -->
        <div class="bg-surface rounded-xl border border-border shadow-sm overflow-hidden flex flex-col">
            <div class="p-5 border-b border-border flex items-center justify-between">
                <div>
                    <h3 class="text-xs font-bold text-navy uppercase tracking-wider">Penempatan PKL Terbaru</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Penugasan siswa di industri mitra</p>
                </div>
                <a href="{{ route('admin.internships.placements.index') }}" class="text-xs font-semibold text-brand hover:underline">
                    Semua Penempatan &rarr;
                </a>
            </div>

            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 border-b border-border text-slate-700 font-semibold uppercase tracking-wider text-[11px]">
                        <tr>
                            <th class="py-3 px-4">Siswa</th>
                            <th class="py-3 px-4">Mitra Perusahaan</th>
                            <th class="py-3 px-4">Pembimbing</th>
                            <th class="py-3 px-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse ($recentPlacements as $placement)
                            <tr class="hover:bg-slate-50/75 transition">
                                <td class="py-3 px-4">
                                    <span class="font-semibold text-navy block">{{ $placement->student->name }}</span>
                                    <span class="text-[11px] text-slate-500 font-mono">{{ $placement->student->nis }}</span>
                                </td>
                                <td class="py-3 px-4 text-slate-700">
                                    {{ $placement->company->name }}
                                </td>
                                <td class="py-3 px-4 text-slate-600">
                                    {{ $placement->teacher->user->name ?? '-' }}
                                </td>
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold border {{ $placement->status->badgeClass() }}">
                                        {{ $placement->status->label() }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-slate-500">
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
    <div class="bg-surface rounded-xl border border-border shadow-sm overflow-hidden">
        <div class="p-5 border-b border-border flex items-center justify-between">
            <div>
                <h3 class="text-xs font-bold text-navy uppercase tracking-wider">Pengguna Terbaru</h3>
                <p class="text-xs text-slate-500 mt-0.5">5 akun terakhir yang didaftarkan pada sistem</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="text-xs font-semibold text-brand hover:underline">
                Kelola Semua Pengguna &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-border text-slate-700 font-semibold uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="py-3 px-4">Nama Lengkap</th>
                        <th class="py-3 px-4">Email</th>
                        <th class="py-3 px-4">Peran</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse ($recentUsers as $user)
                        <tr class="hover:bg-slate-50/75 transition">
                            <td class="py-3 px-4 font-semibold text-navy">{{ $user->name }}</td>
                            <td class="py-3 px-4 font-mono text-slate-600">{{ $user->email }}</td>
                            <td class="py-3 px-4">
                                <div class="flex flex-wrap gap-1">
                                    @foreach ($user->roles as $role)
                                        <span class="px-2 py-0.5 rounded text-[11px] font-medium bg-slate-100 text-slate-700 border border-slate-200">
                                            {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                @if ($user->is_active)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-rose-50 text-rose-800 border border-rose-200">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-right">
                                <a href="{{ route('admin.users.edit', $user) }}" class="font-semibold text-brand hover:underline">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-500">
                                Belum ada pengguna terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
