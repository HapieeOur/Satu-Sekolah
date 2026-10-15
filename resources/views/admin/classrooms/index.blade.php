<x-app-layout title="Data Kelas">
    <x-slot name="header">
        Data Master: Rombel & Kelas
    </x-slot>

    <!-- Header Actions & Filters -->
    <div class="bg-surface rounded-xl border border-border shadow-sm p-5 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-base font-bold text-navy">Daftar Kelas (Rombongan Belajar)</h2>
                <p class="text-xs text-slate-500 mt-0.5">Kelola data kelas, penetapan wali kelas, dan tingkat/jurusan per tahun ajaran.</p>
            </div>
            <a href="{{ route('admin.classrooms.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-brand hover:bg-brand-hover text-white text-xs font-semibold rounded-lg shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Kelas Baru
            </a>
        </div>

        <form method="GET" action="{{ route('admin.classrooms.index') }}" class="flex flex-wrap items-center gap-3 pt-3 border-t border-border">
            <div class="w-48">
                <select name="academic_year_id" class="w-full px-3.5 py-2 text-xs rounded-lg border border-border focus:ring-1 focus:ring-brand focus:border-brand bg-white text-slate-700">
                    <option value="">Semua Tahun Ajaran</option>
                    @foreach ($academicYears as $year)
                        <option value="{{ $year->id }}" {{ request('academic_year_id') == $year->id ? 'selected' : '' }}>
                            {{ $year->name }} ({{ ucfirst($year->semester) }}) {{ $year->is_active ? '★' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="w-40">
                <select name="grade_level" class="w-full px-3.5 py-2 text-xs rounded-lg border border-border focus:ring-1 focus:ring-brand focus:border-brand bg-white text-slate-700">
                    <option value="">Semua Tingkat</option>
                    <option value="10" {{ request('grade_level') == '10' ? 'selected' : '' }}>Kelas 10</option>
                    <option value="11" {{ request('grade_level') == '11' ? 'selected' : '' }}>Kelas 11</option>
                    <option value="12" {{ request('grade_level') == '12' ? 'selected' : '' }}>Kelas 12</option>
                </select>
            </div>

            <button type="submit" class="px-3.5 py-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-medium rounded-lg transition shrink-0">
                Filter
            </button>
            @if (request()->hasAny(['academic_year_id', 'grade_level']))
                <a href="{{ route('admin.classrooms.index') }}" class="px-2.5 py-2 text-xs text-slate-500 hover:text-slate-800 transition shrink-0">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-surface rounded-xl border border-border shadow-sm overflow-hidden flex flex-col">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-canvas border-b border-border text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                        <th class="py-3 px-4">Nama Kelas</th>
                        <th class="py-3 px-4">Tingkat</th>
                        <th class="py-3 px-4">Jurusan</th>
                        <th class="py-3 px-4">Tahun Ajaran</th>
                        <th class="py-3 px-4">Wali Kelas</th>
                        <th class="py-3 px-4">Jumlah Siswa</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse ($classrooms as $classroom)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3.5 px-4 font-bold text-navy">
                                {{ $classroom->name }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-slate-100 text-slate-800 border border-slate-200">
                                    Kelas {{ $classroom->grade_level }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-700">
                                {{ $classroom->major }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-600">
                                {{ $classroom->academicYear->name ?? '-' }} ({{ ucfirst($classroom->academicYear->semester ?? '') }})
                            </td>
                            <td class="py-3.5 px-4 text-slate-800">
                                @if ($classroom->homeroomTeacher)
                                    <div class="font-medium">{{ $classroom->homeroomTeacher->user->name ?? '-' }}</div>
                                    <div class="text-[11px] text-slate-400">NIP: {{ $classroom->homeroomTeacher->nip ?? '-' }}</div>
                                @else
                                    <span class="text-amber-600 italic">Belum ditentukan</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-brand-light text-brand border border-brand/20">
                                    {{ $classroom->students->count() }} Siswa
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.classrooms.edit', $classroom) }}" class="p-1.5 text-slate-500 hover:text-brand hover:bg-slate-100 rounded-lg transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </a>

                                    <form method="POST" action="{{ route('admin.classrooms.destroy', $classroom) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus rombel kelas ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-slate-400 hover:text-danger hover:bg-rose-50 rounded-lg transition" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400">
                                Belum ada data rombel kelas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($classrooms->hasPages())
            <div class="px-4 py-3 border-t border-border">
                {{ $classrooms->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
