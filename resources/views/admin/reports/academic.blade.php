<x-app-layout title="Laporan Akademik">
    <x-slot name="header">
        Laporan Presensi Akademik Siswa
    </x-slot>

    <div class="space-y-6">
        <!-- Header & Description -->
        <div class="bg-surface rounded-xl p-6 border border-border shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-blue-50 text-brand border border-blue-200 mb-2">
                    Laporan Institusi
                </span>
                <h1 class="text-xl font-bold text-navy">Rekapitulasi Kehadiran Akademik</h1>
                <p class="text-xs text-slate-500 mt-0.5">Analisis tingkat partisipasi kehadiran siswa per rombongan belajar dan rentang tanggal.</p>
            </div>
            @if($selectedClassroom)
                <div class="flex items-center gap-2">
                    <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-slate-700 bg-white border border-border rounded-lg hover:bg-slate-50 shadow-sm transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        <span>Cetak Laporan</span>
                    </button>
                </div>
            @endif
        </div>

        <!-- Filter Card -->
        <div class="bg-surface rounded-xl border border-border shadow-sm p-5">
            <form method="GET" action="{{ route('admin.reports.academic') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label for="classroom_id" class="block text-xs font-semibold text-slate-700 mb-1">Rombel Kelas <span class="text-rose-500">*</span></label>
                    <select name="classroom_id" id="classroom_id" required class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-brand">
                        <option value="">-- Pilih Rombel Kelas --</option>
                        @foreach($classrooms as $cls)
                            <option value="{{ $cls->id }}" {{ $classroomId == $cls->id ? 'selected' : '' }}>
                                {{ $cls->name }} ({{ $cls->major }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="start_date" class="block text-xs font-semibold text-slate-700 mb-1">Tanggal Mulai</label>
                    <input type="date" name="start_date" id="start_date" value="{{ $startDate }}" class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-brand">
                </div>

                <div>
                    <label for="end_date" class="block text-xs font-semibold text-slate-700 mb-1">Tanggal Selesai</label>
                    <input type="date" name="end_date" id="end_date" value="{{ $endDate }}" class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-brand">
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-brand hover:bg-brand-hover text-white text-xs font-semibold rounded-lg shadow-sm transition min-h-[38px] flex items-center justify-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <span>Tampilkan Laporan</span>
                    </button>
                    @if($classroomId)
                        <a href="{{ route('admin.reports.academic') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-medium rounded-lg transition min-h-[38px] flex items-center justify-center">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        @if($selectedClassroom)
            <!-- Classroom Overview & Summary Metrics -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-surface rounded-xl p-5 border border-border shadow-sm">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 block">Total Siswa Kelas</span>
                    <div class="mt-2 flex items-baseline gap-2">
                        <span class="text-3xl font-extrabold text-navy">{{ $classSummary['total_students'] }}</span>
                        <span class="text-xs text-slate-400">siswa</span>
                    </div>
                    <p class="mt-1 text-[11px] text-slate-500">Wali Kelas: {{ $selectedClassroom->homeroomTeacher?->user->name ?? 'Belum ditetapkan' }}</p>
                </div>

                <div class="bg-surface rounded-xl p-5 border border-border shadow-sm">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 block">Rata-Rata Kehadiran</span>
                    <div class="mt-2 flex items-baseline gap-2">
                        <span class="text-3xl font-extrabold text-emerald-700">{{ $classSummary['average_rate'] }}%</span>
                    </div>
                    <p class="mt-1 text-[11px] text-slate-500">Periode {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} — {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
                </div>

                <div class="bg-surface rounded-xl p-5 border border-border shadow-sm">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 block">Total Hadir / Terlambat</span>
                    <div class="mt-2 flex items-baseline gap-2">
                        <span class="text-3xl font-extrabold text-navy">{{ $classSummary['total_present'] }}</span>
                        <span class="text-xs text-amber-700 font-semibold">/ {{ $classSummary['total_late'] }} lambat</span>
                    </div>
                    <p class="mt-1 text-[11px] text-slate-500">Akumulasi presensi masuk</p>
                </div>

                <div class="bg-surface rounded-xl p-5 border border-border shadow-sm">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 block">Izin, Sakit & Alpa</span>
                    <div class="mt-2 flex items-baseline gap-2">
                        <span class="text-2xl font-extrabold text-slate-700">{{ $classSummary['total_permit'] + $classSummary['total_sick'] }}</span>
                        <span class="text-xs {{ $classSummary['total_alpha'] > 0 ? 'text-rose-700 font-bold' : 'text-slate-400' }}">({{ $classSummary['total_alpha'] }} Alpa)</span>
                    </div>
                    <p class="mt-1 text-[11px] text-slate-500">{{ $classSummary['total_permit'] }} Izin &bull; {{ $classSummary['total_sick'] }} Sakit</p>
                </div>
            </div>

            <!-- Student Breakdown Table -->
            <div class="bg-surface rounded-xl border border-border shadow-sm overflow-hidden">
                <div class="p-5 border-b border-border flex items-center justify-between">
                    <div>
                        <h2 class="text-xs font-bold text-navy uppercase tracking-wider">Rincian Presensi Siswa Kelas {{ $selectedClassroom->name }}</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Akumulasi per siswa pada rentang {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} sampai {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 border-b border-border text-slate-700 font-semibold uppercase tracking-wider text-[11px]">
                            <tr>
                                <th class="py-3 px-4 w-12 text-center">No</th>
                                <th class="py-3 px-4">NIS</th>
                                <th class="py-3 px-4">Nama Lengkap Siswa</th>
                                <th class="py-3 px-4 text-center">Hadir</th>
                                <th class="py-3 px-4 text-center">Terlambat</th>
                                <th class="py-3 px-4 text-center">Izin</th>
                                <th class="py-3 px-4 text-center">Sakit</th>
                                <th class="py-3 px-4 text-center">Alpa</th>
                                <th class="py-3 px-4 text-center">Total Sesi</th>
                                <th class="py-3 px-4 text-right">% Kehadiran</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @forelse($studentRecaps as $index => $recap)
                                <tr class="hover:bg-slate-50/75 transition">
                                    <td class="py-3 px-4 text-center text-slate-400 font-mono">{{ $index + 1 }}</td>
                                    <td class="py-3 px-4 font-mono text-slate-700">{{ $recap->student->nis }}</td>
                                    <td class="py-3 px-4 font-semibold text-navy">{{ $recap->student->name }}</td>
                                    <td class="py-3 px-4 text-center text-emerald-700 font-semibold">{{ $recap->hadir }}</td>
                                    <td class="py-3 px-4 text-center text-amber-700">{{ $recap->terlambat }}</td>
                                    <td class="py-3 px-4 text-center text-slate-600">{{ $recap->izin }}</td>
                                    <td class="py-3 px-4 text-center text-slate-600">{{ $recap->sakit }}</td>
                                    <td class="py-3 px-4 text-center {{ $recap->alpa > 0 ? 'text-rose-700 font-bold' : 'text-slate-400' }}">{{ $recap->alpa }}</td>
                                    <td class="py-3 px-4 text-center font-mono text-slate-700">{{ $recap->total }}</td>
                                    <td class="py-3 px-4 text-right">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold {{ $recap->rate >= 80 ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : ($recap->rate >= 60 ? 'bg-amber-50 text-amber-800 border border-amber-200' : 'bg-rose-50 text-rose-800 border border-rose-200') }}">
                                            {{ $recap->rate }}%
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="py-8 text-center text-slate-500">
                                        Belum ada data siswa terdaftar pada kelas ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <!-- Empty State Guiding Class Selection -->
            <div class="bg-surface rounded-xl p-12 border border-border text-center shadow-sm">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-brand flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h3 class="text-sm font-bold text-navy">Pilih Rombongan Belajar</h3>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                    Silakan tentukan kelas dan rentang tanggal pada filter di atas untuk menghasilkan laporan rekapitulasi kehadiran akademik.
                </p>
            </div>
        @endif
    </div>
</x-app-layout>
