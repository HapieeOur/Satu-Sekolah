<x-app-layout title="Data Mata Pelajaran">
    <x-slot name="header">
        Data Master: Mata Pelajaran
    </x-slot>

    <div class="space-y-6">
        <!-- Top Hero / Page Header -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 p-6 md:p-8 text-white shadow-xl">
            <div class="absolute -right-12 -top-12 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -left-12 -bottom-12 w-64 h-64 bg-brand/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/20 border border-indigo-400/30 text-indigo-300 text-xs font-semibold mb-3">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        <span>Kurikulum & Modul Ajar</span>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-white">Mata Pelajaran</h1>
                    <p class="text-sm text-slate-300 mt-1 max-w-xl">
                        Kelola silabus kurikulum kejuruan dan umum, tetapkan tim guru pengampu, serta integrasikan dengan jadwal belajar mingguan.
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.subjects.create') }}"
                       class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold text-xs shadow-lg shadow-indigo-500/25 transition duration-150 transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        <span>Tambah Mapel Baru</span>
                    </a>
                </div>
            </div>

            <!-- Bento Stats Sub-row -->
            <div class="relative z-10 grid grid-cols-2 sm:grid-cols-3 gap-3 mt-6 pt-6 border-t border-white/10">
                <div class="p-3 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <span class="text-[11px] font-medium text-slate-400 block">Total Mata Pelajaran</span>
                    <span class="text-xl font-bold text-white mt-0.5 block">{{ $subjects->total() }} Mapel</span>
                </div>
                <div class="p-3 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <span class="text-[11px] font-medium text-slate-400 block">Telah Memiliki Guru Pengampu</span>
                    <span class="text-xl font-bold text-emerald-400 mt-0.5 block">
                        {{ $subjects->filter(fn($s) => $s->teachers->isNotEmpty())->count() }} Aktif Diampu
                    </span>
                </div>
                <div class="p-3 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <span class="text-[11px] font-medium text-slate-400 block">Belum Ada Pengampu</span>
                    <span class="text-xl font-bold text-amber-400 mt-0.5 block">
                        {{ $subjects->filter(fn($s) => $s->teachers->isEmpty())->count() }} Perlu Penugasan
                    </span>
                </div>
            </div>
        </div>

        <!-- Search & Filter Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5">
            <form method="GET" action="{{ route('admin.subjects.index') }}" class="flex items-center gap-3">
                <div class="flex-1 max-w-lg relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Cari kode mapel, nama mata pelajaran, atau kata kunci..."
                        class="w-full pl-10 pr-4 py-2.5 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800"
                    >
                </div>
                <button type="submit" class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold rounded-xl shadow-sm transition flex items-center gap-1.5 min-h-[42px]">
                    Cari
                </button>
                @if (request('search'))
                    <a href="{{ route('admin.subjects.index') }}" class="px-4 py-2.5 text-xs text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 font-medium rounded-xl transition min-h-[42px] flex items-center">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Subjects Table Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50/75 border-b border-slate-200 text-[11px] font-bold uppercase tracking-wider text-slate-600">
                            <th class="py-3.5 px-5">Kode Mapel</th>
                            <th class="py-3.5 px-5">Nama Mata Pelajaran</th>
                            <th class="py-3.5 px-4">Deskripsi / Kompetensi</th>
                            <th class="py-3.5 px-4">Guru Pengampu</th>
                            <th class="py-3.5 px-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($subjects as $subject)
                            <tr class="hover:bg-indigo-50/30 transition-colors duration-150">
                                <td class="py-4 px-5">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-mono font-bold bg-slate-100 text-slate-800 border border-slate-200">
                                        {{ $subject->code }}
                                    </span>
                                </td>
                                <td class="py-4 px-5 font-bold text-slate-900 text-sm">
                                    {{ $subject->name }}
                                </td>
                                <td class="py-4 px-4 text-slate-600 max-w-sm">
                                    <p class="line-clamp-2 leading-relaxed">
                                        {{ $subject->description ?: 'Tidak ada catatan deskripsi khusus.' }}
                                    </p>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex flex-wrap gap-1.5 max-w-md">
                                        @forelse ($subject->teachers as $teacher)
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[11px] font-medium bg-indigo-50 text-indigo-700 border border-indigo-200/80">
                                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                                                {{ $teacher->user->name ?? 'Guru #'.$teacher->id }}
                                            </span>
                                        @empty
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] text-amber-700 bg-amber-50 border border-amber-200">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                                Belum ada pengampu
                                            </span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="py-4 px-5 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5">
                                        <a href="{{ route('admin.subjects.edit', $subject) }}"
                                           class="p-2 text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition"
                                           title="Edit Mapel">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        </a>

                                        <form method="POST" action="{{ route('admin.subjects.destroy', $subject) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mata pelajaran {{ $subject->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition"
                                                    title="Hapus Mapel">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center">
                                    <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                    </div>
                                    <h4 class="text-sm font-bold text-slate-800">Tidak Ditemukan Mata Pelajaran</h4>
                                    <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1 mb-4">
                                        Belum ada data mata pelajaran yang tersimpan atau sesuai dengan kueri pencarian Anda.
                                    </p>
                                    <a href="{{ route('admin.subjects.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl shadow-sm transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        Tambah Mata Pelajaran
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($subjects->hasPages())
                <div class="px-5 py-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $subjects->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
