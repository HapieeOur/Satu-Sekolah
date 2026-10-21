<x-app-layout title="Tambah Mitra PKL Baru">
    <x-slot name="header">
        Tambah Mitra Industri
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Back Navigation -->
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.internship-companies.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600 hover:text-indigo-600 transition group">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Daftar Mitra</span>
            </a>
            <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200">
                Pendaftaran Mitra Baru
            </span>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="p-6 bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white">
                <h2 class="text-lg font-bold">Form Mitra Industri Baru</h2>
                <p class="text-xs text-slate-300 mt-1">Lengkapi profil perusahaan / industri tempat PKL siswa beserta geofence GPS presensi.</p>
            </div>

            <form method="POST" action="{{ route('admin.internship-companies.store') }}" class="p-6 md:p-8 space-y-5 text-xs">
                @csrf

                <div>
                    <label for="name" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Nama Perusahaan / Instansi <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}" 
                        placeholder="Contoh: PT. Telkom Indonesia Witel Malang" 
                        required
                        class="w-full px-4 py-2.5 text-xs rounded-xl border @error('name') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-slate-50/50 @enderror focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand text-slate-800 transition"
                    >
                    @error('name')
                        <p class="text-rose-600 text-[11px] mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="address" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Alamat Lengkap Perusahaan <span class="text-rose-500">*</span>
                    </label>
                    <textarea 
                        id="address" 
                        name="address" 
                        rows="2"
                        placeholder="Alamat fisik instansi/perusahaan tempat pelaksanaan PKL..."
                        required
                        class="w-full px-4 py-2.5 text-xs rounded-xl border @error('address') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-slate-50/50 @enderror focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand text-slate-800 transition leading-relaxed"
                    >{{ old('address') }}</textarea>
                    @error('address')
                        <p class="text-rose-600 text-[11px] mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Guru Pembimbing PKL Sekolah (Wajib) -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="teacher_id" class="block font-bold uppercase tracking-wider text-slate-700">
                            Guru Pembimbing PKL (Sekolah) <span class="text-rose-500">*</span>
                        </label>
                        <span class="text-[10px] font-semibold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-full border border-indigo-100">Khusus Peran: Pembimbing PKL</span>
                    </div>
                    <select 
                        id="teacher_id" 
                        name="teacher_id" 
                        required
                        class="w-full px-4 py-2.5 text-xs rounded-xl border @error('teacher_id') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-slate-50/50 @enderror focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand text-slate-800 transition"
                    >
                        <option value="">-- Pilih Guru Pembimbing dari Sekolah --</option>
                        @forelse ($teachers as $tch)
                            <option value="{{ $tch->id }}" {{ old('teacher_id') == $tch->id ? 'selected' : '' }}>
                                {{ $tch->user->name }} {{ $tch->nip ? '(NIP: ' . $tch->nip . ')' : '(' . $tch->user->email . ')' }}
                            </option>
                        @empty
                            <option value="" disabled>Belum ada akun guru dengan peran Guru Pembimbing PKL</option>
                        @endforelse
                    </select>
                    <p class="text-[11px] text-slate-500 mt-1">Daftar di atas hanya menampilkan guru yang memiliki peran <strong>Guru Pembimbing PKL</strong> (dikelola melalui menu Manajemen Pengguna).</p>
                    @error('teacher_id')
                        <p class="text-rose-600 text-[11px] mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="contact_person" class="block font-bold uppercase tracking-wider text-slate-700">
                                Pembimbing DUDI / PIC
                            </label>
                            <span class="text-[10px] text-slate-400 font-semibold">Opsional</span>
                        </div>
                        <input 
                            type="text" 
                            id="contact_person" 
                            name="contact_person" 
                            value="{{ old('contact_person') }}" 
                            placeholder="Contoh: Bpk. Haryono (Mentor Lapangan)" 
                            class="w-full px-4 py-2.5 text-xs rounded-xl border @error('contact_person') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-slate-50/50 @enderror focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand text-slate-800 transition"
                        >
                        @error('contact_person')
                            <p class="text-rose-600 text-[11px] mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            No. Telepon / WhatsApp DUDI
                        </label>
                        <input 
                            type="text" 
                            id="phone" 
                            name="phone" 
                            value="{{ old('phone') }}" 
                            placeholder="Contoh: 081234567890" 
                            class="w-full px-4 py-2.5 text-xs rounded-xl border @error('phone') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-slate-50/50 @enderror focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand text-slate-800 transition font-mono"
                        >
                        @error('phone')
                            <p class="text-rose-600 text-[11px] mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Email Resmi Perusahaan
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            placeholder="Contoh: hrd@perusahaan.com" 
                            class="w-full px-4 py-2.5 text-xs rounded-xl border @error('email') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-slate-50/50 @enderror focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand text-slate-800 transition"
                        >
                        @error('email')
                            <p class="text-rose-600 text-[11px] mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Geofencing & GPS Map Picker -->
                @include('admin.internship-companies._map-picker')

                <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.internship-companies.index') }}" class="px-5 py-2.5 border border-slate-200 text-slate-600 hover:bg-slate-50 font-semibold rounded-xl transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-md shadow-indigo-500/20 transition">
                        Simpan Mitra PKL
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
