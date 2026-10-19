<x-app-layout title="Dashboard Wali Kelas">
    <x-slot name="header">
        Dashboard Wali Kelas
    </x-slot>

    <!-- Top Classroom & Role Overview Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-2">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-[#E5ECFF] text-[#233DFF] border border-[#233DFF]/20">
                    <span class="w-2 h-2 rounded-full bg-[#233DFF] animate-pulse"></span>
                    Portal Wali Kelas
                </span>
                @if($classroom)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-[#ECEBFA] text-[#171B61] border border-[#171B61]/15">
                        Kelas {{ $classroom->name }}
                    </span>
                @endif
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight mt-2">
                Selamat Datang, {{ $user->name }}
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                @if($classroom)
                    Wali Kelas <span class="font-bold text-slate-800">{{ $classroom->name }}</span> &bull; Program Keahlian <span class="font-bold text-slate-800">{{ $classroom->major }}</span> &bull; Tahun Ajaran <span class="font-mono text-[#233DFF] font-bold">{{ $classroom->academicYear?->name ?? '-' }}</span>
                @else
                    Akun Anda belum terhubung dengan penugasan kelas binaan. Hubungi administrator sekolah.
                @endif
            </p>
        </div>

        @if($classroom)
            <div class="flex items-center gap-2.5">
                <a href="{{ route('homeroom.attendances.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-[#233DFF] hover:bg-[#1a30d8] shadow-md shadow-[#233DFF]/25 hover:-translate-y-0.5 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    <span>Kelola Presensi Kelas</span>
                </a>
            </div>
        @endif
    </div>

    @if($classroom)
        <!-- Horizontal Class Cards Carousel (Reference Image A Style) -->
        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-bold text-slate-800 tracking-tight">Kelas Binaan Saya</h3>
                <span class="text-xs text-slate-400">Semester Aktif {{ $classroom->academicYear?->semester ?? 'Ganjil' }}</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Main Classroom Active Card (Indigo Deep Card) -->
                <div class="md:col-span-2 relative overflow-hidden rounded-2xl bg-gradient-to-r from-[#171B61] to-[#233DFF] p-6 text-white shadow-lg">
                    <div class="relative z-10 flex flex-col justify-between h-full">
                        <div class="flex items-start justify-between">
                            <div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-white/20 text-white backdrop-blur-xs">
                                    {{ $classroom->major }}
                                </span>
                                <h2 class="text-2xl font-black tracking-tight mt-2">Kelas {{ $classroom->name }}</h2>
                                <p class="text-xs text-indigo-100 mt-0.5">Tahun Ajaran {{ $classroom->academicYear?->name ?? '-' }}</p>
                            </div>
                            <div class="text-right">
                                <span class="text-3xl font-black text-[#F4CF52]">{{ $attendanceSummary['attendance_rate'] }}%</span>
                                <p class="text-[10px] text-indigo-200 font-semibold uppercase tracking-wider">Kehadiran Hari Ini</p>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-white/15 grid grid-cols-3 gap-3">
                            <div>
                                <p class="text-[10px] text-indigo-200 font-semibold uppercase">Total Siswa</p>
                                <p class="text-lg font-black text-white mt-0.5">{{ $totalStudents }} Siswa</p>
                            </div>
                            <div>
                                <p class="text-[10px] text-indigo-200 font-semibold uppercase">Hadir / Terlambat</p>
                                <p class="text-lg font-black text-emerald-300 mt-0.5">{{ $attendanceSummary['hadir'] + $attendanceSummary['terlambat'] }} Hadir</p>
                            </div>
                            <div>
                                <p class="text-[10px] text-indigo-200 font-semibold uppercase">Alpa / Tanpa Keterangan</p>
                                <p class="text-lg font-black {{ $attendanceSummary['alpa'] > 0 ? 'text-[#F4CF52]' : 'text-white' }} mt-0.5">{{ $attendanceSummary['alpa'] }} Siswa</p>
                            </div>
                        </div>
                    </div>
                    <div class="absolute -right-8 -bottom-8 w-48 h-48 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>
                </div>

                <!-- Classroom Status Card -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Status Binaan</span>
                            <span class="w-2.5 h-2.5 rounded-full {{ $attendanceSummary['alpa'] > 0 ? 'bg-amber-500' : 'bg-emerald-500' }}"></span>
                        </div>
                        <h4 class="text-base font-bold text-slate-900">Perhatian Wali Kelas</h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                            @if($attendanceSummary['alpa'] > 0)
                                Terdapat <strong class="text-rose-600">{{ $attendanceSummary['alpa'] }} siswa</strong> tanpa keterangan hari ini yang memerlukan konfirmasi orang tua/wali.
                            @else
                                Seluruh siswa tercatat hadir atau melampirkan keterangan resmi. Ketertiban kelas terpantau prima.
                            @endif
                        </p>
                    </div>

                    <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-400">Wali Kelas:</span>
                        <span class="font-bold text-slate-800">{{ $teacher->name ?? $user->name }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4 Bento Metrics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Siswa -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:border-[#233DFF]/30 transition-all">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Siswa</span>
                    <div class="w-9 h-9 rounded-xl bg-[#E5ECFF] text-[#233DFF] flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-2xl font-black text-slate-900">{{ $totalStudents }}</span>
                    <span class="text-xs text-slate-400 font-medium">siswa terdaftar</span>
                </div>
                <p class="mt-1 text-[11px] text-slate-500">Kelas binaan {{ $classroom->name }}</p>
            </div>

            <!-- Tingkat Kehadiran Hari Ini -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:border-emerald-300 transition-all">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Tingkat Kehadiran Hari Ini</span>
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-2xl font-black text-emerald-600">{{ $attendanceSummary['attendance_rate'] }}%</span>
                </div>
                <p class="mt-1 text-[11px] text-slate-500">{{ $attendanceSummary['hadir'] + $attendanceSummary['terlambat'] }} dari {{ $attendanceSummary['total'] }} tercatat hadir</p>
            </div>

            <!-- Izin & Sakit -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:border-amber-300 transition-all">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Izin &amp; Sakit</span>
                    <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-2xl font-black text-amber-600">{{ $attendanceSummary['izin'] + $attendanceSummary['sakit'] }}</span>
                    <span class="text-xs text-slate-400">({{ $attendanceSummary['izin'] }} izin, {{ $attendanceSummary['sakit'] }} sakit)</span>
                </div>
                <p class="mt-1 text-[11px] text-slate-500">Keterangan terverifikasi</p>
            </div>

            <!-- Tanpa Keterangan (Alpa) -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:border-rose-300 transition-all">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Tanpa Keterangan (Alpa)</span>
                    <div class="w-9 h-9 rounded-xl {{ $attendanceSummary['alpa'] > 0 ? 'bg-rose-50 text-rose-600' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-2xl font-black {{ $attendanceSummary['alpa'] > 0 ? 'text-rose-600' : 'text-slate-800' }}">{{ $attendanceSummary['alpa'] }}</span>
                    <span class="text-xs text-slate-400 font-medium">siswa</span>
                </div>
                <p class="mt-1 text-[11px] {{ $attendanceSummary['alpa'] > 0 ? 'text-rose-600 font-semibold' : 'text-slate-500' }}">
                    {{ $attendanceSummary['alpa'] > 0 ? 'Perlu tindak lanjut wali kelas' : 'Nihil ketidakhadiran tanpa izin' }}
                </p>
            </div>
        </div>

        <!-- Main Content Area: Left Recent Attendances Table, Right Sidebar Action Panel (Ref Image A) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left 2 Cols: Recent Attendance Entries Table -->
            <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Presensi Siswa Terbaru Hari Ini</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Catatan presensi terakhir siswa kelas {{ $classroom->name }}</p>
                    </div>
                    <a href="{{ route('homeroom.attendances.index') }}" class="text-xs font-bold text-[#233DFF] hover:underline flex items-center gap-1">
                        <span>Lihat Seluruh Log</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-[#F4F6FB] border-b border-slate-100 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
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
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="py-3 px-4 font-mono text-slate-500">{{ $att->student?->nis ?? '-' }}</td>
                                    <td class="py-3 px-4 font-bold text-slate-900">{{ $att->student?->name ?? '-' }}</td>
                                    <td class="py-3 px-4 font-mono text-slate-600">{{ $att->check_in_time ? substr($att->check_in_time, 0, 5) : '-' }}</td>
                                    <td class="py-3 px-4">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $att->status->badgeClass() }}">
                                            {{ $att->status->label() }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-slate-500">{{ $att->notes ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-10 text-center text-slate-400">
                                        <p class="font-medium">Belum ada catatan presensi hari ini.</p>
                                        <p class="text-[11px] mt-1">Presensi akan muncul otomatis saat guru mata pelajaran mencatat kehadiran.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right Column: Quick Actions & Homeroom Tools Panel -->
            <div class="space-y-4">
                <!-- Action Card -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Tindakan Cepat</h4>
                    <div class="space-y-2">
                        <a href="{{ route('homeroom.attendances.index') }}" class="flex items-center justify-between p-3 rounded-xl bg-[#F4F6FB] hover:bg-[#E5ECFF] border border-slate-200/50 hover:border-[#233DFF]/30 transition group">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-[#233DFF] text-white flex items-center justify-center font-bold text-xs shadow-xs">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900 group-hover:text-[#233DFF]">Presensi Harian</p>
                                    <p class="text-[10px] text-slate-400">Lihat rekap presensi per tanggal</p>
                                </div>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-[#233DFF] group-hover:translate-x-0.5 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>

                        <a href="{{ route('homeroom.attendances.index', ['tab' => 'rekap']) }}" class="flex items-center justify-between p-3 rounded-xl bg-[#F4F6FB] hover:bg-[#ECEBFA] border border-slate-200/50 hover:border-[#171B61]/30 transition group">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-[#171B61] text-white flex items-center justify-center font-bold text-xs shadow-xs">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900 group-hover:text-[#171B61]">Rekap Semester</p>
                                    <p class="text-[10px] text-slate-400">Persentase kehadiran per siswa</p>
                                </div>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-[#171B61] group-hover:translate-x-0.5 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Classroom Profile Details -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Informasi Rombel</h4>
                    <div class="space-y-2.5 text-xs">
                        <div class="flex justify-between py-1.5 border-b border-slate-100">
                            <span class="text-slate-500">Kelas</span>
                            <span class="font-bold text-slate-800">{{ $classroom->name }}</span>
                        </div>
                        <div class="flex justify-between py-1.5 border-b border-slate-100">
                            <span class="text-slate-500">Komp. Keahlian</span>
                            <span class="font-bold text-slate-800">{{ $classroom->major }}</span>
                        </div>
                        <div class="flex justify-between py-1.5 border-b border-slate-100">
                            <span class="text-slate-500">Tingkat</span>
                            <span class="font-bold text-slate-800">Kelas {{ $classroom->level ?? 'XI' }}</span>
                        </div>
                        <div class="flex justify-between py-1.5">
                            <span class="text-slate-500">Kapasitas</span>
                            <span class="font-bold text-slate-800">{{ $totalStudents }} Siswa Terisi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-2xl p-12 border border-slate-200/80 text-center shadow-xs">
            <div class="w-16 h-16 mx-auto rounded-2xl bg-[#ECEBFA] text-[#171B61] flex items-center justify-center mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <h3 class="text-base font-bold text-slate-900">Belum Ada Kelas Binaan</h3>
            <p class="text-xs text-slate-500 mt-1 max-w-md mx-auto leading-relaxed">
                Akun pendidik Anda saat ini belum ditetapkan sebagai Wali Kelas di data master kelas. Silakan koordinasi dengan Admin Sekolah untuk pengaturan penugasan kelas.
            </p>
        </div>
    @endif
</x-app-layout>
