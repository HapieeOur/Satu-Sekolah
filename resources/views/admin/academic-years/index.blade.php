<x-app-layout title="Data Tahun Ajaran & Semester">
    <x-slot name="header">
        Data Master: Tahun Ajaran
    </x-slot>

    <div class="space-y-6">
        <!-- Top Hero / Page Header -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 p-6 md:p-8 text-white shadow-xl">
            <div class="absolute -right-12 -top-12 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -left-12 -bottom-12 w-64 h-64 bg-brand/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/20 border border-indigo-400/30 text-indigo-300 text-xs font-semibold mb-3">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Kalender & Periode Akademik</span>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-white">Tahun Ajaran & Semester</h1>
                    <p class="text-sm text-slate-300 mt-1 max-w-xl">
                        Atur kalender belajar mengajar, aktifkan semester berjalan, dan sinkronisasi seluruh presensi serta pelaporan nilai.
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.academic-years.create') }}"
                       class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold text-xs shadow-lg shadow-indigo-500/25 transition duration-150 transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        <span>Tambah Tahun Ajaran</span>
                    </a>
                </div>
            </div>

            <!-- Bento Stats Sub-row -->
            <div class="relative z-10 grid grid-cols-2 sm:grid-cols-3 gap-3 mt-6 pt-6 border-t border-white/10">
                <div class="p-3 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <span class="text-[11px] font-medium text-slate-400 block">Total Periode Tercatat</span>
                    <span class="text-xl font-bold text-white mt-0.5 block">{{ $academicYears->count() }} Periode</span>
                </div>
                <div class="p-3 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <span class="text-[11px] font-medium text-slate-400 block">Periode Aktif Saat Ini</span>
                    <span class="text-xl font-bold text-emerald-400 mt-0.5 block">
                        {{ $academicYears->firstWhere('is_active', true)?->name ?? 'Belum ada' }}
                    </span>
                </div>
                <div class="p-3 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <span class="text-[11px] font-medium text-slate-400 block">Semester Aktif</span>
                    <span class="text-xl font-bold text-sky-400 mt-0.5 block capitalize">
                        {{ $academicYears->firstWhere('is_active', true)?->semester ?? '-' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Academic Years Table Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50/75 border-b border-slate-200 text-[11px] font-bold uppercase tracking-wider text-slate-600">
                            <th class="py-3.5 px-5">Tahun Ajaran</th>
                            <th class="py-3.5 px-4">Semester</th>
                            <th class="py-3.5 px-4">Rentang Periode Tanggal</th>
                            <th class="py-3.5 px-4">Status KBM</th>
                            <th class="py-3.5 px-5 text-right">Aksi & Kontrol</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($academicYears as $year)
                            <tr class="hover:bg-indigo-50/30 transition-colors duration-150 {{ $year->is_active ? 'bg-emerald-50/20' : '' }}">
                                <td class="py-4 px-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl {{ $year->is_active ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-700' }} font-bold flex items-center justify-center text-xs shadow-sm shrink-0">
                                            {{ substr($year->name, 2, 2) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-900 text-sm flex items-center gap-2">
                                                <span>{{ $year->name }}</span>
                                                @if ($year->is_active)
                                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                        SEDANG BERJALAN
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="text-[11px] text-slate-400">ID Periode: #{{ $year->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold {{ $year->semester === 'ganjil' ? 'bg-sky-50 text-sky-700 border border-sky-200' : 'bg-purple-50 text-purple-700 border border-purple-200' }}">
                                        Semester {{ ucfirst($year->semester) }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-slate-700 font-mono">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <span>{{ $year->start_date ? \Carbon\Carbon::parse($year->start_date)->format('d M Y') : '-' }}</span>
                                        <span class="text-slate-400">&mdash;</span>
                                        <span>{{ $year->end_date ? \Carbon\Carbon::parse($year->end_date)->format('d M Y') : '-' }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    @if ($year->is_active)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                            Tidak Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-5 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-2">
                                        @if (! $year->is_active)
                                            <form method="POST" action="{{ route('admin.academic-years.set-active', $year) }}">
                                                @csrf
                                                <button type="submit" class="px-3 py-1.5 text-xs font-semibold text-emerald-700 hover:text-emerald-900 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 rounded-lg shadow-sm transition">
                                                    Aktifkan Periode
                                                </button>
                                            </form>
                                        @endif

                                        <a href="{{ route('admin.academic-years.edit', $year) }}"
                                           class="p-2 text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition"
                                           title="Edit Periode">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        </a>

                                        @if (! $year->is_active)
                                            <form method="POST" action="{{ route('admin.academic-years.destroy', $year) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tahun ajaran {{ $year->name }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition"
                                                        title="Hapus Tahun Ajaran">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center">
                                    <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                    <h4 class="text-sm font-bold text-slate-800">Belum Ada Tahun Ajaran</h4>
                                    <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1 mb-4">
                                        Daftarkan periode tahun ajaran baru untuk mengaktifkan sistem presensi dan penjadwalan.
                                    </p>
                                    <a href="{{ route('admin.academic-years.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl shadow-sm transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        Tambah Tahun Ajaran Sekarang
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
