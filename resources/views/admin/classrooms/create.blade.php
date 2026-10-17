<x-app-layout title="Tambah Rombel Kelas Baru">
    <x-slot name="header">
        Tambah Rombel Baru
    </x-slot>

    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Top Nav / Back -->
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.classrooms.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600 hover:text-indigo-600 transition group">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Daftar Kelas</span>
            </a>
            <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200">
                Form Penambahan Kelas
            </span>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="p-6 bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white">
                <h2 class="text-lg font-bold">Tambah Rombel / Kelas Baru</h2>
                <p class="text-xs text-slate-300 mt-1">Tentukan nama rombel, tingkat kelas, kompetensi keahlian, dan tetapkan guru sebagai wali kelas.</p>
            </div>

            <form method="POST" action="{{ route('admin.classrooms.store') }}" class="p-6 md:p-8 space-y-5 text-xs">
                @csrf

                <div>
                    <label for="name" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Nama Kelas / Rombel <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}" 
                        placeholder="Contoh: XII RPL 1 atau X TKJ 2" 
                        required
                        class="w-full px-4 py-2.5 text-xs rounded-xl border @error('name') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-slate-50/50 @enderror focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand text-slate-800 transition"
                    >
                    @error('name')
                        <p class="text-rose-600 text-[11px] mt-1.5 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="grade_level" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Tingkat Kelas <span class="text-rose-500">*</span>
                        </label>
                        <select 
                            id="grade_level" 
                            name="grade_level" 
                            required
                            class="w-full px-4 py-2.5 text-xs rounded-xl border @error('grade_level') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-slate-50/50 @enderror focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand text-slate-800 transition"
                        >
                            <option value="">Pilih Tingkat</option>
                            <option value="10" {{ old('grade_level') == '10' ? 'selected' : '' }}>Kelas 10 (Sepuluh)</option>
                            <option value="11" {{ old('grade_level') == '11' ? 'selected' : '' }}>Kelas 11 (Sebelas)</option>
                            <option value="12" {{ old('grade_level') == '12' ? 'selected' : '' }}>Kelas 12 (Dua Belas)</option>
                        </select>
                        @error('grade_level')
                            <p class="text-rose-600 text-[11px] mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="major" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Kompetensi Keahlian / Jurusan <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="major" 
                            name="major" 
                            value="{{ old('major') }}" 
                            placeholder="Contoh: Rekayasa Perangkat Lunak" 
                            required
                            class="w-full px-4 py-2.5 text-xs rounded-xl border @error('major') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-slate-50/50 @enderror focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand text-slate-800 transition"
                        >
                        @error('major')
                            <p class="text-rose-600 text-[11px] mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="academic_year_id" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Tahun Ajaran Aktif <span class="text-rose-500">*</span>
                        </label>
                        <select 
                            id="academic_year_id" 
                            name="academic_year_id" 
                            required
                            class="w-full px-4 py-2.5 text-xs rounded-xl border @error('academic_year_id') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-slate-50/50 @enderror focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand text-slate-800 transition"
                        >
                            <option value="">Pilih Tahun Ajaran</option>
                            @foreach ($academicYears as $year)
                                <option value="{{ $year->id }}" {{ old('academic_year_id') == $year->id || ($year->is_active && !old('academic_year_id')) ? 'selected' : '' }}>
                                    {{ $year->name }} ({{ ucfirst($year->semester) }}) {{ $year->is_active ? '★ [Aktif]' : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('academic_year_id')
                            <p class="text-rose-600 text-[11px] mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="teacher_id" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Wali Kelas (Opsional)
                        </label>
                        <select 
                            id="teacher_id" 
                            name="teacher_id" 
                            class="w-full px-4 py-2.5 text-xs rounded-xl border @error('teacher_id') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-slate-50/50 @enderror focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand text-slate-800 transition"
                        >
                            <option value="">-- Belum Ditentukan --</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->user->name ?? 'Guru #'.$teacher->id }} (NIP: {{ $teacher->nip ?? '-' }})
                                </option>
                            @endforeach
                        </select>
                        @error('teacher_id')
                            <p class="text-rose-600 text-[11px] mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.classrooms.index') }}" class="px-5 py-2.5 border border-slate-200 text-slate-600 hover:bg-slate-50 font-semibold rounded-xl transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-md shadow-indigo-500/20 transition">
                        Simpan Data Kelas
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
