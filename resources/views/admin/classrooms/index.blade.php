<x-app-layout title="Data Kelas & Rombel">
    <x-slot name="header">
        Data Master: Rombel & Kelas
    </x-slot>

    <div class="space-y-6">
        <!-- Top Hero / Page Header -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 p-6 md:p-8 text-white shadow-xl">
            <div class="absolute -right-12 -top-12 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -left-12 -bottom-12 w-64 h-64 bg-brand/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/20 border border-indigo-400/30 text-indigo-300 text-xs font-semibold mb-3">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <span>Manajemen Rombongan Belajar</span>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-white">Daftar Rombel & Kelas</h1>
                    <p class="text-sm text-slate-300 mt-1 max-w-xl">
                        Kelola struktur rombongan belajar, alokasi wali kelas, tingkat keahlian siswa, dan sinkronisasi tahun ajaran aktif.
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.classrooms.create') }}"
                       class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold text-xs shadow-lg shadow-indigo-500/25 transition duration-150 transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        <span>Tambah Kelas Baru</span>
                    </a>
                </div>
            </div>

            <!-- Bento Stats Sub-row -->
            <div class="relative z-10 grid grid-cols-2 sm:grid-cols-4 gap-3 mt-6 pt-6 border-t border-white/10">
                <div class="p-3 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <span class="text-[11px] font-medium text-slate-400 block">Total Kelas</span>
                    <span class="text-xl font-bold text-white mt-0.5 block">{{ $classrooms->total() }} Rombel</span>
                </div>
                <div class="p-3 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <span class="text-[11px] font-medium text-slate-400 block">Tingkat X (10)</span>
                    <span class="text-xl font-bold text-sky-400 mt-0.5 block">{{ $classrooms->where('grade_level', 10)->count() }} Kelas</span>
                </div>
                <div class="p-3 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <span class="text-[11px] font-medium text-slate-400 block">Tingkat XI (11)</span>
                    <span class="text-xl font-bold text-indigo-400 mt-0.5 block">{{ $classrooms->where('grade_level', 11)->count() }} Kelas</span>
                </div>
                <div class="p-3 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <span class="text-[11px] font-medium text-slate-400 block">Tingkat XII (12)</span>
                    <span class="text-xl font-bold text-purple-400 mt-0.5 block">{{ $classrooms->where('grade_level', 12)->count() }} Kelas</span>
                </div>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5">
            <form method="GET" action="{{ route('admin.classrooms.index') }}" class="flex flex-wrap items-center gap-3">
                <div class="w-full sm:w-64">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Tahun Ajaran</label>
                    <select name="academic_year_id" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800">
                        <option value="">Semua Tahun Ajaran</option>
                        @foreach ($academicYears as $year)
                            <option value="{{ $year->id }}" {{ request('academic_year_id') == $year->id ? 'selected' : '' }}>
                                {{ $year->name }} ({{ ucfirst($year->semester) }}) {{ $year->is_active ? '★ Aktif' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full sm:w-48">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Tingkat</label>
                    <select name="grade_level" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800">
                        <option value="">Semua Tingkat</option>
                        <option value="10" {{ request('grade_level') == '10' ? 'selected' : '' }}>Kelas 10 (Sepuluh)</option>
                        <option value="11" {{ request('grade_level') == '11' ? 'selected' : '' }}>Kelas 11 (Sebelas)</option>
                        <option value="12" {{ request('grade_level') == '12' ? 'selected' : '' }}>Kelas 12 (Dua Belas)</option>
                    </select>
                </div>

                <div class="flex items-center gap-2 sm:self-end mt-1 sm:mt-0">
                    <button type="submit" class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold rounded-xl shadow-sm transition flex items-center gap-1.5 min-h-[42px]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                        Filter Data
                    </button>
                    @if (request()->hasAny(['academic_year_id', 'grade_level']))
                        <a href="{{ route('admin.classrooms.index') }}" class="px-4 py-2.5 text-xs text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 font-medium rounded-xl transition min-h-[42px] flex items-center">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Classrooms Table Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50/75 border-b border-slate-200 text-[11px] font-bold uppercase tracking-wider text-slate-600">
                            <th class="py-3.5 px-5">Rombongan Belajar</th>
                            <th class="py-3.5 px-4">Tingkat</th>
                            <th class="py-3.5 px-4">Jurusan / Keahlian</th>
                            <th class="py-3.5 px-4">Tahun Ajaran</th>
                            <th class="py-3.5 px-4">Wali Kelas</th>
                            <th class="py-3.5 px-4 text-center">Jumlah Siswa</th>
                            <th class="py-3.5 px-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($classrooms as $classroom)
                            <tr class="hover:bg-indigo-50/30 transition-colors duration-150">
                                <td class="py-4 px-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-700 text-white font-extrabold flex items-center justify-center text-xs shadow-sm shrink-0">
                                            {{ substr($classroom->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <span class="font-bold text-slate-900 text-sm block">{{ $classroom->name }}</span>
                                            <span class="text-[11px] text-slate-400">ID Kelas: #{{ $classroom->id }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    @if ($classroom->grade_level == 10)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-200">
                                            Kelas 10
                                        </span>
                                    @elseif ($classroom->grade_level == 11)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                            Kelas 11
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-200">
                                            Kelas 12
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    <span class="font-medium text-slate-700">{{ $classroom->major }}</span>
                                </td>
                                <td class="py-4 px-4 text-slate-600">
                                    <div class="font-medium">{{ $classroom->academicYear->name ?? '-' }}</div>
                                    <div class="text-[11px] text-slate-400 capitalize">Semester {{ $classroom->academicYear->semester ?? '-' }}</div>
                                </td>
                                <td class="py-4 px-4">
                                    @if ($classroom->homeroomTeacher)
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-7 h-7 rounded-full bg-slate-100 text-slate-700 font-bold text-[11px] flex items-center justify-center border border-slate-200 shrink-0">
                                                {{ substr($classroom->homeroomTeacher->user->name ?? 'G', 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-semibold text-slate-900">{{ $classroom->homeroomTeacher->user->name ?? '-' }}</div>
                                                <div class="text-[11px] font-mono text-slate-400">NIP: {{ $classroom->homeroomTeacher->nip ?? '-' }}</div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-amber-700 bg-amber-50 px-2 py-0.5 rounded text-[11px] font-medium border border-amber-200">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                            Belum ditentukan
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200/80">
                                        <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        {{ $classroom->students->count() }} Siswa
                                    </span>
                                </td>
                                <td class="py-4 px-5 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5">
                                        <a href="{{ route('admin.classrooms.edit', $classroom) }}"
                                           class="p-2 text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition"
                                           title="Edit Data Kelas">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        </a>

                                        <form method="POST" action="{{ route('admin.classrooms.destroy', $classroom) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus rombel kelas {{ $classroom->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition"
                                                    title="Hapus Rombel">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center">
                                    <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    </div>
                                    <h4 class="text-sm font-bold text-slate-800">Belum Ada Data Rombel Kelas</h4>
                                    <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1 mb-4">
                                        Mulai tambahkan rombongan belajar baru untuk tahun ajaran aktif agar dapat mengalokasikan siswa dan jadwal.
                                    </p>
                                    <a href="{{ route('admin.classrooms.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl shadow-sm transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        Tambah Rombel Sekarang
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($classrooms->hasPages())
                <div class="px-5 py-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $classrooms->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
