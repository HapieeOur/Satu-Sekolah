<x-app-layout title="{{ $task->title }}">
    <x-slot name="header">
        Portal Siswa: Pengerjaan Tugas
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Back Link & Header -->
        <div class="flex items-center gap-3">
            <a href="{{ route('student.tasks.index') }}" 
               class="w-10 h-10 rounded-xl bg-white hover:bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-700 transition shadow-2xs">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-indigo-600 block">{{ $task->subject->name }}</span>
                <h1 class="text-xl md:text-2xl font-black text-slate-900 leading-snug">{{ $task->title }}</h1>
            </div>
        </div>

        @if (session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200/80 text-emerald-800 text-xs flex items-center gap-2.5">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Task Metadata Card -->
        <div class="rounded-2xl bg-white border border-slate-200/80 p-6 shadow-xs space-y-5">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pb-4 border-b border-slate-100">
                <div>
                    <span class="text-[11px] font-semibold text-slate-400 block uppercase">Guru Pengajar</span>
                    <span class="text-xs font-bold text-slate-900 mt-0.5 block">{{ $task->teacher->user?->name ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-[11px] font-semibold text-slate-400 block uppercase">Kelas Sasaran</span>
                    <span class="text-xs font-bold text-slate-900 mt-0.5 block">{{ $task->classroom->name }}</span>
                </div>
                <div>
                    <span class="text-[11px] font-semibold text-slate-400 block uppercase">Batas Pengumpulan</span>
                    <span class="text-xs font-bold {{ $task->due_date->isPast() ? 'text-rose-600' : 'text-slate-900' }} mt-0.5 block">
                        {{ $task->due_date->translatedFormat('d M Y, H:i') }} WIB
                    </span>
                    <span class="text-[10px] text-slate-400 font-mono">{{ $task->due_date->diffForHumans() }}</span>
                </div>
            </div>

            <!-- Instructions -->
            <div>
                <h2 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Instruksi &amp; Petunjuk Pengerjaan</h2>
                <div class="text-xs text-slate-700 leading-relaxed whitespace-pre-line bg-slate-50 p-4 rounded-xl border border-slate-200/70">
                    {{ $task->description }}
                </div>
            </div>

            @if($task->attachment_path)
                @if($task->isAttachmentImage())
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80 space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Foto Lembar Soal Tugas dari Guru
                            </span>
                            <a href="{{ $task->attachment_url }}" target="_blank" class="text-[11px] font-semibold text-indigo-600 hover:underline">
                                Buka Ukuran Penuh &rarr;
                            </a>
                        </div>
                        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
                            <a href="{{ $task->attachment_url }}" target="_blank">
                                <img src="{{ $task->attachment_url }}" alt="Foto Lembar Soal" class="w-full max-h-96 object-contain hover:scale-101 transition duration-200">
                            </a>
                        </div>
                    </div>
                @else
                    <div class="p-4 rounded-xl bg-indigo-50/60 border border-indigo-100 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-indigo-600 text-white flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-900">Lampiran Materi / Lembar Soal</p>
                                <p class="text-[11px] text-slate-500">Berkas instruksi yang dilampirkan oleh guru</p>
                            </div>
                        </div>
                        <a href="{{ $task->attachment_url }}" target="_blank"
                           class="px-3.5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold transition shrink-0">
                            Unduh Berkas
                        </a>
                    </div>
                @endif
            @endif
        </div>

        <!-- Grade & Feedback Banner if Graded -->
        @if ($submission && $submission->grade !== null)
            <div class="rounded-2xl p-6 bg-gradient-to-br from-indigo-50 to-white border border-indigo-200 shadow-xs space-y-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center font-black">
                            ✓
                        </div>
                        <h2 class="text-sm font-bold text-slate-900">Hasil Evaluasi &amp; Nilai Guru</h2>
                    </div>
                    <span class="text-2xl font-black {{ $submission->grade >= 75 ? 'text-emerald-600' : 'text-rose-600' }}">
                        {{ $submission->grade }} <span class="text-xs text-slate-400 font-normal">/ 100</span>
                    </span>
                </div>
                @if ($submission->teacher_feedback)
                    <div class="p-3.5 rounded-xl bg-white border border-indigo-100 text-xs text-slate-700 leading-relaxed">
                        <span class="font-bold block text-slate-900 mb-1">Catatan Umpan Balik Guru:</span>
                        {{ $submission->teacher_feedback }}
                    </div>
                @endif
                <p class="text-[11px] text-slate-400 font-mono">Dinilai pada: {{ $submission->graded_at?->translatedFormat('d M Y, H:i') }} WIB</p>
            </div>
        @endif

        <!-- Submission Status & Upload Form -->
        <div class="rounded-2xl bg-white border border-slate-200/80 p-6 shadow-xs space-y-5">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h2 class="text-sm font-bold text-slate-900">Pengumpulan Jawaban Tugas</h2>
                @if ($submission)
                    @if ($submission->submitted_at->gt($task->due_date))
                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                            Diserahkan Terlambat
                        </span>
                    @else
                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            Diserahkan Tepat Waktu
                        </span>
                    @endif
                @endif
            </div>

            @if ($submission)
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/70 space-y-3">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div>
                            <span class="text-[11px] font-semibold text-slate-500">Waktu Penyerahan:</span>
                            <span class="text-xs font-bold text-slate-800 ml-1">{{ $submission->submitted_at->translatedFormat('l, d F Y, H:i') }} WIB</span>
                        </div>
                        @if ($submission->submission_file_path)
                            @if ($submission->isSubmissionImage())
                                <a href="{{ $submission->submission_file_url }}" target="_blank"
                                   class="inline-flex items-center gap-1.5 text-xs font-bold text-amber-700 hover:underline">
                                    <span>📷 Buka Foto Jawaban Terkirim</span>
                                </a>
                            @else
                                <a href="{{ $submission->submission_file_url }}" target="_blank"
                                   class="inline-flex items-center gap-1.5 text-xs font-bold text-indigo-600 hover:underline">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <span>Lihat Berkas Terkirim</span>
                                </a>
                            @endif
                        @endif
                    </div>
                    @if ($submission->submission_file_path && $submission->isSubmissionImage())
                        <div class="pt-2">
                            <p class="text-[11px] font-semibold text-slate-500 mb-1.5">Foto Jawaban yang Dikumpulkan:</p>
                            <a href="{{ $submission->submission_file_url }}" target="_blank">
                                <img src="{{ $submission->submission_file_url }}" alt="Foto Jawaban Siswa" class="max-h-48 rounded-lg border border-slate-200 object-contain hover:opacity-90 transition">
                            </a>
                        </div>
                    @endif
                    @if ($submission->student_notes)
                        <div class="pt-2 border-t border-slate-200/60 text-xs text-slate-600">
                            <span class="font-semibold text-slate-800">Catatan Pengerjaan:</span>
                            <p class="mt-0.5 leading-relaxed">{{ $submission->student_notes }}</p>
                        </div>
                    @endif
                </div>
            @endif

            <form method="POST" action="{{ route('student.tasks.submit', $task->id) }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label for="submission_file" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        {{ $submission ? 'Unggah / Foto Ulang Jawaban Tugas' : 'Foto Lembar Jawaban / Unggah Berkas' }} <span class="text-rose-500">*</span>
                    </label>
                    <input type="file" name="submission_file" id="submission_file" required accept="image/*,.pdf,.doc,.docx"
                           class="w-full text-xs rounded-xl border border-slate-200 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 bg-white text-slate-800 p-2 transition cursor-pointer">
                    <p class="text-[11px] text-slate-400 mt-1">Dapat mengambil foto buku catatan / lembar pengerjaan (JPG, PNG, WEBP) atau berkas dokumen (PDF, Word maks. 20 MB).</p>
                    @error('submission_file') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="student_notes" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Catatan untuk Guru (Opsional)</label>
                    <textarea name="student_notes" id="student_notes" rows="3" placeholder="Tuliskan catatan tambahan mengenai berkas yang diserahkan..."
                              class="w-full text-xs rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 p-3 text-slate-800 leading-relaxed">{{ old('student_notes', $submission?->student_notes) }}</textarea>
                    @error('student_notes') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="pt-2 flex justify-end">
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md shadow-indigo-600/20 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>{{ $submission ? 'Perbarui Pengumpulan' : 'Kirim Tugas Sekarang' }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
