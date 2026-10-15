<x-app-layout title="Jadwal Mengajar Saya">
    <x-slot name="header">
        Kegiatan Guru: Jadwal Mengajar
    </x-slot>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-navy">Jadwal Mengajar Saya</h1>
                <p class="text-xs text-slate-600 mt-1">Agenda mengajar mingguan Anda berdasarkan penetapan tahun ajaran dan semester aktif.</p>
            </div>
        </div>

        @if (! $teacher)
            <div class="bg-amber-50 border border-amber-300 rounded-xl p-5 text-amber-900 shadow-sm">
                <h3 class="font-bold text-sm mb-1">Profil Guru Belum Terhubung</h3>
                <p class="text-xs text-amber-800 leading-relaxed">
                    Akun pengguna Anda belum ditautkan dengan data guru di pangkalan data sekolah. Hubungi Administrator untuk melakukan sinkronisasi data akun dengan profil guru.
                </p>
            </div>
        @else
            <!-- Teacher Profile & Metrics Banner -->
            <div class="bg-surface rounded-xl border border-border p-5 shadow-sm">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                    <!-- Teacher Identity -->
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-navy text-white flex items-center justify-center font-bold text-base shrink-0">
                            {{ substr($teacher->name, 0, 2) }}
                        </div>
                        <div>
                            <h2 class="text-base font-bold text-navy">{{ $teacher->name }}</h2>
                            <p class="text-xs text-slate-600 mt-0.5">NIP: {{ $teacher->nip ?? '-' }} &bull; NUPTK: {{ $teacher->nuptk ?? '-' }}</p>
                        </div>
                    </div>

                    <!-- Workload -->
                    <div class="border-y md:border-y-0 md:border-x border-border py-3 md:py-0 md:px-6">
                        <span class="text-xs text-slate-500 block">Total Beban Mengajar</span>
                        <span class="text-lg font-bold text-navy mt-0.5 block">{{ $totalSlots }} Sesi / Minggu</span>
                    </div>

                    <!-- Assigned Classes -->
                    <div>
                        <span class="text-xs text-slate-500 block mb-1.5">Kelas yang Diampu</span>
                        <div class="flex flex-wrap gap-1.5">
                            @forelse ($uniqueClassrooms as $clsName)
                                <span class="px-2.5 py-0.5 rounded text-xs font-semibold bg-slate-100 text-slate-800 border border-slate-300">
                                    {{ $clsName }}
                                </span>
                            @empty
                                <span class="text-xs text-slate-500 italic">Belum ada penugasan kelas</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Bar -->
            <div class="bg-surface rounded-xl border border-border p-5 shadow-sm">
                <form method="GET" action="{{ route('teacher.schedules.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
                    <div>
                        <label for="academic_year_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tahun Ajaran</label>
                        <select name="academic_year_id" id="academic_year_id" class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
                            @foreach ($academicYears as $year)
                                <option value="{{ $year->id }}" {{ $academicYearId == $year->id ? 'selected' : '' }}>
                                    {{ $year->name }} {{ $year->is_active ? '(Aktif)' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="semester" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Semester</label>
                        <select name="semester" id="semester" class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
                            <option value="ganjil" {{ $semester === 'ganjil' ? 'selected' : '' }}>Semester Ganjil (1)</option>
                            <option value="genap" {{ $semester === 'genap' ? 'selected' : '' }}>Semester Genap (2)</option>
                        </select>
                    </div>

                    <div>
                        <button type="submit" class="w-full px-4 py-2 bg-navy hover:bg-navy-light text-white text-xs font-semibold rounded-lg transition flex items-center justify-center gap-2 focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                            Tampilkan Jadwal
                        </button>
                    </div>
                </form>
            </div>

            @if ($schedulesGrouped->isEmpty())
                <div class="bg-surface rounded-xl border border-border p-12 text-center shadow-sm">
                    <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <h4 class="text-sm font-bold text-slate-800 mb-1">Belum Ada Jadwal Mengajar</h4>
                    <p class="text-xs text-slate-600 max-w-sm mx-auto">
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

                        <div class="bg-surface rounded-xl border border-border overflow-hidden shadow-sm">
                            <div class="px-5 py-3.5 bg-slate-50 border-b border-border flex items-center justify-between">
                                <h3 class="font-bold text-sm text-navy tracking-tight">{{ $dayName }}</h3>
                                <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full {{ $daySchedules->isNotEmpty() ? 'bg-blue-50 text-brand border border-blue-200' : 'bg-slate-200/70 text-slate-600' }}">
                                    {{ $daySchedules->count() }} sesi
                                </span>
                            </div>

                            @if ($daySchedules->isEmpty())
                                <div class="p-6 text-center text-xs text-slate-500 italic">
                                    Tidak ada jadwal mengajar pada hari {{ $dayName }}.
                                </div>
                            @else
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left text-xs text-slate-800">
                                        <thead class="bg-slate-100/70 text-slate-600 uppercase font-bold text-[11px] border-b border-border">
                                            <tr>
                                                <th scope="col" class="py-3 px-5 w-36">Waktu</th>
                                                <th scope="col" class="py-3 px-5">Mata Pelajaran</th>
                                                <th scope="col" class="py-3 px-5">Kelas</th>
                                                <th scope="col" class="py-3 px-5">Ruangan</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-border">
                                            @foreach ($daySchedules as $sched)
                                                <tr class="hover:bg-slate-50/80 transition">
                                                    <!-- Time -->
                                                    <td class="py-3.5 px-5 font-bold text-navy whitespace-nowrap">
                                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-slate-100 border border-slate-200">
                                                            <svg class="w-3.5 h-3.5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                            {{ $sched->time_range }}
                                                        </span>
                                                    </td>

                                                    <!-- Subject -->
                                                    <td class="py-3.5 px-5">
                                                        <div class="font-bold text-navy text-sm">{{ $sched->subject->name }}</div>
                                                        <div class="text-[11px] text-slate-500 font-mono mt-0.5">Kode: {{ $sched->subject->code }}</div>
                                                    </td>

                                                    <!-- Class -->
                                                    <td class="py-3.5 px-5">
                                                        <span class="inline-flex items-center px-2.5 py-1 rounded text-xs font-bold bg-navy text-white">
                                                            {{ $sched->classroom->name }}
                                                        </span>
                                                        <div class="text-[11px] text-slate-500 mt-0.5">Tingkat {{ $sched->classroom->grade_level }} • {{ $sched->classroom->major }}</div>
                                                    </td>

                                                    <!-- Room -->
                                                    <td class="py-3.5 px-5">
                                                        @if ($sched->room)
                                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded bg-slate-100 text-slate-700 border border-slate-200 text-xs font-medium">
                                                                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                                {{ $sched->room->name }}
                                                            </span>
                                                        @else
                                                            <span class="text-slate-500 italic text-xs">Ruang Kelas Standar</span>
                                                        @endif
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
