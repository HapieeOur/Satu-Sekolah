<x-app-layout title="Data Guru">
    <x-slot name="header">
        Data Master: Guru &amp; Tenaga Pendidik
    </x-slot>

    <!-- Header Actions & Search -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs p-6 space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-black text-navy tracking-tight">Daftar Tenaga Pendidik</h2>
                <p class="text-xs text-slate-500 mt-0.5">Kelola data profil guru, nomor identitas pendidik (NIP/NUPTK), dan penugasan mata pelajaran.</p>
            </div>
            <a href="{{ route('admin.teachers.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-brand to-indigo-600 hover:from-brand-hover hover:to-indigo-700 text-white text-xs font-bold rounded-xl shadow-md hover:shadow-glow hover:-translate-y-0.5 transition-all duration-150">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                <span>Tambah Guru Baru</span>
            </a>
        </div>

        <form method="GET" action="{{ route('admin.teachers.index') }}" class="flex flex-col sm:flex-row items-center gap-2.5 pt-4 border-t border-slate-100">
            <div class="w-full sm:flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari nama guru, NIP, NUPTK, atau email..."
                    class="w-full pl-10 pr-3.5 py-2.5 text-xs rounded-xl border-slate-200 focus:ring-2 focus:ring-brand/20 focus:border-brand bg-white text-slate-900 shadow-xs"
                >
            </div>
            <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-navy hover:bg-slate-800 text-white text-xs font-bold rounded-xl transition shadow-xs shrink-0 cursor-pointer">
                Cari
            </button>
            @if (request('search'))
                <a href="{{ route('admin.teachers.index') }}" class="px-3 py-2.5 text-xs font-bold text-slate-500 hover:text-navy transition shrink-0">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden flex flex-col">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50/80 border-b border-slate-100 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="py-3 px-5">Nama Lengkap &amp; Email</th>
                        <th class="py-3 px-5">NIP / NUPTK</th>
                        <th class="py-3 px-5">L/P</th>
                        <th class="py-3 px-5">No. Telepon</th>
                        <th class="py-3 px-5">Mata Pelajaran Diampu</th>
                        <th class="py-3 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($teachers as $teacher)
                        <tr class="hover:bg-slate-50/75 transition">
                            <td class="py-4 px-5">
                                <div class="font-bold text-navy text-xs sm:text-sm">{{ $teacher->user->name ?? '-' }}</div>
                                <div class="text-[10px] text-slate-400 font-mono mt-0.5">{{ $teacher->user->email ?? '-' }}</div>
                            </td>
                            <td class="py-4 px-5 font-mono text-slate-600">
                                <div class="font-bold text-slate-700">NIP: {{ $teacher->nip ?? '-' }}</div>
                                <div class="text-[10px] text-slate-400">NUPTK: {{ $teacher->nuptk ?? '-' }}</div>
                            </td>
                            <td class="py-4 px-5">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $teacher->gender === 'L' ? 'bg-sky-50 text-sky-700 border border-sky-200' : 'bg-pink-50 text-pink-700 border border-pink-200' }}">
                                    {{ $teacher->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                            </td>
                            <td class="py-4 px-5 font-mono text-slate-600">
                                {{ $teacher->phone ?? '-' }}
                            </td>
                            <td class="py-4 px-5">
                                <div class="flex flex-wrap gap-1 max-w-xs">
                                    @forelse ($teacher->subjects as $subject)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold bg-indigo-50 text-brand border border-indigo-200">
                                            {{ $subject->name }}
                                        </span>
                                    @empty
                                        <span class="text-[10px] text-slate-400 italic">Belum ada mapel</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="py-4 px-5 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('admin.teachers.edit', $teacher) }}" class="p-2 text-slate-500 hover:text-brand hover:bg-indigo-50 rounded-xl transition" title="Edit Data">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </a>

                                    <form method="POST" action="{{ route('admin.teachers.destroy', $teacher) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data profil guru ini?')">
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
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                Belum ada data guru yang cocok dengan kriteria pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($teachers->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/60">
                {{ $teachers->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
