<x-app-layout title="Presensi Siswa Mata Pelajaran">
    <x-slot name="header">
        Kegiatan Guru: Presensi Siswa Mapel
    </x-slot>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-navy">Presensi Siswa Mata Pelajaran</h1>
                <p class="text-xs text-slate-600 mt-1">Pemantauan kehadiran peserta didik pada sesi mata pelajaran dan kelas yang Anda ampu.</p>
            </div>
        </div>

        @if ($schedules->isEmpty())
            <div class="bg-surface rounded-xl border border-dashed border-border p-12 text-center shadow-sm">
                <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="text-sm font-bold text-navy mb-1">Belum Ada Jadwal Mengajar</h3>
                <p class="text-xs text-slate-600 max-w-md mx-auto">
                    Anda belum memiliki jadwal mengajar resmi yang terdaftar pada sistem kurikulum. Presensi siswa per sesi mapel akan aktif setelah jadwal mengajar diterbitkan.
                </p>
            </div>
        @else
            <!-- Filter Bar: Schedule & Date -->
            <div class="bg-surface rounded-xl border border-border p-5 shadow-sm">
                <form method="GET" action="{{ route('teacher.attendances.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
                    <div class="sm:col-span-2">
                        <label for="schedule_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pilih Sesi Mengajar / Kelas <span class="text-danger">*</span></label>
                        <select name="schedule_id" id="schedule_id" required class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
                            @foreach ($schedules as $sched)
                                <option value="{{ $sched->id }}" {{ $selectedScheduleId == $sched->id ? 'selected' : '' }}>
                                    {{ $sched->classroom->name }} — {{ $sched->subject->name }} ({{ ucfirst($sched->day_of_week->value) }}, {{ $sched->time_range }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal Sesi</label>
                        <div class="flex items-center gap-2">
                            <input type="date" name="date" id="date" value="{{ $date }}"
                                   class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
                            <button type="submit" class="px-4 py-2 bg-navy hover:bg-navy-light text-white text-xs font-semibold rounded-lg transition shrink-0">
                                Buka
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            @if ($schedule)
                <!-- Session Metadata Banner -->
                <div class="bg-surface rounded-xl border border-border p-5 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-base font-bold text-navy">{{ $schedule->classroom->name }} — {{ $schedule->subject->name }}</h2>
                            <span class="px-2.5 py-0.5 rounded text-[11px] font-semibold bg-slate-100 text-slate-700 border border-slate-300">
                                {{ $schedule->subject->code }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-600 mt-1">
                            Jadwal Rutin: <strong class="text-slate-800">{{ ucfirst($schedule->day_of_week->value) }}, {{ $schedule->time_range }}</strong>
                            &bull; Ruangan: <strong class="text-slate-800">{{ $schedule->room ? $schedule->room->name : 'Ruang Kelas Standar' }}</strong>
                            &bull; Tanggal Sesi: <strong class="text-slate-800">{{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}</strong>
                        </p>
                    </div>

                    <div class="flex items-center gap-4 text-xs">
                        <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-lg text-center min-w-[90px]">
                            <span class="text-slate-500 block text-[10px] uppercase font-semibold">Total Siswa</span>
                            <span class="text-base font-bold text-navy">{{ $enrolledStudents->count() }}</span>
                        </div>
                        <div class="p-2.5 bg-emerald-50/60 border border-emerald-200 rounded-lg text-center min-w-[90px]">
                            <span class="text-emerald-700 block text-[10px] uppercase font-semibold">Tercatat Hadir</span>
                            <span class="text-base font-bold text-emerald-800">
                                {{ $attendances->whereIn('status', [\App\Enums\AttendanceStatus::Hadir, \App\Enums\AttendanceStatus::Terlambat])->count() }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Students Attendance Table -->
                <div class="bg-surface rounded-xl border border-border overflow-hidden shadow-sm">
                    <div class="px-5 py-3.5 bg-slate-50 border-b border-border flex items-center justify-between">
                        <h3 class="font-bold text-sm text-navy">Presensi Siswa Kelas pada Sesi Ini</h3>
                        <span class="text-xs text-slate-500 font-medium">{{ $enrolledStudents->count() }} siswa terdaftar</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-slate-800">
                            <thead class="bg-slate-100/70 text-slate-600 uppercase font-bold text-[11px] border-b border-border">
                                <tr>
                                    <th scope="col" class="py-3 px-5 w-12">No</th>
                                    <th scope="col" class="py-3 px-5">NIS</th>
                                    <th scope="col" class="py-3 px-5">Nama Siswa</th>
                                    <th scope="col" class="py-3 px-5">Waktu Masuk</th>
                                    <th scope="col" class="py-3 px-5">Status Kehadiran</th>
                                    <th scope="col" class="py-3 px-5">Catatan / Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border">
                                @forelse ($enrolledStudents as $idx => $student)
                                    @php
                                        $attRecord = $attendances->firstWhere('student_id', $student->id);
                                    @endphp
                                    <tr class="hover:bg-slate-50/80 transition">
                                        <td class="py-3.5 px-5 text-slate-400 font-mono">{{ $idx + 1 }}</td>
                                        <td class="py-3.5 px-5 font-mono text-slate-600">{{ $student->nis }}</td>
                                        <td class="py-3.5 px-5 font-bold text-navy">{{ $student->name }}</td>
                                        <td class="py-3.5 px-5 font-mono text-slate-700">
                                            {{ $attRecord && $attRecord->check_in_time ? substr((string) $attRecord->check_in_time, 0, 5) : '-' }}
                                        </td>
                                        <td class="py-3.5 px-5">
                                            @if ($attRecord)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-semibold border {{ $attRecord->status->badgeClass() }}">
                                                    {{ $attRecord->status->label() }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-300">
                                                    Belum Tercatat
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3.5 px-5 text-slate-500 italic">
                                            {{ $attRecord?->notes ?? '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="p-8 text-center text-xs text-slate-500 italic">
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
