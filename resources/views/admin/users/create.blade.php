<x-app-layout title="Tambah Pengguna Baru">
    <x-slot name="header">
        Tambah Pengguna Baru
    </x-slot>

    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Back Navigation -->
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600 hover:text-indigo-600 transition group">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Daftar Pengguna</span>
            </a>
            <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200">
                Pendaftaran Akun
            </span>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="p-6 bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white">
                <h2 class="text-lg font-bold">Formulir Tambah Akun Pengguna</h2>
                <p class="text-xs text-slate-300 mt-1">Lengkapi data kredensial akun dan tetapkan hak akses multi-role (RBAC) yang sesuai.</p>
            </div>

            <form method="POST" action="{{ route('admin.users.store') }}" class="p-6 md:p-8 space-y-5 text-xs">
                @csrf

                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Nama Lengkap & Gelar <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}" 
                        required 
                        placeholder="Contoh: Budi Santoso, S.Pd., M.Kom."
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
                            Alamat Email (Akun Login) <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            placeholder="nama@satusekolah.sch.id"
                            class="w-full px-4 py-2.5 text-xs rounded-xl border @error('email') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-slate-50/50 @enderror focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand text-slate-800 transition"
                        >
                        @error('email')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Nomor WhatsApp / HP
                        </label>
                        <input 
                            type="text" 
                            id="phone" 
                            name="phone" 
                            value="{{ old('phone') }}" 
                            placeholder="081234567890"
                            class="w-full px-4 py-2.5 text-xs rounded-xl border @error('phone') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-slate-50/50 @enderror focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand text-slate-800 transition font-mono"
                        >
                        @error('phone')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Password & Konfirmasi -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="password" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Password Login <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required 
                            placeholder="Minimal 8 karakter"
                            class="w-full px-4 py-2.5 text-xs rounded-xl border @error('password') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-slate-50/50 @enderror focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand text-slate-800 transition"
                        >
                        @error('password')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Konfirmasi Password <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            required 
                            placeholder="Ulangi password sama"
                            class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand text-slate-800 transition"
                        >
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
                                    {{ in_array($role->name, old('roles', [])) ? 'checked' : '' }}
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
                            {{ old('is_active', '1') == '1' ? 'checked' : '' }}
                            class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500 border-slate-300"
                        >
                        <div>
                            <span class="font-bold text-slate-800 text-xs">Akun Aktif (Dapat langsung digunakan untuk login)</span>
                            <p class="text-[11px] text-slate-500 mt-0.5">Jika dinonaktifkan, pengguna tidak akan dapat mengakses aplikasi.</p>
                        </div>
                    </label>
                </div>

                <!-- Action Buttons -->
                <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 border border-slate-200 text-slate-600 hover:bg-slate-50 font-semibold rounded-xl transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-md shadow-indigo-500/20 transition">
                        Simpan Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
