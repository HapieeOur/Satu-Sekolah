<x-app-layout title="Tambah Penempatan PKL">
    <x-slot name="header">
        Penempatan PKL: Tambah Baru
    </x-slot>

    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Back Navigation & Title -->
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.internships.placements.index') }}" class="p-2 rounded-lg bg-surface hover:bg-slate-100 text-slate-600 border border-border transition min-h-[44px] min-w-[44px] flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h1 class="text-xl font-bold text-navy">Tambah Penempatan PKL Siswa</h1>
                <p class="text-xs text-slate-600 mt-0.5">Daftarkan penempatan siswa ke perusahaan mitra dengan guru pembimbing sekolah.</p>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-surface rounded-xl border border-border p-6 shadow-sm">
            <form method="POST" action="{{ route('admin.internships.placements.store') }}" class="space-y-5">
                @csrf

                <!-- Tahun Ajaran & Status -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="academic_year_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tahun Ajaran <span class="text-danger">*</span></label>
                        <select name="academic_year_id" id="academic_year_id" required class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
                            @foreach ($academicYears as $year)
                                <option value="{{ $year->id }}" {{ old('academic_year_id', $activeYear?->id) == $year->id ? 'selected' : '' }}>
                                    {{ $year->label }} {{ $year->is_active ? '(Aktif)' : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('academic_year_id')
                            <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status Penempatan <span class="text-danger">*</span></label>
                        <select name="status" id="status" required class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
                            @foreach ($statuses as $st)
                                <option value="{{ $st->value }}" {{ old('status', 'active') == $st->value ? 'selected' : '' }}>
                                    {{ $st->label() }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Siswa -->
                <div>
                    <label for="student_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pilih Siswa <span class="text-danger">*</span></label>
                    <select name="student_id" id="student_id" required class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
                        <option value="">-- Pilih Siswa yang Belum Ditempatkan --</option>
                        @foreach ($students as $stu)
                            <option value="{{ $stu->id }}" {{ old('student_id') == $stu->id ? 'selected' : '' }}>
                                {{ $stu->name }} (NIS: {{ $stu->nis }}) — Kelas {{ $stu->classroom?->name ?? 'Tanpa Kelas' }}
                            </option>
                        @endforeach
                    </select>
                    @error('student_id')
                        <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mitra DUDI & Departemen -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="internship_company_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Mitra Industri (DUDI) <span class="text-danger">*</span></label>
                        <select name="internship_company_id" id="internship_company_id" required class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
                            <option value="">-- Pilih Perusahaan Mitra --</option>
                            @foreach ($companies as $comp)
                                <option value="{{ $comp->id }}" {{ old('internship_company_id') == $comp->id ? 'selected' : '' }}>
                                    {{ $comp->name }} (Radius {{ $comp->radius_meters }}m)
                                </option>
                            @endforeach
                        </select>
                        @error('internship_company_id')
                            <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="department" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Departemen / Divisi</label>
                        <input type="text" name="department" id="department" value="{{ old('department') }}" placeholder="Contoh: IT Support / Web Development"
                               class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
                        @error('department')
                            <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Guru Pembimbing PKL -->
                <div>
                    <label for="teacher_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Guru Pembimbing PKL <span class="text-danger">*</span></label>
                    <select name="teacher_id" id="teacher_id" required class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
                        <option value="">-- Pilih Guru Pembimbing --</option>
                        @foreach ($teachers as $tch)
                            <option value="{{ $tch->id }}" {{ old('teacher_id') == $tch->id ? 'selected' : '' }}>
                                {{ $tch->user->name }} (NIP: {{ $tch->nip }})
                            </option>
                        @endforeach
                    </select>
                    @error('teacher_id')
                        <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rentang Waktu PKL -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="start_date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal Mulai PKL <span class="text-danger">*</span></label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date', now()->toDateString()) }}" required
                               class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
                        @error('start_date')
                            <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal Selesai PKL <span class="text-danger">*</span></label>
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date', now()->addMonths(3)->toDateString()) }}" required
                               class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
                        @error('end_date')
                            <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Catatan Tambahan -->
                <div>
                    <label for="notes" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Catatan Tambahan</label>
                    <textarea name="notes" id="notes" rows="3" placeholder="Informasi penugasan khusus, nomor surat tugas, dll."
                              class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="pt-4 border-t border-border flex items-center justify-end gap-3">
                    <a href="{{ route('admin.internships.placements.index') }}" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:text-navy hover:bg-slate-100 rounded-lg transition min-h-[44px] flex items-center">
                        Batal
                    </a>
                    <button type="submit" class="px-5 py-2.5 text-xs font-semibold text-white bg-brand rounded-lg hover:bg-brand-hover shadow-sm transition min-h-[44px]">
                        Simpan Penempatan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
