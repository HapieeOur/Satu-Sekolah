<x-app-layout title="Tugas PKL & Penilaian">
    <x-slot name="header">
        Pembimbing: Tugas PKL & Penilaian
    </x-slot>

    <div class="space-y-6">
        <!-- Header & Action -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-navy">Tugas Praktik Kerja Lapangan (PKL)</h1>
                <p class="text-xs text-slate-600 mt-1">Buat instruksi penugasan kerja mandiri, pantau pengumpulan berkas, dan berikan penilaian berkala.</p>
            </div>
            <button type="button" onclick="document.getElementById('newTaskForm').classList.toggle('hidden')"
                    class="inline-flex items-center gap-2 px-4 py-2.5 text-xs font-semibold text-white bg-brand rounded-lg hover:bg-brand-hover shadow-sm transition shrink-0 min-h-[44px]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Terbitkan Tugas Baru</span>
            </button>
        </div>

        <!-- Create Task Form (Collapsible) -->
        <div id="newTaskForm" class="hidden bg-surface rounded-xl border border-border p-6 shadow-sm space-y-4">
            <h2 class="text-sm font-bold text-navy border-b border-border pb-2">Form Pembuatan Tugas PKL Baru</h2>
            <form method="POST" action="{{ route('internship-mentor.tasks.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Judul Penugasan <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="title" required placeholder="Contoh: Laporan Analisis Alur Sistem Perusahaan"
                           class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="due_date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Batas Waktu Pengumpulan (Deadline) <span class="text-danger">*</span></label>
                        <input type="date" name="due_date" id="due_date" required value="{{ now()->addDays(7)->toDateString() }}"
                               class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
                    </div>

                    <div>
                        <label for="internship_company_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Target Mitra Industri (Opsional)</label>
                        <select name="internship_company_id" id="internship_company_id" class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
                            <option value="">Semua Perusahaan Binaan</option>
                            @foreach ($companies as $comp)
                                <option value="{{ $comp->id }}">{{ $comp->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi & Instruksi Pengerjaan <span class="text-danger">*</span></label>
                    <textarea name="description" id="description" required rows="4" placeholder="Jelaskan secara rinci format pengumpulan, poin yang harus dicakup, dan kriteria penilaian..."
                              class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800"></textarea>
                </div>

                <div class="pt-2 flex items-center justify-end gap-2">
                    <button type="button" onclick="document.getElementById('newTaskForm').classList.add('hidden')"
                            class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-lg min-h-[40px]">
                        Tutup Form
                    </button>
                    <button type="submit" class="px-5 py-2 text-xs font-semibold text-white bg-brand hover:bg-brand-hover rounded-lg shadow-sm min-h-[40px]">
                        Terbitkan Tugas
                    </button>
                </div>
            </form>
        </div>

        <!-- Tasks Table -->
        <div class="bg-surface rounded-xl border border-border shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-800">
                    <thead class="bg-slate-50 border-b border-border text-slate-700 font-semibold uppercase tracking-wider text-[11px]">
                        <tr>
                            <th scope="col" class="py-3 px-4 w-12 text-center">No</th>
                            <th scope="col" class="py-3 px-4">Judul Penugasan</th>
                            <th scope="col" class="py-3 px-4">Target Perusahaan</th>
                            <th scope="col" class="py-3 px-4">Batas Pengumpulan</th>
                            <th scope="col" class="py-3 px-4 text-center">Pengumpulan Siswa</th>
                            <th scope="col" class="py-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse ($tasks as $index => $tsk)
                            <tr class="hover:bg-slate-50/75 transition">
                                <td class="py-3.5 px-4 text-center font-mono text-slate-500">{{ $index + 1 }}</td>
                                <td class="py-3.5 px-4">
                                    <p class="font-bold text-navy">{{ $tsk->title }}</p>
                                    <p class="text-[11px] text-slate-500 mt-0.5 line-clamp-1">{{ $tsk->description }}</p>
                                </td>
                                <td class="py-3.5 px-4 text-slate-700">
                                    {{ $tsk->company?->name ?: 'Seluruh Siswa Binaan' }}
                                </td>
                                <td class="py-3.5 px-4 font-mono text-slate-700 whitespace-nowrap">
                                    {{ $tsk->due_date->format('d/m/Y') }}
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-800">
                                        {{ $tsk->submissions->count() }} Terkumpul
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    <a href="{{ route('internship-mentor.tasks.show', $tsk->id) }}"
                                       class="px-3 py-1.5 text-xs font-semibold text-brand hover:text-brand-hover hover:bg-slate-100 rounded-lg transition min-h-[36px] inline-flex items-center">
                                        Periksa & Nilai &rarr;
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-10 text-center text-slate-500">
                                    Belum ada penugasan PKL yang dibuat. Klik tombol di atas untuk menerbitkan tugas pertama.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
