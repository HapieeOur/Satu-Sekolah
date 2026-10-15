<x-app-layout title="Jurnal Harian Siswa PKL">
    <x-slot name="header">
        Pembimbing: Jurnal Harian Siswa
    </x-slot>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-navy">Jurnal Harian Siswa Bimbingan</h1>
                <p class="text-xs text-slate-600 mt-1">Tinjau laporan aktivitas kerja harian, beri persetujuan, atau minta perbaikan/revisi.</p>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="bg-surface rounded-xl border border-border p-5 shadow-sm">
            <form method="GET" action="{{ route('internship-mentor.journals.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="search" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pencarian</label>
                    <input type="text" name="search" id="search" value="{{ $filters['search'] ?? '' }}" placeholder="Nama siswa / judul aktivitas..."
                           class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
                </div>

                <div>
                    <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status Jurnal</label>
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
                        Filter Jurnal
                    </button>
                    @if (! empty(array_filter($filters)))
                        <a href="{{ route('internship-mentor.journals.index') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition min-h-[38px] flex items-center shrink-0">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Journals Table -->
        <div class="bg-surface rounded-xl border border-border shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-800">
                    <thead class="bg-slate-50 border-b border-border text-slate-700 font-semibold uppercase tracking-wider text-[11px]">
                        <tr>
                            <th scope="col" class="py-3 px-4 w-12 text-center">No</th>
                            <th scope="col" class="py-3 px-4">Tanggal</th>
                            <th scope="col" class="py-3 px-4">Siswa Bimbingan</th>
                            <th scope="col" class="py-3 px-4">Judul & Ringkasan Kegiatan</th>
                            <th scope="col" class="py-3 px-4">Status & Catatan Pembimbing</th>
                            <th scope="col" class="py-3 px-4 text-right">Tindakan Review</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse ($journals as $index => $jr)
                            <tr class="hover:bg-slate-50/75 transition">
                                <td class="py-3.5 px-4 text-center font-mono text-slate-500">
                                    {{ $journals->firstItem() + $index }}
                                </td>
                                <td class="py-3.5 px-4 font-mono text-slate-600 whitespace-nowrap">
                                    {{ $jr->date->format('d/m/Y') }}
                                </td>
                                <td class="py-3.5 px-4">
                                    <p class="font-bold text-navy">{{ $jr->placement->student->name }}</p>
                                    <p class="text-[11px] text-slate-500 mt-0.5 truncate max-w-xs">{{ $jr->placement->company->name }}</p>
                                </td>
                                <td class="py-3.5 px-4 max-w-md">
                                    <p class="font-semibold text-slate-800">{{ $jr->title }}</p>
                                    <p class="text-[11px] text-slate-600 mt-1 line-clamp-2 leading-relaxed">
                                        {{ $jr->activity_description }}
                                    </p>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="space-y-1">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold border {{ $jr->status->badgeClass() }}">
                                            {{ $jr->status->label() }}
                                        </span>
                                        @if($jr->mentor_notes)
                                            <p class="text-[10px] text-slate-700 bg-slate-50 border border-slate-200 rounded p-1.5 max-w-xs">
                                                <strong>Catatan:</strong> {{ $jr->mentor_notes }}
                                            </p>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                    @if(in_array($jr->status->value, ['submitted', 'revision_requested']))
                                        <div class="inline-flex items-center gap-1.5">
                                            <form method="POST" action="{{ route('internship-mentor.journals.review', $jr->id) }}" class="inline-block">
                                                @csrf
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="px-2.5 py-1 text-xs font-semibold text-emerald-700 hover:text-emerald-900 hover:bg-emerald-50 rounded transition min-h-[36px]">
                                                    Setujui
                                                </button>
                                            </form>

                                            <button type="button"
                                                    onclick="openRevisionModal('{{ $jr->id }}', '{{ $jr->placement->student->name }}', '{{ $jr->title }}')"
                                                    class="px-2.5 py-1 text-xs font-semibold text-amber-700 hover:text-amber-900 hover:bg-amber-50 rounded transition min-h-[36px]">
                                                Minta Revisi
                                            </button>
                                        </div>
                                    @else
                                        <span class="text-[11px] text-emerald-700 font-semibold">Telah Disetujui</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-10 text-center text-slate-500">
                                    Belum ada catatan jurnal harian yang sesuai filter pencarian.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($journals->hasPages())
                <div class="p-4 border-t border-border bg-slate-50">
                    {{ $journals->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Revision Modal -->
    <div id="revisionModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-surface rounded-xl border border-border shadow-xl max-w-md w-full p-6 space-y-4">
            <h3 class="text-base font-bold text-navy">Permintaan Revisi Jurnal</h3>
            <p id="revisionInfo" class="text-xs text-slate-600"></p>

            <form id="revisionForm" method="POST" action="" class="space-y-4">
                @csrf
                <input type="hidden" name="status" value="revision_requested">
                <div>
                    <label for="mentor_notes" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Catatan Koreksi / Hal yang Perlu Diperbaiki <span class="text-danger">*</span></label>
                    <textarea name="mentor_notes" id="mentor_notes" required rows="3" placeholder="Contoh: Tolong lengkapi uraian teknis tools/framework yang digunakan pada modul tersebut."
                              class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800"></textarea>
                </div>

                <div class="pt-3 border-t border-border flex items-center justify-end gap-2">
                    <button type="button" onclick="closeRevisionModal()" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-lg min-h-[40px]">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 text-xs font-semibold text-white bg-amber-700 hover:bg-amber-800 rounded-lg shadow-sm min-h-[40px]">
                        Kirim Revisi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openRevisionModal(id, studentName, title) {
            const form = document.getElementById('revisionForm');
            form.action = `/internship-mentor/journals/${id}/review`;
            document.getElementById('revisionInfo').textContent = `${studentName} — "${title}"`;
            document.getElementById('mentor_notes').value = '';
            document.getElementById('revisionModal').classList.remove('hidden');
        }

        function closeRevisionModal() {
            document.getElementById('revisionModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
