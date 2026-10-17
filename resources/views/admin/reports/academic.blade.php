<x-app-layout title="Laporan Akademik & Presensi">
    <x-slot name="header">
        Laporan Presensi Akademik Siswa
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
                        <span>Laporan Eksekutif Institusi</span>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-white">Rekapitulasi Kehadiran Akademik</h1>
                    <p class="text-sm text-slate-300 mt-1 max-w-xl">
                        Analisis data tingkat partisipasi siswa per rombongan belajar, evaluasi ketidakhadiran, dan ekspor dokumen laporan berkala.
                    </p>
                </div>
                @if($selectedClassroom)
                    <div class="flex items-center gap-3">
                        <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 px-5 py-3 text-xs font-semibold text-slate-900 bg-white hover:bg-slate-50 rounded-xl shadow-lg transition transform hover:-translate-y-0.5">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                            <span>Cetak Laporan</span>
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <!-- Filter Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5">
            <form method="GET" action="{{ route('admin.reports.academic') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label for="classroom_id" class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">
                        Rombel Kelas <span class="text-rose-500">*</span>
                    </label>
                    <select name="classroom_id" id="classroom_id" required class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800 font-semibold">
                        <option value="">-- Pilih Rombel Kelas --</option>
                        @foreach($classrooms as $cls)
                            <option value="{{ $cls->id }}" {{ $classroomId == $cls->id ? 'selected' : '' }}>
                                {{ $cls->name }} ({{ $cls->major }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="start_date" class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Tanggal Mulai</label>
                    <input type="date" name="start_date" id="start_date" value="{{ $startDate }}"
                           class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800 font-mono">
                </div>

                <div>
                    <label for="end_date" class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Tanggal Selesai</label>
                    <input type="date" name="end_date" id="end_date" value="{{ $endDate }}"
                           class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800 font-mono">
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold rounded-xl shadow-sm transition min-h-[42px] flex items-center justify-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <span>Tampilkan Laporan</span>
                    </button>
                    @if($classroomId)
                        <a href="{{ route('admin.reports.academic') }}" class="px-3.5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl transition min-h-[42px] flex items-center justify-center">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        @if($selectedClassroom)
            <!-- Classroom Overview & Summary Metrics -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Total Siswa Kelas</span>
                    <div class="mt-2 flex items-baseline gap-2">
                        <span class="text-3xl font-extrabold text-slate-900">{{ $classSummary['total_students'] }}</span>
                        <span class="text-xs text-slate-400">siswa</span>
                    </div>
                    <p class="mt-2 text-[11px] text-slate-500">Wali Kelas: <strong class="text-slate-700">{{ $selectedClassroom->homeroomTeacher?->user->name ?? 'Belum ada' }}</strong></p>
                </div>

                <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Rata-Rata Kehadiran</span>
                    <div class="mt-2 flex items-baseline gap-2">
                        <span class="text-3xl font-extrabold text-emerald-600">{{ $classSummary['average_rate'] }}%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-1.5 mt-2">
                        <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ $classSummary['average_rate'] }}%"></div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Presensi Masuk & Lambat</span>
                    <div class="mt-2 flex items-baseline gap-2">
                        <span class="text-3xl font-extrabold text-slate-900">{{ $classSummary['total_present'] }}</span>
                        <span class="text-xs text-amber-600 font-bold">/ {{ $classSummary['total_late'] }} telat</span>
                    </div>
                    <p class="mt-2 text-[11px] text-slate-500">Akumulasi presensi hadir</p>
                </div>

                <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Izin, Sakit & Alpa</span>
                    <div class="mt-2 flex items-baseline gap-2">
                        <span class="text-2xl font-extrabold text-slate-700">{{ $classSummary['total_permit'] + $classSummary['total_sick'] }}</span>
                        <span class="text-xs {{ $classSummary['total_alpha'] > 0 ? 'text-rose-600 font-extrabold' : 'text-slate-400' }}">({{ $classSummary['total_alpha'] }} Alpa)</span>
                    </div>
                    <p class="mt-2 text-[11px] text-slate-500">{{ $classSummary['total_permit'] }} Izin &bull; {{ $classSummary['total_sick'] }} Sakit</p>
                </div>
            </div>

            <!-- Student Breakdown Table -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-bold text-slate-900">Rincian Presensi Siswa Kelas {{ $selectedClassroom->name }}</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Akumulasi per siswa periode {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} sampai {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50/75 border-b border-slate-200 text-[11px] font-bold uppercase tracking-wider text-slate-600">
                                <th class="py-3.5 px-4 w-12 text-center">No</th>
                                <th class="py-3.5 px-4">NIS</th>
                                <th class="py-3.5 px-4">Nama Lengkap Siswa</th>
                                <th class="py-3.5 px-4 text-center">Hadir</th>
                                <th class="py-3.5 px-4 text-center">Terlambat</th>
                                <th class="py-3.5 px-4 text-center">Izin</th>
                                <th class="py-3.5 px-4 text-center">Sakit</th>
                                <th class="py-3.5 px-4 text-center">Alpa</th>
                                <th class="py-3.5 px-4 text-center">Total Sesi</th>
                                <th class="py-3.5 px-5 text-right">% Kehadiran</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($studentRecaps as $index => $recap)
                                <tr class="hover:bg-indigo-50/30 transition-colors duration-150">
                                    <td class="py-4 px-4 text-center text-slate-400 font-mono">{{ $index + 1 }}</td>
                                    <td class="py-4 px-4 font-mono font-medium text-slate-700">{{ $recap->student->nis }}</td>
                                    <td class="py-4 px-4 font-bold text-slate-900 text-sm">{{ $recap->student->name }}</td>
                                    <td class="py-4 px-4 text-center text-emerald-700 font-bold font-mono">{{ $recap->hadir }}</td>
                                    <td class="py-4 px-4 text-center text-amber-700 font-mono">{{ $recap->terlambat }}</td>
                                    <td class="py-4 px-4 text-center text-slate-600 font-mono">{{ $recap->izin }}</td>
                                    <td class="py-4 px-4 text-center text-slate-600 font-mono">{{ $recap->sakit }}</td>
                                    <td class="py-4 px-4 text-center font-mono {{ $recap->alpa > 0 ? 'text-rose-600 font-extrabold' : 'text-slate-400' }}">{{ $recap->alpa }}</td>
                                    <td class="py-4 px-4 text-center font-mono text-slate-800 font-semibold">{{ $recap->total }}</td>
                                    <td class="py-4 px-5 text-right">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $recap->rate >= 80 ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : ($recap->rate >= 60 ? 'bg-amber-50 text-amber-800 border border-amber-200' : 'bg-rose-50 text-rose-800 border border-rose-200') }}">
                                            {{ $recap->rate }}%
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="py-12 text-center text-slate-500">
                                        Belum ada data siswa terdaftar pada kelas ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <!-- Empty State Guiding Selection -->
            <div class="bg-white rounded-2xl p-12 border border-slate-200/80 text-center shadow-sm">
                <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h3 class="text-base font-bold text-slate-800">Tentukan Rombongan Belajar</h3>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                    Silakan tentukan kelas dan rentang tanggal pada formulir filter di atas untuk menghasilkan laporan rekapitulasi kehadiran akademik resmi.
                </p>
            </div>
        @endif
    </div>
</x-app-layout>
