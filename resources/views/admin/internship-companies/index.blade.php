<x-app-layout title="Mitra Dunia Industri & PKL">
    <x-slot name="header">
        Data Master: Mitra Industri & Tempat PKL
    </x-slot>

    <!-- Header Actions & Search -->
    <div class="bg-surface rounded-xl border border-border shadow-sm p-5 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-base font-bold text-navy">Daftar Mitra PKL (DUDI)</h2>
                <p class="text-xs text-slate-500 mt-0.5">Kelola data mitra industri tempat Praktik Kerja Lapangan beserta koordinat GPS untuk validasi presensi siswa.</p>
            </div>
            <a href="{{ route('admin.internship-companies.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-brand hover:bg-brand-hover text-white text-xs font-semibold rounded-lg shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Mitra Baru
            </a>
        </div>

        <form method="GET" action="{{ route('admin.internship-companies.index') }}" class="flex items-center gap-2 pt-3 border-t border-border">
            <div class="flex-1 max-w-md">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari nama mitra, kontak person, telepon, email, alamat..."
                    class="w-full px-3.5 py-2 text-xs rounded-lg border border-border focus:ring-1 focus:ring-brand focus:border-brand"
                >
            </div>
            <button type="submit" class="px-3.5 py-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-medium rounded-lg transition shrink-0">
                Cari
            </button>
            @if (request('search'))
                <a href="{{ route('admin.internship-companies.index') }}" class="px-2.5 py-2 text-xs text-slate-500 hover:text-slate-800 transition shrink-0">
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
                        <th class="py-3 px-4">Nama Mitra Industri</th>
                        <th class="py-3 px-4">Alamat</th>
                        <th class="py-3 px-4">Kontak Person & Telepon</th>
                        <th class="py-3 px-4">Koordinat GPS (Geofence)</th>
                        <th class="py-3 px-4">Radius Presensi</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse ($companies as $company)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3.5 px-4 font-bold text-navy">
                                <div>{{ $company->name }}</div>
                                <div class="text-[11px] font-normal text-slate-400">{{ $company->email ?? '-' }}</div>
                            </td>
                            <td class="py-3.5 px-4 text-slate-600 max-w-xs truncate" title="{{ $company->address }}">
                                {{ $company->address }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-700">
                                <div class="font-medium">{{ $company->contact_person ?? '-' }}</div>
                                <div class="text-[11px] text-slate-500">{{ $company->phone ?? '-' }}</div>
                            </td>
                            <td class="py-3.5 px-4 font-mono text-[11px] text-slate-600">
                                @if ($company->latitude && $company->longitude)
                                    <span class="inline-flex items-center gap-1 text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">
                                        <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        {{ number_format($company->latitude, 5) }}, {{ number_format($company->longitude, 5) }}
                                    </span>
                                @else
                                    <span class="text-slate-400 italic">Belum diset</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-slate-100 text-slate-700 border border-slate-200">
                                    {{ $company->radius_meters }} meter
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.internship-companies.edit', $company) }}" class="p-1.5 text-slate-500 hover:text-brand hover:bg-slate-100 rounded-lg transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </a>

                                    <form method="POST" action="{{ route('admin.internship-companies.destroy', $company) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data mitra PKL ini?')">
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
                            <td colspan="6" class="py-8 text-center text-slate-400">
                                Belum ada data mitra PKL yang terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($companies->hasPages())
            <div class="px-4 py-3 border-t border-border">
                {{ $companies->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
