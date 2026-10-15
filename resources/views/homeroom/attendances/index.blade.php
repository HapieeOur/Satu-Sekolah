<x-app-layout title="Presensi Kelas Binaan">
    <x-slot name="header">
        Wali Kelas: Presensi Siswa Binaan
    </x-slot>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-navy">Presensi Siswa Kelas Binaan</h1>
                <p class="text-xs text-slate-600 mt-1">Pemantauan kehadiran harian dan akumulasi rekapitulasi presensi siswa kelas Anda.</p>
            </div>
        </div>

        @if (! $classroom)
            <div class="bg-surface rounded-xl border border-dashed border-border p-12 text-center shadow-sm">
                <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h3 class="text-sm font-bold text-navy mb-1">Penugasan Wali Kelas Belum Ditemukan</h3>
                <p class="text-xs text-slate-600 max-w-md mx-auto">
                    Akun Anda belum ditetapkan sebagai wali kelas pada kelas manapun untuk tahun ajaran aktif. Silakan hubungi Administrator Kurikulum untuk penetapan kelas binaan.
                </p>
            </div>
        @else
            <!-- Classroom Header Card -->
            <div class="bg-surface rounded-xl border border-border p-5 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-navy text-white flex items-center justify-center font-bold text-base shrink-0">
                        {{ substr($classroom->name, 0, 3) }}
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-base font-bold text-navy">{{ $classroom->name }}</h2>
                            <span class="px-2.5 py-0.5 rounded text-[11px] font-semibold bg-slate-100 text-slate-700 border border-slate-300">
                                Tingkat {{ $classroom->grade_level }} • {{ $classroom->major }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-600 mt-1">
                            Tahun Ajaran: <strong class="text-slate-800">{{ $classroom->academicYear?->name ?? '-' }}</strong>
                            &bull; Total Siswa Terdaftar: <strong class="text-slate-800">{{ $classroom->students->count() }} Siswa</strong>
                        </p>
                    </div>
                </div>

                <!-- Tab Navigation Buttons -->
                <div class="flex items-center gap-2 bg-slate-100 p-1 rounded-lg border border-slate-200">
                    <a href="{{ route('homeroom.attendances.index', ['tab' => 'harian', 'date' => $date]) }}"
                       class="px-3 py-1.5 rounded-md text-xs font-semibold transition {{ $tab === 'harian' ? 'bg-white text-navy shadow-sm' : 'text-slate-600 hover:text-navy' }}">
                        Presensi Harian
                    </a>
                    <a href="{{ route('homeroom.attendances.index', ['tab' => 'rekap', 'start_date' => $startDate, 'end_date' => $endDate]) }}"
                       class="px-3 py-1.5 rounded-md text-xs font-semibold transition {{ $tab === 'rekap' ? 'bg-white text-navy shadow-sm' : 'text-slate-600 hover:text-navy' }}">
                        Rekapitulasi Kehadiran
                    </a>
                </div>
            </div>

            @if ($tab === 'harian')
                <!-- Date Filter & Quick Metrics -->
                <div class="bg-surface rounded-xl border border-border p-5 shadow-sm space-y-5">
                    <form method="GET" action="{{ route('homeroom.attendances.index') }}" class="flex flex-col sm:flex-row items-end gap-3">
                        <input type="hidden" name="tab" value="harian">
                        <div class="w-full sm:w-64">
                            <label for="date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pilih Tanggal Presensi</label>
                            <input type="date" name="date" id="date" value="{{ $date }}"
                                   class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
                        </div>
                        <button type="submit" class="px-4 py-2 bg-navy hover:bg-navy-light text-white text-xs font-semibold rounded-lg transition flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Tampilkan
                        </button>
                    </form>

                    <!-- Real Data Metrics Row -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 pt-4 border-t border-border">
                        <div class="p-3 bg-slate-50 border border-slate-200 rounded-lg">
                            <span class="text-[11px] text-slate-500 block">Tingkat Kehadiran</span>
                            <span class="text-base font-bold text-navy mt-0.5 block">{{ $summary['attendance_rate'] }}%</span>
                        </div>
                        <div class="p-3 bg-emerald-50/60 border border-emerald-200 rounded-lg">
                            <span class="text-[11px] text-emerald-700 block">Hadir Tepat Waktu</span>
                            <span class="text-base font-bold text-emerald-800 mt-0.5 block">{{ $summary['hadir'] }}</span>
                        </div>
                        <div class="p-3 bg-amber-50/60 border border-amber-200 rounded-lg">
                            <span class="text-[11px] text-amber-700 block">Terlambat</span>
                            <span class="text-base font-bold text-amber-800 mt-0.5 block">{{ $summary['terlambat'] }}</span>
                        </div>
                        <div class="p-3 bg-blue-50/60 border border-blue-200 rounded-lg">
                            <span class="text-[11px] text-blue-700 block">Izin</span>
                            <span class="text-base font-bold text-blue-800 mt-0.5 block">{{ $summary['izin'] }}</span>
                        </div>
                        <div class="p-3 bg-purple-50/60 border border-purple-200 rounded-lg">
                            <span class="text-[11px] text-purple-700 block">Sakit</span>
                            <span class="text-base font-bold text-purple-800 mt-0.5 block">{{ $summary['sakit'] }}</span>
                        </div>
                        <div class="p-3 bg-rose-50/60 border border-rose-200 rounded-lg">
                            <span class="text-[11px] text-rose-700 block">Tanpa Keterangan (Alpa)</span>
                            <span class="text-base font-bold text-rose-800 mt-0.5 block">{{ $summary['alpa'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- Attendance Log Table -->
                <div class="bg-surface rounded-xl border border-border overflow-hidden shadow-sm">
                    <div class="px-5 py-3.5 bg-slate-50 border-b border-border flex items-center justify-between">
                        <h3 class="font-bold text-sm text-navy">Log Presensi: {{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}</h3>
                        <span class="text-xs text-slate-500 font-medium">Total tercatat: {{ $attendances->count() }} catatan</span>
                    </div>

                    @if ($attendances->isEmpty())
                        <div class="p-10 text-center text-xs text-slate-500">
                            Belum ada catatan presensi masuk yang terekam pada tanggal {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }} untuk kelas ini.
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs text-slate-800">
                                <thead class="bg-slate-100/70 text-slate-600 uppercase font-bold text-[11px] border-b border-border">
                                    <tr>
                                        <th scope="col" class="py-3 px-5 w-12">No</th>
                                        <th scope="col" class="py-3 px-5">Nama Siswa</th>
                                        <th scope="col" class="py-3 px-5">NIS / NISN</th>
                                        <th scope="col" class="py-3 px-5">Jam Masuk</th>
                                        <th scope="col" class="py-3 px-5">Sesi Pelajaran</th>
                                        <th scope="col" class="py-3 px-5">Status Kehadiran</th>
                                        <th scope="col" class="py-3 px-5">Catatan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-border">
                                    @foreach ($attendances as $index => $att)
                                        <tr class="hover:bg-slate-50/80 transition">
                                            <td class="py-3 px-5 text-slate-400 font-mono">{{ $index + 1 }}</td>
                                            <td class="py-3 px-5 font-bold text-navy">{{ $att->student->name }}</td>
                                            <td class="py-3 px-5 font-mono text-slate-600">{{ $att->student->nis }} / {{ $att->student->nisn }}</td>
                                            <td class="py-3 px-5 font-mono text-slate-700">
                                                {{ $att->check_in_time ? substr((string) $att->check_in_time, 0, 5) : '-' }}
                                            </td>
                                            <td class="py-3 px-5 text-slate-700">
                                                {{ $att->schedule?->subject?->name ?? 'Presensi Harian Kelas' }}
                                            </td>
                                            <td class="py-3 px-5">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-semibold border {{ $att->status->badgeClass() }}">
                                                    {{ $att->status->label() }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-5 text-slate-500 italic">
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
                <div class="bg-surface rounded-xl border border-border p-5 shadow-sm space-y-5">
                    <form method="GET" action="{{ route('homeroom.attendances.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-end">
                        <input type="hidden" name="tab" value="rekap">
                        <div>
                            <label for="start_date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal Awal</label>
                            <input type="date" name="start_date" id="start_date" value="{{ $startDate }}"
                                   class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
                        </div>
                        <div>
                            <label for="end_date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal Akhir</label>
                            <input type="date" name="end_date" id="end_date" value="{{ $endDate }}"
                                   class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
                        </div>
                        <div>
                            <button type="submit" class="w-full px-4 py-2 bg-navy hover:bg-navy-light text-white text-xs font-semibold rounded-lg transition flex items-center justify-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                                Filter Rekapitulasi
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-surface rounded-xl border border-border overflow-hidden shadow-sm">
                    <div class="px-5 py-3.5 bg-slate-50 border-b border-border flex items-center justify-between">
                        <h3 class="font-bold text-sm text-navy">Rekapitulasi Kehadiran Siswa Binaan</h3>
                        <span class="text-xs text-slate-500 font-medium">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} — {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-slate-800">
                            <thead class="bg-slate-100/70 text-slate-600 uppercase font-bold text-[11px] border-b border-border">
                                <tr>
                                    <th scope="col" class="py-3 px-5 w-12">No</th>
                                    <th scope="col" class="py-3 px-5">NIS</th>
                                    <th scope="col" class="py-3 px-5">Nama Siswa</th>
                                    <th scope="col" class="py-3 px-5 text-center">Hadir</th>
                                    <th scope="col" class="py-3 px-5 text-center">Terlambat</th>
                                    <th scope="col" class="py-3 px-5 text-center">Izin</th>
                                    <th scope="col" class="py-3 px-5 text-center">Sakit</th>
                                    <th scope="col" class="py-3 px-5 text-center">Alpa</th>
                                    <th scope="col" class="py-3 px-5 text-right">% Kehadiran</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border">
                                @forelse ($studentRecap as $idx => $st)
                                    <tr class="hover:bg-slate-50/80 transition">
                                        <td class="py-3 px-5 text-slate-400 font-mono">{{ $idx + 1 }}</td>
                                        <td class="py-3 px-5 font-mono text-slate-600">{{ $st->nis }}</td>
                                        <td class="py-3 px-5 font-bold text-navy">{{ $st->name }}</td>
                                        <td class="py-3 px-5 text-center font-bold text-emerald-700">{{ $st->hadir_count }}</td>
                                        <td class="py-3 px-5 text-center font-bold text-amber-700">{{ $st->terlambat_count }}</td>
                                        <td class="py-3 px-5 text-center font-bold text-blue-700">{{ $st->izin_count }}</td>
                                        <td class="py-3 px-5 text-center font-bold text-purple-700">{{ $st->sakit_count }}</td>
                                        <td class="py-3 px-5 text-center font-bold text-rose-700">{{ $st->alpa_count }}</td>
                                        <td class="py-3 px-5 text-right font-bold text-navy">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs {{ $st->rate >= 85 ? 'bg-emerald-50 text-emerald-800' : 'bg-rose-50 text-rose-800' }}">
                                                {{ $st->rate }}%
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="p-6 text-center text-xs text-slate-500 italic">
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
