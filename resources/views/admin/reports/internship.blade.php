<x-app-layout title="Laporan Monitoring PKL">
    <x-slot name="header">
        Laporan Monitoring & Rekapitulasi PKL
    </x-slot>

    <div class="space-y-6">
        <!-- Top Hero / Page Header -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 p-6 md:p-8 text-white shadow-xl">
            <div class="absolute -right-12 -top-12 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -left-12 -bottom-12 w-64 h-64 bg-brand/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/20 border border-indigo-400/30 text-indigo-300 text-xs font-semibold mb-3">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Laporan Terintegrasi PKL</span>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-white">Rekapitulasi Monitoring Praktik Kerja Lapangan</h1>
                    <p class="text-sm text-slate-300 mt-1 max-w-xl">
                        Evaluasi komprehensif penempatan siswa di mitra industri (DUDI), kepatuhan presensi geofence, dan rekapitulasi persetujuan jurnal harian.
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 px-5 py-3 text-xs font-semibold text-slate-900 bg-white hover:bg-slate-50 rounded-xl shadow-lg transition transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        <span>Cetak Laporan</span>
                    </button>
                </div>
            </div>

            <!-- Bento Stats Sub-row -->
            <div class="relative z-10 grid grid-cols-1 sm:grid-cols-3 gap-3 mt-6 pt-6 border-t border-white/10">
                <div class="p-3 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <span class="text-[11px] font-medium text-slate-400 block">Total Penempatan Terdata</span>
                    <span class="text-xl font-bold text-white mt-0.5 block">{{ $reportMetrics['total_placements'] }} Siswa</span>
                </div>
                <div class="p-3 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <span class="text-[11px] font-medium text-slate-400 block">Penempatan Aktif Berjalan</span>
                    <span class="text-xl font-bold text-emerald-400 mt-0.5 block">{{ $reportMetrics['active_count'] }} Siswa</span>
                </div>
                <div class="p-3 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <span class="text-[11px] font-medium text-slate-400 block">Penempatan Tuntas / Selesai</span>
                    <span class="text-xl font-bold text-sky-400 mt-0.5 block">{{ $reportMetrics['completed_count'] }} Tuntas</span>
                </div>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5">
            <form method="GET" action="{{ route('admin.reports.internship') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <div>
                    <label for="company_id" class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Mitra Industri</label>
                    <select name="company_id" id="company_id" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800">
                        <option value="">Semua Perusahaan</option>
                        @foreach($companies as $cmp)
                            <option value="{{ $cmp->id }}" {{ $companyId == $cmp->id ? 'selected' : '' }}>
                                {{ $cmp->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="teacher_id" class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Guru Pembimbing</label>
                    <select name="teacher_id" id="teacher_id" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800">
                        <option value="">Semua Pembimbing</option>
                        @foreach($teachers as $tc)
                            <option value="{{ $tc->id }}" {{ $teacherId == $tc->id ? 'selected' : '' }}>
                                {{ $tc->user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Status Penempatan</label>
                    <select name="status" id="status" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800">
                        <option value="">Semua Status</option>
                        @foreach($statuses as $st)
                            <option value="{{ $st->value }}" {{ $status == $st->value ? 'selected' : '' }}>
                                {{ $st->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="start_date" class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Tanggal Mulai</label>
                    <input type="date" name="start_date" id="start_date" value="{{ $startDate }}" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800 font-mono">
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold rounded-xl shadow-sm transition min-h-[42px] flex items-center justify-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <span>Filter</span>
                    </button>
                    @if($companyId || $teacherId || $status || $startDate)
                        <a href="{{ route('admin.reports.internship') }}" class="px-3.5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl transition min-h-[42px] flex items-center justify-center">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Placements Report Table Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="text-sm font-bold text-slate-900">Daftar Rekapitulasi Siswa Magang PKL</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Menampilkan status presensi, verifikasi jurnal harian, dan evaluasi kinerja</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50/75 border-b border-slate-200 text-[11px] font-bold uppercase tracking-wider text-slate-600">
                            <th class="py-3.5 px-4">Siswa</th>
                            <th class="py-3.5 px-4">Rombel & Jurusan</th>
                            <th class="py-3.5 px-4">Mitra Perusahaan</th>
                            <th class="py-3.5 px-4">Pembimbing Sekolah</th>
                            <th class="py-3.5 px-4 text-center">Presensi (H / T)</th>
                            <th class="py-3.5 px-4 text-center">Izin / Sakit / Alpa</th>
                            <th class="py-3.5 px-4 text-center">Jurnal Disetujui</th>
                            <th class="py-3.5 px-5">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($placements as $plc)
                            @php
                                $hadir = $plc->attendances->where('status.value', 'hadir')->count();
                                $terlambat = $plc->attendances->where('status.value', 'terlambat')->count();
                                $izin = $plc->attendances->where('status.value', 'izin')->count();
                                $sakit = $plc->attendances->where('status.value', 'sakit')->count();
                                $alpa = $plc->attendances->where('status.value', 'alpa')->count();
                                $approvedJournals = $plc->journals->where('status.value', 'approved')->count();
                                $totalJournals = $plc->journals->count();
                            @endphp
                            <tr class="hover:bg-indigo-50/30 transition-colors duration-150">
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-full bg-indigo-50 text-indigo-700 font-bold flex items-center justify-center text-xs shrink-0">
                                            {{ substr($plc->student->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <span class="font-bold text-slate-900 block">{{ $plc->student->name }}</span>
                                            <span class="text-[11px] text-slate-400 font-mono">NIS: {{ $plc->student->nis }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="font-semibold text-slate-800 block">{{ $plc->student->classroom?->name ?? '-' }}</span>
                                    <span class="text-[11px] text-slate-400">{{ $plc->student->classroom?->major ?? '-' }}</span>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="font-bold text-slate-900 block">{{ $plc->company->name }}</span>
                                    <span class="text-[11px] text-slate-400">Divisi: {{ $plc->department ?: 'Umum' }}</span>
                                </td>
                                <td class="py-4 px-4 text-slate-700">
                                    <span class="font-semibold text-slate-800">{{ $plc->teacher->user->name ?? '-' }}</span>
                                    <span class="block text-[11px] text-slate-400 font-mono">NIP: {{ $plc->teacher->nip ?? '-' }}</span>
                                </td>
                                <td class="py-4 px-4 text-center font-mono">
                                    <span class="text-emerald-700 font-bold">{{ $hadir }}</span> /
                                    <span class="text-amber-700">{{ $terlambat }}</span>
                                </td>
                                <td class="py-4 px-4 text-center font-mono">
                                    <span class="text-slate-600">{{ $izin }}</span> /
                                    <span class="text-slate-600">{{ $sakit }}</span> /
                                    <span class="{{ $alpa > 0 ? 'text-rose-600 font-extrabold' : 'text-slate-400' }}">{{ $alpa }}</span>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                        <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        {{ $approvedJournals }} / {{ $totalJournals }}
                                    </span>
                                </td>
                                <td class="py-4 px-5">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $plc->status->badgeClass() }}">
                                        {{ $plc->status->label() }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-12 text-center text-slate-500">
                                    Tidak ada data penempatan PKL yang sesuai dengan kriteria filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($placements->hasPages())
                <div class="px-5 py-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $placements->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
