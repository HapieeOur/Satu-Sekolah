<x-app-layout title="Dashboard Wali Kelas">
    <x-slot name="header">
        Dashboard Wali Kelas
    </x-slot>

    <!-- Welcome & Classroom Overview Banner -->
    <div class="bg-surface rounded-xl p-6 border border-border shadow-sm">
        <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                        Portal Wali Kelas
                    </span>
                    @if($classroom)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-semibold bg-navy-light/10 text-navy border border-navy/20">
                            Kelas {{ $classroom->name }}
                        </span>
                    @endif
                </div>
                <h2 class="text-xl font-bold text-navy">Selamat Datang, {{ $user->name }}</h2>
                <p class="text-xs text-slate-500 mt-1">
                    @if($classroom)
                        Wali Kelas {{ $classroom->name }} &bull; Program Keahlian {{ $classroom->major }} &bull; Tahun Ajaran {{ $classroom->academicYear?->name ?? '-' }}
                    @else
                        Akun Anda belum terhubung dengan penugasan kelas binaan. Hubungi administrator sekolah.
                    @endif
                </p>
            </div>
            @if($classroom)
                <div class="flex items-center gap-2">
                    <a href="{{ route('homeroom.attendances.index') }}" class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-white bg-brand rounded-lg hover:bg-brand-hover shadow-sm transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        <span>Kelola Presensi Kelas</span>
                    </a>
                </div>
            @endif
        </div>
    </div>

    @if($classroom)
        <!-- Real Statistics Metrics -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-surface rounded-xl p-5 border border-border shadow-sm">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Total Siswa Terdaftar</span>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl font-extrabold text-navy">{{ $totalStudents }}</span>
                    <span class="text-xs text-slate-400 font-medium">siswa</span>
                </div>
                <p class="mt-1 text-[11px] text-slate-500">Kelas binaan {{ $classroom->name }}</p>
            </div>

            <div class="bg-surface rounded-xl p-5 border border-border shadow-sm">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Tingkat Kehadiran Hari Ini</span>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl font-extrabold text-emerald-700">{{ $attendanceSummary['attendance_rate'] }}%</span>
                </div>
                <p class="mt-1 text-[11px] text-slate-500">{{ $attendanceSummary['hadir'] + $attendanceSummary['terlambat'] }} dari {{ $attendanceSummary['total'] }} tercatat hadir</p>
            </div>

            <div class="bg-surface rounded-xl p-5 border border-border shadow-sm">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Izin & Sakit Hari Ini</span>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl font-extrabold text-amber-700">{{ $attendanceSummary['izin'] + $attendanceSummary['sakit'] }}</span>
                    <span class="text-xs text-slate-500 font-normal">({{ $attendanceSummary['izin'] }} izin, {{ $attendanceSummary['sakit'] }} sakit)</span>
                </div>
                <p class="mt-1 text-[11px] text-slate-500">Surat & konfirmasi tercatat</p>
            </div>

            <div class="bg-surface rounded-xl p-5 border border-border shadow-sm">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Tanpa Keterangan (Alpa)</span>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl font-extrabold {{ $attendanceSummary['alpa'] > 0 ? 'text-rose-700' : 'text-slate-800' }}">{{ $attendanceSummary['alpa'] }}</span>
                    <span class="text-xs text-slate-400 font-medium">siswa</span>
                </div>
                <p class="mt-1 text-[11px] text-slate-500">Memerlukan tindak lanjut wali kelas</p>
            </div>
        </div>

        <!-- Recent Attendance Entries -->
        <div class="bg-surface rounded-xl border border-border shadow-sm overflow-hidden">
            <div class="p-5 border-b border-border flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-navy">Presensi Siswa Terbaru Hari Ini</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Catatan presensi terakhir siswa kelas {{ $classroom->name }}</p>
                </div>
                <a href="{{ route('homeroom.attendances.index') }}" class="text-xs font-semibold text-brand hover:underline">
                    Lihat Seluruh Log &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 border-b border-border text-slate-700 font-semibold uppercase tracking-wider text-[11px]">
                        <tr>
                            <th class="py-3 px-4">NIS</th>
                            <th class="py-3 px-4">Nama Siswa</th>
                            <th class="py-3 px-4">Jam Masuk</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse($recentAttendances as $att)
                            <tr class="hover:bg-slate-50/75 transition">
                                <td class="py-3 px-4 font-mono text-slate-700">{{ $att->student?->nis ?? '-' }}</td>
                                <td class="py-3 px-4 font-semibold text-navy">{{ $att->student?->name ?? '-' }}</td>
                                <td class="py-3 px-4 font-mono text-slate-600">{{ $att->check_in_time ? substr($att->check_in_time, 0, 5) : '-' }}</td>
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold {{ $att->status->badgeClass() }}">
                                        {{ $att->status->label() }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-slate-600">{{ $att->notes ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-500">
                                    Belum ada catatan presensi hari ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="bg-surface rounded-xl p-8 border border-border text-center">
            <h3 class="text-sm font-bold text-navy">Tidak Ada Kelas Binaan</h3>
            <p class="text-xs text-slate-500 mt-1 max-w-md mx-auto">
                Akun pendidik Anda saat ini belum ditetapkan sebagai Wali Kelas di data master kelas. Silakan koordinasi dengan Admin Sekolah untuk pengaturan penugasan kelas.
            </p>
        </div>
    @endif
</x-app-layout>
