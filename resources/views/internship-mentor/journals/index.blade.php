<x-app-layout title="Jurnal Harian Siswa PKL">
    <x-slot name="header">
        Pembimbing: Jurnal Harian Siswa
    </x-slot>

    <div class="space-y-6">
        <!-- Hero Header -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 p-6 md:p-8 text-white shadow-xl">
            <div class="absolute -top-16 -right-16 w-64 h-64 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-16 -left-16 w-64 h-64 bg-emerald-500/15 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2 max-w-2xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/20 border border-indigo-400/30 text-indigo-300 text-xs font-semibold backdrop-blur-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        <span>Verifikasi Aktivitas Harian</span>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-white">
                        Jurnal Harian Siswa Bimbingan
                    </h1>
                    <p class="text-slate-300 text-xs md:text-sm leading-relaxed">
                        Tinjau laporan kinerja berkala dari siswa bimbingan PKL, berikan persetujuan mandiri atau instruksi revisi yang terarah.
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
            <form method="GET" action="{{ route('internship-mentor.journals.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-end">
                <div class="sm:col-span-5">
                    <label for="search" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Pencarian Siswa / Aktivitas</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="text" name="search" id="search" value="{{ $filters['search'] ?? '' }}" placeholder="Nama siswa bimbingan atau judul jurnal..."
                               class="w-full pl-10 pr-4 py-2.5 text-xs rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 bg-slate-50/50 hover:bg-white text-slate-800 transition">
                    </div>
                </div>

                <div class="sm:col-span-4">
                    <label for="status" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Status Validasi</label>
                    <div class="relative">
                        <select name="status" id="status" class="w-full py-2.5 px-3.5 text-xs rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 bg-slate-50/50 hover:bg-white text-slate-800 transition appearance-none">
                            <option value="">Semua Status Validasi</option>
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
                        <span>Filter Jurnal</span>
                    </button>
                    @if (! empty(array_filter($filters)))
                        <a href="{{ route('internship-mentor.journals.index') }}" class="px-3 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl transition" title="Reset filter">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Journals Table Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-800">
                    <thead class="bg-slate-50/80 border-b border-slate-200/80 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">
                        <tr>
                            <th scope="col" class="py-3.5 px-4 w-14 text-center">No</th>
                            <th scope="col" class="py-3.5 px-4">Tanggal</th>
                            <th scope="col" class="py-3.5 px-4">Siswa Bimbingan</th>
                            <th scope="col" class="py-3.5 px-4">Judul & Ringkasan Kegiatan</th>
                            <th scope="col" class="py-3.5 px-4">Status & Catatan Review</th>
                            <th scope="col" class="py-3.5 px-4 text-right">Tindakan Validasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($journals as $index => $jr)
                            <tr class="hover:bg-indigo-50/30 transition-colors duration-150">
                                <td class="py-4 px-4 text-center font-mono text-slate-400 font-medium">
                                    {{ $journals->firstItem() + $index }}
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                        <div>
                                            <span class="font-bold text-slate-800 block">{{ $jr->date->format('d M Y') }}</span>
                                            <span class="text-[11px] text-slate-400 font-mono">{{ $jr->date->translatedFormat('l') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-slate-900 text-white font-bold text-xs flex items-center justify-center shrink-0 shadow-sm">
                                            {{ strtoupper(substr($jr->placement->student->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900 leading-snug">{{ $jr->placement->student->name }}</p>
                                            <p class="text-[11px] text-slate-500 flex items-center gap-1 mt-0.5">
                                                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                                <span class="truncate max-w-[180px]">{{ $jr->placement->company->name }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4 max-w-sm">
                                    <p class="font-semibold text-slate-900 text-xs">{{ $jr->title }}</p>
                                    <p class="text-[11px] text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                                        {{ $jr->activity_description }}
                                    </p>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="space-y-1.5">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $jr->status->badgeClass() }}">
                                            {{ $jr->status->label() }}
                                        </span>
                                        @if($jr->mentor_notes)
                                            <div class="text-[11px] text-slate-700 bg-slate-50 border border-slate-200/80 rounded-xl p-2.5 max-w-xs shadow-2xs">
                                                <span class="font-bold text-indigo-900 block mb-0.5">Catatan Pembimbing:</span>
                                                <span class="text-slate-600 leading-relaxed">{{ $jr->mentor_notes }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-right whitespace-nowrap">
                                    @if(in_array($jr->status->value, ['submitted', 'revision_requested']))
                                        <div class="inline-flex items-center gap-1.5">
                                            <form method="POST" action="{{ route('internship-mentor.journals.review', $jr->id) }}" class="inline-block">
                                                @csrf
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200/60 rounded-xl transition shadow-2xs">
                                                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                    <span>Setujui</span>
                                                </button>
                                            </form>

                                            <button type="button"
                                                    onclick="openRevisionModal('{{ $jr->id }}', '{{ addslashes($jr->placement->student->name) }}', '{{ addslashes($jr->title) }}')"
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200/60 rounded-xl transition shadow-2xs">
                                                <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                <span>Minta Revisi</span>
                                            </button>
                                        </div>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-700 bg-emerald-50/70 border border-emerald-200/50 px-2.5 py-1 rounded-full">
                                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                            <span>Disetujui</span>
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center">
                                    <div class="max-w-xs mx-auto text-center space-y-2">
                                        <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        </div>
                                        <p class="font-bold text-slate-700 text-sm">Tidak Ada Jurnal Ditemukan</p>
                                        <p class="text-xs text-slate-500">Belum ada catatan jurnal harian dari siswa bimbingan yang sesuai kriteria pencarian.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($journals->hasPages())
                <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $journals->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Revision Modal -->
    <div id="revisionModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-md flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-md w-full p-6 space-y-5 animate-in fade-in zoom-in-95 duration-150">
            <div class="flex items-start justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 border border-amber-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Permintaan Revisi Jurnal</h3>
                        <p class="text-xs text-slate-500">Beri masukan konstruktif untuk siswa</p>
                    </div>
                </div>
                <button type="button" onclick="closeRevisionModal()" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-lg hover:bg-slate-100 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/70 text-xs">
                <span class="text-slate-400 block text-[11px] uppercase font-bold tracking-wider mb-0.5">Siswa & Judul Jurnal</span>
                <p id="revisionInfo" class="font-semibold text-slate-800"></p>
            </div>

            <form id="revisionForm" method="POST" action="" class="space-y-4">
                @csrf
                <input type="hidden" name="status" value="revision_requested">
                <div>
                    <label for="mentor_notes" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Catatan Koreksi / Hal yang Perlu Diperbaiki <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="mentor_notes" id="mentor_notes" required rows="4" 
                              placeholder="Contoh: Tolong jelaskan lebih rinci tahapan konfigurasi database dan sertakan dokumentasi screenshot aktivitas..."
                              class="w-full text-xs rounded-xl border border-slate-200 focus:border-amber-600 focus:ring-2 focus:ring-amber-100 bg-white text-slate-800 p-3 leading-relaxed transition"></textarea>
                </div>

                <div class="pt-2 flex items-center justify-end gap-2.5">
                    <button type="button" onclick="closeRevisionModal()" class="px-4 py-2.5 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition">
                        Batal
                    </button>
                    <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2.5 text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 rounded-xl shadow-md shadow-amber-600/20 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        <span>Kirim Permintaan Revisi</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openRevisionModal(id, studentName, title) {
            const form = document.getElementById('revisionForm');
            form.action = `/internship-mentor/journals/${id}/review`;
            document.getElementById('revisionInfo').textContent = `${studentName} — "${title}"`;
            document.getElementById('mentor_notes').value = '';
            document.getElementById('revisionModal').classList.remove('hidden');
        }

        function closeRevisionModal() {
            document.getElementById('revisionModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
