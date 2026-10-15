<x-app-layout title="Jadwal Pelajaran">
    <x-slot name="header">
        Akademik: Jadwal Pelajaran
    </x-slot>

    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-navy">Jadwal Pelajaran</h1>
                <p class="text-xs text-slate-600 mt-1">Penyusunan dan monitoring alokasi jam belajar mengajar per kelas dengan pencegahan bentrok otomatis.</p>
            </div>
            <div>
                <a href="{{ route('admin.schedules.create', ['classroom_id' => $classroomId, 'academic_year_id' => $academicYearId, 'semester' => $semester]) }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-brand hover:bg-brand-hover text-white text-xs font-semibold rounded-lg shadow-sm transition focus:outline-none focus:ring-2 focus:ring-brand focus:ring-offset-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Jadwal Pelajaran
                </a>
            </div>
        </div>

        <!-- Filter Panel -->
        <div class="bg-surface rounded-xl border border-border shadow-sm p-5">
            <form method="GET" action="{{ route('admin.schedules.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
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
                    <label for="classroom_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Pilih Kelas <span class="text-danger">*</span>
                    </label>
                    <select name="classroom_id" id="classroom_id" required class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
                        <option value="">-- Pilih Kelas Terlebih Dahulu --</option>
                        @foreach ($classrooms as $cls)
                            <option value="{{ $cls->id }}" {{ $classroomId == $cls->id ? 'selected' : '' }}>
                                {{ $cls->name }} (Kelas {{ $cls->grade_level }} • {{ $cls->major }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="day_of_week" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Filter Hari</label>
                    <select name="day_of_week" id="day_of_week" class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
                        <option value="">Semua Hari (Senin - Sabtu)</option>
                        @foreach ($days as $val => $lbl)
                            <option value="{{ $val }}" {{ $dayOfWeek === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-navy hover:bg-navy-light text-white text-xs font-semibold rounded-lg transition flex items-center justify-center gap-2 focus:outline-none focus:ring-2 focus:ring-navy focus:ring-offset-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                        Tampilkan Jadwal
                    </button>
                    <a href="{{ route('admin.schedules.index') }}" class="p-2 border border-border text-slate-600 rounded-lg hover:bg-slate-100 transition focus:outline-none focus:ring-2 focus:ring-slate-400" title="Reset filter pilihan">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    </a>
                </div>
            </form>
        </div>

        @if (! $classroomId)
            <!-- Unselected State: Contextual Guidance -->
            <div class="bg-surface rounded-xl border border-dashed border-border p-12 text-center shadow-sm">
                <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="text-sm font-bold text-navy mb-1">Pilih Kelas untuk Menampilkan Jadwal</h3>
                <p class="text-xs text-slate-600 max-w-md mx-auto">
                    Untuk memastikan alokasi jam belajar terkelola rapi dan terhindar dari tumpang tindih, silakan tentukan kelas terlebih dahulu melalui menu dropdown di atas.
                </p>
            </div>
        @else
            <!-- Selected Classroom Metadata Banner -->
            <div class="bg-surface rounded-xl border border-border p-5 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-navy text-white flex items-center justify-center font-bold text-base shrink-0">
                        {{ substr($selectedClassroom->name, 0, 3) }}
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-base font-bold text-navy">{{ $selectedClassroom->name }}</h2>
                            <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-slate-100 text-slate-700 border border-slate-300">
                                Tingkat {{ $selectedClassroom->grade_level }} • {{ $selectedClassroom->major }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-600 mt-1">
                            Wali Kelas: <strong class="text-slate-800">{{ $selectedClassroom->homeroomTeacher?->name ?? 'Belum ditentukan' }}</strong>
                            &bull; Periode: <strong class="text-slate-800 capitalize">{{ $semester }}</strong>
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <span class="text-xs text-slate-500 block">Total Sesi Terjadwal</span>
                        <span class="text-base font-bold text-navy">{{ $schedulesGrouped->flatten()->count() }} Jam Pelajaran</span>
                    </div>
                    <a href="{{ route('admin.schedules.create', ['classroom_id' => $classroomId, 'academic_year_id' => $academicYearId, 'semester' => $semester]) }}"
                       class="px-3.5 py-2 bg-brand hover:bg-brand-hover text-white text-xs font-semibold rounded-lg shadow-sm transition flex items-center gap-1.5 focus:outline-none focus:ring-2 focus:ring-brand focus:ring-offset-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Sesi Kelas Ini
                    </a>
                </div>
            </div>

            @if ($schedulesGrouped->isEmpty())
                <!-- Empty Class Schedule State -->
                <div class="bg-surface rounded-xl border border-border p-10 text-center shadow-sm">
                    <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h4 class="text-sm font-bold text-slate-800 mb-1">Belum Ada Jadwal Pelajaran</h4>
                    <p class="text-xs text-slate-500 max-w-sm mx-auto mb-4">
                        Kelas ini belum memiliki susunan mata pelajaran pada semester {{ $semester }}. Mulai tambahkan mata pelajaran dan alokasi guru pengajar.
                    </p>
                    <a href="{{ route('admin.schedules.create', ['classroom_id' => $classroomId, 'academic_year_id' => $academicYearId, 'semester' => $semester]) }}"
                       class="inline-flex items-center gap-1.5 px-4 py-2 bg-brand text-white text-xs font-semibold rounded-lg hover:bg-brand-hover transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Buat Jadwal Pertama
                    </a>
                </div>
            @else
                <!-- Structured Day-by-Day Timetables -->
                <div class="space-y-6">
                    @php
                        $displayDays = $dayOfWeek ? [$dayOfWeek => $days[$dayOfWeek] ?? ucfirst($dayOfWeek)] : $days;
                    @endphp

                    @foreach ($displayDays as $dayKey => $dayName)
                        @php
                            $daySchedules = $schedulesGrouped->get($dayKey, collect());
                        @endphp

                        <div class="bg-surface rounded-xl border border-border overflow-hidden shadow-sm">
                            <!-- Day Header -->
                            <div class="px-5 py-3.5 bg-slate-50 border-b border-border flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <h3 class="font-bold text-sm text-navy tracking-tight">{{ $dayName }}</h3>
                                    <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full {{ $daySchedules->isNotEmpty() ? 'bg-blue-50 text-brand border border-blue-200' : 'bg-slate-200/70 text-slate-600' }}">
                                        {{ $daySchedules->count() }} sesi pelajaran
                                    </span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.schedules.create', ['classroom_id' => $classroomId, 'academic_year_id' => $academicYearId, 'semester' => $semester, 'day_of_week' => $dayKey]) }}"
                                       class="text-xs font-semibold text-brand hover:text-brand-hover transition inline-flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        Tambah di {{ $dayName }}
                                    </a>
                                </div>
                            </div>

                            @if ($daySchedules->isEmpty())
                                <div class="p-6 text-center text-xs text-slate-500 italic">
                                    Tidak ada mata pelajaran yang dijadwalkan pada hari {{ $dayName }}.
                                </div>
                            @else
                                <!-- Legible Table for Real Administrative Work -->
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left text-xs text-slate-800">
                                        <thead class="bg-slate-100/70 text-slate-600 uppercase font-bold text-[11px] border-b border-border">
                                            <tr>
                                                <th scope="col" class="py-3 px-5 w-36">Waktu</th>
                                                <th scope="col" class="py-3 px-5">Mata Pelajaran</th>
                                                <th scope="col" class="py-3 px-5">Guru Pengajar</th>
                                                <th scope="col" class="py-3 px-5">Ruangan</th>
                                                <th scope="col" class="py-3 px-5 w-24 text-right">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-border">
                                            @foreach ($daySchedules as $sched)
                                                <tr class="hover:bg-slate-50/80 transition">
                                                    <!-- Time Slot -->
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

                                                    <!-- Teacher -->
                                                    <td class="py-3.5 px-5">
                                                        <div class="font-semibold text-slate-800">{{ $sched->teacher->name }}</div>
                                                        <div class="text-[11px] text-slate-500 mt-0.5">NIP: {{ $sched->teacher->nip ?? '-' }}</div>
                                                    </td>

                                                    <!-- Room -->
                                                    <td class="py-3.5 px-5">
                                                        @if ($sched->room)
                                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-slate-100 text-slate-700 border border-slate-200 text-xs font-medium">
                                                                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                                                {{ $sched->room->name }}
                                                            </span>
                                                        @else
                                                            <span class="text-slate-500 italic text-xs">Ruang Kelas Standar</span>
                                                        @endif
                                                    </td>

                                                    <!-- Actions -->
                                                    <td class="py-3.5 px-5 text-right whitespace-nowrap">
                                                        <div class="inline-flex items-center gap-1 justify-end">
                                                            <a href="{{ route('admin.schedules.edit', $sched) }}"
                                                               class="p-1.5 text-slate-500 hover:text-brand hover:bg-slate-100 rounded-lg transition"
                                                               title="Ubah Jadwal">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                            </a>
                                                            <form action="{{ route('admin.schedules.destroy', $sched) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                        class="p-1.5 text-slate-500 hover:text-danger hover:bg-rose-50 rounded-lg transition"
                                                                        title="Hapus Jadwal">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                                </button>
                                                            </form>
                                                        </div>
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
