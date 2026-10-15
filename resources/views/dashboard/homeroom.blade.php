<x-app-layout title="Dashboard Wali Kelas">
    <x-slot name="header">
        Dashboard Wali Kelas
    </x-slot>

    <!-- Welcome Card -->
    <div class="bg-surface rounded-xl p-6 border border-border shadow-sm">
        <div class="flex items-start justify-between">
            <div>
                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 mb-3">
                    Portal Wali Kelas
                </span>
                <h2 class="text-xl font-bold text-navy">Selamat Datang, {{ $user->name }}</h2>
                <p class="text-sm text-slate-500 mt-1">Area pemantauan khusus untuk data siswa, absensi, dan perkembangan kelas binaan Anda.</p>
            </div>
            <div class="hidden sm:block">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-lg">
                    WK
                </div>
            </div>
        </div>

        <div class="mt-6 pt-6 border-t border-border flex flex-wrap gap-4 text-xs text-slate-600">
            <div>
                <span class="text-slate-400 block uppercase tracking-wider text-[10px] font-semibold">Nama Wali</span>
                <span class="font-medium text-slate-800">{{ $user->name }}</span>
            </div>
            <div class="h-8 w-px bg-border hidden sm:block"></div>
            <div>
                <span class="text-slate-400 block uppercase tracking-wider text-[10px] font-semibold">Email</span>
                <span class="font-medium text-slate-800">{{ $user->email }}</span>
            </div>
            <div class="h-8 w-px bg-border hidden sm:block"></div>
            <div>
                <span class="text-slate-400 block uppercase tracking-wider text-[10px] font-semibold">Tanggung Jawab</span>
                <span class="font-medium text-slate-800">Manajemen Siswa & Kelas</span>
            </div>
        </div>
    </div>

    <!-- Info Sections -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div class="bg-surface p-5 rounded-xl border border-border shadow-sm">
            <h3 class="text-sm font-bold text-navy mb-2">Data Siswa Kelas</h3>
            <p class="text-xs text-slate-500 mb-4">Daftar siswa pada kelas binaan Anda akan dimuat secara otomatis setelah penetapan kelas dan tahun ajaran aktif pada Tahap 2.</p>
            <div class="p-3 bg-canvas rounded-lg border border-border text-xs text-slate-600 flex items-center gap-2">
                <svg class="w-4 h-4 text-brand shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                <span>Siswa terhubung langsung melalui relasi data master kelas.</span>
            </div>
        </div>

        <div class="bg-surface p-5 rounded-xl border border-border shadow-sm">
            <h3 class="text-sm font-bold text-navy mb-2">Pemantauan Siswa PKL</h3>
            <p class="text-xs text-slate-500 mb-4">Siswa di kelas Anda yang sedang menjalani program Praktik Kerja Lapangan (PKL) dapat dipantau perkembangannya melalui modul PKL.</p>
            <div class="p-3 bg-canvas rounded-lg border border-border text-xs text-slate-600 flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <span>Terintegrasi dengan penempatan industri mitra DUDI.</span>
            </div>
        </div>
    </div>
</x-app-layout>
