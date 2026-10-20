<x-app-layout title="Presensi Siswa Mata Pelajaran">
    <x-slot name="header">
        Kegiatan Guru: Presensi Siswa Mapel
    </x-slot>

    <div class="space-y-6">
        <!-- Flash Message -->
        @if (session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-navy tracking-tight">Presensi Siswa Mata Pelajaran</h1>
                <p class="text-xs text-slate-500 mt-0.5">Pencatatan dan pemantauan kehadiran peserta didik pada sesi mata pelajaran kelas Anda secara langsung.</p>
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

                <!-- Students Attendance Form & Table -->
                <form method="POST" action="{{ route('teacher.attendances.store') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                    <input type="hidden" name="date" value="{{ $date }}">

                    <div class="bg-white rounded-3xl border border-slate-200/90 overflow-hidden shadow-xs">
                        <div class="px-6 py-4 bg-slate-50/80 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div>
                                <h3 class="font-extrabold text-sm text-navy">Pencatatan Presensi Sesi Ini</h3>
                                <p class="text-[11px] text-slate-500">Pilih status kehadiran setiap peserta didik lalu klik Simpan Presensi.</p>
                            </div>

                            @if ($enrolledStudents->isNotEmpty())
                                <div class="flex items-center gap-2">
                                    <button type="button" onclick="setAllAttendance('hadir')" class="px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 text-xs font-bold rounded-xl transition cursor-pointer">
                                        &check; Tandai Semua Hadir
                                    </button>
                                    <button type="submit" class="px-4 py-2 bg-[#233DFF] hover:bg-indigo-700 text-white text-xs font-black rounded-xl shadow-md shadow-indigo-900/20 transition cursor-pointer flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                                        <span>Simpan Presensi</span>
                                    </button>
                                </div>
                            @endif
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs">
                                <thead class="bg-slate-50/40 text-slate-500 uppercase font-bold text-[10px] border-b border-slate-100">
                                    <tr>
                                        <th scope="col" class="py-3 px-6 w-12">No</th>
                                        <th scope="col" class="py-3 px-6">NIS</th>
                                        <th scope="col" class="py-3 px-6">Nama Siswa</th>
                                        <th scope="col" class="py-3 px-6">Status Kehadiran</th>
                                        <th scope="col" class="py-3 px-6">Catatan / Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse ($enrolledStudents as $idx => $student)
                                        @php
                                            $attRecord = $attendances->firstWhere('student_id', $student->id);
                                            $currentStatus = $attRecord ? $attRecord->status->value : 'hadir';
                                        @endphp
                                        <tr class="hover:bg-slate-50/75 transition">
                                            <td class="py-4 px-6 text-slate-400 font-mono">{{ $idx + 1 }}</td>
                                            <td class="py-4 px-6 font-mono font-medium text-slate-500">{{ $student->nis }}</td>
                                            <td class="py-4 px-6 font-bold text-navy text-xs sm:text-sm">
                                                {{ $student->name }}
                                                @if ($attRecord && $attRecord->check_in_time)
                                                    <span class="block text-[10px] font-normal text-slate-400 font-mono mt-0.5">Waktu: {{ substr((string) $attRecord->check_in_time, 0, 5) }}</span>
                                                @endif
                                            </td>
                                            <td class="py-4 px-6">
                                                <div class="flex items-center gap-1.5 flex-wrap">
                                                    @foreach (['hadir' => 'Hadir', 'terlambat' => 'Terlambat', 'izin' => 'Izin', 'sakit' => 'Sakit', 'alpa' => 'Alpa'] as $val => $lbl)
                                                        @php
                                                            $colorClass = match($val) {
                                                                'hadir' => 'peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:border-emerald-600 text-emerald-800 bg-emerald-50/80 border-emerald-200 hover:bg-emerald-100',
                                                                'terlambat' => 'peer-checked:bg-amber-500 peer-checked:text-white peer-checked:border-amber-500 text-amber-800 bg-amber-50/80 border-amber-200 hover:bg-amber-100',
                                                                'izin' => 'peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 text-blue-800 bg-blue-50/80 border-blue-200 hover:bg-blue-100',
                                                                'sakit' => 'peer-checked:bg-purple-600 peer-checked:text-white peer-checked:border-purple-600 text-purple-800 bg-purple-50/80 border-purple-200 hover:bg-purple-100',
                                                                'alpa' => 'peer-checked:bg-rose-600 peer-checked:text-white peer-checked:border-rose-600 text-rose-800 bg-rose-50/80 border-rose-200 hover:bg-rose-100',
                                                            };
                                                        @endphp
                                                        <label class="cursor-pointer select-none">
                                                            <input type="radio" 
                                                                   name="attendances[{{ $student->id }}][status]" 
                                                                   value="{{ $val }}" 
                                                                   class="hidden peer attendance-radio-{{ $val }}" 
                                                                   {{ $currentStatus === $val ? 'checked' : '' }}>
                                                            <span class="inline-block px-2.5 py-1 rounded-lg text-[10px] font-bold border transition-all shadow-2xs {{ $colorClass }}">
                                                                {{ $lbl }}
                                                            </span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td class="py-4 px-6">
                                                <input type="text" 
                                                       name="attendances[{{ $student->id }}][notes]" 
                                                       value="{{ $attRecord?->notes }}" 
                                                       placeholder="Keterangan opsional..." 
                                                       class="w-full max-w-xs text-xs rounded-xl border-slate-200 focus:border-brand focus:ring-1 focus:ring-brand bg-slate-50/60 focus:bg-white text-slate-700 py-1.5 px-3">
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-12 text-center text-xs text-slate-400 italic">
                                                Tidak ada data siswa terdaftar pada kelas ini.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($enrolledStudents->isNotEmpty())
                            <div class="px-6 py-4 bg-slate-50/60 border-t border-slate-100 flex items-center justify-between">
                                <span class="text-xs text-slate-500 font-medium">Total: {{ $enrolledStudents->count() }} peserta didik</span>
                                <button type="submit" class="px-5 py-2.5 bg-[#233DFF] hover:bg-indigo-700 text-white text-xs font-black rounded-xl shadow-md shadow-indigo-900/20 transition cursor-pointer flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                                    <span>Simpan Presensi Sesi Ini</span>
                                </button>
                            </div>
                        @endif
                    </div>
                </form>

                <script>
                    function setAllAttendance(status) {
                        const radios = document.querySelectorAll('.attendance-radio-' + status);
                        radios.forEach(radio => {
                            radio.checked = true;
                        });
                    }
                </script>
            @endif
        @endif
    </div>
</x-app-layout>
