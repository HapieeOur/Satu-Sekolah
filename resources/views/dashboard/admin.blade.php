<x-app-layout title="Admin Dashboard">
    <x-slot name="header">
        Dashboard Administrasi
    </x-slot>

    <div class="space-y-7">
        <!-- Top Class & Metric Row: "Ihre Klassen" / "Ringkasan Operasional" (Reference Image A) -->
        <div>
            <div class="flex items-center justify-between mb-3.5">
                <div class="flex items-center gap-2">
                    <h2 class="text-base font-extrabold text-[#171B61] tracking-tight">Ringkasan Operasional Sekolah</h2>
                    <span class="text-xs font-semibold text-slate-400">T.A. 2026/2027</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-[#E5ECFF] text-[#233DFF]">
                        <span class="w-2 h-2 rounded-full bg-[#233DFF] animate-pulse"></span>
                        Status Sistem: Normal
                    </span>
                </div>
            </div>

            <!-- Horizontal Cards Carousel (Reference Image A Deep Indigo-Blue Cards) -->
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- Card 1: Total Siswa -->
                <div class="rounded-3xl p-5 bg-[#2F3DB6] hover:bg-[#2532A6] text-white shadow-md shadow-indigo-950/10 flex flex-col justify-between transition-all duration-200 group">
                    <div class="space-y-3">
                        <div class="flex items-start justify-between">
                            <span class="text-xs font-bold uppercase tracking-wider text-indigo-200">Total Siswa</span>
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        </div>
                        <h3 class="text-3xl font-black tracking-tight group-hover:scale-105 transition-transform">
                            {{ $stats['total_students'] }}
                        </h3>
                        <div class="flex items-center gap-3 text-xs text-indigo-100 font-medium">
                            <div class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-amber-300" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/></svg>
                                <span>{{ $stats['total_classrooms'] }} Rombel</span>
                            </div>
                        </div>
                    </div>
                    <div class="pt-4 mt-3 border-t border-white/15 flex items-center justify-between text-xs">
                        <span class="text-[11px] text-indigo-200 font-semibold">Peserta Didik Aktif</span>
                        <a href="{{ route('admin.students.index') }}" class="text-amber-300 font-bold hover:underline">Kelola &rarr;</a>
                    </div>
                </div>

                <!-- Card 2: Tenaga Pendidik -->
                <div class="rounded-3xl p-5 bg-[#2F3DB6] hover:bg-[#2532A6] text-white shadow-md shadow-indigo-950/10 flex flex-col justify-between transition-all duration-200 group">
                    <div class="space-y-3">
                        <div class="flex items-start justify-between">
                            <span class="text-xs font-bold uppercase tracking-wider text-indigo-200">Tenaga Pendidik</span>
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        </div>
                        <h3 class="text-3xl font-black tracking-tight group-hover:scale-105 transition-transform">
                            {{ $stats['total_teachers'] }}
                        </h3>
                        <div class="flex items-center gap-3 text-xs text-indigo-100 font-medium">
                            <div class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-blue-200" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                                <span>Guru &amp; Mentor</span>
                            </div>
                        </div>
                    </div>
                    <div class="pt-4 mt-3 border-t border-white/15 flex items-center justify-between text-xs">
                        <span class="text-[11px] text-indigo-200 font-semibold">Guru Pengajar</span>
                        <a href="{{ route('admin.teachers.index') }}" class="text-amber-300 font-bold hover:underline">Kelola &rarr;</a>
                    </div>
                </div>

                <!-- Card 3: Rombel Kelas -->
                <div class="rounded-3xl p-5 bg-[#2F3DB6] hover:bg-[#2532A6] text-white shadow-md shadow-indigo-950/10 flex flex-col justify-between transition-all duration-200 group">
                    <div class="space-y-3">
                        <div class="flex items-start justify-between">
                            <span class="text-xs font-bold uppercase tracking-wider text-indigo-200">Rombel Kelas</span>
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        </div>
                        <h3 class="text-3xl font-black tracking-tight group-hover:scale-105 transition-transform">
                            {{ $stats['total_classrooms'] }}
                        </h3>
                        <div class="flex items-center gap-3 text-xs text-indigo-100 font-medium">
                            <div class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-emerald-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4z" clip-rule="evenodd"/></svg>
                                <span>Ruang Belajar</span>
                            </div>
                        </div>
                    </div>
                    <div class="pt-4 mt-3 border-t border-white/15 flex items-center justify-between text-xs">
                        <span class="text-[11px] text-indigo-200 font-semibold">Rombel Aktif</span>
                        <a href="{{ route('admin.classrooms.index') }}" class="text-amber-300 font-bold hover:underline">Kelola &rarr;</a>
                    </div>
                </div>

                <!-- Card 4: Penempatan PKL Aktif -->
                <div class="rounded-3xl p-5 bg-[#2F3DB6] hover:bg-[#2532A6] text-white shadow-md shadow-indigo-950/10 flex flex-col justify-between transition-all duration-200 group">
                    <div class="space-y-3">
                        <div class="flex items-start justify-between">
                            <span class="text-xs font-bold uppercase tracking-wider text-indigo-200">Penempatan PKL Aktif</span>
                            <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                        </div>
                        <h3 class="text-3xl font-black tracking-tight group-hover:scale-105 transition-transform">
                            {{ $stats['active_placements'] }}
                        </h3>
                        <div class="flex items-center gap-3 text-xs text-indigo-100 font-medium">
                            <div class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-amber-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"/></svg>
                                <span>Siswa di Industri</span>
                            </div>
                        </div>
                    </div>
                    <div class="pt-4 mt-3 border-t border-white/15 flex items-center justify-between text-xs">
                        <span class="text-[11px] text-indigo-200 font-semibold">Mitra DUDI</span>
                        <a href="{{ route('admin.internships.placements.index') }}" class="text-amber-300 font-bold hover:underline">Kelola &rarr;</a>
                    </div>
                </div>

                <!-- Add Quick Action Card (Reference Image A Plus Card) -->
                <a href="{{ route('admin.users.create') }}" class="rounded-3xl p-5 border-2 border-dashed border-indigo-200 bg-[#ECEBFA]/40 hover:bg-[#ECEBFA] flex flex-col items-center justify-center text-center gap-2 group transition-all duration-150 cursor-pointer">
                    <div class="w-10 h-10 rounded-2xl bg-white text-[#233DFF] flex items-center justify-center shadow-xs group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    </div>
                    <span class="text-xs font-bold text-[#171B61] leading-tight">Tambah Akun<br>Pengguna</span>
                </a>
            </div>
        </div>

        <!-- Multi-Column Layout: Notifications + Task Queues (Left) + Operational Activity Panel (Right) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            <!-- Left & Middle: Benachrichtigungen + Antrean Verifikasi (8 Cols) -->
            <div class="lg:col-span-7 xl:col-span-8 grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Column 1: "Benachrichtigungen" (Monitoring & Notifikasi Presensi PKL) -->
                <div class="space-y-4">
                    <h3 class="text-sm font-extrabold text-[#171B61] tracking-tight">Presensi PKL &amp; Operasional</h3>

                    <!-- Top Highlight Card in Vibrant Blue (Reference Image A) -->
                    <div class="rounded-3xl p-5 bg-[#233DFF] text-white shadow-lg shadow-indigo-600/25 relative overflow-hidden">
                        <div class="flex items-start justify-between">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-amber-300">Tingkat Kehadiran PKL Hari Ini</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-white/20 text-white">Geofence Live</span>
                        </div>
                        <div class="flex items-baseline gap-2 mt-2">
                            <span class="text-4xl font-black">{{ $pklAttendanceSummary['rate'] }}%</span>
                            <span class="text-xs text-indigo-100">kehadiran siswa</span>
                        </div>

                        <div class="grid grid-cols-4 gap-2 pt-4 mt-3 border-t border-white/20 text-center text-xs">
                            <div class="p-2 rounded-xl bg-white/10">
                                <span class="font-extrabold block text-sm">{{ $pklAttendanceSummary['hadir'] }}</span>
                                <span class="text-[10px] text-indigo-200">Hadir</span>
                            </div>
                            <div class="p-2 rounded-xl bg-white/10">
                                <span class="font-extrabold block text-sm">{{ $pklAttendanceSummary['terlambat'] }}</span>
                                <span class="text-[10px] text-indigo-200">Telat</span>
                            </div>
                            <div class="p-2 rounded-xl bg-white/10">
                                <span class="font-extrabold block text-sm">{{ $pklAttendanceSummary['izin'] + $pklAttendanceSummary['sakit'] }}</span>
                                <span class="text-[10px] text-indigo-200">Izin</span>
                            </div>
                            <div class="p-2 rounded-xl bg-white/10">
                                <span class="font-extrabold block text-sm">{{ $pklAttendanceSummary['alpa'] }}</span>
                                <span class="text-[10px] text-indigo-200">Alpa</span>
                            </div>
                        </div>
                    </div>

                    <!-- User Account Health Cards -->
                    <div class="rounded-2xl p-4 bg-white border border-slate-200/80 shadow-xs flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-[#171B61]">Status Akun Pengguna</h4>
                                <p class="text-[11px] text-slate-500">{{ $stats['active_users'] }} aktif dari {{ $stats['total_users'] }} total akun</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.users.index') }}" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-[#E5ECFF] text-[#233DFF] text-xs font-bold transition">
                            Kelola
                        </a>
                    </div>

                    <div class="rounded-2xl p-4 bg-white border border-slate-200/80 shadow-xs flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-[#ECEBFA] text-[#233DFF] flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-[#171B61]">Publikasi Berita &amp; Acara</h4>
                                <p class="text-[11px] text-slate-500">Kelola warta, pengumuman, dan agenda</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.posts.index') }}" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-[#E5ECFF] text-[#233DFF] text-xs font-bold transition">
                            Buka
                        </a>
                    </div>
                </div>

                <!-- Column 2: "Heute zu erledigen" (Antrean Verifikasi & Tindak Lanjut Admin) -->
                <div class="space-y-4">
                    <h3 class="text-sm font-extrabold text-[#171B61] tracking-tight">Antrean Tindak Lanjut</h3>

                    <div class="space-y-3">
                        <!-- Pending Leaves -->
                        <div class="rounded-2xl p-4 bg-white border border-slate-200/80 shadow-xs flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="text-xs font-bold text-[#171B61] truncate">Pengajuan Izin PKL</h4>
                                    <p class="text-[11px] text-slate-500">{{ $pendingLeavesCount }} permohonan menunggu review</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-xs font-black {{ $pendingLeavesCount > 0 ? 'bg-amber-100 text-amber-700' : 'bg-slate-100 text-slate-500' }}">
                                {{ $pendingLeavesCount }}
                            </span>
                        </div>

                        <!-- Pending Journals -->
                        <div class="rounded-2xl p-4 bg-white border border-slate-200/80 shadow-xs flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-9 h-9 rounded-xl bg-blue-50 text-[#233DFF] flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="text-xs font-bold text-[#171B61] truncate">Jurnal Harian PKL</h4>
                                    <p class="text-[11px] text-slate-500">{{ $pendingJournalsCount }} jurnal masuk</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-xs font-black {{ $pendingJournalsCount > 0 ? 'bg-blue-100 text-[#233DFF]' : 'bg-slate-100 text-slate-500' }}">
                                {{ $pendingJournalsCount }}
                            </span>
                        </div>

                        <!-- Recent Users Quick List -->
                        <div class="rounded-2xl p-4 bg-white border border-slate-200/80 shadow-xs space-y-2.5">
                            <div class="flex items-center justify-between">
                                <h4 class="text-xs font-bold text-[#171B61]">Pengguna Terbaru</h4>
                                <a href="{{ route('admin.users.index') }}" class="text-[10px] text-[#233DFF] font-bold hover:underline">Semua &rarr;</a>
                            </div>
                            <div class="divide-y divide-slate-100">
                                @forelse($recentUsers->take(3) as $user)
                                    <div class="py-2 flex items-center justify-between text-xs">
                                        <div class="min-w-0">
                                            <p class="font-bold text-[#171B61] truncate">{{ $user->name }}</p>
                                            <p class="text-[10px] text-slate-400 truncate">{{ $user->email }}</p>
                                        </div>
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $user->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                                            {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </div>
                                @empty
                                    <p class="text-xs text-slate-400 py-2">Belum ada pengguna terdaftar.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Panel: "Stundenplan" / Aktivitas & Monitoring Terkini (Reference Image A) -->
            <div class="lg:col-span-5 xl:col-span-4 bg-white rounded-3xl border border-slate-200/80 p-6 shadow-xs space-y-6">
                <!-- Section 1: Recent PKL Placements -->
                <div>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                        <div>
                            <h3 class="text-sm font-extrabold text-[#171B61]">Penempatan PKL Terbaru</h3>
                            <p class="text-[11px] text-slate-400">Monitoring mitra DUDI</p>
                        </div>
                        <a href="{{ route('admin.internships.placements.index') }}" class="text-xs font-bold text-[#233DFF] hover:underline">Semua &rarr;</a>
                    </div>

                    <div class="space-y-3">
                        @forelse($recentPlacements as $placement)
                            <div class="p-3.5 rounded-2xl bg-[#F4F6FB] border border-slate-200/80 space-y-1.5">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-[#171B61]">{{ $placement->student->name }}</span>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#E5ECFF] text-[#233DFF]">
                                        {{ $placement->status->label() }}
                                    </span>
                                </div>
                                <p class="text-[11px] text-slate-600 font-semibold flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-[#233DFF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    <span>{{ $placement->company->name }}</span>
                                </p>
                                <p class="text-[10px] text-slate-400">
                                    Pembimbing: {{ $placement->teacher?->user?->name ?? 'Belum ditentukan' }}
                                </p>
                            </div>
                        @empty
                            <div class="p-6 text-center bg-[#F4F6FB] rounded-2xl border border-slate-100">
                                <p class="text-xs text-slate-400">Belum ada penempatan PKL aktif.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Section 2: Recent PKL Check-ins -->
                <div>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                        <div>
                            <h3 class="text-sm font-extrabold text-[#171B61]">Presensi Masuk Hari Ini</h3>
                            <p class="text-[11px] text-slate-400">Log kehadiran GPS real-time</p>
                        </div>
                        <a href="{{ route('admin.internships.attendances.index') }}" class="text-xs font-bold text-[#233DFF] hover:underline">Semua &rarr;</a>
                    </div>

                    <div class="space-y-2.5">
                        @forelse($recentPklAttendances as $att)
                            <div class="p-3 rounded-2xl bg-[#F4F6FB] border border-slate-200/80 flex items-center justify-between text-xs">
                                <div class="min-w-0">
                                    <p class="font-bold text-[#171B61] truncate">{{ $att->placement->student->name }}</p>
                                    <p class="text-[10px] text-slate-400 truncate">{{ $att->placement->company->name }}</p>
                                </div>
                                <div class="text-right shrink-0">
                                    <span class="font-mono font-bold text-[11px] text-[#233DFF] block">{{ substr($att->check_in_time, 0, 5) }} WIB</span>
                                    <span class="text-[10px] text-emerald-600 font-semibold">{{ $att->status->label() }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center bg-[#F4F6FB] rounded-2xl border border-slate-100">
                                <p class="text-xs text-slate-400">Belum ada log presensi tercatat hari ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
