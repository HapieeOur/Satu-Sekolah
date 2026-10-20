<x-app-layout title="Ujian Harian & Evaluasi">
    <x-slot name="header">
        Portal Guru: Ujian Harian & Evaluasi
    </x-slot>

    <div class="space-y-6">
        <!-- Top Header & Action -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight">Ujian Harian &amp; Evaluasi KBM</h1>
                <p class="text-xs text-slate-500 mt-0.5">Jadwalkan ulangan harian, pantau ketuntasan KKM, dan kelola nilai evaluasi belajar siswa</p>
            </div>
            <button type="button" onclick="document.getElementById('newExamForm').classList.toggle('hidden')"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md shadow-indigo-600/20 transition-all duration-150">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Jadwalkan Ujian Harian</span>
            </button>
        </div>

        @if (session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200/80 text-emerald-800 text-xs flex items-center gap-2.5">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Create Exam Form (Collapsible) -->
        <div id="newExamForm" class="{{ $errors->any() ? '' : 'hidden' }} bg-white rounded-2xl border border-slate-200/80 p-6 md:p-8 shadow-sm space-y-5">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-slate-900">Formulir Penjadwalan Ujian Harian</h2>
                        <p class="text-[11px] text-slate-500">Tentukan jadwal, kriteria kelulusan minimal (KKM), dan kelas sasaran</p>
                    </div>
                </div>
                <button type="button" onclick="document.getElementById('newExamForm').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-lg hover:bg-slate-100 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form method="POST" action="{{ route('teacher.exams.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Judul Ujian Harian <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" id="title" required value="{{ old('title') }}" placeholder="Contoh: Ulangan Harian 1: Pemrograman Web & Arsitektur MVC"
                           class="w-full text-xs rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 p-3 text-slate-800 transition">
                    @error('title') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="classroom_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Kelas / Rombel Sasaran <span class="text-rose-500">*</span></label>
                        <select name="classroom_id" id="classroom_id" required class="w-full text-xs rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 p-3 text-slate-800 transition">
                            <option value="">-- Pilih Rombongan Belajar --</option>
                            @foreach ($classrooms as $c)
                                <option value="{{ $c->id }}" {{ old('classroom_id') == $c->id ? 'selected' : '' }}>
                                    {{ $c->name }} ({{ $c->major }})
                                </option>
                            @endforeach
                        </select>
                        @error('classroom_id') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="subject_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Mata Pelajaran <span class="text-rose-500">*</span></label>
                        <select name="subject_id" id="subject_id" required class="w-full text-xs rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 p-3 text-slate-800 transition">
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach ($subjects as $s)
                                <option value="{{ $s->id }}" {{ old('subject_id') == $s->id ? 'selected' : '' }}>
                                    {{ $s->name }} ({{ $s->code }})
                                </option>
                            @endforeach
                        </select>
                        @error('subject_id') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="exam_date" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Waktu Pelaksanaan <span class="text-rose-500">*</span></label>
                        <input type="datetime-local" name="exam_date" id="exam_date" required 
                               value="{{ old('exam_date', now()->addDays(2)->setTime(8, 0)->format('Y-m-d\TH:i')) }}"
                               class="w-full text-xs rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 p-3 text-slate-800 transition">
                        <p class="text-[11px] text-slate-400 mt-1">Tanggal dan jam mulai ujian (WIB).</p>
                        @error('exam_date') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="duration_minutes" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Durasi (Menit) <span class="text-rose-500">*</span></label>
                        <input type="number" name="duration_minutes" id="duration_minutes" min="15" max="240" required value="{{ old('duration_minutes', 60) }}"
                               class="w-full text-xs rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 p-3 text-slate-800 transition">
                        @error('duration_minutes') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="passing_score" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">KKM / Nilai Ketuntasan <span class="text-rose-500">*</span></label>
                        <input type="number" name="passing_score" id="passing_score" min="0" max="100" required value="{{ old('passing_score', 75) }}"
                               class="w-full text-xs rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 p-3 text-slate-800 transition">
                        @error('passing_score') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Materi Kisi-Kisi &amp; Petunjuk Pengerjaan</label>
                    <textarea name="description" id="description" rows="3" placeholder="Tuliskan bab materi yang diujikan, aturan ujian, atau tautan lembar soal..."
                              class="w-full text-xs rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 p-3 text-slate-800 leading-relaxed transition">{{ old('description') }}</textarea>
                    @error('description') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button type="button" onclick="document.getElementById('newExamForm').classList.add('hidden')"
                            class="px-4 py-2.5 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition">
                        Batal
                    </button>
                    <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2.5 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md shadow-indigo-600/20 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Simpan Agenda Ujian</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Exams Table Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="p-5 md:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-base font-bold text-slate-900">Daftar Ujian Harian</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Seluruh agenda ulangan harian yang telah Anda jadwalkan untuk kelas ampu</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-800">
                    <thead class="bg-slate-50/80 border-b border-slate-200/80 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">
                        <tr>
                            <th scope="col" class="py-3.5 px-4 w-14 text-center">No</th>
                            <th scope="col" class="py-3.5 px-4">Judul Ujian</th>
                            <th scope="col" class="py-3.5 px-4">Mata Pelajaran &amp; Kelas</th>
                            <th scope="col" class="py-3.5 px-4">Waktu Pelaksanaan</th>
                            <th scope="col" class="py-3.5 px-4 text-center">Durasi &amp; KKM</th>
                            <th scope="col" class="py-3.5 px-4 text-center">Status &amp; Nilai</th>
                            <th scope="col" class="py-3.5 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($exams as $index => $ex)
                            @php
                                $totalInClass = $ex->classroom?->students?->count() ?? 0;
                                $scoredCount = $ex->scores->whereNotNull('score')->count();
                            @endphp
                            <tr class="hover:bg-indigo-50/30 transition-colors duration-150">
                                <td class="py-4 px-4 text-center font-mono text-slate-400 font-medium">
                                    {{ $exams->firstItem() + $index }}
                                </td>
                                <td class="py-4 px-4 max-w-sm">
                                    <p class="font-bold text-slate-900 text-xs">{{ $ex->title }}</p>
                                    @if($ex->description)
                                        <p class="text-[11px] text-slate-500 mt-1 line-clamp-2 leading-relaxed">{{ $ex->description }}</p>
                                    @endif
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200/60 block mb-1 w-fit">
                                        {{ $ex->subject->name }}
                                    </span>
                                    <span class="text-xs font-mono text-slate-500">
                                        Kelas: {{ $ex->classroom->name }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap font-mono text-slate-700">
                                    <span class="font-bold text-slate-800 block">{{ $ex->exam_date->translatedFormat('d M Y') }}</span>
                                    <span class="text-[11px] text-slate-400">{{ $ex->exam_date->format('H:i') }} WIB</span>
                                </td>
                                <td class="py-4 px-4 text-center whitespace-nowrap">
                                    <span class="font-bold text-slate-800 block">{{ $ex->duration_minutes }} Menit</span>
                                    <span class="text-[11px] text-slate-500 font-mono">KKM: {{ $ex->passing_score }}</span>
                                </td>
                                <td class="py-4 px-4 text-center whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $scoredCount > 0 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $scoredCount > 0 ? 'bg-emerald-600' : 'bg-amber-600' }}"></span>
                                        <span>{{ $scoredCount }} / {{ $totalInClass }} Dinilai</span>
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('teacher.exams.show', $ex->id) }}"
                                           class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200/60 rounded-xl transition">
                                            <span>Input &amp; Rekap Nilai</span>
                                            <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                        </a>
                                        <form method="POST" action="{{ route('teacher.exams.destroy', $ex->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ujian ini? Seluruh data nilai akan terhapus.')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 rounded-lg hover:bg-rose-50 transition" title="Hapus Ujian">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-slate-400">
                                    <p class="text-xs font-bold text-slate-700">Belum ada agenda ujian harian.</p>
                                    <p class="text-[11px] text-slate-400 mt-1">Klik tombol di atas untuk menjadwalkan ulangan harian baru.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($exams->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $exams->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
