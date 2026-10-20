<x-app-layout title="Jadwal & Nilai Ujian Harian">
    <x-slot name="header">
        Portal Siswa: Ujian Harian & Evaluasi
    </x-slot>

    <div class="space-y-6">
        <!-- Top Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight">Ujian Harian &amp; Ulangan Kelas</h1>
                <p class="text-xs text-slate-500 mt-0.5">Jadwal evaluasi pembelajaran dan pengumuman hasil nilai ulangan harian</p>
            </div>
            @if ($student->classroom)
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-indigo-50 border border-indigo-200/60 text-xs font-bold text-indigo-700 w-fit">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <span>Kelas: {{ $student->classroom->name }}</span>
                </span>
            @endif
        </div>

        <!-- Exams Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse ($exams as $ex)
                @php
                    $myScore = $ex->scores->first();
                    $isGraded = !is_null($myScore) && !is_null($myScore->score);
                    $isPassed = $isGraded && $myScore->score >= $ex->passing_score;
                @endphp
                <div class="rounded-2xl bg-white border border-slate-200/80 p-5 shadow-xs hover:shadow-md transition-all flex flex-col justify-between space-y-4">
                    <div class="space-y-2.5">
                        <div class="flex items-center justify-between gap-2">
                            <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200/60 truncate">
                                {{ $ex->subject->name }}
                            </span>
                            @if ($isGraded)
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-black {{ $isPassed ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                                    {{ $isPassed ? '✓ Tuntas' : '⚠ Remedial' }}
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                    {{ $ex->exam_date->isFuture() ? 'Mendatang' : 'Menunggu Nilai' }}
                                </span>
                            @endif
                        </div>

                        <h2 class="text-sm font-bold text-slate-900 leading-snug">
                            {{ $ex->title }}
                        </h2>

                        @if ($ex->description)
                            <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                {{ $ex->description }}
                            </p>
                        @endif
                    </div>

                    <div class="pt-3 border-t border-slate-100 space-y-2.5 text-xs">
                        <div class="flex items-center justify-between text-[11px]">
                            <span class="text-slate-500">Guru: {{ $ex->teacher->user?->name ?? 'Pengajar' }}</span>
                            <span class="font-mono text-slate-400">KKM: {{ $ex->passing_score }}</span>
                        </div>
                        <div class="flex items-center gap-1.5 text-[11px] text-slate-600 font-mono">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>{{ $ex->exam_date->translatedFormat('d M Y, H:i') }} WIB ({{ $ex->duration_minutes }} mnt)</span>
                        </div>

                        <!-- Score result badge -->
                        <div class="pt-2 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-[11px] font-bold text-slate-400 uppercase">Nilai Anda:</span>
                            @if ($isGraded)
                                <span class="text-lg font-black {{ $isPassed ? 'text-emerald-600' : 'text-rose-600' }}">
                                    {{ (float) $myScore->score }} <span class="text-xs text-slate-400 font-normal">/ 100</span>
                                </span>
                            @else
                                <span class="text-xs font-mono text-slate-400 italic">Belum Dinilai</span>
                            @endif
                        </div>
                        @if ($isGraded && $myScore->notes)
                            <div class="p-2 rounded-lg bg-slate-50 text-[11px] text-slate-600">
                                <span class="font-bold">Catatan:</span> {{ $myScore->notes }}
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-slate-200/80">
                    <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <p class="text-sm font-bold text-slate-800">Belum ada agenda ujian harian</p>
                    <p class="text-xs text-slate-400 mt-1">Bapak/Ibu guru belum menjadwalkan ulangan harian baru untuk kelas Anda.</p>
                </div>
            @endforelse
        </div>

        @if ($exams->hasPages())
            <div class="pt-4">
                {{ $exams->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
