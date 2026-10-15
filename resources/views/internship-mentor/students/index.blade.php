<x-app-layout title="Daftar Siswa Bimbingan PKL">
    <x-slot name="header">
        Pembimbing: Siswa Bimbingan
    </x-slot>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-navy">Siswa Bimbingan PKL</h1>
                <p class="text-xs text-slate-600 mt-1">Daftar seluruh siswa binaan PKL yang ditugaskan kepada Anda pada periode aktif.</p>
            </div>
        </div>

        <!-- Mentees Table -->
        <div class="bg-surface rounded-xl border border-border shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-800">
                    <thead class="bg-slate-50 border-b border-border text-slate-700 font-semibold uppercase tracking-wider text-[11px]">
                        <tr>
                            <th scope="col" class="py-3 px-4 w-12 text-center">No</th>
                            <th scope="col" class="py-3 px-4">Siswa & Kelas</th>
                            <th scope="col" class="py-3 px-4">Mitra Perusahaan</th>
                            <th scope="col" class="py-3 px-4">Divisi / Penempatan</th>
                            <th scope="col" class="py-3 px-4">Periode Pelaksanaan</th>
                            <th scope="col" class="py-3 px-4">Status</th>
                            <th scope="col" class="py-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse ($mentees as $index => $placement)
                            <tr class="hover:bg-slate-50/75 transition">
                                <td class="py-3.5 px-4 text-center font-mono text-slate-500">{{ $index + 1 }}</td>
                                <td class="py-3.5 px-4">
                                    <p class="font-bold text-navy">{{ $placement->student->name }}</p>
                                    <p class="text-[11px] text-slate-500 font-mono mt-0.5">
                                        NIS: {{ $placement->student->nis }} &bull; {{ $placement->student->classroom?->name ?? '-' }}
                                    </p>
                                </td>
                                <td class="py-3.5 px-4">
                                    <p class="font-semibold text-slate-800">{{ $placement->company->name }}</p>
                                    <p class="text-[11px] text-slate-500 mt-0.5 truncate max-w-xs">{{ $placement->company->address }}</p>
                                </td>
                                <td class="py-3.5 px-4 text-slate-700">
                                    {{ $placement->department ?: 'Umum / Teknis' }}
                                </td>
                                <td class="py-3.5 px-4 font-mono text-slate-600">
                                    {{ $placement->start_date->format('d/m/Y') }} — {{ $placement->end_date->format('d/m/Y') }}
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold border {{ $placement->status->badgeClass() }}">
                                        {{ $placement->status->label() }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    <a href="{{ route('internship-mentor.students.show', $placement->id) }}"
                                       class="px-3 py-1.5 text-xs font-semibold text-brand hover:text-brand-hover hover:bg-slate-100 rounded-lg transition min-h-[36px] inline-flex items-center">
                                        Detail Progres &rarr;
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-10 text-center text-slate-500">
                                    Belum ada siswa PKL yang ditugaskan sebagai bimbingan Anda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
