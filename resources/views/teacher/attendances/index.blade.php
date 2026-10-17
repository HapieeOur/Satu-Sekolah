<x-app-layout title="Presensi Siswa Mata Pelajaran">
    <x-slot name="header">
        Kegiatan Guru: Presensi Siswa Mapel
    </x-slot>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-navy tracking-tight">Presensi Siswa Mata Pelajaran</h1>
                <p class="text-xs text-slate-500 mt-0.5">Pemantauan kehadiran peserta didik pada sesi mata pelajaran dan kelas binaan Anda.</p>
            </div>
        </div>

        @if ($schedules->isEmpty())
            <div class="bg-white rounded-3xl border border-slate-200/90 p-12 text-center shadow-xs">
                <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="text-base font-extrabold text-navy mb-1">Belum Ada Jadwal Mengajar</h3>
                <p class="text-xs text-slate-500 max-w-md mx-auto">
                    Anda belum memiliki jadwal mengajar resmi yang terdaftar pada sistem kurikulum. Presensi siswa per sesi mapel akan aktif setelah jadwal mengajar diterbitkan.
                </p>
            </div>
        @else
            <!-- Filter Bar: Schedule & Date -->
            <div class="bg-white rounded-3xl border border-slate-200/90 p-6 shadow-xs">
                <form method="GET" action="{{ route('teacher.attendances.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
                    <div class="sm:col-span-2">
                        <label for="schedule_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Pilih Sesi Mengajar / Kelas <span class="text-rose-500">*</span></label>
                        <select name="schedule_id" id="schedule_id" required class="w-full text-xs rounded-xl border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 bg-white text-slate-800 py-2.5 px-3">
                            @foreach ($schedules as $sched)
                                <option value="{{ $sched->id }}" {{ $selectedScheduleId == $sched->id ? 'selected' : '' }}>
                                    {{ $sched->classroom->name }} — {{ $sched->subject->name }} ({{ ucfirst($sched->day_of_week->value) }}, {{ $sched->time_range }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tanggal Sesi</label>
                        <div class="flex items-center gap-2">
                            <input type="date" name="date" id="date" value="{{ $date }}"
                                   class="w-full text-xs rounded-xl border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 bg-white text-slate-800 py-2.5 px-3">
                            <button type="submit" class="px-5 py-2.5 bg-navy hover:bg-slate-800 text-white text-xs font-bold rounded-xl transition shrink-0 shadow-xs cursor-pointer">
                                Buka
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            @if ($schedule)
                <!-- Session Metadata Banner -->
                <div class="bg-white rounded-3xl border border-slate-200/90 p-6 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-5">
                    <div>
                        <div class="flex items-center gap-2.5">
                            <h2 class="text-lg font-black text-navy">{{ $schedule->classroom->name }} — {{ $schedule->subject->name }}</h2>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-indigo-50 text-brand border border-indigo-200">
                                {{ $schedule->subject->code }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 mt-1.5 flex flex-wrap items-center gap-2">
                            <span>Jadwal: <strong class="text-navy">{{ ucfirst($schedule->day_of_week->value) }}, {{ $schedule->time_range }}</strong></span>
                            <span>&bull;</span>
                            <span>Ruangan: <strong class="text-navy">{{ $schedule->room ? $schedule->room->name : 'Ruang Kelas Standar' }}</strong></span>
                            <span>&bull;</span>
                            <span>Tanggal: <strong class="text-navy">{{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}</strong></span>
                        </p>
                    </div>

                    <div class="flex items-center gap-3 text-xs">
                        <div class="p-3 bg-slate-50 border border-slate-100 rounded-2xl text-center min-w-[100px]">
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">Total Siswa</span>
                            <span class="text-xl font-black text-navy mt-0.5 block">{{ $enrolledStudents->count() }}</span>
                        </div>
                        <div class="p-3 bg-emerald-50/70 border border-emerald-100 rounded-2xl text-center min-w-[100px]">
                            <span class="text-emerald-700 block text-[10px] uppercase font-bold">Tercatat Hadir</span>
                            <span class="text-xl font-black text-emerald-800 mt-0.5 block">
                                {{ $attendances->whereIn('status', [\App\Enums\AttendanceStatus::Hadir, \App\Enums\AttendanceStatus::Terlambat])->count() }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Students Attendance Table -->
                <div class="bg-white rounded-3xl border border-slate-200/90 overflow-hidden shadow-xs">
                    <div class="px-6 py-4 bg-slate-50/80 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="font-extrabold text-sm text-navy">Presensi Siswa Kelas pada Sesi Ini</h3>
                        <span class="text-xs text-slate-400 font-medium">{{ $enrolledStudents->count() }} peserta didik</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-50/40 text-slate-500 uppercase font-bold text-[10px] border-b border-slate-100">
                                <tr>
                                    <th scope="col" class="py-3 px-6 w-12">No</th>
                                    <th scope="col" class="py-3 px-6">NIS</th>
                                    <th scope="col" class="py-3 px-6">Nama Siswa</th>
                                    <th scope="col" class="py-3 px-6">Waktu Masuk</th>
                                    <th scope="col" class="py-3 px-6">Status Kehadiran</th>
                                    <th scope="col" class="py-3 px-6">Catatan / Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($enrolledStudents as $idx => $student)
                                    @php
                                        $attRecord = $attendances->firstWhere('student_id', $student->id);
                                    @endphp
                                    <tr class="hover:bg-slate-50/75 transition">
                                        <td class="py-4 px-6 text-slate-400 font-mono">{{ $idx + 1 }}</td>
                                        <td class="py-4 px-6 font-mono font-medium text-slate-500">{{ $student->nis }}</td>
                                        <td class="py-4 px-6 font-bold text-navy text-xs sm:text-sm">{{ $student->name }}</td>
                                        <td class="py-4 px-6 font-mono font-semibold text-slate-600">
                                            {{ $attRecord && $attRecord->check_in_time ? substr((string) $attRecord->check_in_time, 0, 5) : '-' }}
                                        </td>
                                        <td class="py-4 px-6">
                                            @if ($attRecord)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $attRecord->status->badgeClass() }}">
                                                    {{ $attRecord->status->label() }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-500 border border-slate-200">
                                                    Belum Tercatat
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 text-slate-500">
                                            {{ $attRecord?->notes ?? '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-12 text-center text-xs text-slate-400 italic">
                                            Tidak ada data siswa terdaftar pada kelas ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        @endif
    </div>
</x-app-layout>
