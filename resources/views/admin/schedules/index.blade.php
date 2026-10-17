<x-app-layout title="Jadwal Pelajaran & KBM">
    <x-slot name="header">
        Akademik: Jadwal Pelajaran
    </x-slot>

    <div class="space-y-6">
        <!-- Top Hero / Page Header -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 p-6 md:p-8 text-white shadow-xl">
            <div class="absolute -right-12 -top-12 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -left-12 -bottom-12 w-64 h-64 bg-brand/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/20 border border-indigo-400/30 text-indigo-300 text-xs font-semibold mb-3">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Distribusi Jam Belajar & KBM</span>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-white">Jadwal Pelajaran</h1>
                    <p class="text-sm text-slate-300 mt-1 max-w-xl">
                        Penyusunan dan monitoring alokasi jam tatap muka per kelas, penugasan ruangan, dan sistem validasi anti-bentrok jadwal otomatis.
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.schedules.create', ['classroom_id' => $classroomId, 'academic_year_id' => $academicYearId, 'semester' => $semester]) }}"
                       class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold text-xs shadow-lg shadow-indigo-500/25 transition duration-150 transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        <span>Tambah Jadwal Pelajaran</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Filter Panel Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5">
            <form method="GET" action="{{ route('admin.schedules.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
                <div>
                    <label for="academic_year_id" class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Tahun Ajaran</label>
                    <select name="academic_year_id" id="academic_year_id" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800">
                        @foreach ($academicYears as $year)
                            <option value="{{ $year->id }}" {{ $academicYearId == $year->id ? 'selected' : '' }}>
                                {{ $year->name }} {{ $year->is_active ? '★ (Aktif)' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="semester" class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Semester</label>
                    <select name="semester" id="semester" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800">
                        <option value="ganjil" {{ $semester === 'ganjil' ? 'selected' : '' }}>Semester Ganjil (1)</option>
                        <option value="genap" {{ $semester === 'genap' ? 'selected' : '' }}>Semester Genap (2)</option>
                    </select>
                </div>

                <div>
                    <label for="classroom_id" class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">
                        Pilih Kelas <span class="text-rose-500">*</span>
                    </label>
                    <select name="classroom_id" id="classroom_id" required class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800 font-semibold">
                        <option value="">-- Pilih Kelas Terlebih Dahulu --</option>
                        @foreach ($classrooms as $cls)
                            <option value="{{ $cls->id }}" {{ $classroomId == $cls->id ? 'selected' : '' }}>
                                {{ $cls->name }} (Kelas {{ $cls->grade_level }} • {{ $cls->major }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="day_of_week" class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Filter Hari</label>
                    <select name="day_of_week" id="day_of_week" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800">
                        <option value="">Semua Hari (Senin - Sabtu)</option>
                        @foreach ($days as $val => $lbl)
                            <option value="{{ $val }}" {{ $dayOfWeek === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit" class="flex-1 px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold rounded-xl transition flex items-center justify-center gap-1.5 min-h-[42px] shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                        Tampilkan
                    </button>
                    <a href="{{ route('admin.schedules.index') }}" class="p-2.5 border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-100 transition min-h-[42px] flex items-center justify-center" title="Reset filter">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    </a>
                </div>
            </form>
        </div>

        @if (! $classroomId)
            <!-- Unselected State: Guidance Card -->
            <div class="bg-white rounded-2xl border-2 border-dashed border-slate-200 p-12 text-center shadow-sm">
                <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="text-base font-bold text-slate-800">Tentukan Kelas untuk Menampilkan Jadwal</h3>
                <p class="text-xs text-slate-500 max-w-md mx-auto mt-1 mb-5">
                    Pilih rombongan belajar pada menu dropdown di atas untuk mengelola susunan mata pelajaran dan alokasi guru pengajar kelas tersebut.
                </p>
            </div>
        @else
            <!-- Selected Classroom Metadata Banner -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-700 text-white flex items-center justify-center font-extrabold text-base shadow-sm shrink-0">
                        {{ substr($selectedClassroom->name, 0, 3) }}
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-base font-bold text-slate-900">{{ $selectedClassroom->name }}</h2>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                Tingkat {{ $selectedClassroom->grade_level }} • {{ $selectedClassroom->major }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 mt-1">
                            Wali Kelas: <strong class="text-slate-800">{{ $selectedClassroom->homeroomTeacher?->user->name ?? 'Belum ditentukan' }}</strong>
                            &bull; Periode: <strong class="text-slate-800 capitalize">Semester {{ $semester }}</strong>
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <span class="text-[11px] font-medium text-slate-400 block uppercase tracking-wider">Total Sesi Terjadwal</span>
                        <span class="text-lg font-bold text-slate-900">{{ $schedulesGrouped->flatten()->count() }} Jam Pelajaran</span>
                    </div>
                    <a href="{{ route('admin.schedules.create', ['classroom_id' => $classroomId, 'academic_year_id' => $academicYearId, 'semester' => $semester]) }}"
                       class="px-4 py-2.5 bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white text-xs font-semibold rounded-xl shadow-md shadow-indigo-500/20 transition flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>Tambah Sesi</span>
                    </a>
                </div>
            </div>

            @if ($schedulesGrouped->isEmpty())
                <!-- Empty Class Schedule State -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-12 text-center shadow-sm">
                    <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h4 class="text-base font-bold text-slate-800">Belum Ada Jadwal Pelajaran</h4>
                    <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1 mb-5">
                        Kelas ini belum memiliki susunan mata pelajaran pada semester {{ $semester }}. Mulai tambahkan mata pelajaran dan alokasi guru pengajar.
                    </p>
                    <a href="{{ route('admin.schedules.create', ['classroom_id' => $classroomId, 'academic_year_id' => $academicYearId, 'semester' => $semester]) }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl shadow-sm transition">
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

                        <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-sm">
                            <!-- Day Header -->
                            <div class="px-5 py-4 bg-slate-50/75 border-b border-slate-200 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <h3 class="font-bold text-sm text-slate-900 tracking-tight">{{ $dayName }}</h3>
                                    <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full {{ $daySchedules->isNotEmpty() ? 'bg-indigo-50 text-indigo-700 border border-indigo-200' : 'bg-slate-100 text-slate-500' }}">
                                        {{ $daySchedules->count() }} sesi pelajaran
                                    </span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.schedules.create', ['classroom_id' => $classroomId, 'academic_year_id' => $academicYearId, 'semester' => $semester, 'day_of_week' => $dayKey]) }}"
                                       class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition inline-flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        Tambah di {{ $dayName }}
                                    </a>
                                </div>
                            </div>

                            @if ($daySchedules->isEmpty())
                                <div class="p-8 text-center text-xs text-slate-400 italic">
                                    Tidak ada mata pelajaran yang dijadwalkan pada hari {{ $dayName }}.
                                </div>
                            @else
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left border-collapse text-xs">
                                        <thead class="bg-slate-50/50 text-slate-600 uppercase font-bold text-[11px] border-b border-slate-200">
                                            <tr>
                                                <th scope="col" class="py-3 px-5 w-40">Alokasi Waktu</th>
                                                <th scope="col" class="py-3 px-5">Mata Pelajaran</th>
                                                <th scope="col" class="py-3 px-5">Guru Pengajar</th>
                                                <th scope="col" class="py-3 px-5">Ruangan</th>
                                                <th scope="col" class="py-3 px-5 w-24 text-right">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            @foreach ($daySchedules as $sched)
                                                <tr class="hover:bg-indigo-50/30 transition-colors duration-150">
                                                    <!-- Time Slot -->
                                                    <td class="py-4 px-5 whitespace-nowrap">
                                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-slate-100 font-mono font-bold text-slate-800 border border-slate-200">
                                                            <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                            {{ $sched->time_range }}
                                                        </span>
                                                    </td>

                                                    <!-- Subject -->
                                                    <td class="py-4 px-5">
                                                        <div class="font-bold text-slate-900 text-sm">{{ $sched->subject->name }}</div>
                                                        <div class="text-[11px] text-slate-400 font-mono mt-0.5">Kode: {{ $sched->subject->code }}</div>
                                                    </td>

                                                    <!-- Teacher -->
                                                    <td class="py-4 px-5">
                                                        <div class="flex items-center gap-2.5">
                                                            <div class="w-7 h-7 rounded-full bg-slate-100 text-slate-700 font-bold text-[11px] flex items-center justify-center border border-slate-200 shrink-0">
                                                                {{ substr($sched->teacher->name, 0, 1) }}
                                                            </div>
                                                            <div>
                                                                <div class="font-semibold text-slate-800">{{ $sched->teacher->name }}</div>
                                                                <div class="text-[11px] text-slate-400 font-mono mt-0.5">NIP: {{ $sched->teacher->nip ?? '-' }}</div>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <!-- Room -->
                                                    <td class="py-4 px-5">
                                                        @if ($sched->room)
                                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 border border-slate-200 text-xs font-semibold">
                                                                <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                                                {{ $sched->room->name }}
                                                            </span>
                                                        @else
                                                            <span class="text-slate-400 italic text-xs">Ruang Kelas Standar</span>
                                                        @endif
                                                    </td>

                                                    <!-- Actions -->
                                                    <td class="py-4 px-5 text-right whitespace-nowrap">
                                                        <div class="inline-flex items-center gap-1.5 justify-end">
                                                            <a href="{{ route('admin.schedules.edit', $sched) }}"
                                                               class="p-2 text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition"
                                                               title="Ubah Jadwal">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                            </a>
                                                            <form action="{{ route('admin.schedules.destroy', $sched) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                        class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition"
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
