<x-app-layout title="Edit Pengguna">
    <x-slot name="header">
        Edit Pengguna
    </x-slot>

    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Back Navigation -->
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600 hover:text-indigo-600 transition group">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Daftar Pengguna</span>
            </a>
            <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200">
                Mode Edit Akun
            </span>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="p-6 bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white">
                <h2 class="text-lg font-bold">Perbarui Akun: {{ $user->name }}</h2>
                <p class="text-xs text-slate-300 mt-1">Ubah nama profil, email akun, nomor kontak, kata sandi, peran hak akses, atau status keaktifan.</p>
            </div>

            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="p-6 md:p-8 space-y-5 text-xs">
                @csrf
                @method('PUT')

                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Nama Lengkap & Gelar <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', $user->name) }}" 
                        required 
                        class="w-full px-4 py-2.5 text-xs rounded-xl border @error('name') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-slate-50/50 @enderror focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand text-slate-800 transition"
                    >
                    @error('name')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email & No. HP -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="email" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Alamat Email (Login) <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email', $user->email) }}" 
                            required 
                            class="w-full px-4 py-2.5 text-xs rounded-xl border @error('email') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-slate-50/50 @enderror focus:bg-white focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] text-slate-800 transition"
                        >
                        @error('email')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Nomor Telepon / WhatsApp
                        </label>
                        <input 
                            type="text" 
                            id="phone" 
                            name="phone" 
                            value="{{ old('phone', $user->phone) }}" 
                            placeholder="081234567890"
                            class="w-full px-4 py-2.5 text-xs rounded-xl border @error('phone') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-slate-50/50 @enderror focus:bg-white focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] text-slate-800 transition font-mono"
                        >
                        @error('phone')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Identitas Khusus Siswa (NISN & NIS) -->
                <div class="p-4 rounded-2xl bg-blue-50/50 border border-blue-200/70 space-y-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="block text-xs font-bold text-slate-900">Identitas Siswa (NISN & NIS)</span>
                            <p class="text-[11px] text-slate-500">Khusus untuk akun siswa. Siswa dapat menggunakan NISN atau NIS untuk login ke portal.</p>
                        </div>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-[#233DFF]/10 text-[#233DFF] border border-[#233DFF]/20">
                            Login Siswa
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                        <div>
                            <label for="nisn" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5 text-[11px]">
                                NISN (Nomor Induk Siswa Nasional)
                            </label>
                            <input 
                                type="text" 
                                id="nisn" 
                                name="nisn" 
                                value="{{ old('nisn', $user->nisn ?? $user->student?->nisn) }}" 
                                placeholder="Contoh: 0071234567 (10 digit)"
                                class="w-full px-4 py-2.5 text-xs rounded-xl border @error('nisn') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-white @enderror focus:bg-white focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] text-slate-800 transition font-mono"
                            >
                            @error('nisn')
                                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nis" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5 text-[11px]">
                                NIS (Nomor Induk Siswa)
                            </label>
                            <input 
                                type="text" 
                                id="nis" 
                                name="nis" 
                                value="{{ old('nis', $user->nis ?? $user->student?->nis) }}" 
                                placeholder="Contoh: 20261101"
                                class="w-full px-4 py-2.5 text-xs rounded-xl border @error('nis') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-white @enderror focus:bg-white focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] text-slate-800 transition font-mono"
                            >
                            @error('nis')
                                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Ubah Password (Opsional) -->
                <div class="p-5 bg-slate-50/80 rounded-2xl border border-slate-200 space-y-4">
                    <div>
                        <span class="text-xs font-bold text-slate-800 uppercase tracking-wider block">Ubah Password Akun (Opsional)</span>
                        <span class="text-[11px] text-slate-500">Biarkan input di bawah ini kosong jika Anda tidak ingin memperbarui password.</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1">
                                Password Baru
                            </label>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                placeholder="Minimal 8 karakter"
                                class="w-full px-4 py-2.5 text-xs rounded-xl border @error('password') border-rose-400 bg-rose-50/30 @else border-slate-200 @enderror bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand text-slate-800 transition"
                            >
                            @error('password')
                                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1">
                                Konfirmasi Password Baru
                            </label>
                            <input 
                                type="password" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                placeholder="Ulangi password baru"
                                class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand text-slate-800 transition"
                            >
                        </div>
                    </div>
                </div>

                <!-- Penugasan Peran / Roles (Multi-Role) -->
                <div class="pt-2">
                    <label class="block font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Peran & Hak Akses (Pilih satu atau lebih) <span class="text-rose-500">*</span>
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 p-4 bg-slate-50/60 rounded-2xl border border-slate-200">
                        @foreach ($roles as $role)
                            <label class="flex items-start gap-3 p-3 rounded-xl border border-slate-200/80 bg-white hover:border-indigo-300 hover:bg-indigo-50/30 cursor-pointer transition">
                                <input 
                                    type="checkbox" 
                                    name="roles[]" 
                                    value="{{ $role->name }}" 
                                    {{ in_array($role->name, old('roles', $userRoles)) ? 'checked' : '' }}
                                    class="mt-0.5 rounded text-indigo-600 focus:ring-indigo-500 border-slate-300"
                                >
                                <div>
                                    <span class="block text-xs font-bold text-slate-800 capitalize">
                                        {{ str_replace('_', ' ', $role->name) }}
                                    </span>
                                    <span class="block text-[11px] text-slate-400 mt-0.5">
                                        @if ($role->name === 'admin') Akses penuh kelola sistem & master data
                                        @elseif ($role->name === 'guru') Akses jadwal mengajar & presensi sesi
                                        @elseif ($role->name === 'wali_kelas') Rekap presensi & monitoring kelas
                                        @elseif ($role->name === 'guru_pembimbing_pkl') Verifikasi jurnal & tugas PKL
                                        @elseif ($role->name === 'siswa') Akses jadwal kelas, presensi & jurnal PKL (login via NISN)
                                        @endif
                                    </span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('roles')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Aktif -->
                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/60">
                    <label class="inline-flex items-center gap-3 cursor-pointer">
                        <input 
                            type="checkbox" 
                            name="is_active" 
                            value="1" 
                            {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                            class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500 border-slate-300"
                        >
                        <div>
                            <span class="font-bold text-slate-800 text-xs">Akun Aktif (Dapat digunakan untuk login)</span>
                            <p class="text-[11px] text-slate-500 mt-0.5">Jika dinonaktifkan, akun ini diblokir dari sistem.</p>
                        </div>
                    </label>
                </div>

                <!-- Action Buttons -->
                <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 border border-slate-200 text-slate-600 hover:bg-slate-50 font-semibold rounded-xl transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-md shadow-indigo-500/20 transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
