<x-app-layout title="Kelola Pengguna">
    <x-slot name="header">
        Manajemen Pengguna
    </x-slot>

    <!-- Header Actions & Search/Filters -->
    <div class="bg-surface rounded-xl border border-border shadow-sm p-5 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-base font-bold text-navy">Daftar Akun Pengguna</h2>
                <p class="text-xs text-slate-500 mt-0.5">Kelola akun guru, staf administrasi, wali kelas, dan pembimbing PKL.</p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-brand hover:bg-brand-hover text-white text-xs font-semibold rounded-lg shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Pengguna Baru
            </a>
        </div>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('admin.users.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-3 pt-3 border-t border-border">
            <!-- Search -->
            <div class="sm:col-span-2">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari nama, email, atau no. telepon..."
                    class="w-full px-3.5 py-2 text-xs rounded-lg border border-border focus:ring-1 focus:ring-brand focus:border-brand"
                >
            </div>

            <!-- Role Filter -->
            <div>
                <select name="role" class="w-full px-3 py-2 text-xs rounded-lg border border-border focus:ring-1 focus:ring-brand focus:border-brand bg-white text-slate-700">
                    <option value="">Semua Peran (Role)</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}" {{ request('role') === $role->name ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Status Filter & Button -->
            <div class="flex items-center gap-2">
                <select name="status" class="w-full px-3 py-2 text-xs rounded-lg border border-border focus:ring-1 focus:ring-brand focus:border-brand bg-white text-slate-700">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                <button type="submit" class="px-3.5 py-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-medium rounded-lg transition shrink-0">
                    Filter
                </button>
                @if (request()->hasAny(['search', 'role', 'status']))
                    <a href="{{ route('admin.users.index') }}" class="px-2.5 py-2 text-xs text-slate-500 hover:text-slate-800 transition shrink-0">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Users Table Card -->
    <div class="bg-surface rounded-xl border border-border shadow-sm overflow-hidden flex flex-col">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-canvas border-b border-border text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                        <th class="py-3 px-4">Pengguna</th>
                        <th class="py-3 px-4">No. Telepon</th>
                        <th class="py-3 px-4">Peran (Roles)</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Terdaftar</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse ($users as $user)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-200 text-slate-700 font-bold flex items-center justify-center uppercase shrink-0">
                                        {{ substr($user->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-navy flex items-center gap-1.5">
                                            <span>{{ $user->name }}</span>
                                            @if ($user->id === Auth::id())
                                                <span class="text-[10px] px-1.5 py-0.2 bg-blue-50 text-brand border border-blue-200 rounded font-normal">Anda</span>
                                            @endif
                                        </div>
                                        <div class="text-[11px] text-slate-400">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-slate-600">
                                {{ $user->phone ?? '—' }}
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="flex flex-wrap gap-1">
                                    @foreach ($user->roles as $role)
                                        <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                            {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                @if ($user->is_active)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-rose-50 text-rose-700 border border-rose-200">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-slate-500 text-[11px]">
                                {{ $user->created_at->format('d M Y') }}
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="p-1.5 rounded text-brand hover:bg-brand-light transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>

                                    @if ($user->id !== Auth::id())
                                        <!-- Toggle Status Form -->
                                        <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" onsubmit="return confirm('Ubah status akun ini?')">
                                            @csrf
                                            <button type="submit" class="p-1.5 rounded {{ $user->is_active ? 'text-amber-600 hover:bg-amber-50' : 'text-emerald-600 hover:bg-emerald-50' }}" title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                @if ($user->is_active)
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                                @else
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                @endif
                                            </button>
                                        </form>

                                        <!-- Delete Form -->
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ $user->name }}? Tindakan ini tidak dapat dibatalkan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded text-rose-600 hover:bg-rose-50 transition" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-sm text-slate-400">
                                Tidak ada data pengguna yang sesuai dengan filter pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($users->hasPages())
            <div class="p-4 border-t border-border bg-canvas">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
