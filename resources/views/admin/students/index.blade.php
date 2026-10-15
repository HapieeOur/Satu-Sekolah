<x-app-layout title="Data Siswa">
    <x-slot name="header">
        Data Master: Peserta Didik
    </x-slot>

    <!-- Header Actions & Filters -->
    <div class="bg-surface rounded-xl border border-border shadow-sm p-5 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-base font-bold text-navy">Daftar Siswa</h2>
                <p class="text-xs text-slate-500 mt-0.5">Kelola data induk siswa, penempatan rombel kelas, dan status peserta didik.</p>
            </div>
            <a href="{{ route('admin.students.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-brand hover:bg-brand-hover text-white text-xs font-semibold rounded-lg shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Siswa Baru
            </a>
        </div>

        <form method="GET" action="{{ route('admin.students.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-3 pt-3 border-t border-border">
            <div class="sm:col-span-2">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari nama siswa, NIS, atau NISN..."
                    class="w-full px-3.5 py-2 text-xs rounded-lg border border-border focus:ring-1 focus:ring-brand focus:border-brand"
                >
            </div>

            <div>
                <select name="classroom_id" class="w-full px-3 py-2 text-xs rounded-lg border border-border focus:ring-1 focus:ring-brand focus:border-brand bg-white text-slate-700">
                    <option value="">Semua Rombel/Kelas</option>
                    @foreach ($classrooms as $cls)
                        <option value="{{ $cls->id }}" {{ request('classroom_id') == $cls->id ? 'selected' : '' }}>
                            {{ $cls->name }} (Kelas {{ $cls->grade_level }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center gap-2">
                <select name="status" class="w-full px-3 py-2 text-xs rounded-lg border border-border focus:ring-1 focus:ring-brand focus:border-brand bg-white text-slate-700">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="alumni" {{ request('status') === 'alumni' ? 'selected' : '' }}>Alumni / Lulus</option>
                    <option value="pindah" {{ request('status') === 'pindah' ? 'selected' : '' }}>Pindah</option>
                    <option value="keluar" {{ request('status') === 'keluar' ? 'selected' : '' }}>Keluar</option>
                </select>
                <button type="submit" class="px-3.5 py-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-medium rounded-lg transition shrink-0">
                    Filter
                </button>
                @if (request()->hasAny(['search', 'classroom_id', 'status']))
                    <a href="{{ route('admin.students.index') }}" class="px-2.5 py-2 text-xs text-slate-500 hover:text-slate-800 transition shrink-0">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-surface rounded-xl border border-border shadow-sm overflow-hidden flex flex-col">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-canvas border-b border-border text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                        <th class="py-3 px-4">Nama Siswa</th>
                        <th class="py-3 px-4">NIS / NISN</th>
                        <th class="py-3 px-4">L/P</th>
                        <th class="py-3 px-4">Kelas</th>
                        <th class="py-3 px-4">Nama Orang Tua</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse ($students as $student)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-navy">{{ $student->name }}</div>
                                <div class="text-[11px] text-slate-400">{{ $student->phone ?? '-' }}</div>
                            </td>
                            <td class="py-3.5 px-4 font-mono text-slate-700">
                                <div>NIS: {{ $student->nis }}</div>
                                <div class="text-[11px] text-slate-400">NISN: {{ $student->nisn ?? '-' }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium {{ $student->gender === 'L' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-pink-50 text-pink-700 border border-pink-200' }}">
                                    {{ $student->gender === 'L' ? 'L' : 'P' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 font-medium text-slate-800">
                                @if ($student->classroom)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-slate-100 text-slate-800 border border-slate-200">
                                        {{ $student->classroom->name }}
                                    </span>
                                @else
                                    <span class="text-slate-400 italic">Belum ada kelas</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-slate-600">
                                <div>{{ $student->parent_name ?? '-' }}</div>
                                <div class="text-[11px] text-slate-400">{{ $student->parent_phone ?? '' }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                @php
                                    $badgeColors = [
                                        'aktif' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'alumni' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'pindah' => 'bg-amber-50 text-amber-700 border-amber-200',
                                        'keluar' => 'bg-rose-50 text-rose-700 border-rose-200',
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold border {{ $badgeColors[$student->status] ?? 'bg-slate-50 text-slate-700 border-slate-200' }}">
                                    {{ ucfirst($student->status) }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.students.edit', $student) }}" class="p-1.5 text-slate-500 hover:text-brand hover:bg-slate-100 rounded-lg transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </a>

                                    <form method="POST" action="{{ route('admin.students.destroy', $student) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data siswa ini?')">
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
                                Belum ada data siswa yang cocok dengan kriteria pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($students->hasPages())
            <div class="px-4 py-3 border-t border-border">
                {{ $students->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
