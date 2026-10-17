<x-app-layout title="Edit Ruangan">
    <x-slot name="header">
        Edit Ruangan
    </x-slot>

    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Back Navigation -->
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.rooms.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600 hover:text-indigo-600 transition group">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Daftar Ruangan</span>
            </a>
            <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200">
                Mode Edit Ruangan
            </span>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="p-6 bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white">
                <h2 class="text-lg font-bold">Edit Ruangan: {{ $room->name }}</h2>
                <p class="text-xs text-slate-300 mt-1">Perbarui kode identifikasi ruangan, kapasitas siswa, atau fasilitas penunjang KBM.</p>
            </div>

            <form method="POST" action="{{ route('admin.rooms.update', $room) }}" class="p-6 md:p-8 space-y-5 text-xs">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div>
                        <label for="code" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Kode Ruangan <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="code" 
                            name="code" 
                            value="{{ old('code', $room->code) }}" 
                            required
                            class="w-full px-4 py-2.5 text-xs uppercase rounded-xl border @error('code') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-slate-50/50 @enderror focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand font-mono text-slate-800 transition"
                        >
                        @error('code')
                            <p class="text-rose-600 text-[11px] mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="name" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Nama Ruangan <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name', $room->name) }}" 
                            required
                            class="w-full px-4 py-2.5 text-xs rounded-xl border @error('name') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-slate-50/50 @enderror focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand text-slate-800 transition"
                        >
                        @error('name')
                            <p class="text-rose-600 text-[11px] mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="capacity" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Kapasitas Kursi (Siswa) <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        id="capacity" 
                        name="capacity" 
                        value="{{ old('capacity', $room->capacity) }}" 
                        min="1" 
                        max="200" 
                        required
                        class="w-full sm:w-48 px-4 py-2.5 text-xs rounded-xl border @error('capacity') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-slate-50/50 @enderror focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand font-mono text-slate-800 transition"
                    >
                    @error('capacity')
                        <p class="text-rose-600 text-[11px] mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Keterangan / Fasilitas Sarana Prasarana
                    </label>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="3"
                        class="w-full px-4 py-2.5 text-xs rounded-xl border @error('description') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-slate-50/50 @enderror focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand text-slate-800 transition leading-relaxed"
                    >{{ old('description', $room->description) }}</textarea>
                    @error('description')
                        <p class="text-rose-600 text-[11px] mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.rooms.index') }}" class="px-5 py-2.5 border border-slate-200 text-slate-600 hover:bg-slate-50 font-semibold rounded-xl transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-md shadow-indigo-500/20 transition">
                        Perbarui Ruangan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
