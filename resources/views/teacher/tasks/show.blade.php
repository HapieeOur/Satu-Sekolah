<x-app-layout title="Periksa Tugas Mata Pelajaran">
    <x-slot name="header">
        Portal Guru: Periksa Tugas Mata Pelajaran
    </x-slot>

    <div class="space-y-6">
        <!-- Hero Header -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 p-6 md:p-8 text-white shadow-xl">
            <div class="absolute -top-16 -right-16 w-64 h-64 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-16 -left-16 w-64 h-64 bg-blue-500/15 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-start sm:items-center gap-4">
                    <a href="{{ route('teacher.tasks.index') }}" 
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
                                Mapel: {{ $task->subject->name }}
                            </span>
                            <span class="text-xs text-indigo-200 bg-indigo-900/40 px-2.5 py-0.5 rounded-full border border-indigo-500/30 font-mono">
                                Kelas: {{ $task->classroom->name }}
                            </span>
                        </div>
                        <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-white">
                            {{ $task->title }}
                        </h1>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="px-4 py-3 rounded-xl bg-white/10 border border-white/10 text-center backdrop-blur-sm">
                        <span class="text-2xl font-black text-white block">{{ $task->submissions->count() }} / {{ $classroomStudents->count() }}</span>
                        <span class="text-[11px] font-medium text-indigo-200">Siswa Telah Mengumpulkan</span>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200/80 text-emerald-800 text-xs flex items-center gap-2.5">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Task Instruction Box -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                <div class="flex items-center gap-2.5 text-slate-900">
                    <div class="w-7 h-7 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-700">Instruksi &amp; Rubrik Pengerjaan</h2>
                </div>
                @if($task->attachment_path)
                    <a href="{{ $task->attachment_url }}" target="_blank"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-indigo-50 text-indigo-700 hover:bg-indigo-100 border border-indigo-200/60 text-xs font-semibold transition">
                        <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        <span>{{ $task->isAttachmentImage() ? 'Buka Foto Ukuran Penuh' : 'Unduh Lampiran Soal' }}</span>
                    </a>
                @endif
            </div>

            <div class="text-xs text-slate-700 whitespace-pre-line leading-relaxed bg-slate-50/80 p-4 rounded-xl border border-slate-200/70">
                {{ $task->description }}
            </div>

            @if($task->attachment_path && $task->isAttachmentImage())
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Foto Lembar Soal Tugas
                        </span>
                        <a href="{{ $task->attachment_url }}" target="_blank" class="text-[11px] font-semibold text-indigo-600 hover:underline">
                            Perbesar Foto &rarr;
                        </a>
                    </div>
                    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white max-w-xl">
                        <a href="{{ $task->attachment_url }}" target="_blank">
                            <img src="{{ $task->attachment_url }}" alt="Foto Soal Tugas" class="w-full max-h-96 object-contain hover:scale-101 transition duration-200">
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Submissions Roster Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="p-5 md:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Roster Pengumpulan Siswa Kelas {{ $task->classroom->name }}</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Daftar presensi berkas tugas seluruh peserta didik di kelas ini</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-800">
                    <thead class="bg-slate-50/80 border-b border-slate-200/80 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">
                        <tr>
                            <th scope="col" class="py-3.5 px-4 w-14 text-center">No</th>
                            <th scope="col" class="py-3.5 px-4">Nama Siswa</th>
                            <th scope="col" class="py-3.5 px-4">Waktu Penyerahan</th>
                            <th scope="col" class="py-3.5 px-4">Berkas &amp; Catatan Siswa</th>
                            <th scope="col" class="py-3.5 px-4 text-center">Nilai</th>
                            <th scope="col" class="py-3.5 px-4">Umpan Balik Guru</th>
                            <th scope="col" class="py-3.5 px-4 text-right">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($classroomStudents as $index => $stu)
                            @php
                                $sub = $submissionsByStudent->get($stu->id);
                            @endphp
                            <tr class="hover:bg-indigo-50/30 transition-colors duration-150">
                                <td class="py-4 px-4 text-center font-mono text-slate-400 font-medium">
                                    {{ $index + 1 }}
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-slate-900 text-white font-bold text-xs flex items-center justify-center shrink-0 shadow-sm">
                                            {{ strtoupper(substr($stu->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900 leading-snug">{{ $stu->name }}</p>
                                            <p class="text-[11px] text-slate-500 font-mono mt-0.5">NIS: {{ $stu->nis }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4 font-mono text-slate-600 whitespace-nowrap">
                                    @if ($sub)
                                        <span class="font-bold text-slate-800 block">{{ $sub->submitted_at->format('d/m/Y') }}</span>
                                        <span class="text-[11px] text-slate-400">{{ $sub->submitted_at->format('H:i') }} WIB</span>
                                        @if ($sub->submitted_at->gt($task->due_date))
                                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-rose-600 mt-0.5 block">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Terlambat
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-600 mt-0.5 block">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Tepat Waktu
                                            </span>
                                        @endif
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[10px] font-bold bg-slate-100 text-slate-500">
                                            Belum Mengumpulkan
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 max-w-xs">
                                    @if ($sub)
                                        @if ($sub->submission_file_path)
                                            @if ($sub->isSubmissionImage())
                                                <a href="{{ $sub->submission_file_url }}" target="_blank"
                                                   class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-amber-50 text-amber-800 hover:bg-amber-100 border border-amber-200/80 mb-1 transition">
                                                    <svg class="w-3.5 h-3.5 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                    <span>📷 Buka Foto Jawaban</span>
                                                </a>
                                            @else
                                                <a href="{{ $sub->submission_file_url }}" target="_blank"
                                                   class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-indigo-50 text-indigo-700 hover:bg-indigo-100 border border-indigo-200/60 mb-1 transition">
                                                    <svg class="w-3.5 h-3.5 text-indigo-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                    <span>Unduh Jawaban Siswa</span>
                                                </a>
                                            @endif
                                        @endif
                                        <p class="text-[11px] text-slate-500 italic mt-0.5 line-clamp-2">
                                            {{ $sub->student_notes ?: 'Tidak ada catatan pengerjaan.' }}
                                        </p>
                                    @else
                                        <span class="text-slate-400 font-mono text-[11px]">-</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-center whitespace-nowrap">
                                    @if($sub && $sub->grade !== null)
                                        <span class="inline-flex items-center px-3 py-1 rounded-xl text-xs font-black {{ $sub->grade >= 75 ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-rose-50 text-rose-800 border border-rose-200' }}">
                                            {{ $sub->grade }} / 100
                                        </span>
                                    @elseif($sub)
                                        <span class="text-amber-600 font-mono text-xs font-semibold">Menunggu Penilaian</span>
                                    @else
                                        <span class="text-slate-400 font-mono text-xs italic">-</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 max-w-xs">
                                    @if($sub && $sub->teacher_feedback)
                                        <div class="text-[11px] text-slate-700 bg-slate-50 border border-slate-200/80 rounded-xl p-2 leading-relaxed">
                                            {{ $sub->teacher_feedback }}
                                        </div>
                                    @else
                                        <span class="text-slate-400 text-xs">-</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-right whitespace-nowrap">
                                    @if ($sub)
                                        <button type="button"
                                                onclick="openGradingModal('{{ $sub->id }}', '{{ addslashes($stu->name) }}', '{{ $sub->grade ?? '' }}', '{{ addslashes($sub->teacher_feedback ?? '') }}')"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200/60 rounded-xl transition">
                                            <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            <span>{{ $sub->grade !== null ? 'Ubah Nilai' : 'Beri Nilai' }}</span>
                                        </button>
                                    @else
                                        <span class="text-slate-400 text-xs italic">Menunggu Berkas</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-slate-400">
                                    Tidak ada data siswa yang terdaftar di kelas ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Grading Modal -->
    <div id="gradingModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl border border-slate-200 max-w-md w-full p-6 shadow-2xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="text-sm font-bold text-slate-900">Penilaian Tugas Siswa</h3>
                <button type="button" onclick="closeGradingModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form id="gradingForm" method="POST" action="" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1">Nama Siswa</label>
                    <p id="modalStudentName" class="font-bold text-slate-900 text-sm"></p>
                </div>

                <div>
                    <label for="gradeInput" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nilai Tugas (0 - 100) <span class="text-rose-500">*</span></label>
                    <input type="number" name="grade" id="gradeInput" min="0" max="100" required
                           class="w-full text-sm font-bold rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 p-3 text-slate-900">
                </div>

                <div>
                    <label for="feedbackInput" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Umpan Balik &amp; Evaluasi Guru (Opsional)</label>
                    <textarea name="feedback" id="feedbackInput" rows="3" placeholder="Tuliskan apresiasi, masukan perbaikan, atau catatan evaluasi..."
                              class="w-full text-xs rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 p-3 text-slate-800 leading-relaxed"></textarea>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button type="button" onclick="closeGradingModal()" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md shadow-indigo-600/20 transition">
                        Simpan Nilai
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openGradingModal(submissionId, studentName, grade, feedback) {
            const form = document.getElementById('gradingForm');
            form.action = `/teacher/tasks/submissions/${submissionId}/grade`;
            document.getElementById('modalStudentName').textContent = studentName;
            document.getElementById('gradeInput').value = grade;
            document.getElementById('feedbackInput').value = feedback;
            document.getElementById('gradingModal').classList.remove('hidden');
        }

        function closeGradingModal() {
            document.getElementById('gradingModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
