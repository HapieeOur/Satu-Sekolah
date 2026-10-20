<x-app-layout title="Tugas Saya">
    <x-slot name="header">
        Portal Siswa: Daftar Tugas Saya
    </x-slot>

    <div class="space-y-6">
        <!-- Top Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight">Tugas &amp; Pekerjaan Rumah</h1>
                <p class="text-xs text-slate-500 mt-0.5">Penugasan dari bapak/ibu guru pengajar untuk kelas Anda</p>
            </div>
            @if ($student->classroom)
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-indigo-50 border border-indigo-200/60 text-xs font-bold text-indigo-700 w-fit">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <span>Kelas: {{ $student->classroom->name }}</span>
                </span>
            @endif
        </div>

        @if (session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200/80 text-emerald-800 text-xs flex items-center gap-2.5">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Tasks Grid / Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse ($tasks as $task)
                @php
                    $mySub = $task->submissions->first();
                    $isSubmitted = !is_null($mySub);
                    $isGraded = $isSubmitted && !is_null($mySub->grade);
                    $isPassed = $task->due_date->isPast();
                @endphp
                <div class="rounded-2xl bg-white border border-slate-200/80 p-5 shadow-xs hover:shadow-md transition-all flex flex-col justify-between space-y-4">
                    <div class="space-y-2.5">
                        <div class="flex items-center justify-between gap-2">
                            <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200/60 truncate">
                                {{ $task->subject->name }}
                            </span>
                            @if ($isGraded)
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-black {{ $mySub->grade >= 75 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                                    Nilai: {{ $mySub->grade }}/100
                                </span>
                            @elseif ($isSubmitted)
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                    Terkumpul
                                </span>
                            @elseif ($isPassed)
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                    Lewat Batas
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                    Belum Dikumpul
                                </span>
                            @endif
                        </div>

                        <h2 class="text-sm font-bold text-slate-900 leading-snug">
                            {{ $task->title }}
                        </h2>

                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                            {{ $task->description }}
                        </p>
                    </div>

                    <div class="pt-3 border-t border-slate-100 space-y-3">
                        <div class="flex items-center justify-between text-[11px] text-slate-500">
                            <span class="font-medium text-slate-700">Guru: {{ $task->teacher->user?->name ?? 'Pengajar' }}</span>
                        </div>
                        <div class="flex items-center gap-1.5 text-[11px] {{ $isPassed ? 'text-rose-600 font-semibold' : 'text-slate-500' }}">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Deadline: {{ $task->due_date->translatedFormat('d M Y, H:i') }} WIB</span>
                        </div>

                        <a href="{{ route('student.tasks.show', $task->id) }}"
                           class="w-full inline-flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-xs font-bold transition-colors {{ $isSubmitted ? 'bg-slate-100 hover:bg-slate-200 text-slate-700' : 'bg-indigo-600 hover:bg-indigo-700 text-white shadow-xs' }}">
                            <span>{{ $isSubmitted ? 'Lihat Jawaban & Nilai' : 'Buka & Kerjakan Tugas' }}</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-slate-200/80">
                    <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <p class="text-sm font-bold text-slate-800">Tidak ada penugasan saat ini</p>
                    <p class="text-xs text-slate-400 mt-1">Bapak/Ibu guru belum menerbitkan tugas baru untuk kelas Anda.</p>
                </div>
            @endforelse
        </div>

        @if ($tasks->hasPages())
            <div class="pt-4">
                {{ $tasks->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
