<x-app-layout title="Profil Siswa - {{ $student->name }}">
    <x-slot name="header">
        Wali Kelas: Profil Siswa Binaan
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Top Back Link -->
        <div class="flex items-center gap-3">
            <a href="{{ route('homeroom.students.index') }}" 
               class="w-10 h-10 rounded-xl bg-white hover:bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-700 transition shadow-2xs">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-[#233DFF] block">Kelas {{ $classroom->name }}</span>
                <h1 class="text-xl md:text-2xl font-black text-slate-900 leading-snug">{{ $student->name }}</h1>
            </div>
        </div>

        <!-- Student Profile Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 md:p-8 shadow-xs space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-[#171B61] text-white font-black text-xl flex items-center justify-center shadow-md">
                        {{ strtoupper(substr($student->name, 0, 2)) }}
                    </div>
                    <div>
                        <h2 class="text-lg font-black text-slate-900">{{ $student->name }}</h2>
                        <p class="text-xs text-slate-500 font-mono mt-0.5">NIS: {{ $student->nis ?? '-' }} &bull; NISN: {{ $student->nisn ?? '-' }}</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold mt-2 {{ $student->gender === 'L' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                            {{ $student->gender === 'L' ? 'Laki-Laki' : 'Perempuan' }}
                        </span>
                    </div>
                </div>

                <div class="text-left sm:text-right">
                    <span class="text-xs text-slate-400 block font-medium">Rombel Binaan</span>
                    <span class="text-base font-black text-slate-900 block mt-0.5">{{ $classroom->name }}</span>
                    <span class="text-[11px] text-slate-500">{{ $classroom->major }}</span>
                </div>
            </div>

            <!-- Detailed Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 text-xs">
                <div class="space-y-3.5">
                    <h3 class="font-bold text-slate-900 uppercase tracking-wider text-[11px] pb-1 border-b border-slate-100">Kontak &amp; Akun Siswa</h3>
                    <div class="flex justify-between py-1 border-b border-slate-100">
                        <span class="text-slate-400">Email Akun</span>
                        <span class="font-bold text-slate-800 font-mono">{{ $student->user?->email ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-100">
                        <span class="text-slate-400">Nomor Telepon</span>
                        <span class="font-bold text-slate-800">{{ $student->phone ?: '-' }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-100">
                        <span class="text-slate-400">Status Akun</span>
                        <span class="font-bold text-emerald-600">Aktif</span>
                    </div>
                </div>

                <div class="space-y-3.5">
                    <h3 class="font-bold text-slate-900 uppercase tracking-wider text-[11px] pb-1 border-b border-slate-100">Orang Tua / Wali Siswa</h3>
                    <div class="flex justify-between py-1 border-b border-slate-100">
                        <span class="text-slate-400">Nama Orang Tua</span>
                        <span class="font-bold text-slate-800">{{ $student->parent_name ?: '-' }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-100">
                        <span class="text-slate-400">No. Kontak Orang Tua</span>
                        <span class="font-bold text-slate-800">{{ $student->parent_phone ?: '-' }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-100">
                        <span class="text-slate-400">Alamat Domisili</span>
                        <span class="font-bold text-slate-800 max-w-xs text-right truncate">{{ $student->address ?: '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance History Table -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Riwayat Presensi Siswa Terkini</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Catatan presensi masuk dan status kehadiran harian</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-[#F4F6FB] border-b border-slate-100 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                        <tr>
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4">Jam Masuk</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($student->attendances as $att)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-3 px-4 font-mono text-slate-700 font-medium">{{ $att->date->format('d/m/Y') }}</td>
                                <td class="py-3 px-4 font-mono text-slate-600">{{ $att->check_in_time ? substr($att->check_in_time, 0, 5) : '-' }} WIB</td>
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $att->status->badgeClass() }}">
                                        {{ $att->status->label() }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-slate-500">{{ $att->notes ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-slate-400">
                                    Belum ada log presensi tersimpan untuk siswa ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
