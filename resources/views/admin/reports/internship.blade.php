<x-app-layout title="Laporan Monitoring PKL">
    <x-slot name="header">
        Laporan Monitoring & Rekapitulasi PKL
    </x-slot>

    <div class="space-y-6">
        <!-- Header & Description -->
        <div class="bg-surface rounded-xl p-6 border border-border shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-blue-50 text-brand border border-blue-200 mb-2">
                    Laporan Institusi
                </span>
                <h1 class="text-xl font-bold text-navy">Rekapitulasi Monitoring Praktik Kerja Lapangan</h1>
                <p class="text-xs text-slate-500 mt-0.5">Laporan komprehensif penempatan, partisipasi presensi GPS, dan aktivitas jurnal industri.</p>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-slate-700 bg-white border border-border rounded-lg hover:bg-slate-50 shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    <span>Cetak Laporan</span>
                </button>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="bg-surface rounded-xl border border-border shadow-sm p-5">
            <form method="GET" action="{{ route('admin.reports.internship') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <div>
                    <label for="company_id" class="block text-xs font-semibold text-slate-700 mb-1">Mitra Industri</label>
                    <select name="company_id" id="company_id" class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-brand">
                        <option value="">Semua Perusahaan</option>
                        @foreach($companies as $cmp)
                            <option value="{{ $cmp->id }}" {{ $companyId == $cmp->id ? 'selected' : '' }}>
                                {{ $cmp->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="teacher_id" class="block text-xs font-semibold text-slate-700 mb-1">Guru Pembimbing</label>
                    <select name="teacher_id" id="teacher_id" class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-brand">
                        <option value="">Semua Pembimbing</option>
                        @foreach($teachers as $tc)
                            <option value="{{ $tc->id }}" {{ $teacherId == $tc->id ? 'selected' : '' }}>
                                {{ $tc->user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-xs font-semibold text-slate-700 mb-1">Status Penempatan</label>
                    <select name="status" id="status" class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-brand">
                        <option value="">Semua Status</option>
                        @foreach($statuses as $st)
                            <option value="{{ $st->value }}" {{ $status == $st->value ? 'selected' : '' }}>
                                {{ $st->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="start_date" class="block text-xs font-semibold text-slate-700 mb-1">Tanggal Mulai</label>
                    <input type="date" name="start_date" id="start_date" value="{{ $startDate }}" class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-brand">
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-brand hover:bg-brand-hover text-white text-xs font-semibold rounded-lg shadow-sm transition min-h-[38px] flex items-center justify-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <span>Filter</span>
                    </button>
                    @if($companyId || $teacherId || $status || $startDate)
                        <a href="{{ route('admin.reports.internship') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-medium rounded-lg transition min-h-[38px] flex items-center justify-center">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Metrics Overview -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-surface rounded-xl p-5 border border-border shadow-sm">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 block">Total Penempatan PKL</span>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl font-extrabold text-navy">{{ $reportMetrics['total_placements'] }}</span>
                    <span class="text-xs text-slate-400">siswa</span>
                </div>
                <p class="mt-1 text-[11px] text-slate-500">Sesuai kriteria filter terpilih</p>
            </div>

            <div class="bg-surface rounded-xl p-5 border border-border shadow-sm">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 block">Penempatan Aktif</span>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl font-extrabold text-emerald-700">{{ $reportMetrics['active_count'] }}</span>
                    <span class="text-xs text-slate-400">sedang berjalan</span>
                </div>
                <p class="mt-1 text-[11px] text-slate-500">Monitoring operasional harian</p>
            </div>

            <div class="bg-surface rounded-xl p-5 border border-border shadow-sm">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 block">Penempatan Selesai</span>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl font-extrabold text-blue-700">{{ $reportMetrics['completed_count'] }}</span>
                    <span class="text-xs text-slate-400">tuntas</span>
                </div>
                <p class="mt-1 text-[11px] text-slate-500">Periode magang telah berakhir</p>
            </div>
        </div>

        <!-- Placements Report Table -->
        <div class="bg-surface rounded-xl border border-border shadow-sm overflow-hidden">
            <div class="p-5 border-b border-border flex items-center justify-between">
                <div>
                    <h2 class="text-xs font-bold text-navy uppercase tracking-wider">Daftar Rekapitulasi Siswa PKL</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Menampilkan log presensi, persetujuan jurnal, dan penugasan</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 border-b border-border text-slate-700 font-semibold uppercase tracking-wider text-[11px]">
                        <tr>
                            <th class="py-3 px-4">Siswa</th>
                            <th class="py-3 px-4">Kelas & Jurusan</th>
                            <th class="py-3 px-4">Mitra Perusahaan</th>
                            <th class="py-3 px-4">Guru Pembimbing</th>
                            <th class="py-3 px-4 text-center">Presensi (H / T)</th>
                            <th class="py-3 px-4 text-center">Izin / Sakit / Alpa</th>
                            <th class="py-3 px-4 text-center">Jurnal Disetujui</th>
                            <th class="py-3 px-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
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
                            <tr class="hover:bg-slate-50/75 transition">
                                <td class="py-3 px-4">
                                    <span class="font-bold text-navy block">{{ $plc->student->name }}</span>
                                    <span class="text-[11px] text-slate-500 font-mono">{{ $plc->student->nis }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="font-semibold text-slate-800 block">{{ $plc->student->classroom?->name ?? '-' }}</span>
                                    <span class="text-[11px] text-slate-500">{{ $plc->student->classroom?->major ?? '-' }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="font-semibold text-navy block">{{ $plc->company->name }}</span>
                                    <span class="text-[11px] text-slate-500">Divisi: {{ $plc->department ?: 'Umum' }}</span>
                                </td>
                                <td class="py-3 px-4 text-slate-700">
                                    {{ $plc->teacher->user->name ?? '-' }}
                                </td>
                                <td class="py-3 px-4 text-center font-mono">
                                    <span class="text-emerald-700 font-bold">{{ $hadir }}</span> /
                                    <span class="text-amber-700">{{ $terlambat }}</span>
                                </td>
                                <td class="py-3 px-4 text-center font-mono">
                                    <span class="text-slate-600">{{ $izin }}</span> /
                                    <span class="text-slate-600">{{ $sakit }}</span> /
                                    <span class="{{ $alpa > 0 ? 'text-rose-700 font-bold' : 'text-slate-400' }}">{{ $alpa }}</span>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        {{ $approvedJournals }} / {{ $totalJournals }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold border {{ $plc->status->badgeClass() }}">
                                        {{ $plc->status->label() }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-8 text-center text-slate-500">
                                    Tidak ada data penempatan PKL yang sesuai dengan kriteria filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($placements->hasPages())
                <div class="p-4 border-t border-border">
                    {{ $placements->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
