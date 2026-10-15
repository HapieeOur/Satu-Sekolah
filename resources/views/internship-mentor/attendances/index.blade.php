<x-app-layout title="Presensi & Verifikasi Siswa PKL">
    <x-slot name="header">
        Pembimbing: Presensi & Lokasi PKL
    </x-slot>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-navy">Presensi & Verifikasi Lokasi PKL</h1>
                <p class="text-xs text-slate-600 mt-1">Pemantauan kehadiran masuk/pulang, koordinat GPS, foto bukti, dan verifikasi siswa bimbingan.</p>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="bg-surface rounded-xl border border-border p-5 shadow-sm">
            <form method="GET" action="{{ route('internship-mentor.attendances.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label for="date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal</label>
                    <input type="date" name="date" id="date" value="{{ $filters['date'] ?? '' }}"
                           class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
                </div>

                <div>
                    <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status Kehadiran</label>
                    <select name="status" id="status" class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
                        <option value="">Semua Status</option>
                        @foreach ($statuses as $st)
                            <option value="{{ $st->value }}" {{ ($filters['status'] ?? '') == $st->value ? 'selected' : '' }}>
                                {{ $st->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="verification_status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status Verifikasi</label>
                    <select name="verification_status" id="verification_status" class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
                        <option value="">Semua Status</option>
                        @foreach ($verificationStatuses as $vs)
                            <option value="{{ $vs->value }}" {{ ($filters['verification_status'] ?? '') == $vs->value ? 'selected' : '' }}>
                                {{ $vs->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="w-full px-4 py-2 bg-navy hover:bg-navy-light text-white text-xs font-semibold rounded-lg transition min-h-[38px]">
                        Terapkan Filter
                    </button>
                    @if (! empty(array_filter($filters)))
                        <a href="{{ route('internship-mentor.attendances.index') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition min-h-[38px] flex items-center shrink-0">
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
                            <th scope="col" class="py-3 px-4">Tanggal & Mitra</th>
                            <th scope="col" class="py-3 px-4">Waktu (Masuk - Pulang)</th>
                            <th scope="col" class="py-3 px-4">Geofence Lokasi</th>
                            <th scope="col" class="py-3 px-4">Status & Verifikasi</th>
                            <th scope="col" class="py-3 px-4 text-right">Tindakan Pembimbing</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse ($attendances as $index => $att)
                            <tr class="hover:bg-slate-50/75 transition">
                                <td class="py-3.5 px-4 text-center font-mono text-slate-500">
                                    {{ $attendances->firstItem() + $index }}
                                </td>
                                <td class="py-3.5 px-4">
                                    <p class="font-bold text-navy">{{ $att->placement->student->name }}</p>
                                    <p class="text-[11px] text-slate-500 font-mono mt-0.5">NIS: {{ $att->placement->student->nis }}</p>
                                </td>
                                <td class="py-3.5 px-4">
                                    <p class="font-semibold text-slate-800">{{ $att->date->translatedFormat('d F Y') }}</p>
                                    <p class="text-[11px] text-slate-500 mt-0.5 truncate max-w-xs">{{ $att->placement->company->name }}</p>
                                </td>
                                <td class="py-3.5 px-4 font-mono">
                                    <p class="text-slate-800 font-semibold">
                                        {{ $att->check_in_time ? substr($att->check_in_time, 0, 5) : '-' }} — {{ $att->check_out_time ? substr($att->check_out_time, 0, 5) : '-' }}
                                    </p>
                                    @if($att->check_in_distance_meters !== null)
                                        <p class="text-[10px] text-slate-500 mt-0.5">
                                            Jarak: {{ $att->check_in_distance_meters }}m dari koordinat kantor
                                        </p>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4">
                                    @if($att->check_in_time)
                                        @if($att->check_in_within_radius)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-300">
                                                Dalam Radius ({{ $att->placement->company->radius_meters }}m)
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-rose-50 text-rose-800 border border-rose-300">
                                                Di Luar Radius Mitra
                                            </span>
                                        @endif
                                    @else
                                        <span class="text-slate-400 font-mono">-</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="space-y-1">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold border {{ $att->status->badgeClass() }}">
                                            {{ $att->status->label() }}
                                        </span>
                                        <div>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold border {{ $att->verification_status->badgeClass() }}">
                                                {{ $att->verification_status->label() }}
                                            </span>
                                        </div>
                                        @if($att->rejection_reason)
                                            <p class="text-[10px] text-rose-700 bg-rose-50 p-1 rounded max-w-xs">
                                                Alasan Tolak: {{ $att->rejection_reason }}
                                            </p>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    @if($att->verification_status->value === 'pending')
                                        <div class="inline-flex items-center gap-1.5">
                                            <form method="POST" action="{{ route('internship-mentor.attendances.verify', $att->id) }}" class="inline-block">
                                                @csrf
                                                <input type="hidden" name="status" value="verified">
                                                <button type="submit" class="px-2.5 py-1 text-xs font-semibold text-emerald-700 hover:text-emerald-900 hover:bg-emerald-50 rounded transition min-h-[36px]">
                                                    Verifikasi
                                                </button>
                                            </form>

                                            <button type="button"
                                                    onclick="openRejectModal('{{ $att->id }}', '{{ $att->placement->student->name }}')"
                                                    class="px-2.5 py-1 text-xs font-semibold text-rose-700 hover:text-rose-900 hover:bg-rose-50 rounded transition min-h-[36px]">
                                                Tolak
                                            </button>
                                        </div>
                                    @else
                                        <span class="text-[11px] text-slate-400">Telah diproses</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-10 text-center text-slate-500">
                                    Belum ada catatan presensi siswa bimbingan yang sesuai kriteria pencarian.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($attendances->hasPages())
                <div class="p-4 border-t border-border bg-slate-50">
                    {{ $attendances->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-surface rounded-xl border border-border shadow-xl max-w-md w-full p-6 space-y-4">
            <h3 class="text-base font-bold text-navy">Tolak Verifikasi Presensi</h3>
            <p id="rejectStudentInfo" class="text-xs text-slate-600"></p>

            <form id="rejectForm" method="POST" action="" class="space-y-4">
                @csrf
                <input type="hidden" name="status" value="rejected">
                <div>
                    <label for="rejection_reason" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Alasan Penolakan <span class="text-danger">*</span></label>
                    <textarea name="rejection_reason" id="rejection_reason" required rows="3" placeholder="Contoh: Lokasi GPS berada jauh di luar area kantor mitra tanpa keterangan resmi."
                              class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800"></textarea>
                </div>

                <div class="pt-3 border-t border-border flex items-center justify-end gap-2">
                    <button type="button" onclick="closeRejectModal()" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-lg min-h-[40px]">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 text-xs font-semibold text-white bg-rose-700 hover:bg-rose-800 rounded-lg shadow-sm min-h-[40px]">
                        Konfirmasi Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openRejectModal(id, studentName) {
            const form = document.getElementById('rejectForm');
            form.action = `/internship-mentor/attendances/${id}/verify`;
            document.getElementById('rejectStudentInfo').textContent = `Presensi: ${studentName}`;
            document.getElementById('rejection_reason').value = '';
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
