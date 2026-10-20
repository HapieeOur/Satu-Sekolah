<x-app-layout title="Informasi PKL Siswa">
    <x-slot name="header">
        Portal Siswa &mdash; Informasi Praktik Kerja Lapangan (PKL)
    </x-slot>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-navy tracking-tight">Informasi Praktik Kerja Lapangan (PKL)</h1>
                <p class="text-xs text-slate-500 mt-0.5">
                    Data penempatan Dunia Usaha / Dunia Industri (DUDI), kontak pembimbing, dan ketentuan magang.
                </p>
            </div>
            <a href="{{ route('student.dashboard') }}" class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50 transition shadow-xs flex items-center gap-1.5 self-start sm:self-auto cursor-pointer">
                &larr; Kembali ke Beranda
            </a>
        </div>

        @if (! $activePlacement)
            <div class="bg-white rounded-3xl border border-slate-200/90 p-12 text-center shadow-xs">
                <div class="w-16 h-16 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <h3 class="text-base font-extrabold text-navy mb-1">Belum Ada Penempatan PKL Aktif</h3>
                <p class="text-xs text-slate-500 max-w-md mx-auto">
                    Saat ini Anda berstatus KBM reguler di sekolah atau penempatan magang industri belum diterbitkan oleh bagian Hubungan Industri (Hubin).
                </p>
            </div>
        @else
            <!-- Active Placement Banner -->
            <div class="bg-gradient-to-r from-sky-900 via-indigo-900 to-[#171B61] text-white p-6 sm:p-8 rounded-3xl shadow-lg border border-sky-500/20">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <span class="inline-block px-3 py-1 rounded-full text-[11px] font-bold bg-white/10 border border-white/20 text-sky-300 mb-2">
                            ✓ Status Penempatan: Magang Aktif
                        </span>
                        <h2 class="text-2xl font-black text-white tracking-tight">{{ $activePlacement->company->name }}</h2>
                        <p class="text-xs text-sky-100/90 mt-1 max-w-2xl font-medium">
                            {{ $activePlacement->company->address }}
                        </p>
                    </div>
                    <div class="p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 text-center min-w-[160px] shrink-0">
                        <span class="text-[10px] uppercase font-bold text-sky-200 block">Radius Geofence GPS</span>
                        <span class="text-2xl font-black text-white block mt-0.5">{{ $activePlacement->company->radius_meters }}m</span>
                        <span class="text-[10px] text-sky-200/80 block">Presensi Mobile Aktif</span>
                    </div>
                </div>
            </div>

            <!-- 2 Column Details: Left (Company & Location), Right (Mentor & Dates) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Mitra Industri Info -->
                <div class="bg-white rounded-3xl border border-slate-200/90 p-6 shadow-xs space-y-4">
                    <h3 class="text-sm font-black text-navy uppercase tracking-wider pb-3 border-b border-slate-100 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-sky-500"></span>
                        <span>Profil Perusahaan Mitra</span>
                    </h3>

                    <div class="space-y-3 text-xs">
                        <div>
                            <span class="text-slate-400 block text-[10px] font-bold uppercase">Nama Perusahaan</span>
                            <span class="font-bold text-navy text-sm">{{ $activePlacement->company->name }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[10px] font-bold uppercase">Alamat Kantor</span>
                            <span class="text-slate-700 leading-relaxed">{{ $activePlacement->company->address }}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-4 pt-1">
                            <div>
                                <span class="text-slate-400 block text-[10px] font-bold uppercase">Kontak Person / HR</span>
                                <span class="font-semibold text-navy">{{ $activePlacement->company->contact_person ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[10px] font-bold uppercase">Telepon Kantor</span>
                                <span class="font-mono text-slate-700">{{ $activePlacement->company->phone ?? '-' }}</span>
                            </div>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[10px] font-bold uppercase">Email Kantor</span>
                            <span class="text-brand font-medium">{{ $activePlacement->company->email ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Pembimbing & Periode Magang -->
                <div class="bg-white rounded-3xl border border-slate-200/90 p-6 shadow-xs space-y-4">
                    <h3 class="text-sm font-black text-navy uppercase tracking-wider pb-3 border-b border-slate-100 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-indigo-500"></span>
                        <span>Pembimbing &amp; Periode</span>
                    </h3>

                    <div class="space-y-3 text-xs">
                        <div class="p-3.5 rounded-2xl bg-indigo-50/60 border border-indigo-100">
                            <span class="text-[10px] font-bold text-brand uppercase tracking-wider block">Guru Pembimbing PKL</span>
                            <span class="font-black text-navy text-sm block mt-0.5">
                                {{ $activePlacement->teacher?->user?->name ?? 'Belum Ditugaskan' }}
                            </span>
                            <span class="text-[11px] text-slate-500 font-mono block mt-0.5">
                                NIP: {{ $activePlacement->teacher?->nip ?? '-' }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <span class="text-slate-400 block text-[10px] font-bold uppercase">Tanggal Mulai</span>
                                <span class="font-bold text-navy">
                                    {{ \Carbon\Carbon::parse($activePlacement->start_date)->translatedFormat('d F Y') }}
                                </span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[10px] font-bold uppercase">Tanggal Selesai</span>
                                <span class="font-bold text-navy">
                                    {{ \Carbon\Carbon::parse($activePlacement->end_date)->translatedFormat('d F Y') }}
                                </span>
                            </div>
                        </div>

                        <div>
                            <span class="text-slate-400 block text-[10px] font-bold uppercase">Tahun Ajaran Penempatan</span>
                            <span class="font-semibold text-slate-700">{{ $activePlacement->academicYear?->name ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent PKL Attendances -->
            @if ($activePlacement->attendances->isNotEmpty())
                <div class="bg-white rounded-3xl border border-slate-200/90 overflow-hidden shadow-xs">
                    <div class="px-6 py-4 bg-slate-50/80 border-b border-slate-100">
                        <h3 class="font-extrabold text-sm text-navy">Riwayat Presensi PKL Terakhir</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-50/40 text-slate-500 uppercase font-bold text-[10px] border-b border-slate-100">
                                <tr>
                                    <th class="py-3 px-6">Tanggal</th>
                                    <th class="py-3 px-6">Check In</th>
                                    <th class="py-3 px-6">Check Out</th>
                                    <th class="py-3 px-6">Status Kehadiran</th>
                                    <th class="py-3 px-6">Status Verifikasi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($activePlacement->attendances as $att)
                                    <tr class="hover:bg-slate-50/60">
                                        <td class="py-3 px-6 font-mono font-bold text-navy">
                                            {{ \Carbon\Carbon::parse($att->date)->format('d/m/Y') }}
                                        </td>
                                        <td class="py-3 px-6 font-mono text-slate-600">
                                            {{ $att->check_in_time ? substr((string) $att->check_in_time, 0, 5) : '-' }}
                                        </td>
                                        <td class="py-3 px-6 font-mono text-slate-600">
                                            {{ $att->check_out_time ? substr((string) $att->check_out_time, 0, 5) : '-' }}
                                        </td>
                                        <td class="py-3 px-6">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $att->status->badgeClass() }}">
                                                {{ $att->status->label() }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-6">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $att->verification_status?->value === 'verified' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                                                {{ ucfirst($att->verification_status?->value ?? 'Pending') }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        @endif
    </div>
</x-app-layout>
