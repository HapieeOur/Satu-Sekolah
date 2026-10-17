<x-app-layout title="Daftar Siswa Bimbingan PKL">
    <x-slot name="header">
        Pembimbing: Siswa Bimbingan
    </x-slot>

    <div class="space-y-6">
        <!-- Hero Header -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 p-6 md:p-8 text-white shadow-xl">
            <div class="absolute -top-16 -right-16 w-64 h-64 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-16 -left-16 w-64 h-64 bg-teal-500/15 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2 max-w-2xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/20 border border-indigo-400/30 text-indigo-300 text-xs font-semibold backdrop-blur-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <span>Monitoring Pembinaan Praktik</span>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-white">
                        Siswa Bimbingan PKL
                    </h1>
                    <p class="text-slate-300 text-xs md:text-sm leading-relaxed">
                        Pantau seluruh peserta didik bimbingan yang terdaftar pada mitra industri, cek riwayat absensi, evaluasi jurnal aktivitas, dan rekap penilaian tugas.
                    </p>
                </div>
                
                <div class="flex items-center gap-3">
                    <div class="px-4 py-3 rounded-xl bg-white/10 border border-white/10 text-center backdrop-blur-sm">
                        <span class="text-2xl font-black text-white block">{{ $mentees->count() }}</span>
                        <span class="text-[11px] font-medium text-indigo-200">Total Binaan</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mentees Table Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="p-5 md:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-base font-bold text-slate-900">Daftar Siswa Binaan Aktif</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Penempatan kerja praktik di berbagai mitra industri dan instansi</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-800">
                    <thead class="bg-slate-50/80 border-b border-slate-200/80 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">
                        <tr>
                            <th scope="col" class="py-3.5 px-4 w-14 text-center">No</th>
                            <th scope="col" class="py-3.5 px-4">Siswa & Rombel</th>
                            <th scope="col" class="py-3.5 px-4">Mitra Perusahaan</th>
                            <th scope="col" class="py-3.5 px-4">Divisi / Penempatan</th>
                            <th scope="col" class="py-3.5 px-4">Periode Pelaksanaan</th>
                            <th scope="col" class="py-3.5 px-4">Status Penempatan</th>
                            <th scope="col" class="py-3.5 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($mentees as $index => $placement)
                            <tr class="hover:bg-indigo-50/30 transition-colors duration-150">
                                <td class="py-4 px-4 text-center font-mono text-slate-400 font-medium">
                                    {{ $index + 1 }}
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-slate-900 text-white font-bold text-xs flex items-center justify-center shrink-0 shadow-sm">
                                            {{ strtoupper(substr($placement->student->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900 leading-snug">{{ $placement->student->name }}</p>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-mono bg-slate-100 text-slate-600 border border-slate-200">
                                                    NIS {{ $placement->student->nis }}
                                                </span>
                                                <span class="text-[11px] text-slate-500 font-medium">
                                                    {{ $placement->student->classroom?->name ?? 'Belum ada kelas' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="space-y-0.5">
                                        <p class="font-bold text-slate-800 flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-indigo-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                            <span>{{ $placement->company->name }}</span>
                                        </p>
                                        <p class="text-[11px] text-slate-400 truncate max-w-xs pl-5">{{ $placement->company->address }}</p>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200/60">
                                        <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                        <span>{{ $placement->department ?: 'Umum / Teknis' }}</span>
                                    </span>
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <div class="flex items-center gap-1.5 font-mono text-slate-700 text-xs">
                                        <span class="font-bold text-slate-800">{{ $placement->start_date->format('d/m/Y') }}</span>
                                        <span class="text-slate-400">&rarr;</span>
                                        <span class="font-bold text-slate-800">{{ $placement->end_date->format('d/m/Y') }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $placement->status->badgeClass() }}">
                                        {{ $placement->status->label() }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-right whitespace-nowrap">
                                    <a href="{{ route('internship-mentor.students.show', $placement->id) }}"
                                       class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200/60 rounded-xl transition shadow-2xs">
                                        <span>Portofolio & Progres</span>
                                        <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center">
                                    <div class="max-w-xs mx-auto text-center space-y-2">
                                        <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                        </div>
                                        <p class="font-bold text-slate-700 text-sm">Belum Ada Siswa Bimbingan</p>
                                        <p class="text-xs text-slate-500">Anda belum ditugaskan untuk membimbing siswa PKL pada periode aktif.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
