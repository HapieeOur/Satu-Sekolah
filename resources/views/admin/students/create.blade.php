<x-app-layout title="Tambah Siswa Baru">
    <x-slot name="header">
        Administrasi: Tambah Siswa Baru
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.students.index') }}" 
                   class="w-10 h-10 rounded-xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-center text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition"
                   title="Kembali ke Daftar Siswa">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <div>
                    <h1 class="text-xl font-bold text-slate-900">Tambah Data Siswa Baru</h1>
                    <p class="text-xs text-slate-500 mt-0.5">Lengkapi identitas akademik, data rombel kelas, serta informasi kontak wali</p>
                </div>
            </div>
            <a href="{{ route('admin.students.index') }}" class="text-xs font-semibold text-slate-500 hover:text-indigo-600 transition hidden sm:inline-block">
                &larr; Kembali ke Daftar Siswa
            </a>
        </div>

        <!-- Main Form Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 md:p-8">
            <form method="POST" action="{{ route('admin.students.store') }}" class="space-y-6">
                @csrf

                <!-- Section 1: Identitas Pokok & Akademik -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                        <div class="w-6 h-6 rounded-md bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs font-bold">1</div>
                        <h2 class="text-xs font-bold uppercase tracking-wider text-slate-800">Identitas Pokok & Akademik</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="nis" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                NIS (Nomor Induk Siswa) <span class="text-rose-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="nis" 
                                name="nis" 
                                value="{{ old('nis') }}" 
                                placeholder="Contoh: 20241001" 
                                required
                                class="w-full px-3.5 py-2.5 text-xs rounded-xl border @error('nis') border-rose-400 bg-rose-50/30 text-rose-900 @else border-slate-200 bg-white text-slate-800 @enderror focus:ring-2 focus:ring-indigo-100 focus:border-indigo-600 font-mono transition"
                            >
                            @error('nis')
                                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nisn" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                NISN (Nomor Induk Siswa Nasional)
                            </label>
                            <input 
                                type="text" 
                                id="nisn" 
                                name="nisn" 
                                value="{{ old('nisn') }}" 
                                placeholder="Contoh: 0071234567" 
                                class="w-full px-3.5 py-2.5 text-xs rounded-xl border @error('nisn') border-rose-400 bg-rose-50/30 text-rose-900 @else border-slate-200 bg-white text-slate-800 @enderror focus:ring-2 focus:ring-indigo-100 focus:border-indigo-600 font-mono transition"
                            >
                            @error('nisn')
                                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="sm:col-span-2">
                            <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Nama Lengkap Siswa <span class="text-rose-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                value="{{ old('name') }}" 
                                placeholder="Nama lengkap sesuai akta / ijazah sebelumnya" 
                                required
                                class="w-full px-3.5 py-2.5 text-xs rounded-xl border @error('name') border-rose-400 bg-rose-50/30 text-rose-900 @else border-slate-200 bg-white text-slate-800 @enderror focus:ring-2 focus:ring-indigo-100 focus:border-indigo-600 transition"
                            >
                            @error('name')
                                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="gender" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Jenis Kelamin <span class="text-rose-500">*</span>
                            </label>
                            <select 
                                id="gender" 
                                name="gender" 
                                required
                                class="w-full px-3.5 py-2.5 text-xs rounded-xl border @error('gender') border-rose-400 bg-rose-50/30 text-rose-900 @else border-slate-200 bg-white text-slate-800 @enderror focus:ring-2 focus:ring-indigo-100 focus:border-indigo-600 transition"
                            >
                                <option value="L" {{ old('gender', 'L') === 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                                <option value="P" {{ old('gender') === 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                            </select>
                            @error('gender')
                                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 2: Penempatan & Keaktifan -->
                <div class="space-y-4 pt-4 border-t border-slate-100">
                    <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                        <div class="w-6 h-6 rounded-md bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs font-bold">2</div>
                        <h2 class="text-xs font-bold uppercase tracking-wider text-slate-800">Rombongan Belajar & Status</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="classroom_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Kelas / Rombel
                            </label>
                            <select 
                                id="classroom_id" 
                                name="classroom_id" 
                                class="w-full px-3.5 py-2.5 text-xs rounded-xl border @error('classroom_id') border-rose-400 bg-rose-50/30 text-rose-900 @else border-slate-200 bg-white text-slate-800 @enderror focus:ring-2 focus:ring-indigo-100 focus:border-indigo-600 transition"
                            >
                                <option value="">-- Belum Ditentukan / Bebas Rombel --</option>
                                @foreach ($classrooms as $cls)
                                    <option value="{{ $cls->id }}" {{ old('classroom_id') == $cls->id ? 'selected' : '' }}>
                                        {{ $cls->name }} (Kelas {{ $cls->grade_level }} - {{ $cls->major }})
                                    </option>
                                @endforeach
                            </select>
                            @error('classroom_id')
                                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="status" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Status Keaktifan Siswa <span class="text-rose-500">*</span>
                            </label>
                            <select 
                                id="status" 
                                name="status" 
                                required
                                class="w-full px-3.5 py-2.5 text-xs rounded-xl border @error('status') border-rose-400 bg-rose-50/30 text-rose-900 @else border-slate-200 bg-white text-slate-800 @enderror focus:ring-2 focus:ring-indigo-100 focus:border-indigo-600 transition"
                            >
                                <option value="aktif" {{ old('status', 'aktif') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="alumni" {{ old('status') === 'alumni' ? 'selected' : '' }}>Alumni / Lulus</option>
                                <option value="pindah" {{ old('status') === 'pindah' ? 'selected' : '' }}>Pindah Sekolah</option>
                                <option value="keluar" {{ old('status') === 'keluar' ? 'selected' : '' }}>Keluar / DO</option>
                            </select>
                            @error('status')
                                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 3: Kontak & Informasi Keluarga -->
                <div class="space-y-4 pt-4 border-t border-slate-100">
                    <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                        <div class="w-6 h-6 rounded-md bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs font-bold">3</div>
                        <h2 class="text-xs font-bold uppercase tracking-wider text-slate-800">Kontak & Informasi Orang Tua</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                No. Telepon / WhatsApp Siswa
                            </label>
                            <input 
                                type="text" 
                                id="phone" 
                                name="phone" 
                                value="{{ old('phone') }}" 
                                placeholder="Contoh: 08123456789" 
                                class="w-full px-3.5 py-2.5 text-xs rounded-xl border @error('phone') border-rose-400 bg-rose-50/30 text-rose-900 @else border-slate-200 bg-white text-slate-800 @enderror focus:ring-2 focus:ring-indigo-100 focus:border-indigo-600 font-mono transition"
                            >
                            @error('phone')
                                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="parent_name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Nama Orang Tua / Wali
                            </label>
                            <input 
                                type="text" 
                                id="parent_name" 
                                name="parent_name" 
                                value="{{ old('parent_name') }}" 
                                placeholder="Nama ayah / ibu / wali murid" 
                                class="w-full px-3.5 py-2.5 text-xs rounded-xl border @error('parent_name') border-rose-400 bg-rose-50/30 text-rose-900 @else border-slate-200 bg-white text-slate-800 @enderror focus:ring-2 focus:ring-indigo-100 focus:border-indigo-600 transition"
                            >
                            @error('parent_name')
                                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="parent_phone" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                No. Telepon Orang Tua / Wali
                            </label>
                            <input 
                                type="text" 
                                id="parent_phone" 
                                name="parent_phone" 
                                value="{{ old('parent_phone') }}" 
                                placeholder="Contoh: 08129876543" 
                                class="w-full px-3.5 py-2.5 text-xs rounded-xl border @error('parent_phone') border-rose-400 bg-rose-50/30 text-rose-900 @else border-slate-200 bg-white text-slate-800 @enderror focus:ring-2 focus:ring-indigo-100 focus:border-indigo-600 font-mono transition"
                            >
                            @error('parent_phone')
                                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="address" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Alamat Tempat Tinggal
                            </label>
                            <input 
                                type="text" 
                                id="address" 
                                name="address" 
                                value="{{ old('address') }}" 
                                placeholder="Alamat lengkap tempat tinggal siswa saat ini" 
                                class="w-full px-3.5 py-2.5 text-xs rounded-xl border @error('address') border-rose-400 bg-rose-50/30 text-rose-900 @else border-slate-200 bg-white text-slate-800 @enderror focus:ring-2 focus:ring-indigo-100 focus:border-indigo-600 transition"
                            >
                            @error('address')
                                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit / Cancel Actions -->
                <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.students.index') }}" class="px-5 py-2.5 border border-slate-200 text-slate-600 hover:bg-slate-50 font-semibold text-xs rounded-xl transition">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs rounded-xl shadow-md shadow-indigo-600/20 hover:shadow-indigo-600/30 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Simpan Data Siswa</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
