<x-app-layout title="Tugas PKL & Penilaian">
    <x-slot name="header">
        Pembimbing: Tugas PKL & Penilaian
    </x-slot>

    <div class="space-y-6">
        <!-- Hero Header -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 p-6 md:p-8 text-white shadow-xl">
            <div class="absolute -top-16 -right-16 w-64 h-64 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-16 -left-16 w-64 h-64 bg-blue-500/15 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2 max-w-2xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/20 border border-indigo-400/30 text-indigo-300 text-xs font-semibold backdrop-blur-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        <span>Instruksi & Evaluasi Proyek</span>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-white">
                        Tugas Praktik Kerja Lapangan
                    </h1>
                    <p class="text-slate-300 text-xs md:text-sm leading-relaxed">
                        Terbitkan penugasan terstruktur untuk siswa bimbingan PKL, pantau dokumen yang telah terkumpul, dan berikan skor evaluasi beserta umpan balik.
                    </p>
                </div>
                
                <button type="button" onclick="document.getElementById('newTaskForm').classList.toggle('hidden')"
                        class="inline-flex items-center gap-2 px-5 py-3 text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-lg shadow-indigo-600/30 hover:shadow-indigo-600/40 transition shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Terbitkan Tugas Baru</span>
                </button>
            </div>
        </div>

        <!-- Create Task Form (Collapsible) -->
        <div id="newTaskForm" class="hidden bg-white rounded-2xl border border-slate-200/80 p-6 md:p-8 shadow-sm space-y-5 animate-in fade-in duration-150">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 border border-indigo-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Form Pembuatan Tugas PKL Baru</h2>
                        <p class="text-xs text-slate-500">Tentukan instruksi pengerjaan dan batas akhir pengumpulan</p>
                    </div>
                </div>
                <button type="button" onclick="document.getElementById('newTaskForm').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-lg hover:bg-slate-100 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form method="POST" action="{{ route('internship-mentor.tasks.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Judul Penugasan <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" id="title" required placeholder="Contoh: Laporan Analisis Alur Sistem & Arsitektur Jaringan Perusahaan"
                           class="w-full text-xs rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 bg-white text-slate-800 p-3 transition">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="due_date" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Batas Waktu Pengumpulan (Deadline) <span class="text-rose-500">*</span></label>
                        <input type="datetime-local" name="due_date" id="due_date" required value="{{ now()->addDays(7)->setTime(23, 59)->format('Y-m-d\TH:i') }}" min="{{ now()->format('Y-m-d\TH:i') }}"
                               class="w-full text-xs rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 bg-white text-slate-800 p-3 transition">
                        <p class="text-[11px] text-slate-400 mt-1">Tentukan tanggal dan batas jam & menit penyerahan (WIB).</p>
                    </div>

                    <div>
                        <label for="internship_company_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Target Mitra Industri (Opsional)</label>
                        <select name="internship_company_id" id="internship_company_id" class="w-full text-xs rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 bg-white text-slate-800 p-3 transition">
                            <option value="">Seluruh Siswa Bimbingan (Semua Perusahaan)</option>
                            @foreach ($companies as $comp)
                                <option value="{{ $comp->id }}">{{ $comp->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Deskripsi & Instruksi Pengerjaan <span class="text-rose-500">*</span></label>
                    <textarea name="description" id="description" required rows="4" placeholder="Jelaskan secara rinci format file (PDF/Word), poin yang harus dianalisis, dan kriteria rubrik penilaian..."
                              class="w-full text-xs rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 bg-white text-slate-800 p-3 leading-relaxed transition"></textarea>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button type="button" onclick="document.getElementById('newTaskForm').classList.add('hidden')"
                            class="px-4 py-2.5 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition">
                        Batal
                    </button>
                    <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2.5 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md shadow-indigo-600/20 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Terbitkan Tugas</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Tasks Table Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="p-5 md:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-base font-bold text-slate-900">Daftar Penugasan PKL</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Penugasan mandiri yang aktif dan riwayat penyerahan berkas siswa</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-800">
                    <thead class="bg-slate-50/80 border-b border-slate-200/80 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">
                        <tr>
                            <th scope="col" class="py-3.5 px-4 w-14 text-center">No</th>
                            <th scope="col" class="py-3.5 px-4">Judul Penugasan</th>
                            <th scope="col" class="py-3.5 px-4">Target Perusahaan</th>
                            <th scope="col" class="py-3.5 px-4">Batas Waktu</th>
                            <th scope="col" class="py-3.5 px-4 text-center">Progres Pengumpulan</th>
                            <th scope="col" class="py-3.5 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($tasks as $index => $tsk)
                            <tr class="hover:bg-indigo-50/30 transition-colors duration-150">
                                <td class="py-4 px-4 text-center font-mono text-slate-400 font-medium">
                                    {{ $index + 1 }}
                                </td>
                                <td class="py-4 px-4 max-w-sm">
                                    <p class="font-bold text-slate-900 text-xs">{{ $tsk->title }}</p>
                                    <p class="text-[11px] text-slate-500 mt-1 line-clamp-2 leading-relaxed">{{ $tsk->description }}</p>
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap">
                                    @if($tsk->company)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200/60">
                                            <svg class="w-3 h-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                            <span>{{ $tsk->company->name }}</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                            <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                            <span>Seluruh Siswa Binaan</span>
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                        <div>
                                            <span class="font-bold text-slate-800 block">{{ $tsk->due_date->translatedFormat('d M Y, H:i') }} WIB</span>
                                            <span class="text-[11px] text-slate-400 font-mono">{{ $tsk->due_date->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-center whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $tsk->submissions->count() > 0 ? 'bg-indigo-50 text-indigo-700 border border-indigo-200/60' : 'bg-slate-100 text-slate-500' }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $tsk->submissions->count() > 0 ? 'bg-indigo-600' : 'bg-slate-400' }}"></span>
                                        <span>{{ $tsk->submissions->count() }} Berkas Terkumpul</span>
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-right whitespace-nowrap">
                                    <a href="{{ route('internship-mentor.tasks.show', $tsk->id) }}"
                                       class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200/60 rounded-xl transition shadow-2xs">
                                        <span>Periksa & Nilai</span>
                                        <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center">
                                    <div class="max-w-xs mx-auto text-center space-y-2">
                                        <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                        </div>
                                        <p class="font-bold text-slate-700 text-sm">Belum Ada Tugas Diterbitkan</p>
                                        <p class="text-xs text-slate-500">Gunakan tombol "Terbitkan Tugas Baru" di atas untuk membuat penugasan mandiri pertama.</p>
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
