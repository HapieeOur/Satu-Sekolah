<x-app-layout title="Detail Siswa Bimbingan PKL">
    <x-slot name="header">
        Pembimbing: Detail Siswa Bimbingan
    </x-slot>

    <div class="space-y-6">
        <!-- Back Navigation & Header -->
        <div class="flex items-center gap-3">
            <a href="{{ route('internship-mentor.students.index') }}" class="p-2 rounded-lg bg-surface hover:bg-slate-100 text-slate-600 border border-border transition min-h-[44px] min-w-[44px] flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h1 class="text-xl font-bold text-navy">{{ $placement->student->name }}</h1>
                <p class="text-xs text-slate-600 mt-0.5">NIS: {{ $placement->student->nis }} &bull; Kelas {{ $placement->student->classroom?->name ?? '-' }} &bull; {{ $placement->company->name }}</p>
            </div>
        </div>

        <!-- Overview Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Student & Placement Details -->
            <div class="bg-surface rounded-xl border border-border p-5 shadow-sm space-y-4">
                <h2 class="text-sm font-bold text-navy border-b border-border pb-2">Informasi Siswa & Penempatan</h2>
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
                <h2 class="text-sm font-bold text-navy border-b border-border pb-2">Informasi Mitra Industri & Geofence</h2>
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

        <!-- Quick Action Links -->
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('internship-mentor.attendances.index', ['search' => $placement->student->name]) }}"
               class="px-4 py-2 bg-navy hover:bg-navy-light text-white text-xs font-semibold rounded-lg transition min-h-[44px] inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Lihat Riwayat Presensi Siswa</span>
            </a>
            <a href="{{ route('internship-mentor.journals.index', ['search' => $placement->student->name]) }}"
               class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-semibold rounded-lg transition min-h-[44px] inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                <span>Lihat Jurnal Kegiatan Siswa</span>
            </a>
        </div>
    </div>
</x-app-layout>
