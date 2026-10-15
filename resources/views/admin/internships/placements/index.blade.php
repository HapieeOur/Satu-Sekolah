<x-app-layout title="Manajemen Penempatan PKL">
    <x-slot name="header">
        Administrasi: Penempatan PKL
    </x-slot>

    <div class="space-y-6">
        <!-- Header & Action -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-navy">Penempatan Siswa PKL</h1>
                <p class="text-xs text-slate-600 mt-1">Kelola data penempatan siswa pada dunia usaha & dunia industri (DUDI) mitra sekolah.</p>
            </div>
            <a href="{{ route('admin.internships.placements.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-xs font-semibold text-white bg-brand rounded-lg hover:bg-brand-hover shadow-sm transition shrink-0 min-h-[44px]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Tambah Penempatan</span>
            </a>
        </div>

        <!-- Filter Bar -->
        <div class="bg-surface rounded-xl border border-border p-5 shadow-sm">
            <form method="GET" action="{{ route('admin.internships.placements.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pencarian Siswa</label>
                    <input type="text" name="search" id="search" value="{{ $filters['search'] ?? '' }}" placeholder="Nama / NIS siswa..."
                           class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
                </div>

                <div>
                    <label for="company_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Mitra Industri (DUDI)</label>
                    <select name="company_id" id="company_id" class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
                        <option value="">Semua Perusahaan</option>
                        @foreach ($companies as $comp)
                            <option value="{{ $comp->id }}" {{ ($filters['company_id'] ?? '') == $comp->id ? 'selected' : '' }}>
                                {{ $comp->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="teacher_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Guru Pembimbing</label>
                    <select name="teacher_id" id="teacher_id" class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
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
                        <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status</label>
                        <select name="status" id="status" class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
                            <option value="">Semua Status</option>
                            @foreach ($statuses as $st)
                                <option value="{{ $st->value }}" {{ ($filters['status'] ?? '') == $st->value ? 'selected' : '' }}>
                                    {{ $st->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-navy hover:bg-navy-light text-white text-xs font-semibold rounded-lg transition min-h-[38px] shrink-0">
                        Filter
                    </button>
                    @if (! empty(array_filter($filters)))
                        <a href="{{ route('admin.internships.placements.index') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition min-h-[38px] flex items-center shrink-0">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Data Table -->
        <div class="bg-surface rounded-xl border border-border shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-800">
                    <thead class="bg-slate-50 border-b border-border text-slate-700 font-semibold uppercase tracking-wider text-[11px]">
                        <tr>
                            <th scope="col" class="py-3 px-4 w-12 text-center">No</th>
                            <th scope="col" class="py-3 px-4">Siswa</th>
                            <th scope="col" class="py-3 px-4">Mitra Perusahaan (DUDI)</th>
                            <th scope="col" class="py-3 px-4">Pembimbing Sekolah</th>
                            <th scope="col" class="py-3 px-4">Periode PKL</th>
                            <th scope="col" class="py-3 px-4">Status</th>
                            <th scope="col" class="py-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse ($placements as $index => $placement)
                            <tr class="hover:bg-slate-50/75 transition">
                                <td class="py-3.5 px-4 text-center font-mono text-slate-500">
                                    {{ $placements->firstItem() + $index }}
                                </td>
                                <td class="py-3.5 px-4">
                                    <p class="font-bold text-navy">{{ $placement->student->name }}</p>
                                    <p class="text-[11px] text-slate-500 font-mono mt-0.5">
                                        NIS: {{ $placement->student->nis }} &bull; {{ $placement->student->classroom?->name ?? '-' }}
                                    </p>
                                </td>
                                <td class="py-3.5 px-4">
                                    <p class="font-semibold text-slate-800">{{ $placement->company->name }}</p>
                                    <p class="text-[11px] text-slate-500 mt-0.5 truncate max-w-xs" title="{{ $placement->company->address }}">
                                        {{ $placement->department ? $placement->department.' &bull; ' : '' }}{{ $placement->company->address }}
                                    </p>
                                </td>
                                <td class="py-3.5 px-4">
                                    <p class="font-medium text-slate-800">{{ $placement->teacher->user->name }}</p>
                                    <p class="text-[11px] text-slate-500 font-mono mt-0.5">NIP: {{ $placement->teacher->nip }}</p>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="font-mono text-slate-700">
                                        {{ $placement->start_date->format('d/m/Y') }} — {{ $placement->end_date->format('d/m/Y') }}
                                    </span>
                                    <p class="text-[11px] text-slate-400 mt-0.5">{{ $placement->academicYear->name }}</p>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold border {{ $placement->status->badgeClass() }}">
                                        {{ $placement->status->label() }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    <div class="inline-flex items-center gap-1.5">
                                        <a href="{{ route('admin.internships.placements.edit', $placement->id) }}"
                                           class="px-2.5 py-1 text-xs font-semibold text-brand hover:text-brand-hover hover:bg-slate-100 rounded transition min-h-[36px] flex items-center">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('admin.internships.placements.destroy', $placement->id) }}"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus data penempatan PKL untuk {{ $placement->student->name }}? Data presensi dan jurnal terkait akan ikut terhapus.');"
                                              class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-2.5 py-1 text-xs font-semibold text-rose-700 hover:text-rose-900 hover:bg-rose-50 rounded transition min-h-[36px] flex items-center">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-10 text-center text-slate-500">
                                    Belum ada data penempatan PKL yang sesuai dengan filter pencarian.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($placements->hasPages())
                <div class="p-4 border-t border-border bg-slate-50">
                    {{ $placements->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
