<x-app-layout title="Tahun Ajaran">
    <x-slot name="header">
        Data Master: Tahun Ajaran
    </x-slot>

    <!-- Header Actions -->
    <div class="bg-surface rounded-xl border border-border shadow-sm p-5 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-base font-bold text-navy">Daftar Tahun Ajaran & Semester</h2>
                <p class="text-xs text-slate-500 mt-0.5">Kelola periode aktif kegiatan belajar mengajar dan pelaporan akademik.</p>
            </div>
            <a href="{{ route('admin.academic-years.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-brand hover:bg-brand-hover text-white text-xs font-semibold rounded-lg shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Tahun Ajaran
            </a>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-surface rounded-xl border border-border shadow-sm overflow-hidden flex flex-col">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-canvas border-b border-border text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                        <th class="py-3 px-4">Tahun Ajaran</th>
                        <th class="py-3 px-4">Semester</th>
                        <th class="py-3 px-4">Periode Tanggal</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse ($academicYears as $year)
                        <tr class="hover:bg-slate-50/80 transition {{ $year->is_active ? 'bg-emerald-50/30' : '' }}">
                            <td class="py-3.5 px-4 font-semibold text-slate-900">
                                {{ $year->name }}
                            </td>
                            <td class="py-3.5 px-4 capitalize">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium {{ $year->semester === 'ganjil' ? 'bg-sky-50 text-sky-700 border border-sky-200' : 'bg-purple-50 text-purple-700 border border-purple-200' }}">
                                    Semester {{ ucfirst($year->semester) }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-600">
                                {{ $year->start_date ? \Carbon\Carbon::parse($year->start_date)->format('d M Y') : '-' }} s/d 
                                {{ $year->end_date ? \Carbon\Carbon::parse($year->end_date)->format('d M Y') : '-' }}
                            </td>
                            <td class="py-3.5 px-4">
                                @if ($year->is_active)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span>
                                        Aktif (Berjalan)
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                        Tidak Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    @if (! $year->is_active)
                                        <form method="POST" action="{{ route('admin.academic-years.set-active', $year) }}">
                                            @csrf
                                            <button type="submit" class="px-2.5 py-1 text-[11px] font-semibold text-emerald-700 hover:text-emerald-900 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 rounded-md transition">
                                                Aktifkan
                                            </button>
                                        </form>
                                    @endif

                                    <a href="{{ route('admin.academic-years.edit', $year) }}" class="p-1.5 text-slate-500 hover:text-brand hover:bg-slate-100 rounded-lg transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </a>

                                    <form method="POST" action="{{ route('admin.academic-years.destroy', $year) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tahun ajaran ini?')">
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
                            <td colspan="5" class="py-8 text-center text-slate-400">
                                Belum ada data tahun ajaran yang tersimpan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
