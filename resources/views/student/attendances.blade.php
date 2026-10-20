<x-app-layout title="Riwayat Presensi Siswa">
    <x-slot name="header">
        Portal Siswa &mdash; Riwayat Presensi
    </x-slot>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-navy tracking-tight">Riwayat Presensi Siswa</h1>
                <p class="text-xs text-slate-500 mt-0.5">
                    Catatan akumulasi kehadiran Anda pada kegiatan belajar mengajar (KBM).
                </p>
            </div>
            <a href="{{ route('student.dashboard') }}" class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50 transition shadow-xs flex items-center gap-1.5 self-start sm:self-auto cursor-pointer">
                &larr; Kembali ke Beranda
            </a>
        </div>

        <!-- Attendance Recap KPI Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3.5">
            <!-- Rate -->
            <div class="bg-white rounded-2xl border border-slate-200/90 p-4 shadow-xs text-center col-span-2 sm:col-span-1">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Tingkat Kehadiran</span>
                <span class="text-2xl font-black text-[#233DFF] block mt-1">{{ $summary['rate'] }}%</span>
                <span class="text-[10px] text-slate-400 block mt-0.5">{{ $summary['total'] }} Total Sesi</span>
            </div>

            <!-- Hadir -->
            <div class="bg-emerald-50/70 border border-emerald-100 rounded-2xl p-4 shadow-xs text-center">
                <span class="text-[10px] font-bold text-emerald-700 uppercase tracking-wider block">Hadir</span>
                <span class="text-2xl font-black text-emerald-800 block mt-1">{{ $summary['hadir'] }}</span>
                <span class="text-[10px] text-emerald-600 font-semibold block mt-0.5">Tepat Waktu</span>
            </div>

            <!-- Terlambat -->
            <div class="bg-amber-50/70 border border-amber-100 rounded-2xl p-4 shadow-xs text-center">
                <span class="text-[10px] font-bold text-amber-700 uppercase tracking-wider block">Terlambat</span>
                <span class="text-2xl font-black text-amber-800 block mt-1">{{ $summary['terlambat'] }}</span>
                <span class="text-[10px] text-amber-600 font-semibold block mt-0.5">Dispensasi</span>
            </div>

            <!-- Izin -->
            <div class="bg-blue-50/70 border border-blue-100 rounded-2xl p-4 shadow-xs text-center">
                <span class="text-[10px] font-bold text-blue-700 uppercase tracking-wider block">Izin</span>
                <span class="text-2xl font-black text-blue-800 block mt-1">{{ $summary['izin'] }}</span>
                <span class="text-[10px] text-blue-600 font-semibold block mt-0.5">Surat Izin</span>
            </div>

            <!-- Sakit -->
            <div class="bg-purple-50/70 border border-purple-100 rounded-2xl p-4 shadow-xs text-center">
                <span class="text-[10px] font-bold text-purple-700 uppercase tracking-wider block">Sakit</span>
                <span class="text-2xl font-black text-purple-800 block mt-1">{{ $summary['sakit'] }}</span>
                <span class="text-[10px] text-purple-600 font-semibold block mt-0.5">Surat Dokter</span>
            </div>

            <!-- Alpa -->
            <div class="bg-rose-50/70 border border-rose-100 rounded-2xl p-4 shadow-xs text-center">
                <span class="text-[10px] font-bold text-rose-700 uppercase tracking-wider block">Alpa</span>
                <span class="text-2xl font-black text-rose-800 block mt-1">{{ $summary['alpa'] }}</span>
                <span class="text-[10px] text-rose-600 font-semibold block mt-0.5">Tanpa Keterangan</span>
            </div>
        </div>

        <!-- Filter & Attendance Table -->
        <div class="bg-white rounded-3xl border border-slate-200/90 overflow-hidden shadow-xs">
            <div class="px-6 py-4 bg-slate-50/80 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="font-extrabold text-sm text-navy">Log Presensi Siswa</h2>
                    <p class="text-[11px] text-slate-500">Daftar presensi per mata pelajaran yang telah diinput oleh guru.</p>
                </div>

                <form method="GET" action="{{ route('student.attendances.index') }}" class="flex items-center gap-2">
                    <input type="month" name="month" value="{{ request('month') }}" class="text-xs rounded-xl border-slate-200 focus:border-brand focus:ring-1 focus:ring-brand py-2 px-3 bg-white text-slate-700">
                    <button type="submit" class="px-3.5 py-2 bg-navy hover:bg-slate-800 text-white text-xs font-bold rounded-xl transition cursor-pointer">
                        Filter
                    </button>
                    @if (request('month'))
                        <a href="{{ route('student.attendances.index') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold rounded-xl transition">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            @if ($attendances->isEmpty())
                <div class="text-center py-12">
                    <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="text-xs font-bold text-navy">Tidak Ada Data Presensi</p>
                    <p class="text-[11px] text-slate-400 mt-0.5">Belum ada catatan presensi untuk kriteria yang dipilih.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50/40 text-slate-500 uppercase font-bold text-[10px] border-b border-slate-100">
                            <tr>
                                <th class="py-3 px-6">Tanggal</th>
                                <th class="py-3 px-6">Mata Pelajaran</th>
                                <th class="py-3 px-6">Guru Pengajar</th>
                                <th class="py-3 px-6">Waktu Masuk</th>
                                <th class="py-3 px-6">Waktu Pulang</th>
                                <th class="py-3 px-6">Status Kehadiran</th>
                                <th class="py-3 px-6">Catatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($attendances as $att)
                                <tr class="hover:bg-slate-50/75 transition">
                                    <td class="py-4 px-6 font-mono font-bold text-navy">
                                        {{ \Carbon\Carbon::parse($att->date)->translatedFormat('l, d M Y') }}
                                    </td>
                                    <td class="py-4 px-6 font-bold text-navy">
                                        {{ $att->schedule?->subject?->name ?? 'Sesi Mapel' }}
                                    </td>
                                    <td class="py-4 px-6 text-slate-600">
                                        {{ $att->schedule?->teacher?->user?->name ?? 'Guru Mapel' }}
                                    </td>
                                    <td class="py-4 px-6 font-mono font-semibold text-slate-600">
                                        {{ $att->check_in_time ? substr((string) $att->check_in_time, 0, 5) : '-' }}
                                    </td>
                                    <td class="py-4 px-6 font-mono font-semibold text-slate-600">
                                        {{ $att->check_out_time ? substr((string) $att->check_out_time, 0, 5) : '-' }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $att->status->badgeClass() }}">
                                            {{ $att->status->label() }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-slate-500">
                                        {{ $att->notes ?? '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($attendances->hasPages())
                    <div class="px-6 py-4 bg-slate-50/60 border-t border-slate-100">
                        {{ $attendances->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-app-layout>
