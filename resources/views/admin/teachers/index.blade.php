<x-app-layout title="Data Guru">
    <x-slot name="header">
        Data Master: Guru & Tenaga Pendidik
    </x-slot>

    <!-- Header Actions & Search -->
    <div class="bg-surface rounded-xl border border-border shadow-sm p-5 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-base font-bold text-navy">Daftar Guru</h2>
                <p class="text-xs text-slate-500 mt-0.5">Kelola data profil pendidik, NIP/NUPTK, dan penugasan mata pelajaran.</p>
            </div>
            <a href="{{ route('admin.teachers.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-brand hover:bg-brand-hover text-white text-xs font-semibold rounded-lg shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Guru Baru
            </a>
        </div>

        <form method="GET" action="{{ route('admin.teachers.index') }}" class="flex items-center gap-2 pt-3 border-t border-border">
            <div class="flex-1 max-w-md">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari nama guru, NIP, NUPTK, atau email..."
                    class="w-full px-3.5 py-2 text-xs rounded-lg border border-border focus:ring-1 focus:ring-brand focus:border-brand"
                >
            </div>
            <button type="submit" class="px-3.5 py-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-medium rounded-lg transition shrink-0">
                Cari
            </button>
            @if (request('search'))
                <a href="{{ route('admin.teachers.index') }}" class="px-2.5 py-2 text-xs text-slate-500 hover:text-slate-800 transition shrink-0">
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
                        <th class="py-3 px-4">Nama Lengkap & Email</th>
                        <th class="py-3 px-4">NIP / NUPTK</th>
                        <th class="py-3 px-4">L/P</th>
                        <th class="py-3 px-4">No. Telepon</th>
                        <th class="py-3 px-4">Mata Pelajaran Diampu</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse ($teachers as $teacher)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3.5 px-4">
                                <div class="font-semibold text-slate-900">{{ $teacher->user->name ?? '-' }}</div>
                                <div class="text-[11px] text-slate-500">{{ $teacher->user->email ?? '-' }}</div>
                            </td>
                            <td class="py-3.5 px-4 font-mono text-slate-700">
                                <div>NIP: {{ $teacher->nip ?? '-' }}</div>
                                <div class="text-[11px] text-slate-400">NUPTK: {{ $teacher->nuptk ?? '-' }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium {{ $teacher->gender === 'L' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-pink-50 text-pink-700 border border-pink-200' }}">
                                    {{ $teacher->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-600">
                                {{ $teacher->phone ?? '-' }}
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="flex flex-wrap gap-1 max-w-xs">
                                    @forelse ($teacher->subjects as $subject)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-slate-100 text-slate-700 border border-slate-200">
                                            {{ $subject->name }}
                                        </span>
                                    @empty
                                        <span class="text-[11px] text-slate-400 italic">Belum ada mapel</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.teachers.edit', $teacher) }}" class="p-1.5 text-slate-500 hover:text-brand hover:bg-slate-100 rounded-lg transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </a>

                                    <form method="POST" action="{{ route('admin.teachers.destroy', $teacher) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data profil guru ini?')">
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
                                Belum ada data guru yang cocok.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($teachers->hasPages())
            <div class="px-4 py-3 border-t border-border">
                {{ $teachers->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
