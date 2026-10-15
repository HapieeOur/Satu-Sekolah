<x-app-layout title="Dashboard Guru Pembimbing PKL">
    <x-slot name="header">
        Dashboard Pembimbing PKL
    </x-slot>

    <!-- Welcome Card -->
    <div class="bg-surface rounded-xl p-6 border border-border shadow-sm">
        <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                        Portal Pembimbing PKL
                    </span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-semibold bg-navy-light/10 text-navy border border-navy/20">
                        {{ $totalMentees }} Siswa Bimbingan Aktif
                    </span>
                </div>
                <h2 class="text-xl font-bold text-navy">Selamat Datang, {{ $user->name }}</h2>
                <p class="text-xs text-slate-500 mt-1">
                    Portal pemantauan aktivitas, presensi berbasis GPS & foto, peninjauan jurnal harian, serta penugasan siswa PKL.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('internship-mentor.attendances.index') }}" class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-white bg-brand rounded-lg hover:bg-brand-hover shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Verifikasi Presensi</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Real Statistics Metrics -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-surface rounded-xl p-5 border border-border shadow-sm">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Siswa Bimbingan Aktif</span>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="text-3xl font-extrabold text-navy">{{ $totalMentees }}</span>
                <span class="text-xs text-slate-400 font-medium">siswa</span>
            </div>
            <p class="mt-1 text-[11px] text-slate-500">Penempatan industri mitra</p>
        </div>

        <div class="bg-surface rounded-xl p-5 border border-border shadow-sm">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Presensi PKL Hari Ini</span>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="text-3xl font-extrabold text-emerald-700">{{ $attendanceSummary['rate'] }}%</span>
            </div>
            <p class="mt-1 text-[11px] text-slate-500">{{ $attendanceSummary['hadir'] + $attendanceSummary['terlambat'] }} dari {{ $attendanceSummary['total'] }} siswa tercatat hadir</p>
        </div>

        <div class="bg-surface rounded-xl p-5 border border-border shadow-sm">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Jurnal Menunggu Review</span>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="text-3xl font-extrabold {{ $pendingJournalsCount > 0 ? 'text-amber-700' : 'text-slate-800' }}">{{ $pendingJournalsCount }}</span>
                <span class="text-xs text-slate-400 font-medium">catatan</span>
            </div>
            <p class="mt-1 text-[11px] text-slate-500">Memerlukan persetujuan pembimbing</p>
        </div>

        <div class="bg-surface rounded-xl p-5 border border-border shadow-sm">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Izin / Sakit Menunggu</span>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="text-3xl font-extrabold {{ $pendingLeavesCount > 0 ? 'text-blue-700' : 'text-slate-800' }}">{{ $pendingLeavesCount }}</span>
                <span class="text-xs text-slate-400 font-medium">pengajuan</span>
            </div>
            <p class="mt-1 text-[11px] text-slate-500">Permohonan izin perlu ditinjau</p>
        </div>
    </div>

    <!-- Recent Journals Table -->
    <div class="bg-surface rounded-xl border border-border shadow-sm overflow-hidden">
        <div class="p-5 border-b border-border flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-navy">Jurnal Harian Siswa Bimbingan Terbaru</h3>
                <p class="text-xs text-slate-500 mt-0.5">Catatan aktivitas kerja terkini yang diajukan oleh siswa bimbingan Anda</p>
            </div>
            <a href="{{ route('internship-mentor.journals.index') }}" class="text-xs font-semibold text-brand hover:underline">
                Lihat Seluruh Jurnal &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-800">
                <thead class="bg-slate-50 border-b border-border text-slate-700 font-semibold uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="py-3 px-4">Tanggal</th>
                        <th class="py-3 px-4">Siswa</th>
                        <th class="py-3 px-4">Mitra Perusahaan</th>
                        <th class="py-3 px-4">Judul Aktivitas</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse($recentJournals as $jr)
                        <tr class="hover:bg-slate-50/75 transition">
                            <td class="py-3 px-4 font-mono text-slate-600">{{ $jr->date->format('d/m/Y') }}</td>
                            <td class="py-3 px-4">
                                <p class="font-bold text-navy">{{ $jr->placement->student->name }}</p>
                                <p class="text-[11px] text-slate-500 font-mono">{{ $jr->placement->student->nis }}</p>
                            </td>
                            <td class="py-3 px-4 text-slate-700">{{ $jr->placement->company->name }}</td>
                            <td class="py-3 px-4 font-semibold text-slate-800">{{ $jr->title }}</td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold border {{ $jr->status->badgeClass() }}">
                                    {{ $jr->status->label() }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <a href="{{ route('internship-mentor.journals.index', ['search' => $jr->placement->student->name]) }}"
                                   class="text-xs font-semibold text-brand hover:underline">
                                    Tinjau
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-500">
                                Belum ada jurnal aktivitas siswa bimbingan yang dikirimkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
