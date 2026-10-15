<x-app-layout title="Monitoring & Koreksi Presensi PKL">
    <x-slot name="header">
        Administrasi: Presensi Siswa PKL
    </x-slot>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-navy">Monitoring Presensi PKL</h1>
                <p class="text-xs text-slate-600 mt-1">
                    Verifikasi presensi berbasis lokasi GPS dan foto mobile. Koreksi manual dicatat dalam jejak audit resmi.
                </p>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="bg-surface rounded-xl border border-border p-5 shadow-sm">
            <form method="GET" action="{{ route('admin.internships.attendances.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <div>
                    <label for="date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal</label>
                    <input type="date" name="date" id="date" value="{{ $filters['date'] ?? '' }}"
                           class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
                </div>

                <div>
                    <label for="company_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Mitra Industri</label>
                    <select name="company_id" id="company_id" class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
                        <option value="">Semua Perusahaan</option>
                        @foreach ($companies as $comp)
                            <option value="{{ $comp->id }}" {{ ($filters['company_id'] ?? '') == $comp->id ? 'selected' : '' }}>
                                {{ $comp->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status Presensi</label>
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
                    <label for="verification_status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Verifikasi</label>
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
                        <a href="{{ route('admin.internships.attendances.index') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition min-h-[38px] flex items-center shrink-0">
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
                            <th scope="col" class="py-3 px-4">Siswa & Kelas</th>
                            <th scope="col" class="py-3 px-4">Tanggal & Mitra</th>
                            <th scope="col" class="py-3 px-4">Waktu (Masuk - Pulang)</th>
                            <th scope="col" class="py-3 px-4">Status & Radius</th>
                            <th scope="col" class="py-3 px-4">Verifikasi & Audit</th>
                            <th scope="col" class="py-3 px-4 text-right">Aksi</th>
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
                                    <p class="text-[11px] text-slate-500 font-mono mt-0.5">
                                        NIS: {{ $att->placement->student->nis }} &bull; {{ $att->placement->student->classroom?->name ?? '-' }}
                                    </p>
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
                                            Jarak: {{ $att->check_in_distance_meters }}m dari titik mitra
                                        </p>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="space-y-1">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold border {{ $att->status->badgeClass() }}">
                                            {{ $att->status->label() }}
                                        </span>
                                        @if($att->check_in_time)
                                            <div>
                                                @if($att->check_in_within_radius)
                                                    <span class="inline-flex items-center text-[10px] text-emerald-800 font-medium">
                                                        Dalam radius mitra
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center text-[10px] text-rose-800 font-semibold">
                                                        Di luar radius geofence
                                                    </span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="space-y-1">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold border {{ $att->verification_status->badgeClass() }}">
                                            {{ $att->verification_status->label() }}
                                        </span>
                                        @if($att->is_manual_correction)
                                            <p class="text-[10px] text-indigo-900 bg-indigo-50 border border-indigo-200 rounded p-1 max-w-xs">
                                                <strong>Koreksi Manual:</strong> {{ $att->correction_reason }}
                                                <span class="block text-[9px] text-slate-500 mt-0.5">Oleh {{ $att->corrector?->name ?? 'Admin' }} ({{ $att->corrected_at?->format('d/m H:i') }})</span>
                                            </p>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    @can('attendance.correct')
                                        <button type="button"
                                                onclick="openCorrectionModal('{{ $att->id }}', '{{ $att->placement->student->name }}', '{{ $att->date->format('Y-m-d') }}', '{{ $att->status->value }}', '{{ $att->check_in_time ? substr($att->check_in_time, 0, 5) : '' }}', '{{ $att->check_out_time ? substr($att->check_out_time, 0, 5) : '' }}')"
                                                class="px-2.5 py-1 text-xs font-semibold text-brand hover:text-brand-hover hover:bg-slate-100 rounded transition min-h-[36px]">
                                            Koreksi
                                        </button>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-10 text-center text-slate-500">
                                    Belum ada data presensi PKL yang sesuai kriteria pencarian.
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

    <!-- Modal Koreksi Manual Presensi -->
    <div id="correctionModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-surface rounded-xl border border-border shadow-xl max-w-md w-full p-6 space-y-4">
            <div class="flex items-start justify-between border-b border-border pb-3">
                <div>
                    <h3 class="text-base font-bold text-navy">Koreksi Manual Presensi PKL</h3>
                    <p id="modalStudentInfo" class="text-xs text-slate-600 mt-0.5"></p>
                </div>
                <button type="button" onclick="closeCorrectionModal()" class="text-slate-400 hover:text-slate-700 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form id="correctionForm" method="POST" action="" class="space-y-4">
                @csrf
                <div>
                    <label for="corr_status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Status Kehadiran <span class="text-danger">*</span></label>
                    <select name="status" id="corr_status" required class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
                        @foreach ($statuses as $st)
                            <option value="{{ $st->value }}">{{ $st->label() }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="corr_check_in" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Jam Masuk (HH:mm)</label>
                        <input type="text" name="check_in_time" id="corr_check_in" placeholder="07:30"
                               class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800 font-mono">
                    </div>
                    <div>
                        <label for="corr_check_out" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Jam Pulang (HH:mm)</label>
                        <input type="text" name="check_out_time" id="corr_check_out" placeholder="16:00"
                               class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800 font-mono">
                    </div>
                </div>

                <div>
                    <label for="corr_reason" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Alasan Koreksi Manual <span class="text-danger">* (Audit Log)</span></label>
                    <textarea name="correction_reason" id="corr_reason" required rows="3" placeholder="Contoh: Kendala sinyal GPS saat tiba di lokasi perusahaan, bukti foto kehadiran diverifikasi oleh pembimbing industri."
                              class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800"></textarea>
                    <p class="text-[11px] text-slate-500 mt-1">Alasan koreksi akan disimpan permanen untuk pemeriksaan audit administrasi.</p>
                </div>

                <div class="pt-3 border-t border-border flex items-center justify-end gap-2">
                    <button type="button" onclick="closeCorrectionModal()" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-lg min-h-[40px]">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 text-xs font-semibold text-white bg-brand hover:bg-brand-hover rounded-lg shadow-sm min-h-[40px]">
                        Simpan Koreksi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openCorrectionModal(id, studentName, date, status, checkIn, checkOut) {
            const form = document.getElementById('correctionForm');
            form.action = `/admin/internships/attendances/${id}/correct`;
            document.getElementById('modalStudentInfo').textContent = `${studentName} — ${date}`;
            document.getElementById('corr_status').value = status;
            document.getElementById('corr_check_in').value = checkIn;
            document.getElementById('corr_check_out').value = checkOut;
            document.getElementById('corr_reason').value = '';
            document.getElementById('correctionModal').classList.remove('hidden');
        }

        function closeCorrectionModal() {
            document.getElementById('correctionModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
