<x-app-layout title="Admin Dashboard">
    <x-slot name="header">
        Dashboard Administrasi
    </x-slot>

    <!-- Welcome Banner -->
    <div class="bg-surface rounded-xl p-6 border border-border shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-navy">Selamat Datang, {{ Auth::user()->name }}!</h2>
            <p class="text-sm text-slate-500 mt-1">Anda masuk sebagai Administrator Sistem Informasi Satu-Sekolah.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-brand hover:bg-brand-hover text-white text-sm font-semibold rounded-lg shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Pengguna
            </a>
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-border text-sm font-medium rounded-lg transition">
                Daftar Pengguna
            </a>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-surface p-5 rounded-xl border border-border shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Pengguna</p>
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-brand flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
            </div>
            <p class="mt-3 text-2xl font-bold text-navy">{{ $stats['total_users'] }}</p>
            <p class="text-xs text-slate-500 mt-1">Akun terdaftar di sistem</p>
        </div>

        <div class="bg-surface p-5 rounded-xl border border-border shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Pengguna Aktif</p>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="mt-3 text-2xl font-bold text-navy">{{ $stats['active_users'] }}</p>
            <p class="text-xs text-slate-500 mt-1">Status aktif login</p>
        </div>

        <div class="bg-surface p-5 rounded-xl border border-border shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Tenaga Pendidik</p>
                <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </div>
            </div>
            <p class="mt-3 text-2xl font-bold text-navy">{{ $stats['total_teachers'] }}</p>
            <p class="text-xs text-slate-500 mt-1">Guru, Wali Kelas & Pembimbing</p>
        </div>

        <div class="bg-surface p-5 rounded-xl border border-border shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Role Sistem</p>
                <div class="w-8 h-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
            </div>
            <p class="mt-3 text-2xl font-bold text-navy">{{ $stats['total_roles'] }}</p>
            <p class="text-xs text-slate-500 mt-1">Konfigurasi hak akses RBAC</p>
        </div>
    </div>

    <!-- Role Distribution & Recent Users -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Role Distribution Card -->
        <div class="bg-surface rounded-xl border border-border shadow-sm p-6">
            <h3 class="text-sm font-bold text-navy uppercase tracking-wider mb-4">Distribusi Peran Pengguna</h3>
            <div class="space-y-3">
                @foreach ($rolesCount as $role)
                    <div class="flex items-center justify-between p-3 rounded-lg bg-canvas border border-border/60">
                        <div class="flex items-center gap-2.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-brand"></span>
                            <span class="text-sm font-semibold text-slate-700 capitalize">{{ str_replace('_', ' ', $role->name) }}</span>
                        </div>
                        <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-surface border border-border text-slate-600">
                            {{ $role->users_count }} Pengguna
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Users Table -->
        <div class="lg:col-span-2 bg-surface rounded-xl border border-border shadow-sm overflow-hidden flex flex-col">
            <div class="p-6 border-b border-border flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-navy uppercase tracking-wider">Pengguna Terbaru</h3>
                    <p class="text-xs text-slate-500 mt-0.5">5 akun terakhir yang terdaftar</p>
                </div>
                <a href="{{ route('admin.users.index') }}" class="text-xs font-semibold text-brand hover:underline">
                    Lihat Semua &rarr;
                </a>
            </div>

            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-canvas border-b border-border text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                            <th class="py-3 px-4">Nama & Email</th>
                            <th class="py-3 px-4">Peran</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse ($recentUsers as $user)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-3 px-4">
                                    <div class="font-semibold text-navy">{{ $user->name }}</div>
                                    <div class="text-xs text-slate-400">{{ $user->email }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach ($user->roles as $role)
                                            <span class="px-2 py-0.5 rounded text-[11px] font-medium bg-slate-100 text-slate-700 border border-slate-200">
                                                {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    @if ($user->is_active)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-rose-50 text-rose-700 border border-rose-200">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-right">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="text-xs font-medium text-brand hover:underline">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-sm text-slate-400">
                                    Belum ada pengguna terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
