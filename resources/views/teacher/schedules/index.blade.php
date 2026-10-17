<x-app-layout title="Jadwal Mengajar Saya">
    <x-slot name="header">
        Kegiatan Guru: Jadwal Mengajar
    </x-slot>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-navy tracking-tight">Jadwal Mengajar Saya</h1>
                <p class="text-xs text-slate-500 mt-0.5">Agenda mengajar mingguan terstruktur berdasarkan kalender akademik aktif.</p>
            </div>
        </div>

        @if (! $teacher)
            <div class="bg-amber-50 border border-amber-200 rounded-3xl p-6 text-amber-900 shadow-xs">
                <div class="flex items-center gap-2 mb-1">
                    <svg class="w-5 h-5 text-amber-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    <h3 class="font-bold text-sm">Profil Guru Belum Terhubung</h3>
                </div>
                <p class="text-xs text-amber-800 leading-relaxed">
                    Akun pengguna Anda belum ditautkan dengan data guru di pangkalan data sekolah. Hubungi Administrator untuk melakukan sinkronisasi data akun dengan profil pendidik.
                </p>
            </div>
        @else
            <!-- Teacher Profile & Metrics Banner -->
            <div class="bg-white rounded-3xl border border-slate-200/90 p-6 shadow-xs">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                    <!-- Teacher Identity -->
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-brand to-violet-600 text-white flex items-center justify-center font-extrabold text-lg shadow-sm shrink-0">
                            {{ substr($teacher->name, 0, 2) }}
                        </div>
                        <div>
                            <h2 class="text-base font-extrabold text-navy">{{ $teacher->name }}</h2>
                            <p class="text-xs text-slate-500 mt-0.5">NIP: {{ $teacher->nip ?? '-' }} &bull; NUPTK: {{ $teacher->nuptk ?? '-' }}</p>
                        </div>
                    </div>

                    <!-- Workload -->
                    <div class="border-y md:border-y-0 md:border-x border-slate-100 py-4 md:py-0 md:px-6">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block">Total Beban Mengajar</span>
                        <span class="text-xl font-black text-navy mt-1 block">{{ $totalSlots }} Sesi / Minggu</span>
                    </div>

                    <!-- Assigned Classes -->
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-2">Kelas yang Diampu</span>
                        <div class="flex flex-wrap gap-1.5">
                            @forelse ($uniqueClassrooms as $clsName)
                                <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                    {{ $clsName }}
                                </span>
                            @empty
                                <span class="text-xs text-slate-400 italic">Belum ada penugasan kelas</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Bar -->
            <div class="bg-white rounded-3xl border border-slate-200/90 p-6 shadow-xs">
                <form method="GET" action="{{ route('teacher.schedules.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
                    <div>
                        <label for="academic_year_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tahun Ajaran</label>
                        <select name="academic_year_id" id="academic_year_id" class="w-full text-xs rounded-xl border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 bg-white text-slate-800 py-2.5 px-3">
                            @foreach ($academicYears as $year)
                                <option value="{{ $year->id }}" {{ $academicYearId == $year->id ? 'selected' : '' }}>
                                    {{ $year->name }} {{ $year->is_active ? '(Aktif)' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="semester" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Semester</label>
                        <select name="semester" id="semester" class="w-full text-xs rounded-xl border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 bg-white text-slate-800 py-2.5 px-3">
                            <option value="ganjil" {{ $semester === 'ganjil' ? 'selected' : '' }}>Semester Ganjil (1)</option>
                            <option value="genap" {{ $semester === 'genap' ? 'selected' : '' }}>Semester Genap (2)</option>
                        </select>
                    </div>

                    <div>
                        <button type="submit" class="w-full py-2.5 px-4 bg-navy hover:bg-slate-800 text-white text-xs font-bold rounded-xl transition flex items-center justify-center gap-2 shadow-xs cursor-pointer">
                            <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                            <span>Tampilkan Jadwal</span>
                        </button>
                    </div>
                </form>
            </div>

            @if ($schedulesGrouped->isEmpty())
                <div class="bg-white rounded-3xl border border-slate-200/90 p-12 text-center shadow-xs">
                    <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <h4 class="text-sm font-bold text-navy mb-1">Belum Ada Jadwal Mengajar</h4>
                    <p class="text-xs text-slate-500 max-w-sm mx-auto">
                        Tidak ada alokasi jam mengajar yang tercatat untuk Anda pada semester {{ $semester }}. Silakan hubungi bagian kurikulum jika penugasan mengajar Anda belum terbit.
                    </p>
                </div>
            @else
                <!-- Weekly Schedule Table Grouped by Day -->
                <div class="space-y-6">
                    @foreach ($days as $dayKey => $dayName)
                        @php
                            $daySchedules = $schedulesGrouped->get($dayKey, collect());
                        @endphp

                        <div class="bg-white rounded-3xl border border-slate-200/90 overflow-hidden shadow-xs">
                            <div class="px-6 py-4 bg-slate-50/80 border-b border-slate-100 flex items-center justify-between">
                                <h3 class="font-extrabold text-sm text-navy tracking-tight flex items-center gap-2">
                                    <span>{{ $dayName }}</span>
                                </h3>
                                <span class="text-xs font-bold px-3 py-1 rounded-full {{ $daySchedules->isNotEmpty() ? 'bg-indigo-50 text-brand border border-indigo-200/70' : 'bg-slate-200/70 text-slate-600' }}">
                                    {{ $daySchedules->count() }} sesi
                                </span>
                            </div>

                            @if ($daySchedules->isEmpty())
                                <div class="p-6 text-center text-xs text-slate-400 italic">
                                    Tidak ada jadwal mengajar pada hari {{ $dayName }}.
                                </div>
                            @else
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left text-xs">
                                        <thead class="bg-slate-50/40 text-slate-500 uppercase font-bold text-[10px] border-b border-slate-100">
                                            <tr>
                                                <th scope="col" class="py-3 px-6 w-40">Waktu</th>
                                                <th scope="col" class="py-3 px-6">Mata Pelajaran</th>
                                                <th scope="col" class="py-3 px-6">Kelas</th>
                                                <th scope="col" class="py-3 px-6">Ruangan</th>
                                                <th scope="col" class="py-3 px-6 text-right">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            @foreach ($daySchedules as $sched)
                                                <tr class="hover:bg-slate-50/75 transition">
                                                    <!-- Time -->
                                                    <td class="py-4 px-6 font-mono font-bold text-navy whitespace-nowrap">
                                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-100 border border-slate-200/80 text-xs">
                                                            <svg class="w-3.5 h-3.5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                            {{ $sched->time_range }}
                                                        </span>
                                                    </td>

                                                    <!-- Subject -->
                                                    <td class="py-4 px-6">
                                                        <div class="font-extrabold text-navy text-sm">{{ $sched->subject->name }}</div>
                                                        <div class="text-[11px] text-slate-400 font-mono mt-0.5">Kode: {{ $sched->subject->code }}</div>
                                                    </td>

                                                    <!-- Class -->
                                                    <td class="py-4 px-6">
                                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-extrabold bg-navy text-white">
                                                            {{ $sched->classroom->name }}
                                                        </span>
                                                        <div class="text-[11px] text-slate-400 mt-0.5">Tingkat {{ $sched->classroom->grade_level }} • {{ $sched->classroom->major }}</div>
                                                    </td>

                                                    <!-- Room -->
                                                    <td class="py-4 px-6">
                                                        @if ($sched->room)
                                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 border border-slate-200 text-xs font-semibold">
                                                                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                                                {{ $sched->room->name }}
                                                            </span>
                                                        @else
                                                            <span class="text-slate-400 italic text-xs">Ruang Kelas Standar</span>
                                                        @endif
                                                    </td>

                                                    <!-- Action -->
                                                    <td class="py-4 px-6 text-right">
                                                        <a href="{{ route('teacher.attendances.index', ['schedule_id' => $sched->id]) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-bold text-brand bg-indigo-50 hover:bg-brand hover:text-white transition">
                                                            <span>Presensi</span>
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        @endif
    </div>
</x-app-layout>
