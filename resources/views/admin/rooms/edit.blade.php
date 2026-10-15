<x-app-layout title="Edit Ruangan">
    <x-slot name="header">
        Edit Ruangan
    </x-slot>

    <div class="max-w-2xl bg-surface rounded-xl border border-border shadow-sm p-6">
        <div class="mb-6 pb-4 border-b border-border flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-navy">Edit Ruangan: {{ $room->name }}</h2>
                <p class="text-xs text-slate-500 mt-0.5">Perbarui informasi kode ruangan, kapasitas, atau fasilitas.</p>
            </div>
            <a href="{{ route('admin.rooms.index') }}" class="text-xs font-semibold text-slate-600 hover:text-navy transition">
                &larr; Kembali
            </a>
        </div>

        <form method="POST" action="{{ route('admin.rooms.update', $room) }}" class="space-y-4 text-xs">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="code" class="block font-semibold text-slate-700 mb-1">Kode Ruangan <span class="text-danger">*</span></label>
                    <input 
                        type="text" 
                        id="code" 
                        name="code" 
                        value="{{ old('code', $room->code) }}" 
                        required
                        class="w-full px-3.5 py-2 text-xs uppercase rounded-lg border @error('code') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand font-mono"
                    >
                    @error('code')
                        <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="name" class="block font-semibold text-slate-700 mb-1">Nama Ruangan <span class="text-danger">*</span></label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', $room->name) }}" 
                        required
                        class="w-full px-3.5 py-2 text-xs rounded-lg border @error('name') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand"
                    >
                    @error('name')
                        <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="capacity" class="block font-semibold text-slate-700 mb-1">Kapasitas (Jumlah Orang) <span class="text-danger">*</span></label>
                <input 
                    type="number" 
                    id="capacity" 
                    name="capacity" 
                    value="{{ old('capacity', $room->capacity) }}" 
                    min="1" 
                    max="200" 
                    required
                    class="w-full sm:w-48 px-3.5 py-2 text-xs rounded-lg border @error('capacity') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand"
                >
                @error('capacity')
                    <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block font-semibold text-slate-700 mb-1">Keterangan / Fasilitas Ruangan</label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="3"
                    class="w-full px-3.5 py-2 text-xs rounded-lg border @error('description') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand"
                >{{ old('description', $room->description) }}</textarea>
                @error('description')
                    <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 border-t border-border flex items-center justify-end gap-3">
                <a href="{{ route('admin.rooms.index') }}" class="px-4 py-2 border border-border text-slate-700 hover:bg-slate-50 font-semibold rounded-lg transition">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-brand hover:bg-brand-hover text-white font-semibold rounded-lg shadow-sm transition">
                    Perbarui Ruangan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
