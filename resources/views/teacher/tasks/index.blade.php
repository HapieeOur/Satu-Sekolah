<x-app-layout title="Tugas & Penugasan Siswa">
    <x-slot name="header">
        Portal Guru: Tugas & Penugasan Siswa
    </x-slot>

    <div class="space-y-6">
        <x-role-switcher />

        <!-- Top Header & Action -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight">Tugas &amp; Penugasan Kelas</h1>
                <p class="text-xs text-slate-500 mt-0.5">Kelola penugasan mandiri, materi evaluasi, dan penilaian hasil belajar siswa</p>
            </div>
            <div class="flex items-center gap-2.5">
                <button type="button" onclick="document.getElementById('newTaskForm').classList.toggle('hidden')"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md shadow-indigo-600/20 transition-all duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Terbitkan Tugas Baru</span>
                </button>
            </div>
        </div>

        @if (session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200/80 text-emerald-800 text-xs flex items-center gap-2.5 animate-in fade-in">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Create Task Form (Collapsible) -->
        <div id="newTaskForm" class="{{ $errors->any() ? '' : 'hidden' }} bg-white rounded-2xl border border-slate-200/80 p-6 md:p-8 shadow-sm space-y-5 animate-in fade-in duration-150">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-slate-900">Formulir Buat Tugas Siswa</h2>
                        <p class="text-[11px] text-slate-500">Buat penugasan untuk kelas ampu: tentukan target kelas, tenggat waktu (deadline), deskripsi, dan lampirkan foto soal tugas jika ada</p>
                    </div>
                </div>
                <button type="button" onclick="document.getElementById('newTaskForm').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-lg hover:bg-slate-100 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form method="POST" action="{{ route('teacher.tasks.store') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <!-- Target Kelas & Mata Pelajaran -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="classroom_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Untuk Kelas Mana <span class="text-rose-500">*</span></label>
                        <select name="classroom_id" id="classroom_id" required class="w-full text-xs rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 bg-white text-slate-800 p-3 transition">
                            <option value="">-- Pilih Kelas Target --</option>
                            @foreach ($classrooms as $c)
                                <option value="{{ $c->id }}" {{ old('classroom_id') == $c->id ? 'selected' : '' }}>
                                    {{ $c->name }} ({{ $c->major }})
                                </option>
                            @endforeach
                        </select>
                        <p class="text-[11px] text-slate-400 mt-1">Pilih kelas yang akan menerima tugas ini.</p>
                        @error('classroom_id') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="subject_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Mata Pelajaran <span class="text-rose-500">*</span></label>
                        <select name="subject_id" id="subject_id" required class="w-full text-xs rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 bg-white text-slate-800 p-3 transition">
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach ($subjects as $s)
                                <option value="{{ $s->id }}" {{ old('subject_id') == $s->id ? 'selected' : '' }}>
                                    {{ $s->name }} ({{ $s->code }})
                                </option>
                            @endforeach
                        </select>
                        <p class="text-[11px] text-slate-400 mt-1">Mata pelajaran tugas terkait.</p>
                        @error('subject_id') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Judul & Deadline -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Judul Tugas <span class="text-slate-400 font-normal lowercase">(opsional)</span>
                        </label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" placeholder="Contoh: Latihan Soal Pemrograman Objek Bab 2"
                               class="w-full text-xs rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 bg-white text-slate-800 p-3 transition">
                        <p class="text-[11px] text-slate-400 mt-1">Jika dikosongkan, judul akan terisi otomatis dari nama mapel &amp; kelas.</p>
                        @error('title') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="due_date" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Tenggat Waktu (Deadline) <span class="text-rose-500">*</span></label>
                        <input type="datetime-local" name="due_date" id="due_date" required 
                               value="{{ old('due_date', now()->addDays(7)->setTime(23, 59)->format('Y-m-d\TH:i')) }}" 
                               min="{{ now()->format('Y-m-d\TH:i') }}"
                               class="w-full text-xs rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 bg-white text-slate-800 p-3 transition">
                        <p class="text-[11px] text-slate-400 mt-1">Batas akhir tanggal &amp; jam penyerahan tugas (WIB).</p>
                        @error('due_date') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Foto Tugas (Opsional) -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Foto Tugas / Lampiran Lembar Soal <span class="text-slate-400 font-normal lowercase">(opsional)</span>
                    </label>
                    <div class="border-2 border-dashed border-slate-200 hover:border-indigo-400 rounded-2xl p-4 bg-slate-50/50 transition">
                        <div class="flex flex-col sm:flex-row items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div class="flex-1 text-center sm:text-left">
                                <input type="file" name="attachment" id="task_attachment_input" accept="image/*,.pdf,.doc,.docx"
                                       onchange="handleTaskPhotoPreview(event)"
                                       class="w-full text-xs rounded-xl border border-slate-200 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 bg-white text-slate-800 p-2 transition cursor-pointer">
                                <p class="text-[11px] text-slate-400 mt-1">Dapat berupa foto papan tulis / lembar kerja buku catatan (JPG, PNG, WEBP) atau berkas dokumen (PDF, Word maks. 10 MB).</p>
                            </div>
                        </div>

                        <!-- Live Photo Preview Box -->
                        <div id="photoPreviewContainer" class="hidden mt-4 pt-3 border-t border-slate-200/60 flex items-start gap-3">
                            <div class="relative group">
                                <img id="photoPreviewImage" src="#" alt="Pratinjau Foto Tugas" class="w-32 h-32 object-cover rounded-xl border border-slate-300 shadow-sm">
                            </div>
                            <div class="space-y-1">
                                <span class="text-xs font-bold text-slate-800 block">Pratinjau Foto Soal Tugas</span>
                                <span id="photoFileName" class="text-[11px] text-slate-500 font-mono block"></span>
                                <button type="button" onclick="clearTaskPhoto()" class="inline-flex items-center gap-1 text-[11px] font-semibold text-rose-600 hover:text-rose-700 mt-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    <span>Hapus Foto Pilihan</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    @error('attachment') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Deskripsi & Instruksi -->
                <div>
                    <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Deskripsi &amp; Instruksi Pengerjaan <span class="text-rose-500">*</span></label>
                    <textarea name="description" id="description" required rows="4" placeholder="Tuliskan petunjuk pengerjaan tugas, nomor soal yang dikerjakan, format pengumpulan jawaban, atau catatan bagi siswa..."
                              class="w-full text-xs rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 bg-white text-slate-800 p-3 leading-relaxed transition">{{ old('description') }}</textarea>
                    @error('description') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button type="button" onclick="document.getElementById('newTaskForm').classList.add('hidden')"
                            class="px-4 py-2.5 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition">
                        Batal
                    </button>
                    <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2.5 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md shadow-indigo-600/20 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Terbitkan Tugas</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Tasks Table Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="p-5 md:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-base font-bold text-slate-900">Daftar Penugasan Mata Pelajaran</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Seluruh penugasan aktif yang Anda berikan kepada siswa kelas</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-800">
                    <thead class="bg-slate-50/80 border-b border-slate-200/80 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">
                        <tr>
                            <th scope="col" class="py-3.5 px-4 w-14 text-center">No</th>
                            <th scope="col" class="py-3.5 px-4">Judul Penugasan</th>
                            <th scope="col" class="py-3.5 px-4">Mata Pelajaran &amp; Kelas</th>
                            <th scope="col" class="py-3.5 px-4">Batas Waktu (Deadline)</th>
                            <th scope="col" class="py-3.5 px-4 text-center">Progres Pengumpulan</th>
                            <th scope="col" class="py-3.5 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($tasks as $index => $tsk)
                            @php
                                $totalStudents = $tsk->classroom?->students?->count() ?? 0;
                                $submittedCount = $tsk->submissions->count();
                            @endphp
                            <tr class="hover:bg-indigo-50/30 transition-colors duration-150">
                                <td class="py-4 px-4 text-center font-mono text-slate-400 font-medium">
                                    {{ $tasks->firstItem() + $index }}
                                </td>
                                <td class="py-4 px-4 max-w-sm">
                                    <p class="font-bold text-slate-900 text-xs">{{ $tsk->title }}</p>
                                    <p class="text-[11px] text-slate-500 mt-1 line-clamp-2 leading-relaxed">{{ $tsk->description }}</p>
                                    @if($tsk->attachment_path)
                                        <div class="mt-2 flex items-center gap-2">
                                            @if($tsk->isAttachmentImage())
                                                <a href="{{ $tsk->attachment_url }}" target="_blank" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[11px] font-bold bg-amber-50 text-amber-800 border border-amber-200/80 hover:bg-amber-100 transition">
                                                    <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                    <span>📷 Foto Lembar Soal</span>
                                                </a>
                                            @else
                                                <a href="{{ $tsk->attachment_url }}" target="_blank" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200/80 hover:bg-indigo-100 transition">
                                                    <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                                    <span>Lampiran Berkas</span>
                                                </a>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200/60 block mb-1 w-fit">
                                        {{ $tsk->subject->name }}
                                    </span>
                                    <span class="text-xs font-mono text-slate-500">
                                        Kelas: {{ $tsk->classroom->name }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                        <div>
                                            <span class="font-bold text-slate-800 block">{{ $tsk->due_date->translatedFormat('d M Y, H:i') }} WIB</span>
                                            <span class="text-[11px] text-slate-400 font-mono">{{ $tsk->due_date->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-center whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $submittedCount > 0 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60' : 'bg-slate-100 text-slate-500' }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $submittedCount > 0 ? 'bg-emerald-600' : 'bg-slate-400' }}"></span>
                                        <span>{{ $submittedCount }} / {{ $totalStudents }} Siswa</span>
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('teacher.tasks.show', $tsk->id) }}"
                                           class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200/60 rounded-xl transition">
                                            <span>Periksa &amp; Nilai</span>
                                            <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                        </a>
                                        <form method="POST" action="{{ route('teacher.tasks.destroy', $tsk->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tugas ini? Seluruh data pengumpulan siswa akan ikut terhapus.')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 rounded-lg hover:bg-rose-50 transition" title="Hapus Tugas">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center">
                                    <div class="max-w-xs mx-auto text-center space-y-2">
                                        <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                        </div>
                                        <p class="text-xs font-bold text-slate-700">Belum ada tugas mata pelajaran.</p>
                                        <p class="text-[11px] text-slate-400">Klik tombol di atas untuk menerbitkan penugasan baru kepada kelas ampu Anda.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        @if ($tasks->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $tasks->links() }}
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
        function handleTaskPhotoPreview(event) {
            const file = event.target.files[0];
            const previewContainer = document.getElementById('photoPreviewContainer');
            const previewImage = document.getElementById('photoPreviewImage');
            const fileNameSpan = document.getElementById('photoFileName');

            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    fileNameSpan.textContent = file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
                    previewContainer.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else if (file) {
                previewContainer.classList.remove('hidden');
                previewImage.src = 'data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="128" height="128" fill="%236366f1" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>';
                fileNameSpan.textContent = file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
            } else {
                clearTaskPhoto();
            }
        }

        function clearTaskPhoto() {
            const input = document.getElementById('task_attachment_input');
            const previewContainer = document.getElementById('photoPreviewContainer');
            if (input) input.value = '';
            if (previewContainer) previewContainer.classList.add('hidden');
        }
    </script>
    @endpush
</x-app-layout>
