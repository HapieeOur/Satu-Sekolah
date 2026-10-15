<x-app-layout title="Permohonan Izin / Sakit PKL">
    <x-slot name="header">
        Pembimbing: Pengajuan Izin / Sakit PKL
    </x-slot>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-navy">Permohonan Izin / Sakit PKL</h1>
                <p class="text-xs text-slate-600 mt-1">Verifikasi pengajuan izin dan sakit siswa bimbingan PKL beserta bukti surat pendukung.</p>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="bg-surface rounded-xl border border-border p-5 shadow-sm">
            <form method="GET" action="{{ route('internship-mentor.leaves.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="type" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Jenis Pengajuan</label>
                    <select name="type" id="type" class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
                        <option value="">Semua Jenis</option>
                        <option value="izin" {{ ($filters['type'] ?? '') == 'izin' ? 'selected' : '' }}>Izin</option>
                        <option value="sakit" {{ ($filters['type'] ?? '') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status Persetujuan</label>
                    <select name="status" id="status" class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
                        <option value="">Semua Status</option>
                        @foreach ($statuses as $st)
                            <option value="{{ $st->value }}" {{ ($filters['status'] ?? '') == $st->value ? 'selected' : '' }}>
                                {{ $st->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="w-full px-4 py-2 bg-navy hover:bg-navy-light text-white text-xs font-semibold rounded-lg transition min-h-[38px]">
                        Filter Pengajuan
                    </button>
                    @if (! empty(array_filter($filters)))
                        <a href="{{ route('internship-mentor.leaves.index') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition min-h-[38px] flex items-center shrink-0">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="bg-surface rounded-xl border border-border shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-800">
                    <thead class="bg-slate-50 border-b border-border text-slate-700 font-semibold uppercase tracking-wider text-[11px]">
                        <tr>
                            <th scope="col" class="py-3 px-4 w-12 text-center">No</th>
                            <th scope="col" class="py-3 px-4">Siswa Bimbingan</th>
                            <th scope="col" class="py-3 px-4">Jenis</th>
                            <th scope="col" class="py-3 px-4">Rentang Tanggal</th>
                            <th scope="col" class="py-3 px-4">Alasan & Keterangan</th>
                            <th scope="col" class="py-3 px-4">Status & Catatan Review</th>
                            <th scope="col" class="py-3 px-4 text-right">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse ($leaveRequests as $index => $leave)
                            <tr class="hover:bg-slate-50/75 transition">
                                <td class="py-3.5 px-4 text-center font-mono text-slate-500">
                                    {{ $leaveRequests->firstItem() + $index }}
                                </td>
                                <td class="py-3.5 px-4">
                                    <p class="font-bold text-navy">{{ $leave->placement->student->name }}</p>
                                    <p class="text-[11px] text-slate-500 mt-0.5">{{ $leave->placement->company->name }}</p>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold border {{ $leave->type->badgeClass() }}">
                                        {{ $leave->type->label() }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 font-mono text-slate-700 whitespace-nowrap">
                                    {{ $leave->start_date->format('d/m/Y') }} — {{ $leave->end_date->format('d/m/Y') }}
                                </td>
                                <td class="py-3.5 px-4 max-w-xs text-slate-700">
                                    {{ $leave->reason }}
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="space-y-1">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold border {{ $leave->status->badgeClass() }}">
                                            {{ $leave->status->label() }}
                                        </span>
                                        @if($leave->review_notes)
                                            <p class="text-[10px] text-slate-600 bg-slate-50 border border-slate-200 rounded p-1 max-w-xs">
                                                {{ $leave->review_notes }}
                                            </p>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                    @if($leave->status->value === 'pending')
                                        <div class="inline-flex items-center gap-1.5">
                                            <form method="POST" action="{{ route('internship-mentor.leaves.review', $leave->id) }}" class="inline-block">
                                                @csrf
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="px-2.5 py-1 text-xs font-semibold text-emerald-700 hover:text-emerald-900 hover:bg-emerald-50 rounded transition min-h-[36px]">
                                                    Setujui
                                                </button>
                                            </form>

                                            <form method="POST" action="{{ route('internship-mentor.leaves.review', $leave->id) }}" class="inline-block" onsubmit="return confirm('Tolak permohonan izin ini?');">
                                                @csrf
                                                <input type="hidden" name="status" value="rejected">
                                                <input type="hidden" name="review_notes" value="Ditolak oleh pembimbing sekolah">
                                                <button type="submit" class="px-2.5 py-1 text-xs font-semibold text-rose-700 hover:text-rose-900 hover:bg-rose-50 rounded transition min-h-[36px]">
                                                    Tolak
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-[11px] text-slate-400">Telah Ditinjau</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-10 text-center text-slate-500">
                                    Belum ada permohonan izin atau sakit yang diajukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($leaveRequests->hasPages())
                <div class="p-4 border-t border-border bg-slate-50">
                    {{ $leaveRequests->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
