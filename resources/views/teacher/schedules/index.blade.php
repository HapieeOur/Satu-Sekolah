@extends('layouts.app', ['title' => 'Jadwal Mengajar Saya'])

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-navy">Jadwal Mengajar Saya</h1>
            <p class="text-sm text-slate-500 mt-1">Daftar agenda mengajar mingguan Anda berdasarkan tahun ajaran dan semester aktif.</p>
        </div>
    </div>

    @if (! $teacher)
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-6 text-amber-800">
            <h3 class="font-bold text-sm mb-1">Profil Guru Belum Ditemukan</h3>
            <p class="text-xs">Akun Anda belum ditautkan dengan data profil guru di sistem. Silakan hubungi Administrator untuk menghubungkan akun pengguna Anda dengan profil guru.</p>
        </div>
    @else
        <!-- Teacher Profile & Metrics Banner -->
        <div class="bg-surface rounded-xl border border-border p-5 shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                <!-- Teacher Info -->
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-navy text-white flex items-center justify-center font-bold text-lg shrink-0">
                        {{ substr($teacher->name, 0, 2) }}
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-navy">{{ $teacher->name }}</h2>
                        <p class="text-xs text-slate-500">NIP: {{ $teacher->nip ?? '-' }} &bull; NUPTK: {{ $teacher->nuptk ?? '-' }}</p>
                    </div>
                </div>

                <!-- Stats: Total Slots -->
                <div class="border-y md:border-y-0 md:border-x border-border py-2 md:py-0 md:px-6">
                    <span class="text-xs text-slate-500 block">Total Beban Mengajar</span>
                    <span class="text-xl font-bold text-navy">{{ $totalSlots }} Sesi / Minggu</span>
                </div>

                <!-- Stats: Classes Taught -->
                <div>
                    <span class="text-xs text-slate-500 block">Kelas yang Diajar</span>
                    <div class="flex flex-wrap gap-1.5 mt-1">
                        @forelse ($uniqueClassrooms as $clsName)
                            <span class="px-2 py-0.5 rounded text-xs font-semibold bg-brand-light text-brand border border-blue-200">
                                {{ $clsName }}
                            </span>
                        @empty
                            <span class="text-xs text-slate-400 italic">Belum ada kelas terjadwal</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="bg-surface rounded-xl border border-border p-5 shadow-sm">
            <form method="GET" action="{{ route('teacher.schedules.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
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
                    <button type="submit" class="w-full px-4 py-2 bg-navy text-white text-sm font-semibold rounded-lg hover:bg-navy-light transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                        Filter Jadwal
                    </button>
                </div>
            </form>
        </div>

        @if ($schedulesGrouped->isEmpty())
            <div class="bg-surface rounded-xl border border-border p-12 text-center shadow-sm">
                <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h4 class="text-sm font-bold text-slate-700 mb-1">Belum Ada Jadwal Mengajar</h4>
                <p class="text-xs text-slate-500 max-w-sm mx-auto">
                    Anda belum memiliki jadwal mengajar pada {{ ucfirst($semester) }} tahun ajaran terpilih. Silakan hubungi bagian kurikulum/admin untuk alokasi jadwal.
                </p>
            </div>
        @else
            <!-- Weekly Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($days as $dayKey => $dayName)
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

                        <!-- Day Content -->
                        <div class="p-4 flex-1 space-y-3">
                            @if ($daySchedules->isEmpty())
                                <p class="text-xs text-slate-400 italic py-6 text-center">Tidak ada jadwal mengajar</p>
                            @else
                                @foreach ($daySchedules as $sched)
                                    <div class="p-3.5 rounded-lg border border-border bg-canvas hover:bg-white hover:border-brand/40 transition">
                                        <div class="flex items-center justify-between gap-2 mb-2">
                                            <span class="inline-flex items-center gap-1 text-xs font-bold text-navy bg-white px-2 py-0.5 rounded border border-border">
                                                <svg class="w-3.5 h-3.5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                {{ $sched->time_range }}
                                            </span>
                                            <span class="px-2 py-0.5 rounded text-xs font-bold bg-navy text-white">
                                                {{ $sched->classroom->name }}
                                            </span>
                                        </div>

                                        <h4 class="text-sm font-bold text-navy">{{ $sched->subject->name }}</h4>
                                        <div class="mt-2 flex items-center justify-between text-xs text-slate-500">
                                            <span>Kode: {{ $sched->subject->code }}</span>
                                            <span class="text-slate-600 font-medium">
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
