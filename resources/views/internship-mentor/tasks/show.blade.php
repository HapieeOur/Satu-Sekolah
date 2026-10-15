<x-app-layout title="Periksa Tugas PKL">
    <x-slot name="header">
        Pembimbing: Periksa Pengumpulan Tugas
    </x-slot>

    <div class="space-y-6">
        <!-- Back Navigation & Task Details -->
        <div class="flex items-center gap-3">
            <a href="{{ route('internship-mentor.tasks.index') }}" class="p-2 rounded-lg bg-surface hover:bg-slate-100 text-slate-600 border border-border transition min-h-[44px] min-w-[44px] flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h1 class="text-xl font-bold text-navy">{{ $task->title }}</h1>
                <p class="text-xs text-slate-600 mt-0.5">
                    Target: <strong class="text-slate-800">{{ $task->company?->name ?: 'Seluruh Siswa Binaan' }}</strong>
                    &bull; Batas Waktu: <strong class="text-slate-800 font-mono">{{ $task->due_date->format('d/m/Y') }}</strong>
                </p>
            </div>
        </div>

        <!-- Task Instruction Box -->
        <div class="bg-surface rounded-xl border border-border p-5 shadow-sm">
            <h2 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Instruksi Penugasan</h2>
            <div class="text-xs text-slate-700 whitespace-pre-line leading-relaxed bg-slate-50 p-4 rounded-lg border border-slate-200">
                {{ $task->description }}
            </div>
        </div>

        <!-- Submissions Table -->
        <div class="bg-surface rounded-xl border border-border shadow-sm overflow-hidden">
            <div class="p-5 border-b border-border flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-navy">Daftar Pengumpulan Siswa</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Total berkas tugas terkumpul: {{ $submissions->count() }} siswa</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-800">
                    <thead class="bg-slate-50 border-b border-border text-slate-700 font-semibold uppercase tracking-wider text-[11px]">
                        <tr>
                            <th scope="col" class="py-3 px-4 w-12 text-center">No</th>
                            <th scope="col" class="py-3 px-4">Siswa & Kelas</th>
                            <th scope="col" class="py-3 px-4">Waktu Pengumpulan</th>
                            <th scope="col" class="py-3 px-4">Catatan Siswa</th>
                            <th scope="col" class="py-3 px-4 text-center">Nilai</th>
                            <th scope="col" class="py-3 px-4">Status & Umpan Balik</th>
                            <th scope="col" class="py-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse ($submissions as $index => $sub)
                            <tr class="hover:bg-slate-50/75 transition">
                                <td class="py-3.5 px-4 text-center font-mono text-slate-500">{{ $index + 1 }}</td>
                                <td class="py-3.5 px-4">
                                    <p class="font-bold text-navy">{{ $sub->student->name }}</p>
                                    <p class="text-[11px] text-slate-500 font-mono mt-0.5">NIS: {{ $sub->student->nis }} &bull; {{ $sub->student->classroom?->name ?? '-' }}</p>
                                </td>
                                <td class="py-3.5 px-4 font-mono text-slate-600 whitespace-nowrap">
                                    {{ $sub->submitted_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="py-3.5 px-4 max-w-xs text-slate-700">
                                    {{ $sub->student_notes ?: '-' }}
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    @if($sub->grade !== null)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold {{ $sub->grade >= 75 ? 'bg-emerald-50 text-emerald-800' : 'bg-rose-50 text-rose-800' }}">
                                            {{ $sub->grade }} / 100
                                        </span>
                                    @else
                                        <span class="text-slate-400 font-mono">Belum Dinilai</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="space-y-1">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold border {{ $sub->status->badgeClass() }}">
                                            {{ $sub->status->label() }}
                                        </span>
                                        @if($sub->mentor_feedback)
                                            <p class="text-[10px] text-slate-600 bg-slate-50 border border-slate-200 rounded p-1 max-w-xs">
                                                {{ $sub->mentor_feedback }}
                                            </p>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    <button type="button"
                                            onclick="openGradingModal('{{ $sub->id }}', '{{ $sub->student->name }}', '{{ $sub->grade ?? '' }}', '{{ addslashes($sub->mentor_feedback ?? '') }}')"
                                            class="px-3 py-1.5 text-xs font-semibold text-brand hover:text-brand-hover hover:bg-slate-100 rounded-lg transition min-h-[36px]">
                                        {{ $sub->grade !== null ? 'Ubah Nilai' : 'Beri Nilai' }}
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-10 text-center text-slate-500">
                                    Belum ada siswa bimbingan yang mengumpulkan berkas untuk tugas ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Grading Modal -->
    <div id="gradingModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-surface rounded-xl border border-border shadow-xl max-w-md w-full p-6 space-y-4">
            <h3 class="text-base font-bold text-navy">Penilaian Tugas Siswa</h3>
            <p id="gradingStudentInfo" class="text-xs text-slate-600"></p>

            <form id="gradingForm" method="POST" action="" class="space-y-4">
                @csrf
                <div>
                    <label for="grade" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Skor / Nilai (0 - 100) <span class="text-danger">*</span></label>
                    <input type="number" name="grade" id="grade" min="0" max="100" required placeholder="Contoh: 85"
                           class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800 font-mono">
                </div>

                <div>
                    <label for="feedback" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Umpan Balik / Evaluasi Pembimbing</label>
                    <textarea name="feedback" id="feedback" rows="3" placeholder="Tuliskan masukan dan evaluasi untuk perkembangan siswa..."
                              class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800"></textarea>
                </div>

                <div class="pt-3 border-t border-border flex items-center justify-end gap-2">
                    <button type="button" onclick="closeGradingModal()" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-lg min-h-[40px]">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 text-xs font-semibold text-white bg-brand hover:bg-brand-hover rounded-lg shadow-sm min-h-[40px]">
                        Simpan Penilaian
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openGradingModal(subId, studentName, grade, feedback) {
            const form = document.getElementById('gradingForm');
            form.action = `/internship-mentor/tasks/submissions/${subId}/grade`;
            document.getElementById('gradingStudentInfo').textContent = `Pengumpulan dari: ${studentName}`;
            document.getElementById('grade').value = grade;
            document.getElementById('feedback').value = feedback;
            document.getElementById('gradingModal').classList.remove('hidden');
        }

        function closeGradingModal() {
            document.getElementById('gradingModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
