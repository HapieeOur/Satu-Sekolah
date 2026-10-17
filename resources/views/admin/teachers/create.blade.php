<x-app-layout title="Tambah Data Guru">
    <x-slot name="header">
        Administrasi: Tambah Data Guru
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.teachers.index') }}" 
                   class="w-10 h-10 rounded-xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-center text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition"
                   title="Kembali ke Daftar Guru">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <div>
                    <h1 class="text-xl font-bold text-slate-900">Tambah Profil Guru Baru</h1>
                    <p class="text-xs text-slate-500 mt-0.5">Tautkan akun pengguna guru, lengkapi identitas kepegawaian, serta tentukan mata pelajaran yang diampu</p>
                </div>
            </div>
            <a href="{{ route('admin.teachers.index') }}" class="text-xs font-semibold text-slate-500 hover:text-indigo-600 transition hidden sm:inline-block">
                &larr; Kembali ke Daftar Guru
            </a>
        </div>

        @if ($availableUsers->isEmpty())
            <div class="p-4 bg-amber-50/80 border border-amber-200 rounded-2xl text-amber-900 text-xs flex items-start gap-3 shadow-sm">
                <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0 mt-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div class="space-y-1">
                    <span class="font-bold block text-sm">Tidak Ada Akun Guru Tersedia</span>
                    <p class="leading-relaxed text-amber-800">
                        Seluruh akun dengan peran Guru telah memiliki profil pendidik yang terdaftar. Silakan buat akun pengguna baru terlebih dahulu melalui menu 
                        <a href="{{ route('admin.users.create') }}" class="underline font-bold hover:text-amber-950 inline-flex items-center gap-0.5">
                            <span>Kelola Pengguna</span>
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a> 
                        dengan memilih peran Guru.
                    </p>
                </div>
            </div>
        @endif

        <!-- Main Form Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 md:p-8">
            <form method="POST" action="{{ route('admin.teachers.store') }}" class="space-y-6">
                @csrf

                <!-- Section 1: Akun & Identitas Kepegawaian -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                        <div class="w-6 h-6 rounded-md bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs font-bold">1</div>
                        <h2 class="text-xs font-bold uppercase tracking-wider text-slate-800">Akun Pengguna & Data Kepegawaian</h2>
                    </div>

                    <div>
                        <label for="user_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Pilih Akun Pengguna Guru <span class="text-rose-500">*</span>
                        </label>
                        <select 
                            id="user_id" 
                            name="user_id" 
                            required 
                            {{ $availableUsers->isEmpty() ? 'disabled' : '' }}
                            class="w-full px-3.5 py-2.5 text-xs rounded-xl border @error('user_id') border-rose-400 bg-rose-50/30 text-rose-900 @else border-slate-200 bg-white text-slate-800 @enderror focus:ring-2 focus:ring-indigo-100 focus:border-indigo-600 transition"
                        >
                            <option value="">-- Pilih Akun Pengguna (Peran: Guru) --</option>
                            @foreach ($availableUsers as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} &bull; {{ $user->email }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="nip" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                NIP (Nomor Induk Pegawai)
                            </label>
                            <input 
                                type="text" 
                                id="nip" 
                                name="nip" 
                                value="{{ old('nip') }}" 
                                placeholder="Contoh: 198001012005011001"
                                class="w-full px-3.5 py-2.5 text-xs rounded-xl border @error('nip') border-rose-400 bg-rose-50/30 text-rose-900 @else border-slate-200 bg-white text-slate-800 @enderror focus:ring-2 focus:ring-indigo-100 focus:border-indigo-600 font-mono transition"
                            >
                            @error('nip')
                                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nuptk" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                NUPTK
                            </label>
                            <input 
                                type="text" 
                                id="nuptk" 
                                name="nuptk" 
                                value="{{ old('nuptk') }}" 
                                placeholder="Contoh: 1234567890123456"
                                class="w-full px-3.5 py-2.5 text-xs rounded-xl border @error('nuptk') border-rose-400 bg-rose-50/30 text-rose-900 @else border-slate-200 bg-white text-slate-800 @enderror focus:ring-2 focus:ring-indigo-100 focus:border-indigo-600 font-mono transition"
                            >
                            @error('nuptk')
                                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 2: Biodata & Kontak -->
                <div class="space-y-4 pt-4 border-t border-slate-100">
                    <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                        <div class="w-6 h-6 rounded-md bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs font-bold">2</div>
                        <h2 class="text-xs font-bold uppercase tracking-wider text-slate-800">Biodata & Kontak Guru</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
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
                                <option value="L" {{ old('gender', 'L') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('gender') === 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('gender')
                                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                No. Telepon / WhatsApp
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
                    </div>

                    <div>
                        <label for="address" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Alamat Tinggal
                        </label>
                        <textarea 
                            id="address" 
                            name="address" 
                            rows="2"
                            placeholder="Alamat lengkap tempat tinggal guru saat ini..."
                            class="w-full px-3.5 py-2.5 text-xs rounded-xl border @error('address') border-rose-400 bg-rose-50/30 text-rose-900 @else border-slate-200 bg-white text-slate-800 @enderror focus:ring-2 focus:ring-indigo-100 focus:border-indigo-600 transition"
                        >{{ old('address') }}</textarea>
                        @error('address')
                            <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Section 3: Mata Pelajaran yang Diampu -->
                <div class="space-y-4 pt-4 border-t border-slate-100">
                    <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-md bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs font-bold">3</div>
                            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-800">Penugasan Mata Pelajaran</h2>
                        </div>
                        <span class="text-[11px] text-slate-500">Pilih satu atau lebih mapel</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2.5 p-4 rounded-2xl border border-slate-200/80 bg-slate-50/50 max-h-56 overflow-y-auto">
                        @forelse ($subjects as $subject)
                            <label class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-white hover:shadow-2xs text-slate-700 cursor-pointer border border-transparent hover:border-slate-200/60 transition group">
                                <input 
                                    type="checkbox" 
                                    name="subject_ids[]" 
                                    value="{{ $subject->id }}"
                                    {{ in_array($subject->id, old('subject_ids', [])) ? 'checked' : '' }}
                                    class="w-4 h-4 rounded-md text-indigo-600 focus:ring-indigo-500 border-slate-300 transition"
                                >
                                <span class="truncate text-xs">
                                    <span class="font-bold text-slate-900 group-hover:text-indigo-600">{{ $subject->code }}</span>
                                    <span class="text-slate-500">&bull; {{ $subject->name }}</span>
                                </span>
                            </label>
                        @empty
                            <p class="text-slate-400 col-span-3 text-center py-4 italic">Belum ada mata pelajaran terdaftar di sistem.</p>
                        @endforelse
                    </div>
                    @error('subject_ids')
                        <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit / Cancel Actions -->
                <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.teachers.index') }}" class="px-5 py-2.5 border border-slate-200 text-slate-600 hover:bg-slate-50 font-semibold text-xs rounded-xl transition">
                        Batal
                    </a>
                    <button 
                        type="submit" 
                        {{ $availableUsers->isEmpty() ? 'disabled' : '' }}
                        class="inline-flex items-center gap-2 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed text-white font-semibold text-xs rounded-xl shadow-md shadow-indigo-600/20 hover:shadow-indigo-600/30 transition"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Simpan Data Guru</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
