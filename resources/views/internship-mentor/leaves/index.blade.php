<x-app-layout title="Permohonan Izin / Sakit PKL">
    <x-slot name="header">
        Pembimbing: Pengajuan Izin / Sakit PKL
    </x-slot>

    <div class="space-y-6">
        <!-- Hero Header -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 p-6 md:p-8 text-white shadow-xl">
            <div class="absolute -top-16 -right-16 w-64 h-64 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-16 -left-16 w-64 h-64 bg-blue-500/15 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2 max-w-2xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/20 border border-indigo-400/30 text-indigo-300 text-xs font-semibold backdrop-blur-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Verifikasi Kehadiran & Dispensasi</span>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-white">
                        Permohonan Izin / Sakit Siswa
                    </h1>
                    <p class="text-slate-300 text-xs md:text-sm leading-relaxed">
                        Tinjau dan proses permohonan dispensasi ketidakhadiran kerja praktik lapangan dari siswa binaan Anda secara tertib dan transparan.
                    </p>
                </div>
                
                <div class="flex items-center gap-3">
                    <a href="{{ route('internship-mentor.students.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/15 border border-white/10 text-xs font-semibold text-white transition backdrop-blur-sm">
                        <svg class="w-4 h-4 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        <span>Daftar Siswa Binaan</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 md:p-6 shadow-sm">
            <form method="GET" action="{{ route('internship-mentor.leaves.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-end">
                <div class="sm:col-span-5">
                    <label for="type" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Jenis Permohonan</label>
                    <div class="relative">
                        <select name="type" id="type" class="w-full py-2.5 px-3.5 text-xs rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 bg-slate-50/50 hover:bg-white text-slate-800 transition appearance-none">
                            <option value="">Semua Jenis Permohonan</option>
                            <option value="izin" {{ ($filters['type'] ?? '') == 'izin' ? 'selected' : '' }}>Izin Keperluan</option>
                            <option value="sakit" {{ ($filters['type'] ?? '') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                </div>

                <div class="sm:col-span-4">
                    <label for="status" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Status Persetujuan</label>
                    <div class="relative">
                        <select name="status" id="status" class="w-full py-2.5 px-3.5 text-xs rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 bg-slate-50/50 hover:bg-white text-slate-800 transition appearance-none">
                            <option value="">Semua Status Persetujuan</option>
                            @foreach ($statuses as $st)
                                <option value="{{ $st->value }}" {{ ($filters['status'] ?? '') == $st->value ? 'selected' : '' }}>
                                    {{ $st->label() }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                </div>

                <div class="sm:col-span-3 flex items-center gap-2">
                    <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl shadow-md shadow-indigo-600/20 hover:shadow-indigo-600/30 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                        <span>Filter Data</span>
                    </button>
                    @if (! empty(array_filter($filters)))
                        <a href="{{ route('internship-mentor.leaves.index') }}" class="px-3 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl transition" title="Reset filter">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Leave Requests Table Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-800">
                    <thead class="bg-slate-50/80 border-b border-slate-200/80 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">
                        <tr>
                            <th scope="col" class="py-3.5 px-4 w-14 text-center">No</th>
                            <th scope="col" class="py-3.5 px-4">Siswa Bimbingan</th>
                            <th scope="col" class="py-3.5 px-4">Jenis Dispensasi</th>
                            <th scope="col" class="py-3.5 px-4">Rentang Waktu</th>
                            <th scope="col" class="py-3.5 px-4">Alasan & Dokumen</th>
                            <th scope="col" class="py-3.5 px-4">Status & Catatan Review</th>
                            <th scope="col" class="py-3.5 px-4 text-right">Tindakan Validasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($leaveRequests as $index => $leave)
                            <tr class="hover:bg-indigo-50/30 transition-colors duration-150">
                                <td class="py-4 px-4 text-center font-mono text-slate-400 font-medium">
                                    {{ $leaveRequests->firstItem() + $index }}
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-slate-900 text-white font-bold text-xs flex items-center justify-center shrink-0 shadow-sm">
                                            {{ strtoupper(substr($leave->placement->student->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900 leading-snug">{{ $leave->placement->student->name }}</p>
                                            <p class="text-[11px] text-slate-500 flex items-center gap-1 mt-0.5">
                                                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                                <span class="truncate max-w-[170px]">{{ $leave->placement->company->name }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $leave->type->badgeClass() }}">
                                        @if($leave->type->value === 'sakit')
                                            <svg class="w-3 h-3 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                        @else
                                            <svg class="w-3 h-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        @endif
                                        <span>{{ $leave->type->label() }}</span>
                                    </span>
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <div class="flex items-center gap-1.5 font-mono text-slate-700 text-xs">
                                        <span class="font-bold text-slate-800">{{ $leave->start_date->format('d/m/Y') }}</span>
                                        <span class="text-slate-400">&rarr;</span>
                                        <span class="font-bold text-slate-800">{{ $leave->end_date->format('d/m/Y') }}</span>
                                    </div>
                                    <span class="text-[11px] text-slate-400 mt-0.5 block">
                                        {{ $leave->start_date->diffInDays($leave->end_date) + 1 }} hari kalender
                                    </span>
                                </td>
                                <td class="py-4 px-4 max-w-xs">
                                    <p class="text-slate-700 leading-relaxed line-clamp-2">{{ $leave->reason }}</p>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="space-y-1.5">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $leave->status->badgeClass() }}">
                                            {{ $leave->status->label() }}
                                        </span>
                                        @if($leave->review_notes)
                                            <div class="text-[11px] text-slate-600 bg-slate-50 border border-slate-200/80 rounded-xl p-2 max-w-xs shadow-2xs">
                                                {{ $leave->review_notes }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-right whitespace-nowrap">
                                    @if($leave->status->value === 'pending')
                                        <div class="inline-flex items-center gap-1.5">
                                            <form method="POST" action="{{ route('internship-mentor.leaves.review', $leave->id) }}" class="inline-block">
                                                @csrf
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200/60 rounded-xl transition shadow-2xs">
                                                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                    <span>Setujui</span>
                                                </button>
                                            </form>

                                            <form method="POST" action="{{ route('internship-mentor.leaves.review', $leave->id) }}" class="inline-block" onsubmit="return confirm('Tolak permohonan dispensasi siswa ini?');">
                                                @csrf
                                                <input type="hidden" name="status" value="rejected">
                                                <input type="hidden" name="review_notes" value="Ditolak oleh pembimbing sekolah">
                                                <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200/60 rounded-xl transition shadow-2xs">
                                                    <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                    <span>Tolak</span>
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-full">
                                            <svg class="w-3.5 h-3.5 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                            <span>Selesai Ditinjau</span>
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center">
                                    <div class="max-w-xs mx-auto text-center space-y-2">
                                        <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        </div>
                                        <p class="font-bold text-slate-700 text-sm">Tidak Ada Permohonan</p>
                                        <p class="text-xs text-slate-500">Belum ada permohonan izin atau sakit dari siswa yang membutuhkan peninjauan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($leaveRequests->hasPages())
                <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $leaveRequests->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
