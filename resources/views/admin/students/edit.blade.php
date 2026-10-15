<x-app-layout title="Edit Siswa">
    <x-slot name="header">
        Edit Siswa
    </x-slot>

    <div class="max-w-3xl bg-surface rounded-xl border border-border shadow-sm p-6">
        <div class="mb-6 pb-4 border-b border-border flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-navy">Edit Data Siswa: {{ $student->name }}</h2>
                <p class="text-xs text-slate-500 mt-0.5">Perbarui profil siswa, penetapan rombel kelas, atau status keaktifan.</p>
            </div>
            <a href="{{ route('admin.students.index') }}" class="text-xs font-semibold text-slate-600 hover:text-navy transition">
                &larr; Kembali
            </a>
        </div>

        <form method="POST" action="{{ route('admin.students.update', $student) }}" class="space-y-4 text-xs">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="nis" class="block font-semibold text-slate-700 mb-1">NIS (Nomor Induk Siswa) <span class="text-danger">*</span></label>
                    <input 
                        type="text" 
                        id="nis" 
                        name="nis" 
                        value="{{ old('nis', $student->nis) }}" 
                        required
                        class="w-full px-3.5 py-2 text-xs rounded-lg border @error('nis') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand"
                    >
                    @error('nis')
                        <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nisn" class="block font-semibold text-slate-700 mb-1">NISN (Nomor Induk Siswa Nasional)</label>
                    <input 
                        type="text" 
                        id="nisn" 
                        name="nisn" 
                        value="{{ old('nisn', $student->nisn) }}" 
                        class="w-full px-3.5 py-2 text-xs rounded-lg border @error('nisn') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand"
                    >
                    @error('nisn')
                        <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <label for="name" class="block font-semibold text-slate-700 mb-1">Nama Lengkap Siswa <span class="text-danger">*</span></label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', $student->name) }}" 
                        required
                        class="w-full px-3.5 py-2 text-xs rounded-lg border @error('name') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand"
                    >
                    @error('name')
                        <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="gender" class="block font-semibold text-slate-700 mb-1">Jenis Kelamin <span class="text-danger">*</span></label>
                    <select 
                        id="gender" 
                        name="gender" 
                        required
                        class="w-full px-3.5 py-2 text-xs rounded-lg border @error('gender') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand bg-white"
                    >
                        <option value="L" {{ old('gender', $student->gender) === 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                        <option value="P" {{ old('gender', $student->gender) === 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                    </select>
                    @error('gender')
                        <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="classroom_id" class="block font-semibold text-slate-700 mb-1">Kelas / Rombel</label>
                    <select 
                        id="classroom_id" 
                        name="classroom_id" 
                        class="w-full px-3.5 py-2 text-xs rounded-lg border @error('classroom_id') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand bg-white"
                    >
                        <option value="">-- Belum Ditentukan --</option>
                        @foreach ($classrooms as $cls)
                            <option value="{{ $cls->id }}" {{ old('classroom_id', $student->classroom_id) == $cls->id ? 'selected' : '' }}>
                                {{ $cls->name }} (Kelas {{ $cls->grade_level }} - {{ $cls->major }})
                            </option>
                        @endforeach
                    </select>
                    @error('classroom_id')
                        <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block font-semibold text-slate-700 mb-1">Status Keaktifan <span class="text-danger">*</span></label>
                    <select 
                        id="status" 
                        name="status" 
                        required
                        class="w-full px-3.5 py-2 text-xs rounded-lg border @error('status') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand bg-white"
                    >
                        <option value="aktif" {{ old('status', $student->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="alumni" {{ old('status', $student->status) === 'alumni' ? 'selected' : '' }}>Alumni / Lulus</option>
                        <option value="pindah" {{ old('status', $student->status) === 'pindah' ? 'selected' : '' }}>Pindah</option>
                        <option value="keluar" {{ old('status', $student->status) === 'keluar' ? 'selected' : '' }}>Keluar / DO</option>
                    </select>
                    @error('status')
                        <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="phone" class="block font-semibold text-slate-700 mb-1">No. Telepon Siswa</label>
                    <input 
                        type="text" 
                        id="phone" 
                        name="phone" 
                        value="{{ old('phone', $student->phone) }}" 
                        class="w-full px-3.5 py-2 text-xs rounded-lg border @error('phone') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand"
                    >
                    @error('phone')
                        <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="parent_name" class="block font-semibold text-slate-700 mb-1">Nama Orang Tua / Wali</label>
                    <input 
                        type="text" 
                        id="parent_name" 
                        name="parent_name" 
                        value="{{ old('parent_name', $student->parent_name) }}" 
                        class="w-full px-3.5 py-2 text-xs rounded-lg border @error('parent_name') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand"
                    >
                    @error('parent_name')
                        <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="parent_phone" class="block font-semibold text-slate-700 mb-1">No. Telepon Orang Tua</label>
                    <input 
                        type="text" 
                        id="parent_phone" 
                        name="parent_phone" 
                        value="{{ old('parent_phone', $student->parent_phone) }}" 
                        class="w-full px-3.5 py-2 text-xs rounded-lg border @error('parent_phone') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand"
                    >
                    @error('parent_phone')
                        <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="address" class="block font-semibold text-slate-700 mb-1">Alamat Rumah</label>
                    <input 
                        type="text" 
                        id="address" 
                        name="address" 
                        value="{{ old('address', $student->address) }}" 
                        class="w-full px-3.5 py-2 text-xs rounded-lg border @error('address') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand"
                    >
                    @error('address')
                        <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-4 border-t border-border flex items-center justify-end gap-3">
                <a href="{{ route('admin.students.index') }}" class="px-4 py-2 border border-border text-slate-700 hover:bg-slate-50 font-semibold rounded-lg transition">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-brand hover:bg-brand-hover text-white font-semibold rounded-lg shadow-sm transition">
                    Perbarui Data Siswa
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
