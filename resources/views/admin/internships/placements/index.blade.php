<x-app-layout title="Manajemen Penempatan PKL">
    <x-slot name="header">
        Administrasi: Penempatan PKL Siswa
    </x-slot>

    <div class="space-y-6">
        <!-- Top Hero / Page Header -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 p-6 md:p-8 text-white shadow-xl">
            <div class="absolute -right-12 -top-12 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -left-12 -bottom-12 w-64 h-64 bg-brand/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/20 border border-indigo-400/30 text-indigo-300 text-xs font-semibold mb-3">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>Distribusi Magang Industri</span>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-white">Penempatan Siswa PKL</h1>
                    <p class="text-sm text-slate-300 mt-1 max-w-xl">
                        Petakan siswa ke perusahaan mitra (DUDI), tetapkan guru pembimbing sekolah, dan pantau status kelulusan magang.
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.internships.placements.create') }}"
                       class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold text-xs shadow-lg shadow-indigo-500/25 transition duration-150 transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        <span>Tambah Penempatan</span>
                    </a>
                </div>
            </div>

            <!-- Bento Stats Sub-row -->
            <div class="relative z-10 grid grid-cols-2 sm:grid-cols-4 gap-3 mt-6 pt-6 border-t border-white/10">
                <div class="p-3 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <span class="text-[11px] font-medium text-slate-400 block">Total Penempatan</span>
                    <span class="text-xl font-bold text-white mt-0.5 block">{{ $placements->total() }} Siswa</span>
                </div>
                <div class="p-3 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <span class="text-[11px] font-medium text-slate-400 block">Sedang Berjalan (Aktif)</span>
                    <span class="text-xl font-bold text-emerald-400 mt-0.5 block">
                        {{ $placements->where('status.value', 'active')->count() }} Siswa
                    </span>
                </div>
                <div class="p-3 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <span class="text-[11px] font-medium text-slate-400 block">Selesai Magang</span>
                    <span class="text-xl font-bold text-sky-400 mt-0.5 block">
                        {{ $placements->where('status.value', 'completed')->count() }} Tuntas
                    </span>
                </div>
                <div class="p-3 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <span class="text-[11px] font-medium text-slate-400 block">Draf / Menunggu</span>
                    <span class="text-xl font-bold text-amber-400 mt-0.5 block">
                        {{ $placements->where('status.value', 'draft')->count() }} Siswa
                    </span>
                </div>
            </div>
        </div>

        <!-- Filter Bar Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5">
            <form method="GET" action="{{ route('admin.internships.placements.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Cari Siswa</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </span>
                        <input type="text" name="search" id="search" value="{{ $filters['search'] ?? '' }}" placeholder="Nama atau NIS siswa..."
                               class="w-full pl-9 pr-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800">
                    </div>
                </div>

                <div>
                    <label for="company_id" class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Mitra Industri (DUDI)</label>
                    <select name="company_id" id="company_id" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800">
                        <option value="">Semua Perusahaan</option>
                        @foreach ($companies as $comp)
                            <option value="{{ $comp->id }}" {{ ($filters['company_id'] ?? '') == $comp->id ? 'selected' : '' }}>
                                {{ $comp->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="teacher_id" class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Guru Pembimbing</label>
                    <select name="teacher_id" id="teacher_id" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800">
                        <option value="">Semua Pembimbing</option>
                        @foreach ($teachers as $tch)
                            <option value="{{ $tch->id }}" {{ ($filters['teacher_id'] ?? '') == $tch->id ? 'selected' : '' }}>
                                {{ $tch->user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <div class="flex-1">
                        <label for="status" class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Status</label>
                        <select name="status" id="status" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800">
                            <option value="">Semua Status</option>
                            @foreach ($statuses as $st)
                                <option value="{{ $st->value }}" {{ ($filters['status'] ?? '') == $st->value ? 'selected' : '' }}>
                                    {{ $st->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold rounded-xl shadow-sm transition flex items-center justify-center min-h-[42px] shrink-0">
                        Filter
                    </button>
                    @if (! empty(array_filter($filters)))
                        <a href="{{ route('admin.internships.placements.index') }}" class="px-3.5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl transition min-h-[42px] flex items-center shrink-0">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Placements Data Table -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50/75 border-b border-slate-200 text-[11px] font-bold uppercase tracking-wider text-slate-600">
                            <th scope="col" class="py-3.5 px-4 w-12 text-center">No</th>
                            <th scope="col" class="py-3.5 px-4">Siswa & Kelas</th>
                            <th scope="col" class="py-3.5 px-4">Mitra Perusahaan (DUDI)</th>
                            <th scope="col" class="py-3.5 px-4">Pembimbing Sekolah</th>
                            <th scope="col" class="py-3.5 px-4">Periode PKL</th>
                            <th scope="col" class="py-3.5 px-4">Status</th>
                            <th scope="col" class="py-3.5 px-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($placements as $index => $placement)
                            <tr class="hover:bg-indigo-50/30 transition-colors duration-150">
                                <td class="py-4 px-4 text-center font-mono text-slate-400">
                                    {{ $placements->firstItem() + $index }}
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-indigo-50 text-indigo-700 font-bold flex items-center justify-center text-xs border border-indigo-100 shrink-0">
                                            {{ substr($placement->student->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900 text-sm">{{ $placement->student->name }}</p>
                                            <p class="text-[11px] text-slate-400 font-mono mt-0.5">
                                                NIS: {{ $placement->student->nis }} &bull; {{ $placement->student->classroom?->name ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <p class="font-semibold text-slate-800">{{ $placement->company->name }}</p>
                                    <p class="text-[11px] text-slate-400 mt-0.5 truncate max-w-xs" title="{{ $placement->company->address }}">
                                        {{ $placement->department ? $placement->department.' &bull; ' : '' }}{{ $placement->company->address }}
                                    </p>
                                </td>
                                <td class="py-4 px-4">
                                    <p class="font-semibold text-slate-800">{{ $placement->teacher->user->name }}</p>
                                    <p class="text-[11px] text-slate-400 font-mono mt-0.5">NIP: {{ $placement->teacher->nip }}</p>
                                </td>
                                <td class="py-4 px-4 font-mono text-slate-700">
                                    <div class="font-semibold">
                                        {{ $placement->start_date->format('d/m/Y') }} — {{ $placement->end_date->format('d/m/Y') }}
                                    </div>
                                    <p class="text-[11px] text-slate-400 mt-0.5">{{ $placement->academicYear->name }}</p>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $placement->status->badgeClass() }}">
                                        {{ $placement->status->label() }}
                                    </span>
                                </td>
                                <td class="py-4 px-5 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5">
                                        <a href="{{ route('admin.internships.placements.edit', $placement->id) }}"
                                           class="p-2 text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition"
                                           title="Edit Penempatan">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        </a>

                                        <form method="POST" action="{{ route('admin.internships.placements.destroy', $placement->id) }}"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus data penempatan PKL untuk {{ $placement->student->name }}? Data presensi dan jurnal terkait akan ikut terhapus.');"
                                              class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition"
                                                    title="Hapus Penempatan">
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
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    </div>
                                    <h4 class="text-sm font-bold text-slate-800">Tidak Ada Data Penempatan PKL</h4>
                                    <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1 mb-4">
                                        Belum ada siswa yang ditempatkan ke mitra industri pada kriteria filter pencarian ini.
                                    </p>
                                    <a href="{{ route('admin.internships.placements.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl shadow-sm transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        Tambah Penempatan Baru
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($placements->hasPages())
                <div class="px-5 py-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $placements->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
