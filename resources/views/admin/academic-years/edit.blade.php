<x-app-layout title="Edit Tahun Ajaran">
    <x-slot name="header">
        Edit Tahun Ajaran
    </x-slot>

    <div class="max-w-2xl bg-surface rounded-xl border border-border shadow-sm p-6">
        <div class="mb-6 pb-4 border-b border-border flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-navy">Edit Tahun Ajaran: {{ $academicYear->name }}</h2>
                <p class="text-xs text-slate-500 mt-0.5">Perbarui data periode tahun ajaran.</p>
            </div>
            <a href="{{ route('admin.academic-years.index') }}" class="text-xs font-semibold text-slate-600 hover:text-navy transition">
                &larr; Kembali
            </a>
        </div>

        <form method="POST" action="{{ route('admin.academic-years.update', $academicYear) }}" class="space-y-4 text-xs">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block font-semibold text-slate-700 mb-1">Nama Tahun Ajaran <span class="text-danger">*</span></label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name', $academicYear->name) }}" 
                    required
                    class="w-full px-3.5 py-2 text-xs rounded-lg border @error('name') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand"
                >
                @error('name')
                    <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="semester" class="block font-semibold text-slate-700 mb-1">Semester <span class="text-danger">*</span></label>
                <select 
                    id="semester" 
                    name="semester" 
                    required
                    class="w-full px-3.5 py-2 text-xs rounded-lg border @error('semester') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand bg-white"
                >
                    <option value="ganjil" {{ old('semester', $academicYear->semester) === 'ganjil' ? 'selected' : '' }}>Ganjil (1)</option>
                    <option value="genap" {{ old('semester', $academicYear->semester) === 'genap' ? 'selected' : '' }}>Genap (2)</option>
                </select>
                @error('semester')
                    <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="start_date" class="block font-semibold text-slate-700 mb-1">Tanggal Mulai <span class="text-danger">*</span></label>
                    <input 
                        type="date" 
                        id="start_date" 
                        name="start_date" 
                        value="{{ old('start_date', $academicYear->start_date ? \Carbon\Carbon::parse($academicYear->start_date)->format('Y-m-d') : '') }}" 
                        required
                        class="w-full px-3.5 py-2 text-xs rounded-lg border @error('start_date') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand"
                    >
                    @error('start_date')
                        <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="end_date" class="block font-semibold text-slate-700 mb-1">Tanggal Selesai <span class="text-danger">*</span></label>
                    <input 
                        type="date" 
                        id="end_date" 
                        name="end_date" 
                        value="{{ old('end_date', $academicYear->end_date ? \Carbon\Carbon::parse($academicYear->end_date)->format('Y-m-d') : '') }}" 
                        required
                        class="w-full px-3.5 py-2 text-xs rounded-lg border @error('end_date') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand"
                    >
                    @error('end_date')
                        <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-2">
                <label class="inline-flex items-center gap-2 cursor-pointer">
                    <input 
                        type="checkbox" 
                        name="is_active" 
                        value="1" 
                        {{ old('is_active', $academicYear->is_active) ? 'checked' : '' }}
                        class="w-4 h-4 rounded text-brand focus:ring-brand border-border"
                    >
                    <span class="font-medium text-slate-700">Jadikan sebagai tahun ajaran aktif</span>
                </label>
            </div>

            <div class="pt-4 border-t border-border flex items-center justify-end gap-3">
                <a href="{{ route('admin.academic-years.index') }}" class="px-4 py-2 border border-border text-slate-700 hover:bg-slate-50 font-semibold rounded-lg transition">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-brand hover:bg-brand-hover text-white font-semibold rounded-lg shadow-sm transition">
                    Perbarui Tahun Ajaran
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
