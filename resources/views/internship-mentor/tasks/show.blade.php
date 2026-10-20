<x-app-layout title="Periksa Tugas PKL">
    <x-slot name="header">
        Pembimbing: Periksa Pengumpulan Tugas
    </x-slot>

    <div class="space-y-6">
        <!-- Hero Header -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 p-6 md:p-8 text-white shadow-xl">
            <div class="absolute -top-16 -right-16 w-64 h-64 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-16 -left-16 w-64 h-64 bg-blue-500/15 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-start sm:items-center gap-4">
                    <a href="{{ route('internship-mentor.tasks.index') }}" 
                       class="w-10 h-10 rounded-xl bg-white/10 hover:bg-white/15 border border-white/10 flex items-center justify-center text-white transition shrink-0 backdrop-blur-sm shadow-sm"
                       title="Kembali ke Daftar Tugas">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    </a>
                    <div class="space-y-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-indigo-500/20 text-indigo-300 border border-indigo-400/30">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>Batas: {{ $task->due_date->translatedFormat('d M Y, H:i') }} WIB</span>
                            </span>
                            <span class="text-xs text-slate-300 bg-white/10 px-2.5 py-0.5 rounded-full border border-white/10">
                                Target: {{ $task->company?->name ?: 'Seluruh Siswa Binaan' }}
                            </span>
                        </div>
                        <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-white">
                            {{ $task->title }}
                        </h1>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="px-4 py-3 rounded-xl bg-white/10 border border-white/10 text-center backdrop-blur-sm">
                        <span class="text-2xl font-black text-white block">{{ $submissions->count() }}</span>
                        <span class="text-[11px] font-medium text-indigo-200">Berkas Masuk</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Task Instruction Box -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm space-y-3">
            <div class="flex items-center gap-2.5 text-slate-900 pb-2 border-b border-slate-100">
                <div class="w-7 h-7 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h2 class="text-xs font-bold uppercase tracking-wider text-slate-700">Instruksi & Rubrik Penugasan</h2>
            </div>
            <div class="text-xs text-slate-700 whitespace-pre-line leading-relaxed bg-slate-50/80 p-4 rounded-xl border border-slate-200/70">
                {{ $task->description }}
            </div>
        </div>

        <!-- Submissions Table Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="p-5 md:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Daftar Pengumpulan Siswa</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Total berkas tugas yang telah diserahkan: {{ $submissions->count() }} siswa bimbingan</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-800">
                    <thead class="bg-slate-50/80 border-b border-slate-200/80 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">
                        <tr>
                            <th scope="col" class="py-3.5 px-4 w-14 text-center">No</th>
                            <th scope="col" class="py-3.5 px-4">Siswa & Rombel</th>
                            <th scope="col" class="py-3.5 px-4">Waktu Penyerahan</th>
                            <th scope="col" class="py-3.5 px-4">Catatan Siswa</th>
                            <th scope="col" class="py-3.5 px-4 text-center">Nilai Evaluasi</th>
                            <th scope="col" class="py-3.5 px-4">Status & Catatan Pembimbing</th>
                            <th scope="col" class="py-3.5 px-4 text-right">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($submissions as $index => $sub)
                            <tr class="hover:bg-indigo-50/30 transition-colors duration-150">
                                <td class="py-4 px-4 text-center font-mono text-slate-400 font-medium">
                                    {{ $index + 1 }}
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-slate-900 text-white font-bold text-xs flex items-center justify-center shrink-0 shadow-sm">
                                            {{ strtoupper(substr($sub->student->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900 leading-snug">{{ $sub->student->name }}</p>
                                            <p class="text-[11px] text-slate-500 font-mono mt-0.5">
                                                NIS: {{ $sub->student->nis }} &bull; {{ $sub->student->classroom?->name ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4 font-mono text-slate-600 whitespace-nowrap">
                                    <span class="font-bold text-slate-800 block">{{ $sub->submitted_at->format('d/m/Y') }}</span>
                                    <span class="text-[11px] text-slate-400">{{ $sub->submitted_at->format('H:i') }} WIB</span>
                                    @if ($task->due_date)
                                        @if ($sub->submitted_at->gt($task->due_date))
                                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-rose-600 mt-0.5 block">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Terlambat
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-600 mt-0.5 block">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Tepat Waktu
                                            </span>
                                        @endif
                                    @endif
                                </td>
                                <td class="py-4 px-4 max-w-xs text-slate-600">
                                    {{ $sub->student_notes ?: '-' }}
                                </td>
                                <td class="py-4 px-4 text-center whitespace-nowrap">
                                    @if($sub->grade !== null)
                                        <span class="inline-flex items-center px-3 py-1 rounded-xl text-xs font-black {{ $sub->grade >= 75 ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-rose-50 text-rose-800 border border-rose-200' }}">
                                            {{ $sub->grade }} / 100
                                        </span>
                                    @else
                                        <span class="text-slate-400 font-mono text-xs italic">Belum Dinilai</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    <div class="space-y-1.5">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $sub->status->badgeClass() }}">
                                            {{ $sub->status->label() }}
                                        </span>
                                        @if($sub->mentor_feedback)
                                            <div class="text-[11px] text-slate-600 bg-slate-50 border border-slate-200/80 rounded-xl p-2 max-w-xs shadow-2xs">
                                                {{ $sub->mentor_feedback }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-right whitespace-nowrap">
                                    <button type="button"
                                            onclick="openGradingModal('{{ $sub->id }}', '{{ addslashes($sub->student->name) }}', '{{ $sub->grade ?? '' }}', '{{ addslashes($sub->mentor_feedback ?? '') }}')"
                                            class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200/60 rounded-xl transition shadow-2xs">
                                        <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        <span>{{ $sub->grade !== null ? 'Ubah Nilai' : 'Beri Nilai' }}</span>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center">
                                    <div class="max-w-xs mx-auto text-center space-y-2">
                                        <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        </div>
                                        <p class="font-bold text-slate-700 text-sm">Belum Ada Pengumpulan</p>
                                        <p class="text-xs text-slate-500">Belum ada siswa bimbingan yang menyerahkan berkas untuk tugas ini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Grading Modal -->
    <div id="gradingModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-md flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-md w-full p-6 space-y-5 animate-in fade-in zoom-in-95 duration-150">
            <div class="flex items-start justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 border border-indigo-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Penilaian Tugas Siswa</h3>
                        <p class="text-xs text-slate-500">Evaluasi mutu tugas & berikan skor</p>
                    </div>
                </div>
                <button type="button" onclick="closeGradingModal()" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-lg hover:bg-slate-100 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/70 text-xs">
                <span class="text-slate-400 block text-[11px] uppercase font-bold tracking-wider mb-0.5">Peserta Didik</span>
                <p id="gradingStudentInfo" class="font-semibold text-slate-800"></p>
            </div>

            <form id="gradingForm" method="POST" action="" class="space-y-4">
                @csrf
                <div>
                    <label for="grade" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Skor / Nilai (Rentang 0 - 100) <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" name="grade" id="grade" min="0" max="100" required placeholder="Contoh: 85"
                           class="w-full text-sm font-bold font-mono rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 bg-white text-slate-800 p-3 transition">
                </div>

                <div>
                    <label for="feedback" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Umpan Balik / Evaluasi Pembimbing
                    </label>
                    <textarea name="feedback" id="feedback" rows="3" 
                              placeholder="Tuliskan masukan positif dan saran perbaikan untuk pengembangan kompetensi siswa..."
                              class="w-full text-xs rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 bg-white text-slate-800 p-3 leading-relaxed transition"></textarea>
                </div>

                <div class="pt-2 flex items-center justify-end gap-2.5">
                    <button type="button" onclick="closeGradingModal()" class="px-4 py-2.5 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition">
                        Batal
                    </button>
                    <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2.5 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md shadow-indigo-600/20 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Simpan Penilaian</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openGradingModal(subId, studentName, grade, feedback) {
            const form = document.getElementById('gradingForm');
            form.action = `/internship-mentor/tasks/submissions/${subId}/grade`;
            document.getElementById('gradingStudentInfo').textContent = studentName;
            document.getElementById('grade').value = grade;
            document.getElementById('feedback').value = feedback;
            document.getElementById('gradingModal').classList.remove('hidden');
        }

        function closeGradingModal() {
            document.getElementById('gradingModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
