<x-app-layout title="Dashboard Wali Kelas">
    <x-slot name="header">
        Dashboard Wali Kelas
    </x-slot>

    <!-- Welcome & Classroom Overview Banner -->
    <div class="relative bg-gradient-to-r from-slate-900 via-emerald-950 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl border border-slate-800 overflow-hidden flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="absolute -right-16 -top-16 w-64 h-64 bg-emerald-500/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 space-y-2">
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-white/10 text-emerald-300 border border-white/15">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    Portal Wali Kelas
                </span>
                @if($classroom)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-500/20 text-emerald-200 border border-emerald-400/30">
                        Kelas {{ $classroom->name }}
                    </span>
                @endif
            </div>
            <h2 class="text-xl sm:text-2xl font-black tracking-tight text-white">
                Selamat Datang, {{ $user->name }}
            </h2>
            <p class="text-xs text-slate-300 max-w-xl leading-relaxed">
                @if($classroom)
                    Wali Kelas <span class="font-bold text-white">{{ $classroom->name }}</span> &bull; Program Keahlian <span class="font-bold text-white">{{ $classroom->major }}</span> &bull; Tahun Ajaran <span class="font-mono text-emerald-300">{{ $classroom->academicYear?->name ?? '-' }}</span>
                @else
                    Akun Anda belum terhubung dengan penugasan kelas binaan. Hubungi administrator sekolah.
                @endif
            </p>
        </div>

        @if($classroom)
            <div class="relative z-10 flex items-center gap-2.5">
                <a href="{{ route('homeroom.attendances.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-xs font-bold text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 rounded-xl shadow-md hover:shadow-glow hover:-translate-y-0.5 transition-all duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    <span>Kelola Presensi Kelas</span>
                </a>
            </div>
        @endif
    </div>

    @if($classroom)
        <!-- Real Statistics Metrics (Bento 4-Column) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Stat 1 -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs hover:shadow-card hover:-translate-y-0.5 transition-all duration-200">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Siswa</span>
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 text-white flex items-center justify-center shadow-xs">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg>
                    </div>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-3xl font-black text-navy">{{ $totalStudents }}</span>
                    <span class="text-xs text-slate-400 font-medium">siswa terdaftar</span>
                </div>
                <p class="mt-1 text-[11px] text-slate-500">Kelas binaan {{ $classroom->name }}</p>
            </div>

            <!-- Stat 2 -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs hover:shadow-card hover:-translate-y-0.5 transition-all duration-200">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Tingkat Kehadiran Hari Ini</span>
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center shadow-xs">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-3xl font-black text-emerald-600">{{ $attendanceSummary['attendance_rate'] }}%</span>
                </div>
                <p class="mt-1 text-[11px] text-slate-500">{{ $attendanceSummary['hadir'] + $attendanceSummary['terlambat'] }} dari {{ $attendanceSummary['total'] }} tercatat hadir</p>
            </div>

            <!-- Stat 3 -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs hover:shadow-card hover:-translate-y-0.5 transition-all duration-200">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Izin &amp; Sakit</span>
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 text-white flex items-center justify-center shadow-xs">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-3xl font-black text-amber-600">{{ $attendanceSummary['izin'] + $attendanceSummary['sakit'] }}</span>
                    <span class="text-xs text-slate-400">({{ $attendanceSummary['izin'] }} izin, {{ $attendanceSummary['sakit'] }} sakit)</span>
                </div>
                <p class="mt-1 text-[11px] text-slate-500">Surat &amp; konfirmasi tercatat</p>
            </div>

            <!-- Stat 4 -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs hover:shadow-card hover:-translate-y-0.5 transition-all duration-200">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Tanpa Keterangan (Alpa)</span>
                    <div class="w-10 h-10 rounded-xl {{ $attendanceSummary['alpa'] > 0 ? 'bg-gradient-to-br from-rose-500 to-red-600' : 'bg-slate-200' }} text-white flex items-center justify-center shadow-xs">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-3xl font-black {{ $attendanceSummary['alpa'] > 0 ? 'text-rose-600' : 'text-slate-800' }}">{{ $attendanceSummary['alpa'] }}</span>
                    <span class="text-xs text-slate-400 font-medium">siswa</span>
                </div>
                <p class="mt-1 text-[11px] {{ $attendanceSummary['alpa'] > 0 ? 'text-rose-600 font-semibold' : 'text-slate-500' }}">
                    {{ $attendanceSummary['alpa'] > 0 ? 'Perlu tindak lanjut wali kelas' : 'Nihil ketidakhadiran tanpa izin' }}
                </p>
            </div>
        </div>

        <!-- Recent Attendance Entries -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-extrabold text-navy">Presensi Siswa Terbaru Hari Ini</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Catatan presensi terakhir siswa kelas {{ $classroom->name }}</p>
                </div>
                <a href="{{ route('homeroom.attendances.index') }}" class="text-xs font-bold text-brand hover:underline">
                    Lihat Seluruh Log &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50/80 border-b border-slate-100 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                        <tr>
                            <th class="py-3 px-4">NIS</th>
                            <th class="py-3 px-4">Nama Siswa</th>
                            <th class="py-3 px-4">Jam Masuk</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentAttendances as $att)
                            <tr class="hover:bg-slate-50/75 transition">
                                <td class="py-3.5 px-4 font-mono text-slate-500">{{ $att->student?->nis ?? '-' }}</td>
                                <td class="py-3.5 px-4 font-bold text-navy">{{ $att->student?->name ?? '-' }}</td>
                                <td class="py-3.5 px-4 font-mono text-slate-600">{{ $att->check_in_time ? substr($att->check_in_time, 0, 5) : '-' }}</td>
                                <td class="py-3.5 px-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $att->status->badgeClass() }}">
                                        {{ $att->status->label() }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-slate-600">{{ $att->notes ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-10 text-center text-slate-400">
                                    Belum ada catatan presensi hari ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="bg-white rounded-3xl p-12 border border-slate-200/90 text-center shadow-xs">
            <div class="w-16 h-16 mx-auto rounded-3xl bg-slate-100 text-slate-400 flex items-center justify-center mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <h3 class="text-base font-extrabold text-navy">Belum Ada Kelas Binaan</h3>
            <p class="text-xs sm:text-sm text-slate-500 mt-1 max-w-md mx-auto">
                Akun pendidik Anda saat ini belum ditetapkan sebagai Wali Kelas di data master kelas. Silakan koordinasi dengan Admin Sekolah untuk pengaturan penugasan kelas.
            </p>
        </div>
    @endif
</x-app-layout>
