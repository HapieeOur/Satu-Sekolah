<x-app-layout title="Input & Rekap Nilai Ujian">
    <x-slot name="header">
        Portal Guru: Input & Rekap Nilai Ujian Harian
    </x-slot>

    <div class="space-y-6">
        <!-- Hero Header -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 p-6 md:p-8 text-white shadow-xl">
            <div class="absolute -top-16 -right-16 w-64 h-64 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-16 -left-16 w-64 h-64 bg-blue-500/15 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-start sm:items-center gap-4">
                    <a href="{{ route('teacher.exams.index') }}" 
                       class="w-10 h-10 rounded-xl bg-white/10 hover:bg-white/15 border border-white/10 flex items-center justify-center text-white transition shrink-0 backdrop-blur-sm shadow-sm"
                       title="Kembali ke Daftar Ujian">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    </a>
                    <div class="space-y-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-indigo-500/20 text-indigo-300 border border-indigo-400/30">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>{{ $exam->exam_date->translatedFormat('d M Y, H:i') }} WIB</span>
                            </span>
                            <span class="text-xs text-slate-300 bg-white/10 px-2.5 py-0.5 rounded-full border border-white/10">
                                Mapel: {{ $exam->subject->name }}
                            </span>
                            <span class="text-xs text-indigo-200 bg-indigo-900/40 px-2.5 py-0.5 rounded-full border border-indigo-500/30 font-mono">
                                Kelas: {{ $exam->classroom->name }}
                            </span>
                            <span class="text-xs text-amber-300 bg-amber-900/40 px-2.5 py-0.5 rounded-full border border-amber-500/30 font-bold">
                                KKM: {{ $exam->passing_score }}
                            </span>
                        </div>
                        <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-white">
                            {{ $exam->title }}
                        </h1>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="px-4 py-3 rounded-xl bg-white/10 border border-white/10 text-center backdrop-blur-sm">
                        <span class="text-2xl font-black text-white block">{{ $scoresByStudent->whereNotNull('score')->count() }} / {{ $classroomStudents->count() }}</span>
                        <span class="text-[11px] font-medium text-indigo-200">Siswa Dinilai</span>
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

        <!-- 3 Stats Bento Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Rata-Rata Kelas</span>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-2xl font-black text-slate-900">{{ $averageScore !== null ? $averageScore : '-' }}</span>
                    <span class="text-xs text-slate-400">/ 100</span>
                </div>
                <p class="text-[11px] text-slate-400 mt-1">Evaluasi kumulatif rombel</p>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
                <span class="text-xs font-bold text-emerald-600 uppercase tracking-wider">Tuntas KKM (&ge; {{ $exam->passing_score }})</span>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-2xl font-black text-emerald-600">{{ $passedCount }}</span>
                    <span class="text-xs text-slate-400">siswa</span>
                </div>
                <p class="text-[11px] text-slate-400 mt-1">Memenuhi standar ketuntasan</p>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
                <span class="text-xs font-bold text-rose-600 uppercase tracking-wider">Perlu Remedial (&lt; {{ $exam->passing_score }})</span>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-2xl font-black text-rose-600">{{ $remedialCount }}</span>
                    <span class="text-xs text-slate-400">siswa</span>
                </div>
                <p class="text-[11px] text-slate-400 mt-1">Membutuhkan bimbingan perbaikan</p>
            </div>
        </div>

        <!-- Scores Input Form & Roster -->
        <form method="POST" action="{{ route('teacher.exams.scores.store', $exam->id) }}">
            @csrf
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                <div class="p-5 md:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Roster Penilaian Siswa Kelas {{ $exam->classroom->name }}</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Input nilai ujian (0 - 100) dan catatan remedial jika diperlukan</p>
                    </div>
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md shadow-indigo-600/20 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Simpan Seluruh Nilai</span>
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-800">
                        <thead class="bg-slate-50/80 border-b border-slate-200/80 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">
                            <tr>
                                <th scope="col" class="py-3.5 px-4 w-12 text-center">No</th>
                                <th scope="col" class="py-3.5 px-4">Nama Siswa</th>
                                <th scope="col" class="py-3.5 px-4">NIS</th>
                                <th scope="col" class="py-3.5 px-4 w-36">Nilai Ujian (0-100)</th>
                                <th scope="col" class="py-3.5 px-4">Status Ketuntasan</th>
                                <th scope="col" class="py-3.5 px-4">Catatan / Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($classroomStudents as $index => $stu)
                                @php
                                    $scoreRecord = $scoresByStudent->get($stu->id);
                                    $val = old("scores.{$index}.score", $scoreRecord?->score);
                                @endphp
                                <tr class="hover:bg-indigo-50/25 transition">
                                    <td class="py-3.5 px-4 text-center font-mono text-slate-400">
                                        {{ $index + 1 }}
                                        <input type="hidden" name="scores[{{ $index }}][student_id]" value="{{ $stu->id }}">
                                    </td>
                                    <td class="py-3.5 px-4 font-bold text-slate-900">
                                        {{ $stu->name }}
                                    </td>
                                    <td class="py-3.5 px-4 font-mono text-slate-500">
                                        {{ $stu->nis ?? '-' }}
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <input type="number" name="scores[{{ $index }}][score]" step="0.1" min="0" max="100"
                                               value="{{ $val }}"
                                               placeholder="0 - 100"
                                               class="w-28 text-xs font-bold rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 p-2 text-slate-900">
                                    </td>
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        @if ($val !== null && $val !== '')
                                            @if ((float)$val >= $exam->passing_score)
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                    ✓ Tuntas KKM
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                                    ⚠ Perlu Remedial
                                                </span>
                                            @endif
                                        @else
                                            <span class="text-slate-400 text-xs italic">Belum Dinilai</span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <input type="text" name="scores[{{ $index }}][notes]"
                                               value="{{ old("scores.{$index}.notes", $scoreRecord?->notes) }}"
                                               placeholder="Catatan hasil ujian..."
                                               class="w-full text-xs rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 p-2 text-slate-800">
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-slate-400">
                                        Tidak ada siswa terdaftar di kelas ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 bg-slate-50/80 border-t border-slate-100 flex items-center justify-between">
                    <p class="text-[11px] text-slate-500">Nilai di bawah KKM ({{ $exam->passing_score }}) akan otomatis ditandai sebagai peserta remedial.</p>
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md shadow-indigo-600/20 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Simpan Seluruh Nilai</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
