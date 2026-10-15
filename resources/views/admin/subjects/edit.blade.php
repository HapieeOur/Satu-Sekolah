<x-app-layout title="Edit Mata Pelajaran">
    <x-slot name="header">
        Edit Mata Pelajaran
    </x-slot>

    <div class="max-w-2xl bg-surface rounded-xl border border-border shadow-sm p-6">
        <div class="mb-6 pb-4 border-b border-border flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-navy">Edit Mata Pelajaran: {{ $subject->name }}</h2>
                <p class="text-xs text-slate-500 mt-0.5">Perbarui informasi kurikulum mapel dan tim guru pengampu.</p>
            </div>
            <a href="{{ route('admin.subjects.index') }}" class="text-xs font-semibold text-slate-600 hover:text-navy transition">
                &larr; Kembali
            </a>
        </div>

        <form method="POST" action="{{ route('admin.subjects.update', $subject) }}" class="space-y-4 text-xs">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="code" class="block font-semibold text-slate-700 mb-1">Kode Mapel <span class="text-danger">*</span></label>
                    <input 
                        type="text" 
                        id="code" 
                        name="code" 
                        value="{{ old('code', $subject->code) }}" 
                        required
                        class="w-full px-3.5 py-2 text-xs uppercase rounded-lg border @error('code') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand font-mono"
                    >
                    @error('code')
                        <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="name" class="block font-semibold text-slate-700 mb-1">Nama Mata Pelajaran <span class="text-danger">*</span></label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', $subject->name) }}" 
                        required
                        class="w-full px-3.5 py-2 text-xs rounded-lg border @error('name') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand"
                    >
                    @error('name')
                        <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="description" class="block font-semibold text-slate-700 mb-1">Deskripsi / Silabus Singkat</label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="3"
                    class="w-full px-3.5 py-2 text-xs rounded-lg border @error('description') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand"
                >{{ old('description', $subject->description) }}</textarea>
                @error('description')
                    <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            @php
                $currentTeacherIds = old('teacher_ids', $subject->teachers->pluck('id')->toArray());
            @endphp

            <div class="pt-2">
                <label class="block font-semibold text-slate-700 mb-2">Pilih Guru Pengampu</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 p-3 rounded-lg border border-border bg-slate-50/50 max-h-48 overflow-y-auto">
                    @forelse ($teachers as $teacher)
                        <label class="flex items-center gap-2 p-1.5 rounded hover:bg-white text-slate-700 cursor-pointer">
                            <input 
                                type="checkbox" 
                                name="teacher_ids[]" 
                                value="{{ $teacher->id }}"
                                {{ in_array($teacher->id, $currentTeacherIds) ? 'checked' : '' }}
                                class="w-4 h-4 rounded text-brand focus:ring-brand border-border"
                            >
                            <span class="truncate">
                                <span class="font-semibold text-slate-900">{{ $teacher->user->name ?? 'Guru #'.$teacher->id }}</span>
                                <span class="text-[11px] text-slate-400">({{ $teacher->nip ?? 'Tanpa NIP' }})</span>
                            </span>
                        </label>
                    @empty
                        <p class="text-slate-400 col-span-2 italic">Belum ada guru terdaftar di sistem.</p>
                    @endforelse
                </div>
                @error('teacher_ids')
                    <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 border-t border-border flex items-center justify-end gap-3">
                <a href="{{ route('admin.subjects.index') }}" class="px-4 py-2 border border-border text-slate-700 hover:bg-slate-50 font-semibold rounded-lg transition">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-brand hover:bg-brand-hover text-white font-semibold rounded-lg shadow-sm transition">
                    Perbarui Mata Pelajaran
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
