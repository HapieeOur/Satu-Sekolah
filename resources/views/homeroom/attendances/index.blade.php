<x-app-layout title="Presensi Kelas Binaan">
    <x-slot name="header">
        Wali Kelas: Presensi Siswa Binaan
    </x-slot>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-navy tracking-tight">Presensi Siswa Kelas Binaan</h1>
                <p class="text-xs text-slate-500 mt-0.5">Pemantauan kehadiran harian dan akumulasi rekapitulasi presensi siswa kelas Anda.</p>
            </div>
        </div>

        @if (! $classroom)
            <div class="bg-white rounded-3xl border border-slate-200/90 p-12 text-center shadow-xs">
                <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h3 class="text-base font-extrabold text-navy mb-1">Penugasan Wali Kelas Belum Ditemukan</h3>
                <p class="text-xs text-slate-500 max-w-md mx-auto">
                    Akun Anda belum ditetapkan sebagai wali kelas pada kelas manapun untuk tahun ajaran aktif. Silakan hubungi Administrator Kurikulum untuk penetapan kelas binaan.
                </p>
            </div>
        @else
            <!-- Classroom Header Card -->
            <div class="bg-white rounded-3xl border border-slate-200/90 p-6 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-5">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-600 text-white flex items-center justify-center font-extrabold text-lg shadow-sm shrink-0">
                        {{ substr($classroom->name, 0, 3) }}
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-base sm:text-lg font-black text-navy">{{ $classroom->name }}</h2>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                Tingkat {{ $classroom->grade_level }} • {{ $classroom->major }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 mt-1">
                            Tahun Ajaran: <strong class="text-navy">{{ $classroom->academicYear?->name ?? '-' }}</strong>
                            &bull; Siswa Terdaftar: <strong class="text-navy">{{ $classroom->students->count() }} Orang</strong>
                        </p>
                    </div>
                </div>

                <!-- Tab Navigation Buttons -->
                <div class="flex items-center gap-1.5 bg-slate-100/80 p-1.5 rounded-2xl border border-slate-200/70">
                    <a href="{{ route('homeroom.attendances.index', ['tab' => 'harian', 'date' => $date]) }}"
                       class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-150 {{ $tab === 'harian' ? 'bg-white text-navy shadow-xs' : 'text-slate-500 hover:text-navy' }}">
                        Presensi Harian
                    </a>
                    <a href="{{ route('homeroom.attendances.index', ['tab' => 'rekap', 'start_date' => $startDate, 'end_date' => $endDate]) }}"
                       class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-150 {{ $tab === 'rekap' ? 'bg-white text-navy shadow-xs' : 'text-slate-500 hover:text-navy' }}">
                        Rekapitulasi Kehadiran
                    </a>
                </div>
            </div>

            @if ($tab === 'harian')
                <!-- Date Filter & Quick Metrics -->
                <div class="bg-white rounded-3xl border border-slate-200/90 p-6 shadow-xs space-y-5">
                    <form method="GET" action="{{ route('homeroom.attendances.index') }}" class="flex flex-col sm:flex-row items-end gap-3">
                        <input type="hidden" name="tab" value="harian">
                        <div class="w-full sm:w-64">
                            <label for="date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Pilih Tanggal Presensi</label>
                            <input type="date" name="date" id="date" value="{{ $date }}"
                                   class="w-full text-xs rounded-xl border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 bg-white text-slate-800 py-2.5 px-3">
                        </div>
                        <button type="submit" class="px-5 py-2.5 bg-navy hover:bg-slate-800 text-white text-xs font-bold rounded-xl transition flex items-center gap-2 shadow-xs cursor-pointer">
                            <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>Tampilkan</span>
                        </button>
                    </form>

                    <!-- Real Data Metrics Row -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 pt-5 border-t border-slate-100">
                        <div class="p-3.5 bg-slate-50 border border-slate-100 rounded-2xl">
                            <span class="text-[10px] uppercase font-bold text-slate-400 block">Tingkat Kehadiran</span>
                            <span class="text-xl font-black text-navy mt-1 block">{{ $summary['attendance_rate'] }}%</span>
                        </div>
                        <div class="p-3.5 bg-emerald-50/70 border border-emerald-100 rounded-2xl">
                            <span class="text-[10px] uppercase font-bold text-emerald-700 block">Hadir Tepat Waktu</span>
                            <span class="text-xl font-black text-emerald-800 mt-1 block">{{ $summary['hadir'] }}</span>
                        </div>
                        <div class="p-3.5 bg-amber-50/70 border border-amber-100 rounded-2xl">
                            <span class="text-[10px] uppercase font-bold text-amber-700 block">Terlambat</span>
                            <span class="text-xl font-black text-amber-800 mt-1 block">{{ $summary['terlambat'] }}</span>
                        </div>
                        <div class="p-3.5 bg-sky-50/70 border border-sky-100 rounded-2xl">
                            <span class="text-[10px] uppercase font-bold text-sky-700 block">Izin</span>
                            <span class="text-xl font-black text-sky-800 mt-1 block">{{ $summary['izin'] }}</span>
                        </div>
                        <div class="p-3.5 bg-violet-50/70 border border-violet-100 rounded-2xl">
                            <span class="text-[10px] uppercase font-bold text-violet-700 block">Sakit</span>
                            <span class="text-xl font-black text-violet-800 mt-1 block">{{ $summary['sakit'] }}</span>
                        </div>
                        <div class="p-3.5 bg-rose-50/70 border border-rose-100 rounded-2xl">
                            <span class="text-[10px] uppercase font-bold text-rose-700 block">Alpa (Tanpa Ket.)</span>
                            <span class="text-xl font-black text-rose-800 mt-1 block">{{ $summary['alpa'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- Attendance Log Table -->
                <div class="bg-white rounded-3xl border border-slate-200/90 overflow-hidden shadow-xs">
                    <div class="px-6 py-4 bg-slate-50/80 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="font-extrabold text-sm text-navy">Log Presensi: {{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}</h3>
                        <span class="text-xs text-slate-400 font-medium">Total tercatat: {{ $attendances->count() }} data</span>
                    </div>

                    @if ($attendances->isEmpty())
                        <div class="p-12 text-center text-xs text-slate-400 italic">
                            Belum ada catatan presensi masuk yang terekam pada tanggal {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }} untuk kelas ini.
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs">
                                <thead class="bg-slate-50/40 text-slate-500 uppercase font-bold text-[10px] border-b border-slate-100">
                                    <tr>
                                        <th scope="col" class="py-3 px-6 w-12">No</th>
                                        <th scope="col" class="py-3 px-6">Nama Siswa</th>
                                        <th scope="col" class="py-3 px-6">NIS / NISN</th>
                                        <th scope="col" class="py-3 px-6">Jam Masuk</th>
                                        <th scope="col" class="py-3 px-6">Sesi Pelajaran</th>
                                        <th scope="col" class="py-3 px-6">Status Kehadiran</th>
                                        <th scope="col" class="py-3 px-6">Catatan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach ($attendances as $index => $att)
                                        <tr class="hover:bg-slate-50/75 transition">
                                            <td class="py-4 px-6 text-slate-400 font-mono">{{ $index + 1 }}</td>
                                            <td class="py-4 px-6 font-bold text-navy text-xs sm:text-sm">{{ $att->student->name }}</td>
                                            <td class="py-4 px-6 font-mono text-slate-500">{{ $att->student->nis }} / {{ $att->student->nisn }}</td>
                                            <td class="py-4 px-6 font-mono font-bold text-slate-700">
                                                {{ $att->check_in_time ? substr((string) $att->check_in_time, 0, 5) : '-' }}
                                            </td>
                                            <td class="py-4 px-6 text-slate-600 font-medium">
                                                {{ $att->schedule?->subject?->name ?? 'Presensi Harian Kelas' }}
                                            </td>
                                            <td class="py-4 px-6">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $att->status->badgeClass() }}">
                                                    {{ $att->status->label() }}
                                                </span>
                                            </td>
                                            <td class="py-4 px-6 text-slate-500 italic">
                                                {{ $att->notes ?? '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

            @else
                <!-- Rekapitulasi Presensi per Siswa (Semester / Date Range) -->
                <div class="bg-white rounded-3xl border border-slate-200/90 p-6 shadow-xs space-y-5">
                    <form method="GET" action="{{ route('homeroom.attendances.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
                        <input type="hidden" name="tab" value="rekap">
                        <div>
                            <label for="start_date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tanggal Awal</label>
                            <input type="date" name="start_date" id="start_date" value="{{ $startDate }}"
                                   class="w-full text-xs rounded-xl border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 bg-white text-slate-800 py-2.5 px-3">
                        </div>
                        <div>
                            <label for="end_date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tanggal Akhir</label>
                            <input type="date" name="end_date" id="end_date" value="{{ $endDate }}"
                                   class="w-full text-xs rounded-xl border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 bg-white text-slate-800 py-2.5 px-3">
                        </div>
                        <div>
                            <button type="submit" class="w-full py-2.5 px-4 bg-navy hover:bg-slate-800 text-white text-xs font-bold rounded-xl transition flex items-center justify-center gap-2 shadow-xs cursor-pointer">
                                <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                                <span>Filter Rekapitulasi</span>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-white rounded-3xl border border-slate-200/90 overflow-hidden shadow-xs">
                    <div class="px-6 py-4 bg-slate-50/80 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="font-extrabold text-sm text-navy">Rekapitulasi Kehadiran Siswa Binaan</h3>
                        <span class="text-xs text-slate-400 font-medium">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} — {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-50/40 text-slate-500 uppercase font-bold text-[10px] border-b border-slate-100">
                                <tr>
                                    <th scope="col" class="py-3 px-6 w-12">No</th>
                                    <th scope="col" class="py-3 px-6">NIS</th>
                                    <th scope="col" class="py-3 px-6">Nama Siswa</th>
                                    <th scope="col" class="py-3 px-6 text-center">Hadir</th>
                                    <th scope="col" class="py-3 px-6 text-center">Terlambat</th>
                                    <th scope="col" class="py-3 px-6 text-center">Izin</th>
                                    <th scope="col" class="py-3 px-6 text-center">Sakit</th>
                                    <th scope="col" class="py-3 px-6 text-center">Alpa</th>
                                    <th scope="col" class="py-3 px-6 text-right">% Kehadiran</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($studentRecap as $idx => $st)
                                    <tr class="hover:bg-slate-50/75 transition">
                                        <td class="py-4 px-6 text-slate-400 font-mono">{{ $idx + 1 }}</td>
                                        <td class="py-4 px-6 font-mono text-slate-500">{{ $st->nis }}</td>
                                        <td class="py-4 px-6 font-bold text-navy">{{ $st->name }}</td>
                                        <td class="py-4 px-6 text-center font-bold text-emerald-700">{{ $st->hadir_count }}</td>
                                        <td class="py-4 px-6 text-center font-bold text-amber-700">{{ $st->terlambat_count }}</td>
                                        <td class="py-4 px-6 text-center font-bold text-sky-700">{{ $st->izin_count }}</td>
                                        <td class="py-4 px-6 text-center font-bold text-violet-700">{{ $st->sakit_count }}</td>
                                        <td class="py-4 px-6 text-center font-bold text-rose-700">{{ $st->alpa_count }}</td>
                                        <td class="py-4 px-6 text-right">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $st->rate >= 85 ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-rose-50 text-rose-800 border border-rose-200' }}">
                                                {{ $st->rate }}%
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="p-8 text-center text-xs text-slate-400 italic">
                                            Tidak ada data siswa ditemukan pada kelas ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        @endif
    </div>
</x-app-layout>
