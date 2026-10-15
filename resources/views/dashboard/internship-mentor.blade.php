<x-app-layout title="Dashboard Pembimbing PKL">
    <x-slot name="header">
        Dashboard Pembimbing PKL
    </x-slot>

    <!-- Welcome Card -->
    <div class="bg-surface rounded-xl p-6 border border-border shadow-sm">
        <div class="flex items-start justify-between">
            <div>
                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200 mb-3">
                    Portal Pembimbing PKL
                </span>
                <h2 class="text-xl font-bold text-navy">Selamat Datang, {{ $user->name }}</h2>
                <p class="text-sm text-slate-500 mt-1">Area pengawasan siswa bimbingan PKL, peninjauan jurnal harian, dan evaluasi tugas.</p>
            </div>
            <div class="hidden sm:block">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-lg">
                    PKL
                </div>
            </div>
        </div>

        <div class="mt-6 pt-6 border-t border-border flex flex-wrap gap-4 text-xs text-slate-600">
            <div>
                <span class="text-slate-400 block uppercase tracking-wider text-[10px] font-semibold">Nama Pembimbing</span>
                <span class="font-medium text-slate-800">{{ $user->name }}</span>
            </div>
            <div class="h-8 w-px bg-border hidden sm:block"></div>
            <div>
                <span class="text-slate-400 block uppercase tracking-wider text-[10px] font-semibold">Email</span>
                <span class="font-medium text-slate-800">{{ $user->email }}</span>
            </div>
            <div class="h-8 w-px bg-border hidden sm:block"></div>
            <div>
                <span class="text-slate-400 block uppercase tracking-wider text-[10px] font-semibold">Kewenangan Khusus</span>
                <span class="font-medium text-slate-800">Verifikasi Jurnal & Presensi Bimbingan</span>
            </div>
        </div>
    </div>

    <!-- Modules Overview Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="bg-surface p-5 rounded-xl border border-border shadow-sm">
            <h3 class="text-sm font-bold text-navy mb-2">Siswa Bimbingan</h3>
            <p class="text-xs text-slate-500 mb-4">Daftar siswa asuhan Anda yang aktif di lokasi mitra industri (DUDI).</p>
            <div class="p-2.5 bg-canvas rounded-lg border border-border text-xs text-slate-500">
                Fitur aktif pada Tahap 5 (Monitoring PKL)
            </div>
        </div>

        <div class="bg-surface p-5 rounded-xl border border-border shadow-sm">
            <h3 class="text-sm font-bold text-navy mb-2">Jurnal Kegiatan</h3>
            <p class="text-xs text-slate-500 mb-4">Tinjau logbook dan kegiatan harian yang disubmit siswa dengan status draft/revisi/disetujui.</p>
            <div class="p-2.5 bg-canvas rounded-lg border border-border text-xs text-slate-500">
                Workflow persetujuan jurnal
            </div>
        </div>

        <div class="bg-surface p-5 rounded-xl border border-border shadow-sm">
            <h3 class="text-sm font-bold text-navy mb-2">Presensi & Pengajuan Izin</h3>
            <p class="text-xs text-slate-500 mb-4">Pantau riwayat presensi masuk/pulang serta pengajuan izin sakit dari aplikasi mobile siswa.</p>
            <div class="p-2.5 bg-canvas rounded-lg border border-border text-xs text-slate-500">
                Validasi koordinat GPS & foto
            </div>
        </div>
    </div>
</x-app-layout>
