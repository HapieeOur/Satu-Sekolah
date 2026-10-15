<x-app-layout title="Edit Kelas">
    <x-slot name="header">
        Edit Kelas
    </x-slot>

    <div class="max-w-2xl bg-surface rounded-xl border border-border shadow-sm p-6">
        <div class="mb-6 pb-4 border-b border-border flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-navy">Edit Kelas: {{ $classroom->name }}</h2>
                <p class="text-xs text-slate-500 mt-0.5">Perbarui informasi rombongan belajar dan penetapan wali kelas.</p>
            </div>
            <a href="{{ route('admin.classrooms.index') }}" class="text-xs font-semibold text-slate-600 hover:text-navy transition">
                &larr; Kembali
            </a>
        </div>

        <form method="POST" action="{{ route('admin.classrooms.update', $classroom) }}" class="space-y-4 text-xs">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block font-semibold text-slate-700 mb-1">Nama Kelas / Rombel <span class="text-danger">*</span></label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name', $classroom->name) }}" 
                    required
                    class="w-full px-3.5 py-2 text-xs rounded-lg border @error('name') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand"
                >
                @error('name')
                    <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="grade_level" class="block font-semibold text-slate-700 mb-1">Tingkat Kelas <span class="text-danger">*</span></label>
                    <select 
                        id="grade_level" 
                        name="grade_level" 
                        required
                        class="w-full px-3.5 py-2 text-xs rounded-lg border @error('grade_level') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand bg-white"
                    >
                        <option value="10" {{ old('grade_level', $classroom->grade_level) == 10 ? 'selected' : '' }}>Kelas 10 (Sepuluh)</option>
                        <option value="11" {{ old('grade_level', $classroom->grade_level) == 11 ? 'selected' : '' }}>Kelas 11 (Sebelas)</option>
                        <option value="12" {{ old('grade_level', $classroom->grade_level) == 12 ? 'selected' : '' }}>Kelas 12 (Dua Belas)</option>
                    </select>
                    @error('grade_level')
                        <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="major" class="block font-semibold text-slate-700 mb-1">Jurusan / Keahlian <span class="text-danger">*</span></label>
                    <input 
                        type="text" 
                        id="major" 
                        name="major" 
                        value="{{ old('major', $classroom->major) }}" 
                        required
                        class="w-full px-3.5 py-2 text-xs rounded-lg border @error('major') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand"
                    >
                    @error('major')
                        <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="academic_year_id" class="block font-semibold text-slate-700 mb-1">Tahun Ajaran <span class="text-danger">*</span></label>
                    <select 
                        id="academic_year_id" 
                        name="academic_year_id" 
                        required
                        class="w-full px-3.5 py-2 text-xs rounded-lg border @error('academic_year_id') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand bg-white"
                    >
                        @foreach ($academicYears as $year)
                            <option value="{{ $year->id }}" {{ old('academic_year_id', $classroom->academic_year_id) == $year->id ? 'selected' : '' }}>
                                {{ $year->name }} ({{ ucfirst($year->semester) }}) {{ $year->is_active ? '[Aktif]' : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('academic_year_id')
                        <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="teacher_id" class="block font-semibold text-slate-700 mb-1">Wali Kelas (Opsional)</label>
                    <select 
                        id="teacher_id" 
                        name="teacher_id" 
                        class="w-full px-3.5 py-2 text-xs rounded-lg border @error('teacher_id') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand bg-white"
                    >
                        <option value="">-- Belum Ditentukan --</option>
                        @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ old('teacher_id', $classroom->teacher_id) == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->user->name ?? 'Guru #'.$teacher->id }} (NIP: {{ $teacher->nip ?? '-' }})
                            </option>
                        @endforeach
                    </select>
                    @error('teacher_id')
                        <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-4 border-t border-border flex items-center justify-end gap-3">
                <a href="{{ route('admin.classrooms.index') }}" class="px-4 py-2 border border-border text-slate-700 hover:bg-slate-50 font-semibold rounded-lg transition">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-brand hover:bg-brand-hover text-white font-semibold rounded-lg shadow-sm transition">
                    Perbarui Data Kelas
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
