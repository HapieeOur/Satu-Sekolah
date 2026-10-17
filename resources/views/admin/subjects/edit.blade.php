<x-app-layout title="Edit Mata Pelajaran">
    <x-slot name="header">
        Edit Mata Pelajaran
    </x-slot>

    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Back Navigation -->
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.subjects.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600 hover:text-indigo-600 transition group">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Daftar Mapel</span>
            </a>
            <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200">
                Mode Edit Kurikulum
            </span>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="p-6 bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white">
                <h2 class="text-lg font-bold">Edit Mata Pelajaran: {{ $subject->name }}</h2>
                <p class="text-xs text-slate-300 mt-1">Perbarui kode mapel, nama kurikulum, deskripsi materi, dan komposisi guru pengampu.</p>
            </div>

            <form method="POST" action="{{ route('admin.subjects.update', $subject) }}" class="p-6 md:p-8 space-y-5 text-xs">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div>
                        <label for="code" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Kode Mapel <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="code" 
                            name="code" 
                            value="{{ old('code', $subject->code) }}" 
                            required
                            class="w-full px-4 py-2.5 text-xs uppercase rounded-xl border @error('code') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-slate-50/50 @enderror focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand font-mono text-slate-800 transition"
                        >
                        @error('code')
                            <p class="text-rose-600 text-[11px] mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="name" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Nama Mata Pelajaran <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name', $subject->name) }}" 
                            required
                            class="w-full px-4 py-2.5 text-xs rounded-xl border @error('name') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-slate-50/50 @enderror focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand text-slate-800 transition"
                        >
                        @error('name')
                            <p class="text-rose-600 text-[11px] mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="description" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Deskripsi / Silabus Singkat
                    </label>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="3"
                        class="w-full px-4 py-2.5 text-xs rounded-xl border @error('description') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-slate-50/50 @enderror focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand text-slate-800 transition leading-relaxed"
                    >{{ old('description', $subject->description) }}</textarea>
                    @error('description')
                        <p class="text-rose-600 text-[11px] mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                @php
                    $currentTeacherIds = old('teacher_ids', $subject->teachers->pluck('id')->toArray());
                @endphp

                <div class="pt-2">
                    <label class="block font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Pilih Guru Pengampu Mata Pelajaran
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 p-4 rounded-xl border border-slate-200 bg-slate-50/50 max-h-56 overflow-y-auto">
                        @forelse ($teachers as $teacher)
                            <label class="flex items-center gap-3 p-2.5 rounded-lg border border-slate-200/60 bg-white hover:border-indigo-300 hover:bg-indigo-50/30 text-slate-700 cursor-pointer transition">
                                <input 
                                    type="checkbox" 
                                    name="teacher_ids[]" 
                                    value="{{ $teacher->id }}"
                                    {{ in_array($teacher->id, $currentTeacherIds) ? 'checked' : '' }}
                                    class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500 border-slate-300"
                                >
                                <div class="truncate">
                                    <div class="font-semibold text-slate-900 truncate">{{ $teacher->user->name ?? 'Guru #'.$teacher->id }}</div>
                                    <div class="text-[11px] font-mono text-slate-400">NIP: {{ $teacher->nip ?? '-' }}</div>
                                </div>
                            </label>
                        @empty
                            <p class="text-slate-400 col-span-2 italic text-center py-4">Belum ada tenaga pengajar terdaftar di sistem.</p>
                        @endforelse
                    </div>
                    @error('teacher_ids')
                        <p class="text-rose-600 text-[11px] mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.subjects.index') }}" class="px-5 py-2.5 border border-slate-200 text-slate-600 hover:bg-slate-50 font-semibold rounded-xl transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-md shadow-indigo-500/20 transition">
                        Perbarui Mata Pelajaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
