<x-app-layout title="Edit Penempatan PKL">
    <x-slot name="header">
        Penempatan PKL: Edit
    </x-slot>

    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Back Navigation -->
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.internships.placements.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600 hover:text-indigo-600 transition group">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Daftar Penempatan</span>
            </a>
            <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200">
                Mode Edit Penempatan
            </span>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="p-6 bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white">
                <h2 class="text-lg font-bold">Edit Penempatan: {{ $placement->student->name }}</h2>
                <p class="text-xs text-slate-300 mt-1">Perbarui mitra industri, guru pembimbing, status kelulusan, atau rentang waktu magang.</p>
            </div>

            <form method="POST" action="{{ route('admin.internships.placements.update', $placement->id) }}" class="p-6 md:p-8 space-y-5 text-xs">
                @csrf
                @method('PUT')

                <!-- Tahun Ajaran & Status -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="academic_year_id" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Tahun Ajaran <span class="text-rose-500">*</span>
                        </label>
                        <select name="academic_year_id" id="academic_year_id" required class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800 transition">
                            @foreach ($academicYears as $year)
                                <option value="{{ $year->id }}" {{ old('academic_year_id', $placement->academic_year_id) == $year->id ? 'selected' : '' }}>
                                    {{ $year->label }} {{ $year->is_active ? '★ (Aktif)' : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('academic_year_id')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Status Penempatan <span class="text-rose-500">*</span>
                        </label>
                        <select name="status" id="status" required class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800 transition">
                            @foreach ($statuses as $st)
                                <option value="{{ $st->value }}" {{ old('status', $placement->status->value) == $st->value ? 'selected' : '' }}>
                                    {{ $st->label() }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Siswa -->
                <div>
                    <label for="student_id" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Siswa Terpilih <span class="text-rose-500">*</span>
                    </label>
                    <select name="student_id" id="student_id" required class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800 transition">
                        <option value="{{ $placement->student_id }}">
                            {{ $placement->student->name }} (NIS: {{ $placement->student->nis }}) — Kelas {{ $placement->student->classroom?->name ?? '-' }}
                        </option>
                        @foreach ($students as $stu)
                            @if ($stu->id !== $placement->student_id)
                                <option value="{{ $stu->id }}" {{ old('student_id') == $stu->id ? 'selected' : '' }}>
                                    {{ $stu->name }} (NIS: {{ $stu->nis }}) — Kelas {{ $stu->classroom?->name ?? 'Tanpa Kelas' }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                    @error('student_id')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mitra DUDI & Departemen -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="internship_company_id" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Mitra Industri (DUDI) <span class="text-rose-500">*</span>
                        </label>
                        <select name="internship_company_id" id="internship_company_id" required class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800 transition">
                            @foreach ($companies as $comp)
                                <option value="{{ $comp->id }}" {{ old('internship_company_id', $placement->internship_company_id) == $comp->id ? 'selected' : '' }}>
                                    {{ $comp->name }} (Radius {{ $comp->radius_meters }}m)
                                </option>
                            @endforeach
                        </select>
                        @error('internship_company_id')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="department" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Departemen / Divisi
                        </label>
                        <input type="text" name="department" id="department" value="{{ old('department', $placement->department) }}" placeholder="Contoh: IT Support / Web Development"
                               class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800 transition">
                        @error('department')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Guru Pembimbing PKL -->
                <div>
                    <label for="teacher_id" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Guru Pembimbing PKL <span class="text-rose-500">*</span>
                    </label>
                    <select name="teacher_id" id="teacher_id" required class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800 transition">
                        @foreach ($teachers as $tch)
                            <option value="{{ $tch->id }}" {{ old('teacher_id', $placement->teacher_id) == $tch->id ? 'selected' : '' }}>
                                {{ $tch->user->name }} {{ $tch->nip ? '(NIP: ' . $tch->nip . ')' : '(' . $tch->user->email . ')' }}
                            </option>
                        @endforeach
                    </select>
                    @error('teacher_id')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rentang Waktu PKL -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="start_date" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Tanggal Mulai PKL <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $placement->start_date->toDateString()) }}" required
                               class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800 transition font-mono">
                        @error('start_date')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_date" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Tanggal Selesai PKL <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $placement->end_date->toDateString()) }}" required
                               class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800 transition font-mono">
                        @error('end_date')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Catatan Tambahan -->
                <div>
                    <label for="notes" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Catatan Tambahan
                    </label>
                    <textarea name="notes" id="notes" rows="3"
                              class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800 transition leading-relaxed">{{ old('notes', $placement->notes) }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.internships.placements.index') }}" class="px-5 py-2.5 border border-slate-200 text-slate-600 hover:bg-slate-50 font-semibold rounded-xl transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-md shadow-indigo-500/20 transition">
                        Perbarui Penempatan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
