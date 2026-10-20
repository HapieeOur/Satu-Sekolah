<x-app-layout title="Jadwal Pelajaran Siswa">
    <x-slot name="header">
        Portal Siswa &mdash; Jadwal Pelajaran
    </x-slot>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-navy tracking-tight">Jadwal Pelajaran Kelas</h1>
                <p class="text-xs text-slate-500 mt-0.5">
                    Jadwal KBM kelas <strong class="text-navy">{{ $student?->classroom?->name ?? 'Kelas Belum Ditentukan' }}</strong> &bull; Tahun Ajaran {{ $activeAcademicYear?->name ?? '-' }}
                </p>
            </div>
            <a href="{{ route('student.dashboard') }}" class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50 transition shadow-xs flex items-center gap-1.5 self-start sm:self-auto cursor-pointer">
                &larr; Kembali ke Beranda
            </a>
        </div>

        <!-- Filter Day Tabs -->
        <div class="bg-white rounded-2xl border border-slate-200/90 p-2 shadow-xs flex items-center gap-1.5 overflow-x-auto text-xs font-bold">
            <a href="{{ route('student.schedules.index') }}" 
               class="px-4 py-2 rounded-xl transition shrink-0 {{ empty($selectedDay) ? 'bg-[#233DFF] text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}">
                Semua Hari
            </a>
            @foreach (['senin' => 'Senin', 'selasa' => 'Selasa', 'rabu' => 'Rabu', 'kamis' => 'Kamis', 'jumat' => 'Jumat', 'sabtu' => 'Sabtu'] as $val => $lbl)
                <a href="{{ route('student.schedules.index', ['day' => $val]) }}" 
                   class="px-4 py-2 rounded-xl transition shrink-0 {{ $selectedDay === $val ? 'bg-[#233DFF] text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}">
                    {{ $lbl }}
                </a>
            @endforeach
        </div>

        <!-- Timetable Content -->
        @if ($schedules->isEmpty())
            <div class="bg-white rounded-3xl border border-slate-200/90 p-12 text-center shadow-xs">
                <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="text-base font-extrabold text-navy mb-1">Tidak Ada Jadwal Ditemukan</h3>
                <p class="text-xs text-slate-500 max-w-md mx-auto">
                    @if ($selectedDay)
                        Tidak ada sesi mata pelajaran yang terdaftar pada hari {{ ucfirst($selectedDay) }}.
                    @else
                        Jadwal pelajaran kelas Anda belum diterbitkan oleh bagian kurikulum.
                    @endif
                </p>
            </div>
        @else
            @php
                $groupedSchedules = $schedules->groupBy(fn ($item) => $item->day_of_week?->value ?? (string) $item->day_of_week);
            @endphp

            <div class="space-y-6">
                @foreach ($groupedSchedules as $dayKey => $dayItems)
                    <div class="bg-white rounded-3xl border border-slate-200/90 overflow-hidden shadow-xs">
                        <div class="px-6 py-3.5 bg-slate-50/80 border-b border-slate-100 flex items-center justify-between">
                            <h2 class="font-extrabold text-sm text-navy uppercase tracking-wider flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-[#233DFF]"></span>
                                <span>{{ ucfirst($dayKey) }}</span>
                            </h2>
                            <span class="text-xs text-slate-400 font-bold">{{ $dayItems->count() }} Mata Pelajaran</span>
                        </div>

                        <div class="divide-y divide-slate-100">
                            @foreach ($dayItems as $item)
                                <div class="p-5 hover:bg-slate-50/60 transition flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-16 py-2 rounded-xl bg-indigo-50/80 border border-indigo-100 text-[#233DFF] text-center font-mono font-bold text-xs shrink-0">
                                            {{ substr((string) $item->start_time, 0, 5) }}
                                            <span class="block text-[10px] text-slate-400 font-normal">s/d</span>
                                            {{ substr((string) $item->end_time, 0, 5) }}
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <h3 class="text-sm font-extrabold text-navy">{{ $item->subject->name }}</h3>
                                                <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                                    {{ $item->subject->code }}
                                                </span>
                                            </div>
                                            <p class="text-xs text-slate-500 mt-1 flex flex-wrap items-center gap-2">
                                                <span>Guru: <strong class="text-navy">{{ $item->teacher?->user?->name ?? 'Guru Mapel' }}</strong></span>
                                                <span>&bull;</span>
                                                <span>Ruangan: <strong class="text-navy">{{ $item->room ? $item->room->name : 'Ruang Kelas' }}</strong></span>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="shrink-0 flex items-center gap-2">
                                        <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-indigo-50 text-brand border border-indigo-200">
                                            {{ $item->time_range }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
