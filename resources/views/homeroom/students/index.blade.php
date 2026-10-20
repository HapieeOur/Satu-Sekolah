<x-app-layout title="Daftar Siswa Binaan">
    <x-slot name="header">
        Wali Kelas: Roster Siswa Binaan
    </x-slot>

    <div class="space-y-6">
        @if ($classroom)
            <!-- Top Header & Summary -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-[#E5ECFF] text-[#233DFF] border border-[#233DFF]/20">
                            Kelas {{ $classroom->name }}
                        </span>
                        <span class="text-xs text-slate-400">&bull;</span>
                        <span class="text-xs text-slate-500 font-semibold">{{ $classroom->major }}</span>
                    </div>
                    <h1 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight mt-1">Daftar Siswa Binaan</h1>
                    <p class="text-xs text-slate-500 mt-0.5">Daftar seluruh peserta didik terdaftar di rombel kelas binaan Anda</p>
                </div>

                <div class="flex items-center gap-2.5 flex-wrap">
                    <div class="px-4 py-2.5 rounded-xl bg-white border border-slate-200 shadow-2xs text-center">
                        <span class="text-xs text-slate-400 block font-medium">Total Siswa</span>
                        <span class="text-lg font-black text-slate-900">{{ $totalStudents }}</span>
                    </div>
                    <div class="px-4 py-2.5 rounded-xl bg-blue-50 border border-blue-200/60 shadow-2xs text-center">
                        <span class="text-xs text-blue-600 block font-medium">Laki-Laki</span>
                        <span class="text-lg font-black text-blue-700">{{ $maleCount }}</span>
                    </div>
                    <div class="px-4 py-2.5 rounded-xl bg-rose-50 border border-rose-200/60 shadow-2xs text-center">
                        <span class="text-xs text-rose-600 block font-medium">Perempuan</span>
                        <span class="text-lg font-black text-rose-700">{{ $femaleCount }}</span>
                    </div>
                </div>
            </div>

            <!-- Search & Filter Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-4 md:p-5 shadow-xs">
                <form method="GET" action="{{ route('homeroom.students.index') }}" class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama siswa, NIS, atau NISN..."
                               class="w-full text-xs rounded-xl border border-slate-200 pl-9 pr-4 py-2.5 focus:border-[#233DFF] focus:ring-2 focus:ring-[#233DFF]/10 text-slate-800 placeholder-slate-400 transition">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                    </div>

                    <div class="w-full sm:w-48">
                        <select name="gender" onchange="this.form.submit()" class="w-full text-xs rounded-xl border border-slate-200 py-2.5 px-3 focus:border-[#233DFF] focus:ring-2 focus:ring-[#233DFF]/10 text-slate-800 transition">
                            <option value="">Semua Gender</option>
                            <option value="L" {{ request('gender') === 'L' ? 'selected' : '' }}>Laki-Laki (L)</option>
                            <option value="P" {{ request('gender') === 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                        </select>
                    </div>

                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#233DFF] hover:bg-[#1a30d8] text-white text-xs font-bold shadow-xs transition">
                        Cari
                    </button>
                    @if(request()->hasAny(['q', 'gender']))
                        <a href="{{ route('homeroom.students.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold text-center transition">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            <!-- Students Table Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-800">
                        <thead class="bg-[#F4F6FB] border-b border-slate-200/80 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">
                            <tr>
                                <th scope="col" class="py-3.5 px-4 w-12 text-center">No</th>
                                <th scope="col" class="py-3.5 px-4">Siswa</th>
                                <th scope="col" class="py-3.5 px-4">Identitas (NIS/NISN)</th>
                                <th scope="col" class="py-3.5 px-4">Gender</th>
                                <th scope="col" class="py-3.5 px-4">Kontak &amp; Orang Tua</th>
                                <th scope="col" class="py-3.5 px-4">Alamat</th>
                                <th scope="col" class="py-3.5 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($students as $index => $stu)
                                <tr class="hover:bg-indigo-50/25 transition">
                                    <td class="py-3.5 px-4 text-center font-mono text-slate-400">
                                        {{ $students->firstItem() + $index }}
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-slate-900 text-white font-bold text-xs flex items-center justify-center shrink-0 shadow-2xs">
                                                {{ strtoupper(substr($stu->name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <a href="{{ route('homeroom.students.show', $stu->id) }}" class="font-bold text-slate-900 hover:text-[#233DFF] transition block leading-snug">
                                                    {{ $stu->name }}
                                                </a>
                                                <span class="text-[11px] text-slate-400 font-mono">{{ $stu->user?->email ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4 font-mono text-slate-600 whitespace-nowrap">
                                        <p class="font-bold text-slate-800 text-xs">NIS: {{ $stu->nis ?? '-' }}</p>
                                        <p class="text-[11px] text-slate-400">NISN: {{ $stu->nisn ?? '-' }}</p>
                                    </td>
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        @if($stu->gender === 'L')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                                Laki-Laki
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                                Perempuan
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        <p class="text-xs text-slate-800 font-semibold">{{ $stu->phone ?: '-' }}</p>
                                        <p class="text-[11px] text-slate-500 mt-0.5">
                                            Ortu: <span class="font-medium text-slate-700">{{ $stu->parent_name ?: '-' }}</span> ({{ $stu->parent_phone ?: '-' }})
                                        </p>
                                    </td>
                                    <td class="py-3.5 px-4 max-w-xs text-slate-600 truncate" title="{{ $stu->address }}">
                                        {{ $stu->address ?: '-' }}
                                    </td>
                                    <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                        <a href="{{ route('homeroom.students.show', $stu->id) }}"
                                           class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-[#E5ECFF] text-slate-700 hover:text-[#233DFF] text-xs font-bold transition">
                                            <span>Profil</span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-12 text-center text-slate-400">
                                        <p class="text-xs font-semibold text-slate-700">Tidak ada data siswa ditemukan.</p>
                                        <p class="text-[11px] mt-1">Coba sesuaikan kata kunci pencarian Anda.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($students->hasPages())
                    <div class="p-4 border-t border-slate-100">
                        {{ $students->links() }}
                    </div>
                @endif
            </div>
        @else
            <div class="bg-white rounded-2xl p-12 border border-slate-200/80 text-center shadow-xs">
                <div class="w-16 h-16 mx-auto rounded-2xl bg-[#ECEBFA] text-[#171B61] flex items-center justify-center mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <h3 class="text-base font-bold text-slate-900">Belum Ada Kelas Binaan</h3>
                <p class="text-xs text-slate-500 mt-1 max-w-md mx-auto leading-relaxed">
                    Akun pendidik Anda saat ini belum ditetapkan sebagai Wali Kelas di data master kelas sekolah.
                </p>
            </div>
        @endif
    </div>
</x-app-layout>
