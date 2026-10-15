<x-app-layout title="Tambah Data Guru">
    <x-slot name="header">
        Tambah Guru
    </x-slot>

    <div class="max-w-3xl bg-surface rounded-xl border border-border shadow-sm p-6">
        <div class="mb-6 pb-4 border-b border-border flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-navy">Form Profil Guru Baru</h2>
                <p class="text-xs text-slate-500 mt-0.5">Pilih akun pengguna bertipe Guru dan lengkapi data profil serta mapel yang diampu.</p>
            </div>
            <a href="{{ route('admin.teachers.index') }}" class="text-xs font-semibold text-slate-600 hover:text-navy transition">
                &larr; Kembali
            </a>
        </div>

        @if ($availableUsers->isEmpty())
            <div class="p-4 mb-4 bg-amber-50 border border-amber-200 rounded-lg text-amber-800 text-xs">
                <span class="font-bold">Perhatian:</span> Tidak ada akun pengguna dengan peran Guru yang belum memiliki data guru. Silakan buat akun pengguna baru terlebih dahulu melalui menu 
                <a href="{{ route('admin.users.create') }}" class="underline font-semibold hover:text-amber-900">Kelola Pengguna</a> dengan role Guru.
            </div>
        @endif

        <form method="POST" action="{{ route('admin.teachers.store') }}" class="space-y-4 text-xs">
            @csrf

            <div>
                <label for="user_id" class="block font-semibold text-slate-700 mb-1">Pilih Akun Pengguna <span class="text-danger">*</span></label>
                <select 
                    id="user_id" 
                    name="user_id" 
                    required 
                    {{ $availableUsers->isEmpty() ? 'disabled' : '' }}
                    class="w-full px-3.5 py-2 text-xs rounded-lg border @error('user_id') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand bg-white"
                >
                    <option value="">-- Pilih Akun Pengguna (Role Guru) --</option>
                    @foreach ($availableUsers as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="nip" class="block font-semibold text-slate-700 mb-1">NIP (Nomor Induk Pegawai)</label>
                    <input 
                        type="text" 
                        id="nip" 
                        name="nip" 
                        value="{{ old('nip') }}" 
                        placeholder="Contoh: 198001012005011001"
                        class="w-full px-3.5 py-2 text-xs rounded-lg border @error('nip') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand"
                    >
                    @error('nip')
                        <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nuptk" class="block font-semibold text-slate-700 mb-1">NUPTK</label>
                    <input 
                        type="text" 
                        id="nuptk" 
                        name="nuptk" 
                        value="{{ old('nuptk') }}" 
                        placeholder="Contoh: 1234567890123456"
                        class="w-full px-3.5 py-2 text-xs rounded-lg border @error('nuptk') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand"
                    >
                    @error('nuptk')
                        <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="gender" class="block font-semibold text-slate-700 mb-1">Jenis Kelamin <span class="text-danger">*</span></label>
                    <select 
                        id="gender" 
                        name="gender" 
                        required
                        class="w-full px-3.5 py-2 text-xs rounded-lg border @error('gender') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand bg-white"
                    >
                        <option value="L" {{ old('gender', 'L') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('gender') === 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('gender')
                        <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block font-semibold text-slate-700 mb-1">No. Telepon / WhatsApp</label>
                    <input 
                        type="text" 
                        id="phone" 
                        name="phone" 
                        value="{{ old('phone') }}" 
                        placeholder="Contoh: 08123456789"
                        class="w-full px-3.5 py-2 text-xs rounded-lg border @error('phone') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand"
                    >
                    @error('phone')
                        <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="address" class="block font-semibold text-slate-700 mb-1">Alamat Tinggal</label>
                <textarea 
                    id="address" 
                    name="address" 
                    rows="2"
                    placeholder="Alamat lengkap tempat tinggal guru..."
                    class="w-full px-3.5 py-2 text-xs rounded-lg border @error('address') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand"
                >{{ old('address') }}</textarea>
                @error('address')
                    <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-2">
                <label class="block font-semibold text-slate-700 mb-2">Mata Pelajaran yang Diampu</label>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5 p-3 rounded-lg border border-border bg-slate-50/50 max-h-48 overflow-y-auto">
                    @forelse ($subjects as $subject)
                        <label class="flex items-center gap-2 p-1.5 rounded hover:bg-white text-slate-700 cursor-pointer">
                            <input 
                                type="checkbox" 
                                name="subject_ids[]" 
                                value="{{ $subject->id }}"
                                {{ in_array($subject->id, old('subject_ids', [])) ? 'checked' : '' }}
                                class="w-4 h-4 rounded text-brand focus:ring-brand border-border"
                            >
                            <span class="truncate">
                                <span class="font-semibold text-slate-900">{{ $subject->code }}</span> - {{ $subject->name }}
                            </span>
                        </label>
                    @empty
                        <p class="text-slate-400 col-span-3 italic">Belum ada mata pelajaran terdaftar.</p>
                    @endforelse
                </div>
                @error('subject_ids')
                    <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 border-t border-border flex items-center justify-end gap-3">
                <a href="{{ route('admin.teachers.index') }}" class="px-4 py-2 border border-border text-slate-700 hover:bg-slate-50 font-semibold rounded-lg transition">
                    Batal
                </a>
                <button 
                    type="submit" 
                    {{ $availableUsers->isEmpty() ? 'disabled' : '' }}
                    class="px-4 py-2 bg-brand hover:bg-brand-hover disabled:opacity-50 text-white font-semibold rounded-lg shadow-sm transition"
                >
                    Simpan Data Guru
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
