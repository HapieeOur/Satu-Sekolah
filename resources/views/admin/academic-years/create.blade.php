<x-app-layout title="Tambah Tahun Ajaran Baru">
    <x-slot name="header">
        Tambah Tahun Ajaran
    </x-slot>

    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Back Navigation -->
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.academic-years.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600 hover:text-indigo-600 transition group">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Daftar Tahun Ajaran</span>
            </a>
            <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200">
                Periode Akademik Baru
            </span>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="p-6 bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white">
                <h2 class="text-lg font-bold">Definisi Tahun Ajaran Baru</h2>
                <p class="text-xs text-slate-300 mt-1">Lengkapi nama tahun ajaran, semester ganjil/genap, dan rentang tanggal efektif kalender sekolah.</p>
            </div>

            <form method="POST" action="{{ route('admin.academic-years.store') }}" class="p-6 md:p-8 space-y-5 text-xs">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="name" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Nama Tahun Ajaran <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name') }}" 
                            placeholder="Contoh: 2026/2027" 
                            required
                            class="w-full px-4 py-2.5 text-xs rounded-xl border @error('name') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-slate-50/50 @enderror focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand text-slate-800 transition"
                        >
                        @error('name')
                            <p class="text-rose-600 text-[11px] mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="semester" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Semester <span class="text-rose-500">*</span>
                        </label>
                        <select 
                            id="semester" 
                            name="semester" 
                            required
                            class="w-full px-4 py-2.5 text-xs rounded-xl border @error('semester') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-slate-50/50 @enderror focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand text-slate-800 transition"
                        >
                            <option value="">Pilih Semester</option>
                            <option value="ganjil" {{ old('semester') === 'ganjil' ? 'selected' : '' }}>Semester Ganjil (1)</option>
                            <option value="genap" {{ old('semester') === 'genap' ? 'selected' : '' }}>Semester Genap (2)</option>
                        </select>
                        @error('semester')
                            <p class="text-rose-600 text-[11px] mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="start_date" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Tanggal Mulai KBM <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="date" 
                            id="start_date" 
                            name="start_date" 
                            value="{{ old('start_date') }}" 
                            required
                            class="w-full px-4 py-2.5 text-xs rounded-xl border @error('start_date') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-slate-50/50 @enderror focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand text-slate-800 transition font-mono"
                        >
                        @error('start_date')
                            <p class="text-rose-600 text-[11px] mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="end_date" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Tanggal Selesai KBM <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="date" 
                            id="end_date" 
                            name="end_date" 
                            value="{{ old('end_date') }}" 
                            required
                            class="w-full px-4 py-2.5 text-xs rounded-xl border @error('end_date') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-slate-50/50 @enderror focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand text-slate-800 transition font-mono"
                        >
                        @error('end_date')
                            <p class="text-rose-600 text-[11px] mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/60">
                    <label class="inline-flex items-center gap-3 cursor-pointer">
                        <input 
                            type="checkbox" 
                            name="is_active" 
                            value="1" 
                            {{ old('is_active') ? 'checked' : '' }}
                            class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500 border-slate-300"
                        >
                        <div>
                            <span class="font-bold text-slate-800 text-xs">Jadikan sebagai tahun ajaran aktif</span>
                            <p class="text-[11px] text-slate-500 mt-0.5">Tahun ajaran yang sedang aktif akan otomatis dinonaktifkan dan digantikan oleh periode ini.</p>
                        </div>
                    </label>
                </div>

                <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.academic-years.index') }}" class="px-5 py-2.5 border border-slate-200 text-slate-600 hover:bg-slate-50 font-semibold rounded-xl transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-md shadow-indigo-500/20 transition">
                        Simpan Tahun Ajaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
