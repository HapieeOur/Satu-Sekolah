<x-app-layout title="Data Siswa">
    <x-slot name="header">
        Data Master: Peserta Didik
    </x-slot>

    <!-- Header Actions & Filters -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs p-6 space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-black text-navy tracking-tight">Daftar Peserta Didik</h2>
                <p class="text-xs text-slate-500 mt-0.5">Kelola data induk siswa, penempatan rombel kelas, dan status peserta didik.</p>
            </div>
            <a href="{{ route('admin.students.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-brand to-indigo-600 hover:from-brand-hover hover:to-indigo-700 text-white text-xs font-bold rounded-xl shadow-md hover:shadow-glow hover:-translate-y-0.5 transition-all duration-150">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                <span>Tambah Siswa Baru</span>
            </a>
        </div>

        <form method="GET" action="{{ route('admin.students.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-3.5 pt-4 border-t border-slate-100">
            <div class="sm:col-span-2 relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari nama siswa, NIS, atau NISN..."
                    class="w-full pl-10 pr-3.5 py-2.5 text-xs rounded-xl border-slate-200 focus:ring-2 focus:ring-brand/20 focus:border-brand bg-white text-slate-900 shadow-xs"
                >
            </div>

            <div>
                <select name="classroom_id" class="w-full px-3.5 py-2.5 text-xs rounded-xl border-slate-200 focus:ring-2 focus:ring-brand/20 focus:border-brand bg-white text-slate-700 shadow-xs">
                    <option value="">Semua Rombel/Kelas</option>
                    @foreach ($classrooms as $cls)
                        <option value="{{ $cls->id }}" {{ request('classroom_id') == $cls->id ? 'selected' : '' }}>
                            {{ $cls->name }} (Kelas {{ $cls->grade_level }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center gap-2">
                <select name="status" class="w-full px-3.5 py-2.5 text-xs rounded-xl border-slate-200 focus:ring-2 focus:ring-brand/20 focus:border-brand bg-white text-slate-700 shadow-xs">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="alumni" {{ request('status') === 'alumni' ? 'selected' : '' }}>Alumni / Lulus</option>
                    <option value="pindah" {{ request('status') === 'pindah' ? 'selected' : '' }}>Pindah</option>
                    <option value="keluar" {{ request('status') === 'keluar' ? 'selected' : '' }}>Keluar</option>
                </select>
                <button type="submit" class="px-4 py-2.5 bg-navy hover:bg-slate-800 text-white text-xs font-bold rounded-xl transition shadow-xs shrink-0 cursor-pointer">
                    Filter
                </button>
                @if (request()->hasAny(['search', 'classroom_id', 'status']))
                    <a href="{{ route('admin.students.index') }}" class="px-3 py-2.5 text-xs text-slate-500 hover:text-navy transition font-bold shrink-0">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden flex flex-col">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50/80 border-b border-slate-100 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="py-3 px-5">Nama Siswa</th>
                        <th class="py-3 px-5">NIS / NISN</th>
                        <th class="py-3 px-5">L/P</th>
                        <th class="py-3 px-5">Rombel Kelas</th>
                        <th class="py-3 px-5">Nama Orang Tua</th>
                        <th class="py-3 px-5">Status</th>
                        <th class="py-3 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($students as $student)
                        <tr class="hover:bg-slate-50/75 transition">
                            <td class="py-4 px-5">
                                <div class="font-bold text-navy text-xs sm:text-sm">{{ $student->name }}</div>
                                <div class="text-[10px] text-slate-400 font-mono mt-0.5">{{ $student->phone ?? '-' }}</div>
                            </td>
                            <td class="py-4 px-5 font-mono text-slate-600">
                                <div class="font-bold text-slate-700">NIS: {{ $student->nis }}</div>
                                <div class="text-[10px] text-slate-400">NISN: {{ $student->nisn ?? '-' }}</div>
                            </td>
                            <td class="py-4 px-5">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $student->gender === 'L' ? 'bg-sky-50 text-sky-700 border border-sky-200' : 'bg-pink-50 text-pink-700 border border-pink-200' }}">
                                    {{ $student->gender === 'L' ? 'L' : 'P' }}
                                </span>
                            </td>
                            <td class="py-4 px-5 font-medium text-slate-800">
                                @if ($student->classroom)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                        {{ $student->classroom->name }}
                                    </span>
                                @else
                                    <span class="text-slate-400 italic">Belum ada kelas</span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-slate-600">
                                <div class="font-medium text-navy">{{ $student->parent_name ?? '-' }}</div>
                                <div class="text-[10px] text-slate-400 font-mono">{{ $student->parent_phone ?? '' }}</div>
                            </td>
                            <td class="py-4 px-5">
                                @php
                                    $badgeColors = [
                                        'aktif' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'alumni' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'pindah' => 'bg-amber-50 text-amber-700 border-amber-200',
                                        'keluar' => 'bg-rose-50 text-rose-700 border-rose-200',
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $badgeColors[$student->status] ?? 'bg-slate-50 text-slate-700 border-slate-200' }}">
                                    {{ ucfirst($student->status) }}
                                </span>
                            </td>
                            <td class="py-4 px-5 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('admin.students.edit', $student) }}" class="p-2 text-slate-500 hover:text-brand hover:bg-indigo-50 rounded-xl transition" title="Edit Data">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </a>

                                    <form method="POST" action="{{ route('admin.students.destroy', $student) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data siswa ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition cursor-pointer" title="Hapus Data">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                Belum ada data siswa yang cocok dengan kriteria pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($students->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/60">
                {{ $students->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
