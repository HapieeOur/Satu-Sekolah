<x-app-layout title="Dashboard Guru">
    <x-slot name="header">
        Dashboard Guru
    </x-slot>

    <!-- Welcome Card -->
    <div class="bg-surface rounded-xl p-6 border border-border shadow-sm">
        <div class="flex items-start justify-between">
            <div>
                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-blue-50 text-brand border border-blue-200 mb-3">
                    Portal Pendidik
                </span>
                <h2 class="text-xl font-bold text-navy">Selamat Datang, {{ $user->name }}</h2>
                <p class="text-sm text-slate-500 mt-1">Kelola jadwal mengajar, mata pelajaran, dan aktivitas kelas Anda di sini.</p>
            </div>
            <div class="hidden sm:block">
                <div class="w-12 h-12 rounded-xl bg-brand/10 text-brand flex items-center justify-center font-bold text-lg">
                    {{ substr($user->name, 0, 2) }}
                </div>
            </div>
        </div>

        <div class="mt-6 pt-6 border-t border-border flex flex-wrap gap-4 text-xs text-slate-600">
            <div>
                <span class="text-slate-400 block uppercase tracking-wider text-[10px] font-semibold">Email</span>
                <span class="font-medium text-slate-800">{{ $user->email }}</span>
            </div>
            <div class="h-8 w-px bg-border hidden sm:block"></div>
            <div>
                <span class="text-slate-400 block uppercase tracking-wider text-[10px] font-semibold">No. Telepon</span>
                <span class="font-medium text-slate-800">{{ $user->phone ?? 'Belum diisi' }}</span>
            </div>
            <div class="h-8 w-px bg-border hidden sm:block"></div>
            <div>
                <span class="text-slate-400 block uppercase tracking-wider text-[10px] font-semibold">Peran Terdaftar</span>
                <div class="flex gap-1 mt-0.5">
                    @foreach ($user->roles as $role)
                        <span class="px-1.5 py-0.5 rounded text-[10px] font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                            {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Overview Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="bg-surface p-5 rounded-xl border border-border shadow-sm">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-brand flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="text-sm font-bold text-navy">Jadwal Mengajar</h3>
            </div>
            <p class="text-xs text-slate-500">Jadwal pelajaran aktif Anda akan dimuat setelah konfigurasi Tahun Ajaran dan Kelas pada Tahap 2 & 3.</p>
        </div>

        <div class="bg-surface p-5 rounded-xl border border-border shadow-sm">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <h3 class="text-sm font-bold text-navy">Mata Pelajaran</h3>
            </div>
            <p class="text-xs text-slate-500">Relasi mata pelajaran yang Anda ampu akan tampil pada modul data master.</p>
        </div>

        <div class="bg-surface p-5 rounded-xl border border-border shadow-sm">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                </div>
                <h3 class="text-sm font-bold text-navy">Pengumuman Sekolah</h3>
            </div>
            <p class="text-xs text-slate-500">Berita dan informasi resmi dari pihak sekolah dapat dipantau melalui portal ini.</p>
        </div>
    </div>
</x-app-layout>
