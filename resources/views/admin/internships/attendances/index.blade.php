<x-app-layout title="Monitoring & Koreksi Presensi PKL">
    <x-slot name="header">
        Administrasi: Presensi Siswa PKL
    </x-slot>

    <div class="space-y-6">
        <!-- Top Hero / Page Header -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 p-6 md:p-8 text-white shadow-xl">
            <div class="absolute -right-12 -top-12 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -left-12 -bottom-12 w-64 h-64 bg-brand/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/20 border border-indigo-400/30 text-indigo-300 text-xs font-semibold mb-3">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>Geofence & Attendance Center</span>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-white">Monitoring Presensi PKL</h1>
                    <p class="text-sm text-slate-300 mt-1 max-w-xl">
                        Verifikasi presensi mobile berbasis koordinat GPS, deteksi kepatuhan radius mitra industri, dan kelola koreksi administratif dengan jejak audit resmi.
                    </p>
                </div>
            </div>

            <!-- Bento Stats Sub-row -->
            <div class="relative z-10 grid grid-cols-2 sm:grid-cols-4 gap-3 mt-6 pt-6 border-t border-white/10">
                <div class="p-3 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <span class="text-[11px] font-medium text-slate-400 block">Total Log Presensi</span>
                    <span class="text-xl font-bold text-white mt-0.5 block">{{ $attendances->total() }} Log</span>
                </div>
                <div class="p-3 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <span class="text-[11px] font-medium text-slate-400 block">Dalam Radius Valid</span>
                    <span class="text-xl font-bold text-emerald-400 mt-0.5 block">
                        {{ $attendances->where('check_in_within_radius', true)->count() }} Valid GPS
                    </span>
                </div>
                <div class="p-3 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <span class="text-[11px] font-medium text-slate-400 block">Di Luar Titik Geofence</span>
                    <span class="text-xl font-bold text-rose-400 mt-0.5 block">
                        {{ $attendances->where('check_in_within_radius', false)->whereNotNull('check_in_time')->count() }} Luar Area
                    </span>
                </div>
                <div class="p-3 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <span class="text-[11px] font-medium text-slate-400 block">Koreksi Manual Audit</span>
                    <span class="text-xl font-bold text-amber-400 mt-0.5 block">
                        {{ $attendances->where('is_manual_correction', true)->count() }} Terkoreksi
                    </span>
                </div>
            </div>
        </div>

        <!-- Filter Bar Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5">
            <form method="GET" action="{{ route('admin.internships.attendances.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <div>
                    <label for="date" class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Tanggal</label>
                    <input type="date" name="date" id="date" value="{{ $filters['date'] ?? '' }}"
                           class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800 font-mono">
                </div>

                <div>
                    <label for="company_id" class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Mitra Industri</label>
                    <select name="company_id" id="company_id" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800">
                        <option value="">Semua Perusahaan</option>
                        @foreach ($companies as $comp)
                            <option value="{{ $comp->id }}" {{ ($filters['company_id'] ?? '') == $comp->id ? 'selected' : '' }}>
                                {{ $comp->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Status Kehadiran</label>
                    <select name="status" id="status" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800">
                        <option value="">Semua Status</option>
                        @foreach ($statuses as $st)
                            <option value="{{ $st->value }}" {{ ($filters['status'] ?? '') == $st->value ? 'selected' : '' }}>
                                {{ $st->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="verification_status" class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Verifikasi</label>
                    <select name="verification_status" id="verification_status" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800">
                        <option value="">Semua Status</option>
                        @foreach ($verificationStatuses as $vs)
                            <option value="{{ $vs->value }}" {{ ($filters['verification_status'] ?? '') == $vs->value ? 'selected' : '' }}>
                                {{ $vs->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="w-full px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold rounded-xl shadow-sm transition min-h-[42px]">
                        Terapkan Filter
                    </button>
                    @if (! empty(array_filter($filters)))
                        <a href="{{ route('admin.internships.attendances.index') }}" class="px-3.5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl transition min-h-[42px] flex items-center shrink-0">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Attendances Table Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50/75 border-b border-slate-200 text-[11px] font-bold uppercase tracking-wider text-slate-600">
                            <th scope="col" class="py-3.5 px-4 w-12 text-center">No</th>
                            <th scope="col" class="py-3.5 px-4">Siswa & Rombel</th>
                            <th scope="col" class="py-3.5 px-4">Tanggal & Mitra</th>
                            <th scope="col" class="py-3.5 px-4">Waktu (Masuk - Pulang)</th>
                            <th scope="col" class="py-3.5 px-4">Status & Radius GPS</th>
                            <th scope="col" class="py-3.5 px-4">Verifikasi & Jejak Audit</th>
                            <th scope="col" class="py-3.5 px-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($attendances as $index => $att)
                            <tr class="hover:bg-indigo-50/30 transition-colors duration-150">
                                <td class="py-4 px-4 text-center font-mono text-slate-400">
                                    {{ $attendances->firstItem() + $index }}
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-indigo-50 text-indigo-700 font-bold flex items-center justify-center text-xs border border-indigo-100 shrink-0">
                                            {{ substr($att->placement->student->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900 text-sm">{{ $att->placement->student->name }}</p>
                                            <p class="text-[11px] text-slate-400 font-mono mt-0.5">
                                                NIS: {{ $att->placement->student->nis }} &bull; {{ $att->placement->student->classroom?->name ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <p class="font-semibold text-slate-800">{{ $att->date->translatedFormat('d F Y') }}</p>
                                    <div class="flex items-center gap-1 text-[11px] text-slate-400 mt-0.5 truncate max-w-xs">
                                        <svg class="w-3 h-3 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                        <span class="truncate">{{ $att->placement->company->name }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4 font-mono">
                                    <div class="flex items-center gap-1.5 font-bold text-slate-800">
                                        <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span>{{ $att->check_in_time ? substr($att->check_in_time, 0, 5) : '--:--' }}</span>
                                        <span class="text-slate-400">&mdash;</span>
                                        <span>{{ $att->check_out_time ? substr($att->check_out_time, 0, 5) : '--:--' }}</span>
                                    </div>
                                    @if($att->check_in_distance_meters !== null)
                                        <p class="text-[10px] text-slate-400 mt-1">
                                            Jarak: <span class="font-bold text-slate-600">{{ $att->check_in_distance_meters }}m</span> dari pusat geofence
                                        </p>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    <div class="space-y-1.5">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $att->status->badgeClass() }}">
                                            {{ $att->status->label() }}
                                        </span>
                                        @if($att->check_in_time)
                                            <div>
                                                @if($att->check_in_within_radius)
                                                    <span class="inline-flex items-center gap-1 text-[11px] text-emerald-700 font-medium bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                        Dalam radius mitra
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 text-[11px] text-rose-700 font-semibold bg-rose-50 px-2 py-0.5 rounded border border-rose-200">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                        Di luar radius geofence
                                                    </span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="space-y-1.5">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $att->verification_status->badgeClass() }}">
                                            {{ $att->verification_status->label() }}
                                        </span>
                                        @if($att->is_manual_correction)
                                            <div class="text-[11px] text-indigo-900 bg-indigo-50/80 border border-indigo-200/80 rounded-lg p-2 max-w-xs shadow-sm">
                                                <div class="font-bold flex items-center gap-1">
                                                    <svg class="w-3 h-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                    Koreksi Audit:
                                                </div>
                                                <p class="mt-0.5 leading-snug">{{ $att->correction_reason }}</p>
                                                <span class="block text-[10px] text-slate-400 mt-1">Oleh {{ $att->corrector?->name ?? 'Admin' }} ({{ $att->corrected_at?->format('d/m H:i') }})</span>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-4 px-5 text-right whitespace-nowrap">
                                    @can('attendance.correct')
                                        <button type="button"
                                                onclick="openCorrectionModal('{{ $att->id }}', '{{ $att->placement->student->name }}', '{{ $att->date->format('Y-m-d') }}', '{{ $att->status->value }}', '{{ $att->check_in_time ? substr($att->check_in_time, 0, 5) : '' }}', '{{ $att->check_out_time ? substr($att->check_out_time, 0, 5) : '' }}')"
                                                class="px-3 py-1.5 text-xs font-semibold text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition min-h-[36px] inline-flex items-center gap-1 shadow-sm">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            Koreksi Presensi
                                        </button>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center">
                                    <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <h4 class="text-sm font-bold text-slate-800">Tidak Ada Log Presensi PKL</h4>
                                    <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1">
                                        Belum ada riwayat presensi siswa PKL yang cocok dengan kriteria filter yang Anda pilih.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($attendances->hasPages())
                <div class="px-5 py-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $attendances->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Koreksi Manual Presensi -->
    <div id="correctionModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-md flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-md w-full p-6 space-y-4 animate-in fade-in zoom-in-95 duration-150">
            <div class="flex items-start justify-between border-b border-slate-100 pb-3">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Koreksi Manual Presensi PKL</h3>
                    <p id="modalStudentInfo" class="text-xs text-slate-500 mt-0.5 font-medium"></p>
                </div>
                <button type="button" onclick="closeCorrectionModal()" class="text-slate-400 hover:text-slate-700 p-1.5 rounded-lg hover:bg-slate-100 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form id="correctionForm" method="POST" action="" class="space-y-4 text-xs">
                @csrf
                <div>
                    <label for="corr_status" class="block font-bold uppercase tracking-wider text-slate-700 mb-1">Status Kehadiran <span class="text-rose-500">*</span></label>
                    <select name="status" id="corr_status" required class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800 transition">
                        @foreach ($statuses as $st)
                            <option value="{{ $st->value }}">{{ $st->label() }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="corr_check_in" class="block font-bold uppercase tracking-wider text-slate-700 mb-1">Jam Masuk (HH:mm)</label>
                        <input type="text" name="check_in_time" id="corr_check_in" placeholder="07:30"
                               class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800 font-mono transition">
                    </div>
                    <div>
                        <label for="corr_check_out" class="block font-bold uppercase tracking-wider text-slate-700 mb-1">Jam Pulang (HH:mm)</label>
                        <input type="text" name="check_out_time" id="corr_check_out" placeholder="16:00"
                               class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800 font-mono transition">
                    </div>
                </div>

                <div>
                    <label for="corr_reason" class="block font-bold uppercase tracking-wider text-slate-700 mb-1">
                        Alasan Koreksi Manual <span class="text-rose-500">* (Audit Log)</span>
                    </label>
                    <textarea name="correction_reason" id="corr_reason" required rows="3" placeholder="Contoh: Kendala sinyal GPS saat tiba di lokasi perusahaan, bukti foto kehadiran diverifikasi oleh pembimbing industri."
                              class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800 transition leading-relaxed"></textarea>
                    <p class="text-[11px] text-slate-400 mt-1">Alasan koreksi akan dicatat permanen dalam audit log sistem sekolah.</p>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button type="button" onclick="closeCorrectionModal()" class="px-4 py-2.5 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 text-xs font-semibold text-white bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 rounded-xl shadow-md shadow-indigo-500/20 transition">
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
