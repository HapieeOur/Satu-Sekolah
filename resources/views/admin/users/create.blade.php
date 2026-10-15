<x-app-layout title="Tambah Pengguna Baru">
    <x-slot name="header">
        Tambah Pengguna Baru
    </x-slot>

    <div class="max-w-3xl">
        <div class="bg-surface rounded-xl border border-border shadow-sm p-6 sm:p-8">
            <div class="mb-6 pb-5 border-b border-border flex items-center justify-between">
                <div>
                    <h2 class="text-base font-bold text-navy">Formulir Tambah Akun</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Isi data akun baru dan tetapkan peran (role) yang sesuai.</p>
                </div>
                <a href="{{ route('admin.users.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition">
                    &larr; Kembali
                </a>
            </div>

            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-5">
                @csrf

                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-1.5">
                        Nama Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}" 
                        required 
                        placeholder="Contoh: Budi Santoso, S.Pd."
                        class="w-full px-3.5 py-2.5 text-xs rounded-lg border @error('name') border-rose-400 bg-rose-50/20 @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand"
                    >
                    @error('name')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email & No. HP -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-1.5">
                            Alamat Email <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            placeholder="nama@oneschool.sch.id"
                            class="w-full px-3.5 py-2.5 text-xs rounded-lg border @error('email') border-rose-400 bg-rose-50/20 @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand"
                        >
                        @error('email')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-1.5">
                            Nomor Telepon / WhatsApp
                        </label>
                        <input 
                            type="text" 
                            id="phone" 
                            name="phone" 
                            value="{{ old('phone') }}" 
                            placeholder="081234567890"
                            class="w-full px-3.5 py-2.5 text-xs rounded-lg border @error('phone') border-rose-400 bg-rose-50/20 @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand"
                        >
                        @error('phone')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Password & Konfirmasi -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-1.5">
                            Password <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required 
                            placeholder="Minimal 8 karakter"
                            class="w-full px-3.5 py-2.5 text-xs rounded-lg border @error('password') border-rose-400 bg-rose-50/20 @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand"
                        >
                        @error('password')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-1.5">
                            Konfirmasi Password <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            required 
                            placeholder="Ulangi password"
                            class="w-full px-3.5 py-2.5 text-xs rounded-lg border border-border focus:ring-1 focus:ring-brand focus:border-brand"
                        >
                    </div>
                </div>

                <!-- Penugasan Peran / Roles (Multi-Role) -->
                <div class="pt-2">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-2">
                        Peran Akun (Pilih satu atau lebih) <span class="text-rose-500">*</span>
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 p-4 bg-canvas rounded-xl border border-border">
                        @foreach ($roles as $role)
                            <label class="flex items-start gap-3 p-2.5 rounded-lg border border-border/80 bg-white hover:bg-slate-50 cursor-pointer transition">
                                <input 
                                    type="checkbox" 
                                    name="roles[]" 
                                    value="{{ $role->name }}" 
                                    {{ in_array($role->name, old('roles', [])) ? 'checked' : '' }}
                                    class="mt-0.5 rounded border-border text-brand focus:ring-brand"
                                >
                                <div>
                                    <span class="block text-xs font-bold text-slate-800 capitalize">
                                        {{ str_replace('_', ' ', $role->name) }}
                                    </span>
                                    <span class="block text-[11px] text-slate-400">
                                        @if ($role->name === 'admin') Akses penuh administrasi sistem
                                        @elseif ($role->name === 'guru') Jadwal & aktivitas mengajar
                                        @elseif ($role->name === 'wali_kelas') Manajemen siswa kelas binaan
                                        @elseif ($role->name === 'guru_pembimbing_pkl') Pengawasan siswa PKL & jurnal
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
                <div class="pt-2">
                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input 
                            type="checkbox" 
                            name="is_active" 
                            value="1" 
                            {{ old('is_active', '1') == '1' ? 'checked' : '' }}
                            class="rounded border-border text-brand focus:ring-brand"
                        >
                        <span class="text-xs font-semibold text-slate-700">Akun Aktif (Dapat langsung digunakan untuk login)</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="pt-4 border-t border-border flex items-center justify-end gap-3">
                    <a href="{{ route('admin.users.index') }}" class="px-4 py-2.5 rounded-lg border border-border text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                        Batal
                    </a>
                    <button type="submit" class="px-5 py-2.5 rounded-lg bg-brand hover:bg-brand-hover text-white text-xs font-semibold shadow-sm transition">
                        Simpan Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
