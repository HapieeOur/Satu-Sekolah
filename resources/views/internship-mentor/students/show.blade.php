<x-app-layout title="Portofolio Siswa Bimbingan PKL">
    <x-slot name="header">
        Pembimbing: Portofolio & Rekap Siswa Bimbingan
    </x-slot>

    <div class="space-y-6">
        <!-- Hero Header -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 p-6 md:p-8 text-white shadow-xl">
            <div class="absolute -top-16 -right-16 w-64 h-64 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-16 -left-16 w-64 h-64 bg-emerald-500/15 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-start sm:items-center gap-4">
                    <a href="{{ route('internship-mentor.students.index') }}" 
                       class="w-10 h-10 rounded-xl bg-white/10 hover:bg-white/15 border border-white/10 flex items-center justify-center text-white transition shrink-0 backdrop-blur-sm shadow-sm"
                       title="Kembali ke Daftar Siswa">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    </a>
                    <div class="space-y-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold border {{ $placement->status->badgeClass() }}">
                                {{ $placement->status->label() }}
                            </span>
                            <span class="text-xs text-indigo-300 font-mono bg-indigo-500/20 px-2 py-0.5 rounded-md border border-indigo-400/30">
                                NIS: {{ $placement->student->nis }}
                            </span>
                        </div>
                        <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-white">
                            {{ $placement->student->name }}
                        </h1>
                        <p class="text-slate-300 text-xs md:text-sm flex flex-wrap items-center gap-x-2 gap-y-1">
                            <span>Kelas {{ $placement->student->classroom?->name ?? '-' }}</span>
                            <span class="text-slate-500">&bull;</span>
                            <span class="font-semibold text-indigo-200">{{ $placement->company->name }}</span>
                            <span class="text-slate-500">&bull;</span>
                            <span class="text-slate-300">Divisi {{ $placement->department ?: 'Umum' }}</span>
                        </p>
                    </div>
                </div>

                <!-- Quick Action Buttons -->
                <div class="flex flex-wrap items-center gap-2.5">
                    <a href="{{ route('internship-mentor.attendances.index', ['search' => $placement->student->name]) }}"
                       class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl shadow-md shadow-indigo-600/30 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Audit Presensi</span>
                    </a>
                    <a href="{{ route('internship-mentor.journals.index', ['search' => $placement->student->name]) }}"
                       class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/10 hover:bg-white/15 border border-white/10 text-white text-xs font-semibold rounded-xl transition backdrop-blur-sm">
                        <svg class="w-4 h-4 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        <span>Jurnal Aktivitas</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Student Progress Metric Cards (Bento Grid) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Attendance Metric -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm relative overflow-hidden group hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Presensi PKL</span>
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-3xl font-black text-slate-900">{{ $attendanceSummary['total'] }}</span>
                    <span class="text-xs text-slate-500 font-medium">hari tercatat</span>
                </div>
                <div class="mt-3 pt-3 border-t border-slate-100 flex flex-wrap items-center gap-1.5 text-[11px]">
                    <span class="text-emerald-700 font-bold bg-emerald-50 px-2 py-0.5 rounded-md">{{ $attendanceSummary['hadir'] }} Hadir</span>
                    <span class="text-amber-700 font-bold bg-amber-50 px-2 py-0.5 rounded-md">{{ $attendanceSummary['terlambat'] }} Telat</span>
                    <span class="text-blue-700 bg-blue-50 px-2 py-0.5 rounded-md">{{ $attendanceSummary['izin'] + $attendanceSummary['sakit'] }} Izin</span>
                    @if($attendanceSummary['alpa'] > 0)
                        <span class="text-rose-700 font-bold bg-rose-50 px-2 py-0.5 rounded-md">{{ $attendanceSummary['alpa'] }} Alpa</span>
                    @endif
                </div>
            </div>

            <!-- Journal Metric -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm relative overflow-hidden group hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Jurnal Aktivitas</span>
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-3xl font-black text-emerald-600">{{ $journalSummary['approved'] }}</span>
                    <span class="text-xs text-slate-500 font-medium">/ {{ $journalSummary['total'] }} Disetujui</span>
                </div>
                <div class="mt-3 pt-3 border-t border-slate-100 flex items-center gap-2 text-[11px]">
                    <span class="text-amber-700 font-semibold bg-amber-50 px-2 py-0.5 rounded-md">{{ $journalSummary['submitted'] }} Menunggu</span>
                    <span class="text-blue-700 font-semibold bg-blue-50 px-2 py-0.5 rounded-md">{{ $journalSummary['revision_requested'] }} Revisi</span>
                </div>
            </div>

            <!-- Task Submissions Metric -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm relative overflow-hidden group hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Pengumpulan Tugas</span>
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-3xl font-black text-slate-900">{{ $taskSubmissions->count() }}</span>
                    <span class="text-xs text-slate-500 font-medium">tugas diserahkan</span>
                </div>
                <div class="mt-3 pt-3 border-t border-slate-100 text-[11px] text-slate-600">
                    <span class="font-bold text-slate-800">{{ $taskSubmissions->whereNotNull('grade')->count() }}</span> telah dinilai oleh pembimbing
                </div>
            </div>

            <!-- Average Grade Metric -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm relative overflow-hidden group hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Rata-Rata Nilai</span>
                    <div class="w-8 h-8 rounded-lg bg-violet-50 text-violet-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
                    </div>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-3xl font-black {{ $averageGrade !== null ? ($averageGrade >= 75 ? 'text-emerald-600' : 'text-amber-600') : 'text-slate-400' }}">
                        {{ $averageGrade !== null ? $averageGrade : '-' }}
                    </span>
                    <span class="text-xs text-slate-400 font-mono">/ 100</span>
                </div>
                <div class="mt-3 pt-3 border-t border-slate-100 text-[11px] text-slate-500">
                    {{ $averageGrade !== null ? 'Evaluasi kumulatif tugas mandiri' : 'Belum ada penilaian tersimpan' }}
                </div>
            </div>
        </div>

        <!-- Overview Details Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Student & Placement Details -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm space-y-4">
                <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100">
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-slate-900">Biodata Siswa & Rombel</h2>
                        <p class="text-[11px] text-slate-500">Identitas resmi dan kontak darurat siswa</p>
                    </div>
                </div>

                <div class="space-y-3 text-xs">
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-50">
                        <span class="text-slate-500">Nama Lengkap</span>
                        <span class="font-bold text-slate-900">{{ $placement->student->name }}</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-50">
                        <span class="text-slate-500">NIS / NISN</span>
                        <span class="font-mono font-medium text-slate-800">{{ $placement->student->nis }} / {{ $placement->student->nisn }}</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-50">
                        <span class="text-slate-500">Program Keahlian</span>
                        <span class="font-semibold text-slate-800">{{ $placement->student->classroom?->major ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-50">
                        <span class="text-slate-500">Kontak Siswa</span>
                        <span class="font-mono text-slate-800">{{ $placement->student->phone ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-50">
                        <span class="text-slate-500">Orang Tua / Wali</span>
                        <span class="font-medium text-slate-800">{{ $placement->student->parent_name }} ({{ $placement->student->parent_phone }})</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-50">
                        <span class="text-slate-500">Rentang Waktu PKL</span>
                        <span class="font-mono font-semibold text-slate-800">{{ $placement->start_date->format('d M Y') }} — {{ $placement->end_date->format('d M Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5">
                        <span class="text-slate-500">Status Penempatan</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold border {{ $placement->status->badgeClass() }}">
                            {{ $placement->status->label() }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Company & Geofence Details -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm space-y-4">
                <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100">
                    <div class="w-8 h-8 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-slate-900">Mitra Industri & Geofence</h2>
                        <p class="text-[11px] text-slate-500">Ketentuan presensi berbasis lokasi perusahaan</p>
                    </div>
                </div>

                <div class="space-y-3 text-xs">
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-50">
                        <span class="text-slate-500">Perusahaan Mitra</span>
                        <span class="font-bold text-slate-900">{{ $placement->company->name }}</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-50">
                        <span class="text-slate-500">Divisi Penugasan</span>
                        <span class="font-semibold text-slate-800">{{ $placement->department ?: 'Umum / Teknis' }}</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-50">
                        <span class="text-slate-500">Penanggung Jawab (PIC)</span>
                        <span class="font-medium text-slate-800">{{ $placement->company->contact_person ?? '-' }} ({{ $placement->company->phone ?? '-' }})</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-50">
                        <span class="text-slate-500">Alamat Kantor</span>
                        <span class="text-slate-800 text-right max-w-xs truncate">{{ $placement->company->address }}</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-50">
                        <span class="text-slate-500">Koordinat Validasi (Lat, Lng)</span>
                        <span class="font-mono text-slate-800">{{ $placement->company->latitude ?? '-' }}, {{ $placement->company->longitude ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5">
                        <span class="text-slate-500">Batas Toleransi Radius</span>
                        <span class="font-bold text-indigo-700 bg-indigo-50 px-2.5 py-0.5 rounded-lg border border-indigo-100">
                            {{ $placement->company->radius_meters }} meter
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity Tables: Presensi & Jurnal Terakhir -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Attendances -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden flex flex-col">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-2.5 h-2.5 rounded-full bg-emerald-500"></div>
                        <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Presensi Terakhir</h3>
                    </div>
                    <a href="{{ route('internship-mentor.attendances.index', ['search' => $placement->student->name]) }}" 
                       class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 hover:underline inline-flex items-center gap-1">
                        <span>Lihat Semua</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50/80 border-b border-slate-200/80 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">
                            <tr>
                                <th class="py-3 px-4">Tanggal</th>
                                <th class="py-3 px-4">Masuk / Keluar</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4">Verifikasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($recentAttendances as $att)
                                <tr class="hover:bg-slate-50/60 transition">
                                    <td class="py-3 px-4 font-mono font-medium text-slate-800">{{ $att->date->format('d/m/Y') }}</td>
                                    <td class="py-3 px-4 font-mono text-slate-600">
                                        {{ $att->check_in_time ? substr($att->check_in_time, 0, 5) : '-' }} /
                                        {{ $att->check_out_time ? substr($att->check_out_time, 0, 5) : '-' }}
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $att->status->badgeClass() }}">
                                            {{ $att->status->label() }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold border {{ $att->verification_status->badgeClass() }}">
                                            {{ $att->verification_status->label() }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-slate-400">
                                        Belum ada riwayat presensi tercatat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Journals -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden flex flex-col">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-2.5 h-2.5 rounded-full bg-indigo-500"></div>
                        <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Jurnal Harian Terakhir</h3>
                    </div>
                    <a href="{{ route('internship-mentor.journals.index', ['search' => $placement->student->name]) }}" 
                       class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 hover:underline inline-flex items-center gap-1">
                        <span>Lihat Semua</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50/80 border-b border-slate-200/80 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">
                            <tr>
                                <th class="py-3 px-4">Tanggal</th>
                                <th class="py-3 px-4">Aktivitas</th>
                                <th class="py-3 px-4">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($recentJournals as $jr)
                                <tr class="hover:bg-slate-50/60 transition">
                                    <td class="py-3 px-4 font-mono font-medium text-slate-800 whitespace-nowrap">{{ $jr->date->format('d/m/Y') }}</td>
                                    <td class="py-3 px-4 max-w-xs">
                                        <p class="font-bold text-slate-900 truncate">{{ $jr->title }}</p>
                                        <p class="text-[11px] text-slate-500 line-clamp-1 mt-0.5">{{ Str::limit($jr->activity_description, 60) }}</p>
                                    </td>
                                    <td class="py-3 px-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $jr->status->badgeClass() }}">
                                            {{ $jr->status->label() }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-8 text-center text-slate-400">
                                        Belum ada catatan jurnal harian.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Task Submissions & Grades Table Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="p-5 md:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Pengumpulan Tugas & Evaluasi Siswa</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Daftar penugasan mandiri yang telah dikumpulkan beserta umpan balik pembimbing</p>
                </div>
                <a href="{{ route('internship-mentor.tasks.index') }}" 
                   class="inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-600 hover:text-indigo-700 hover:underline">
                    <span>Kelola Penugasan PKL</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50/80 border-b border-slate-200/80 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">
                        <tr>
                            <th class="py-3.5 px-4">Judul Penugasan</th>
                            <th class="py-3.5 px-4">Batas Pengumpulan</th>
                            <th class="py-3.5 px-4">Waktu Penyerahan</th>
                            <th class="py-3.5 px-4">Status Pengumpulan</th>
                            <th class="py-3.5 px-4 text-center">Nilai Evaluasi</th>
                            <th class="py-3.5 px-4">Umpan Balik Pembimbing</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($taskSubmissions as $sub)
                            <tr class="hover:bg-indigo-50/30 transition-colors duration-150">
                                <td class="py-3.5 px-4">
                                    <p class="font-bold text-slate-900">{{ $sub->task->title }}</p>
                                </td>
                                <td class="py-3.5 px-4 font-mono text-slate-600 whitespace-nowrap">
                                    {{ $sub->task->due_date ? $sub->task->due_date->format('d/m/Y H:i') : '-' }}
                                </td>
                                <td class="py-3.5 px-4 font-mono text-slate-600 whitespace-nowrap">
                                    {{ $sub->submitted_at ? $sub->submitted_at->format('d/m/Y H:i') : '-' }}
                                </td>
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $sub->status->badgeClass() }}">
                                        {{ $sub->status->label() }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                    @if($sub->grade !== null)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-xs font-black {{ $sub->grade >= 75 ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-rose-50 text-rose-800 border border-rose-200' }}">
                                            {{ $sub->grade }} / 100
                                        </span>
                                    @else
                                        <span class="text-slate-400 font-mono text-xs italic">Belum Dinilai</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-slate-600 max-w-xs">
                                    {{ $sub->mentor_feedback ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-10 text-center text-slate-400">
                                    Belum ada berkas tugas PKL yang dikumpulkan oleh siswa ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
