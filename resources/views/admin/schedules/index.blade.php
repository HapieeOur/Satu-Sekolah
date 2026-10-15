@extends('layouts.app', ['title' => 'Jadwal Pelajaran'])

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-navy">Jadwal Pelajaran</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola dan susun jadwal mata pelajaran per kelas dengan deteksi otomatis bentrok jam, guru, dan ruangan.</p>
        </div>
        <div>
            <a href="{{ route('admin.schedules.create', ['classroom_id' => $classroomId, 'academic_year_id' => $academicYearId, 'semester' => $semester]) }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-brand text-white text-sm font-medium rounded-lg hover:bg-brand-hover shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Jadwal
            </a>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-surface rounded-xl border border-border p-5 shadow-sm">
        <form method="GET" action="{{ route('admin.schedules.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
            <div>
                <label for="academic_year_id" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">Tahun Ajaran</label>
                <select name="academic_year_id" id="academic_year_id" class="w-full text-sm rounded-lg border-border focus:border-brand focus:ring-brand">
                    @foreach ($academicYears as $year)
                        <option value="{{ $year->id }}" {{ $academicYearId == $year->id ? 'selected' : '' }}>
                            {{ $year->name }} {{ $year->is_active ? '(Aktif)' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="semester" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">Semester</label>
                <select name="semester" id="semester" class="w-full text-sm rounded-lg border-border focus:border-brand focus:ring-brand">
                    <option value="ganjil" {{ $semester === 'ganjil' ? 'selected' : '' }}>Semester Ganjil (1)</option>
                    <option value="genap" {{ $semester === 'genap' ? 'selected' : '' }}>Semester Genap (2)</option>
                </select>
            </div>

            <div>
                <label for="classroom_id" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                    Pilih Kelas <span class="text-danger">*</span>
                </label>
                <select name="classroom_id" id="classroom_id" required class="w-full text-sm rounded-lg border-border focus:border-brand focus:ring-brand">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach ($classrooms as $cls)
                        <option value="{{ $cls->id }}" {{ $classroomId == $cls->id ? 'selected' : '' }}>
                            {{ $cls->name }} (Kelas {{ $cls->grade_level }} - {{ $cls->major }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="day_of_week" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">Hari (Opsional)</label>
                <select name="day_of_week" id="day_of_week" class="w-full text-sm rounded-lg border-border focus:border-brand focus:ring-brand">
                    <option value="">Semua Hari</option>
                    @foreach ($days as $val => $lbl)
                        <option value="{{ $val }}" {{ $dayOfWeek === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="flex-1 px-4 py-2 bg-navy text-white text-sm font-medium rounded-lg hover:bg-navy-light transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    Tampilkan
                </button>
                <a href="{{ route('admin.schedules.index') }}" class="p-2 border border-border text-slate-600 rounded-lg hover:bg-slate-50 transition" title="Reset filter">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </a>
            </div>
        </form>
    </div>

    @if (! $classroomId)
        <!-- Empty Selection Notice -->
        <div class="bg-surface rounded-xl border border-dashed border-border p-12 text-center shadow-sm">
            <div class="w-16 h-16 rounded-2xl bg-brand-light text-brand flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <h3 class="text-base font-bold text-navy mb-1">Silakan Pilih Kelas Terlebih Dahulu</h3>
            <p class="text-sm text-slate-500 max-w-md mx-auto mb-6">
                Untuk menjaga konteks dan kenyamanan penyusunan jadwal, silakan pilih salah satu kelas melalui filter di atas.
            </p>
        </div>
    @else
        <!-- Classroom Header Banner -->
        <div class="bg-surface rounded-xl border border-border p-5 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-navy text-white flex items-center justify-center font-bold text-lg shrink-0">
                    {{ substr($selectedClassroom->name, 0, 3) }}
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-lg font-bold text-navy">{{ $selectedClassroom->name }}</h2>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-brand border border-blue-200">
                            Kelas {{ $selectedClassroom->grade_level }} • {{ $selectedClassroom->major }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 mt-1">
                        Wali Kelas: <strong class="text-slate-700">{{ $selectedClassroom->homeroomTeacher?->name ?? 'Belum ditentukan' }}</strong>
                        &bull; Semester: <strong class="text-slate-700 capitalize">{{ $semester }}</strong>
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="text-right">
                    <span class="text-xs text-slate-500 block">Total Sesi Terjadwal</span>
                    <span class="text-lg font-bold text-navy">{{ $schedulesGrouped->flatten()->count() }} Jam Pelajaran</span>
                </div>
                <a href="{{ route('admin.schedules.create', ['classroom_id' => $classroomId, 'academic_year_id' => $academicYearId, 'semester' => $semester]) }}"
                   class="px-3 py-1.5 bg-brand-light text-brand font-semibold text-xs rounded-lg hover:bg-brand hover:text-white transition flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Jadwal di Kelas Ini
                </a>
            </div>
        </div>

        @if ($schedulesGrouped->isEmpty())
            <div class="bg-surface rounded-xl border border-border p-10 text-center shadow-sm">
                <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h4 class="text-sm font-bold text-slate-700 mb-1">Belum Ada Jadwal Pelajaran</h4>
                <p class="text-xs text-slate-500 max-w-sm mx-auto mb-4">
                    Belum ada mata pelajaran yang dijadwalkan untuk kelas ini pada {{ ucfirst($semester) }} tahun ajaran terpilih.
                </p>
                <a href="{{ route('admin.schedules.create', ['classroom_id' => $classroomId, 'academic_year_id' => $academicYearId, 'semester' => $semester]) }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-brand text-white text-xs font-semibold rounded-lg hover:bg-brand-hover transition">
                    + Buat Jadwal Pertama
                </a>
            </div>
        @else
            <!-- Weekly Schedule Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    $displayDays = $dayOfWeek ? [$dayOfWeek => $days[$dayOfWeek] ?? ucfirst($dayOfWeek)] : $days;
                @endphp

                @foreach ($displayDays as $dayKey => $dayName)
                    @php
                        $daySchedules = $schedulesGrouped->get($dayKey, collect());
                    @endphp
                    <div class="bg-surface rounded-xl border border-border overflow-hidden shadow-sm flex flex-col">
                        <!-- Day Header -->
                        <div class="px-4 py-3 bg-slate-50 border-b border-border flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full {{ $daySchedules->isNotEmpty() ? 'bg-brand' : 'bg-slate-300' }}"></span>
                                <h3 class="font-bold text-sm text-navy">{{ $dayName }}</h3>
                            </div>
                            <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $daySchedules->isNotEmpty() ? 'bg-brand-light text-brand' : 'bg-slate-200/60 text-slate-500' }}">
                                {{ $daySchedules->count() }} sesi
                            </span>
                        </div>

                        <!-- Day Body -->
                        <div class="p-4 flex-1 space-y-3">
                            @if ($daySchedules->isEmpty())
                                <p class="text-xs text-slate-400 italic py-6 text-center">Tidak ada jadwal</p>
                            @else
                                @foreach ($daySchedules as $sched)
                                    <div class="p-3 rounded-lg border border-border/80 bg-canvas/60 hover:bg-white hover:border-brand/40 hover:shadow-sm transition">
                                        <div class="flex items-start justify-between gap-2 mb-1.5">
                                            <span class="inline-flex items-center gap-1 text-xs font-bold text-navy bg-white px-2 py-0.5 rounded border border-border">
                                                <svg class="w-3.5 h-3.5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                {{ $sched->time_range }}
                                            </span>
                                            <div class="flex items-center gap-1">
                                                <a href="{{ route('admin.schedules.edit', $sched) }}" class="p-1 text-slate-400 hover:text-brand transition" title="Edit Jadwal">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                </a>
                                                <form action="{{ route('admin.schedules.destroy', $sched) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-1 text-slate-400 hover:text-danger transition" title="Hapus Jadwal">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        <h4 class="text-xs font-bold text-navy line-clamp-1">{{ $sched->subject->name }}</h4>
                                        <div class="mt-1 flex items-center justify-between text-[11px] text-slate-500">
                                            <span class="truncate max-w-[150px]" title="{{ $sched->teacher->name }}">
                                                👤 {{ $sched->teacher->name }}
                                            </span>
                                            <span class="shrink-0 text-slate-400">
                                                📍 {{ $sched->room ? $sched->room->name : 'Ruang Kelas' }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endif
</div>
@endsection
