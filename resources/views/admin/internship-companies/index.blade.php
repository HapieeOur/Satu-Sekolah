<x-app-layout title="Mitra Industri & Tempat PKL">
    <x-slot name="header">
        Data Master: Mitra Industri & Tempat PKL
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
                        <span>Kerjasama Dunia Usaha & Industri (DUDI)</span>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-white">Mitra Perusahaan PKL</h1>
                    <p class="text-sm text-slate-300 mt-1 max-w-xl">
                        Kelola data mitra magang, kontak penanggung jawab industri, dan parameter geofencing GPS untuk validasi presensi siswa.
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.internship-companies.create') }}"
                       class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold text-xs shadow-lg shadow-indigo-500/25 transition duration-150 transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        <span>Tambah Mitra Baru</span>
                    </a>
                </div>
            </div>

            <!-- Bento Stats Sub-row -->
            <div class="relative z-10 grid grid-cols-2 sm:grid-cols-3 gap-3 mt-6 pt-6 border-t border-white/10">
                <div class="p-3 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <span class="text-[11px] font-medium text-slate-400 block">Total Mitra Terdaftar</span>
                    <span class="text-xl font-bold text-white mt-0.5 block">{{ $companies->total() }} Perusahaan</span>
                </div>
                <div class="p-3 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <span class="text-[11px] font-medium text-slate-400 block">Koordinat Geofence Lengkap</span>
                    <span class="text-xl font-bold text-emerald-400 mt-0.5 block">
                        {{ $companies->filter(fn($c) => $c->latitude && $c->longitude)->count() }} Lokasi Terverifikasi
                    </span>
                </div>
                <div class="p-3 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <span class="text-[11px] font-medium text-slate-400 block">Standar Radius Presensi</span>
                    <span class="text-xl font-bold text-sky-400 mt-0.5 block">100 - 500 Meter</span>
                </div>
            </div>
        </div>

        <!-- Search Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5">
            <form method="GET" action="{{ route('admin.internship-companies.index') }}" class="flex items-center gap-3">
                <div class="flex-1 max-w-lg relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Cari nama perusahaan, kontak person, telepon, email, alamat..."
                        class="w-full pl-10 pr-4 py-2.5 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800"
                    >
                </div>
                <button type="submit" class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold rounded-xl shadow-sm transition flex items-center gap-1.5 min-h-[42px]">
                    Cari
                </button>
                @if (request('search'))
                    <a href="{{ route('admin.internship-companies.index') }}" class="px-4 py-2.5 text-xs text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 font-medium rounded-xl transition min-h-[42px] flex items-center">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Companies Table Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50/75 border-b border-slate-200 text-[11px] font-bold uppercase tracking-wider text-slate-600">
                            <th class="py-3.5 px-5">Nama Mitra Industri</th>
                            <th class="py-3.5 px-4">Pembimbing PKL & DUDI</th>
                            <th class="py-3.5 px-4">Alamat Fisik</th>
                            <th class="py-3.5 px-4">Titik Geofence (GPS)</th>
                            <th class="py-3.5 px-4">Radius Presensi</th>
                            <th class="py-3.5 px-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($companies as $company)
                            <tr class="hover:bg-indigo-50/30 transition-colors duration-150">
                                <td class="py-4 px-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-700 text-white font-extrabold flex items-center justify-center text-xs shadow-sm shrink-0">
                                            {{ substr($company->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-900 text-sm">{{ $company->name }}</div>
                                            <div class="text-[11px] text-slate-400">{{ $company->email ?: 'Email belum diset' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    @if ($company->teacher)
                                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-indigo-50 border border-indigo-200 text-indigo-700 font-bold text-xs">
                                            <svg class="w-3.5 h-3.5 text-indigo-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                            <span class="truncate max-w-[140px]">{{ $company->teacher->user->name }}</span>
                                        </div>
                                        <div class="text-[10px] text-slate-400 mt-0.5">Sekolah (NIP: {{ $company->teacher->nip }})</div>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] text-amber-700 bg-amber-50 border border-amber-200">
                                            Belum diset
                                        </span>
                                    @endif

                                    @if ($company->contact_person)
                                        <div class="mt-1.5 pt-1.5 border-t border-slate-100 text-[11px] text-slate-600">
                                            <span class="font-semibold text-slate-700">DUDI:</span> {{ $company->contact_person }}
                                            @if ($company->phone)
                                                <div class="text-slate-400 font-mono text-[10px]">{{ $company->phone }}</div>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-slate-600 max-w-xs">
                                    <div class="flex items-start gap-1.5" title="{{ $company->address }}">
                                        <svg class="w-3.5 h-3.5 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <p class="truncate">{{ $company->address }}</p>
                                    </div>
                                </td>
                                <td class="py-4 px-4 font-mono text-[11px]">
                                    @if ($company->latitude && $company->longitude)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-emerald-800 bg-emerald-50 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            {{ number_format($company->latitude, 4) }}, {{ number_format($company->longitude, 4) }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] text-amber-700 bg-amber-50 border border-amber-200">
                                            Belum ditentukan
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                        {{ $company->radius_meters }} meter
                                    </span>
                                </td>
                                <td class="py-4 px-5 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5">
                                        <a href="{{ route('admin.internship-companies.edit', $company) }}"
                                           class="p-2 text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition"
                                           title="Edit Mitra">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        </a>

                                        <form method="POST" action="{{ route('admin.internship-companies.destroy', $company) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data mitra {{ $company->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition"
                                                    title="Hapus Mitra">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center">
                                    <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    </div>
                                    <h4 class="text-sm font-bold text-slate-800">Tidak Ditemukan Mitra Industri</h4>
                                    <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1 mb-4">
                                        Belum ada data perusahaan atau instansi tempat PKL yang tersimpan.
                                    </p>
                                    <a href="{{ route('admin.internship-companies.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl shadow-sm transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        Tambah Mitra Baru
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($companies->hasPages())
                <div class="px-5 py-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $companies->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
