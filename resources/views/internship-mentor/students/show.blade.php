<x-app-layout title="Portofolio Siswa Bimbingan PKL">
    <x-slot name="header">
        Pembimbing: Portofolio & Rekap Siswa Bimbingan
    </x-slot>

    <div class="space-y-6">
        <!-- Back Navigation & Student Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('internship-mentor.students.index') }}" class="p-2 rounded-lg bg-surface hover:bg-slate-100 text-slate-600 border border-border transition min-h-[44px] min-w-[44px] flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold border {{ $placement->status->badgeClass() }}">
                            {{ $placement->status->label() }}
                        </span>
                        <span class="text-xs text-slate-500 font-mono">NIS: {{ $placement->student->nis }}</span>
                    </div>
                    <h1 class="text-xl font-bold text-navy">{{ $placement->student->name }}</h1>
                    <p class="text-xs text-slate-600 mt-0.5">Kelas {{ $placement->student->classroom?->name ?? '-' }} &bull; Mitra: <span class="font-semibold text-navy">{{ $placement->company->name }}</span> (Divisi: {{ $placement->department ?: 'Umum' }})</p>
                </div>
            </div>

            <!-- Quick Action Links -->
            <div class="flex flex-wrap items-center gap-2.5">
                <a href="{{ route('internship-mentor.attendances.index', ['search' => $placement->student->name]) }}"
                   class="px-3.5 py-2 bg-navy hover:bg-navy-light text-white text-xs font-semibold rounded-lg transition min-h-[40px] inline-flex items-center gap-2 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Presensi Siswa</span>
                </a>
                <a href="{{ route('internship-mentor.journals.index', ['search' => $placement->student->name]) }}"
                   class="px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-border text-xs font-semibold rounded-lg transition min-h-[40px] inline-flex items-center gap-2 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    <span>Jurnal Siswa</span>
                </a>
            </div>
        </div>

        <!-- Student Progress Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Attendance Metric -->
            <div class="bg-surface rounded-xl p-5 border border-border shadow-sm">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 block">Total Presensi PKL</span>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl font-extrabold text-navy">{{ $attendanceSummary['total'] }}</span>
                    <span class="text-xs text-slate-400">hari tercatat</span>
                </div>
                <div class="mt-2 flex flex-wrap gap-1 text-[11px] text-slate-600">
                    <span class="text-emerald-700 font-semibold">{{ $attendanceSummary['hadir'] }} Hadir</span> &bull;
                    <span class="text-amber-700 font-semibold">{{ $attendanceSummary['terlambat'] }} Terlambat</span> &bull;
                    <span class="text-blue-700">{{ $attendanceSummary['izin'] + $attendanceSummary['sakit'] }} Izin/Sakit</span> &bull;
                    <span class="{{ $attendanceSummary['alpa'] > 0 ? 'text-rose-700 font-bold' : 'text-slate-500' }}">{{ $attendanceSummary['alpa'] }} Alpa</span>
                </div>
            </div>

            <!-- Journal Metric -->
            <div class="bg-surface rounded-xl p-5 border border-border shadow-sm">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 block">Jurnal Harian Aktivitas</span>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl font-extrabold text-emerald-700">{{ $journalSummary['approved'] }}</span>
                    <span class="text-xs text-slate-400">/ {{ $journalSummary['total'] }} disetujui</span>
                </div>
                <div class="mt-2 flex items-center gap-2 text-[11px]">
                    <span class="text-amber-700 font-semibold">{{ $journalSummary['submitted'] }} Menunggu</span> &bull;
                    <span class="text-blue-700 font-semibold">{{ $journalSummary['revision_requested'] }} Revisi</span>
                </div>
            </div>

            <!-- Task Metric -->
            <div class="bg-surface rounded-xl p-5 border border-border shadow-sm">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 block">Pengumpulan Tugas PKL</span>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl font-extrabold text-navy">{{ $taskSubmissions->count() }}</span>
                    <span class="text-xs text-slate-400">tugas diserahkan</span>
                </div>
                <p class="mt-2 text-[11px] text-slate-500">
                    {{ $taskSubmissions->whereNotNull('grade')->count() }} telah dinilai oleh pembimbing
                </p>
            </div>

            <!-- Average Grade Metric -->
            <div class="bg-surface rounded-xl p-5 border border-border shadow-sm">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 block">Rata-Rata Nilai Tugas</span>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl font-extrabold {{ $averageGrade !== null ? ($averageGrade >= 75 ? 'text-emerald-700' : 'text-amber-700') : 'text-slate-400' }}">
                        {{ $averageGrade !== null ? $averageGrade : '-' }}
                    </span>
                    <span class="text-xs text-slate-400">/ 100</span>
                </div>
                <p class="mt-2 text-[11px] text-slate-500">
                    {{ $averageGrade !== null ? 'Kriteria evaluasi tugas PKL' : 'Belum ada penilaian' }}
                </p>
            </div>
        </div>

        <!-- Overview Details Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Student & Placement Details -->
            <div class="bg-surface rounded-xl border border-border p-5 shadow-sm space-y-4">
                <h2 class="text-xs font-bold text-navy uppercase tracking-wider border-b border-border pb-2">Informasi Siswa & Penempatan</h2>
                <div class="space-y-2 text-xs">
                    <div class="flex justify-between py-1 border-b border-slate-100">
                        <span class="text-slate-500">Nama Lengkap</span>
                        <span class="font-semibold text-slate-800">{{ $placement->student->name }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-100">
                        <span class="text-slate-500">NIS / NISN</span>
                        <span class="font-mono text-slate-800">{{ $placement->student->nis }} / {{ $placement->student->nisn }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-100">
                        <span class="text-slate-500">Program Keahlian</span>
                        <span class="font-medium text-slate-800">{{ $placement->student->classroom?->major ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-100">
                        <span class="text-slate-500">Nomor Telepon</span>
                        <span class="font-mono text-slate-800">{{ $placement->student->phone ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-100">
                        <span class="text-slate-500">Kontak Orang Tua / Wali</span>
                        <span class="text-slate-800">{{ $placement->student->parent_name }} ({{ $placement->student->parent_phone }})</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-100">
                        <span class="text-slate-500">Periode PKL</span>
                        <span class="font-mono text-slate-800">{{ $placement->start_date->format('d M Y') }} — {{ $placement->end_date->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span class="text-slate-500">Status Penempatan</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold border {{ $placement->status->badgeClass() }}">
                            {{ $placement->status->label() }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Company & Geofence Details -->
            <div class="bg-surface rounded-xl border border-border p-5 shadow-sm space-y-4">
                <h2 class="text-xs font-bold text-navy uppercase tracking-wider border-b border-border pb-2">Informasi Mitra Industri & Geofence</h2>
                <div class="space-y-2 text-xs">
                    <div class="flex justify-between py-1 border-b border-slate-100">
                        <span class="text-slate-500">Perusahaan Mitra</span>
                        <span class="font-semibold text-slate-800">{{ $placement->company->name }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-100">
                        <span class="text-slate-500">Divisi / Penugasan</span>
                        <span class="font-medium text-slate-800">{{ $placement->department ?: 'Umum' }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-100">
                        <span class="text-slate-500">Penanggung Jawab (PIC)</span>
                        <span class="text-slate-800">{{ $placement->company->contact_person ?? '-' }} ({{ $placement->company->phone ?? '-' }})</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-100">
                        <span class="text-slate-500">Alamat Kantor</span>
                        <span class="text-slate-800 text-right max-w-xs">{{ $placement->company->address }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-100">
                        <span class="text-slate-500">Koordinat Kantor (Lat, Long)</span>
                        <span class="font-mono text-slate-800">{{ $placement->company->latitude ?? '-' }}, {{ $placement->company->longitude ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span class="text-slate-500">Batas Toleransi Radius</span>
                        <span class="font-bold text-navy">{{ $placement->company->radius_meters }} meter</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity Tables: Presensi & Jurnal Terakhir -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Attendances -->
            <div class="bg-surface rounded-xl border border-border shadow-sm overflow-hidden flex flex-col">
                <div class="p-4 border-b border-border flex items-center justify-between">
                    <h3 class="text-xs font-bold text-navy uppercase tracking-wider">Presensi Terakhir</h3>
                    <a href="{{ route('internship-mentor.attendances.index', ['search' => $placement->student->name]) }}" class="text-xs font-semibold text-brand hover:underline">
                        Lihat Seluruh Presensi &rarr;
                    </a>
                </div>

                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 border-b border-border text-slate-700 font-semibold uppercase tracking-wider text-[11px]">
                            <tr>
                                <th class="py-2.5 px-4">Tanggal</th>
                                <th class="py-2.5 px-4">Masuk / Keluar</th>
                                <th class="py-2.5 px-4">Status</th>
                                <th class="py-2.5 px-4">Verifikasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @forelse($recentAttendances as $att)
                                <tr class="hover:bg-slate-50/75 transition">
                                    <td class="py-2.5 px-4 font-mono text-slate-700">{{ $att->date->format('d/m/Y') }}</td>
                                    <td class="py-2.5 px-4 font-mono text-slate-600">
                                        {{ $att->check_in_time ? substr($att->check_in_time, 0, 5) : '-' }} /
                                        {{ $att->check_out_time ? substr($att->check_out_time, 0, 5) : '-' }}
                                    </td>
                                    <td class="py-2.5 px-4">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold {{ $att->status->badgeClass() }}">
                                            {{ $att->status->label() }}
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-4">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold border {{ $att->verification_status->badgeClass() }}">
                                            {{ $att->verification_status->label() }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-6 text-center text-slate-500">
                                        Belum ada riwayat presensi tercatat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Journals -->
            <div class="bg-surface rounded-xl border border-border shadow-sm overflow-hidden flex flex-col">
                <div class="p-4 border-b border-border flex items-center justify-between">
                    <h3 class="text-xs font-bold text-navy uppercase tracking-wider">Jurnal Harian Terakhir</h3>
                    <a href="{{ route('internship-mentor.journals.index', ['search' => $placement->student->name]) }}" class="text-xs font-semibold text-brand hover:underline">
                        Lihat Seluruh Jurnal &rarr;
                    </a>
                </div>

                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 border-b border-border text-slate-700 font-semibold uppercase tracking-wider text-[11px]">
                            <tr>
                                <th class="py-2.5 px-4">Tanggal</th>
                                <th class="py-2.5 px-4">Aktivitas</th>
                                <th class="py-2.5 px-4">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @forelse($recentJournals as $jr)
                                <tr class="hover:bg-slate-50/75 transition">
                                    <td class="py-2.5 px-4 font-mono text-slate-700">{{ $jr->date->format('d/m/Y') }}</td>
                                    <td class="py-2.5 px-4">
                                        <p class="font-semibold text-navy">{{ $jr->title }}</p>
                                        <p class="text-[11px] text-slate-500 line-clamp-1">{{ Str::limit($jr->activity_description, 60) }}</p>
                                    </td>
                                    <td class="py-2.5 px-4">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold border {{ $jr->status->badgeClass() }}">
                                            {{ $jr->status->label() }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-6 text-center text-slate-500">
                                        Belum ada jurnal harian yang dikirimkan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Task Submissions & Grades Table -->
        <div class="bg-surface rounded-xl border border-border shadow-sm overflow-hidden">
            <div class="p-5 border-b border-border flex items-center justify-between">
                <div>
                    <h3 class="text-xs font-bold text-navy uppercase tracking-wider">Pengumpulan Tugas PKL Siswa</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Daftar tugas bimbingan yang telah diserahkan dan nilai evaluasi</p>
                </div>
                <a href="{{ route('internship-mentor.tasks.index') }}" class="text-xs font-semibold text-brand hover:underline">
                    Daftar Tugas PKL &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 border-b border-border text-slate-700 font-semibold uppercase tracking-wider text-[11px]">
                        <tr>
                            <th class="py-3 px-4">Judul Tugas</th>
                            <th class="py-3 px-4">Batas Pengumpulan</th>
                            <th class="py-3 px-4">Waktu Penyerahan</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4">Nilai</th>
                            <th class="py-3 px-4">Catatan Mentor</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse($taskSubmissions as $sub)
                            <tr class="hover:bg-slate-50/75 transition">
                                <td class="py-3 px-4 font-semibold text-navy">{{ $sub->task->title }}</td>
                                <td class="py-3 px-4 font-mono text-slate-600">{{ $sub->task->due_date ? $sub->task->due_date->format('d/m/Y') : '-' }}</td>
                                <td class="py-3 px-4 font-mono text-slate-600">{{ $sub->submitted_at ? $sub->submitted_at->format('d/m/Y H:i') : '-' }}</td>
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold border {{ $sub->status->badgeClass() }}">
                                        {{ $sub->status->label() }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 font-bold {{ $sub->grade !== null ? ($sub->grade >= 75 ? 'text-emerald-700' : 'text-amber-700') : 'text-slate-400' }}">
                                    {{ $sub->grade !== null ? $sub->grade : 'Belum Dinilai' }}
                                </td>
                                <td class="py-3 px-4 text-slate-600">{{ $sub->mentor_feedback ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-500">
                                    Belum ada pengumpulan tugas PKL dari siswa ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
