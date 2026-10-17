<x-app-layout title="Edit Mitra PKL">
    <x-slot name="header">
        Edit Mitra Industri
    </x-slot>

    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Back Navigation -->
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.internship-companies.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600 hover:text-indigo-600 transition group">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Daftar Mitra</span>
            </a>
            <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200">
                Mode Edit Mitra
            </span>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="p-6 bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white">
                <h2 class="text-lg font-bold">Edit Mitra: {{ $internshipCompany->name }}</h2>
                <p class="text-xs text-slate-300 mt-1">Perbarui profil industri, PIC, atau batas geofence koordinat GPS presensi.</p>
            </div>

            <form method="POST" action="{{ route('admin.internship-companies.update', $internshipCompany) }}" class="p-6 md:p-8 space-y-5 text-xs">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Nama Perusahaan / Instansi <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', $internshipCompany->name) }}" 
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
                        required
                        class="w-full px-4 py-2.5 text-xs rounded-xl border @error('address') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-slate-50/50 @enderror focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand text-slate-800 transition leading-relaxed"
                    >{{ old('address', $internshipCompany->address) }}</textarea>
                    @error('address')
                        <p class="text-rose-600 text-[11px] mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div>
                        <label for="contact_person" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Nama Penanggung Jawab (PIC)
                        </label>
                        <input 
                            type="text" 
                            id="contact_person" 
                            name="contact_person" 
                            value="{{ old('contact_person', $internshipCompany->contact_person) }}" 
                            class="w-full px-4 py-2.5 text-xs rounded-xl border @error('contact_person') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-slate-50/50 @enderror focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand text-slate-800 transition"
                        >
                        @error('contact_person')
                            <p class="text-rose-600 text-[11px] mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            No. Telepon / WhatsApp
                        </label>
                        <input 
                            type="text" 
                            id="phone" 
                            name="phone" 
                            value="{{ old('phone', $internshipCompany->phone) }}" 
                            class="w-full px-4 py-2.5 text-xs rounded-xl border @error('phone') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-slate-50/50 @enderror focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand text-slate-800 transition font-mono"
                        >
                        @error('phone')
                            <p class="text-rose-600 text-[11px] mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Email Resmi
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email', $internshipCompany->email) }}" 
                            class="w-full px-4 py-2.5 text-xs rounded-xl border @error('email') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-slate-50/50 @enderror focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand text-slate-800 transition"
                        >
                        @error('email')
                            <p class="text-rose-600 text-[11px] mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Geofencing & GPS -->
                <div class="p-5 rounded-2xl border border-indigo-100 bg-indigo-50/40 space-y-4">
                    <div class="flex items-center gap-2">
                        <span class="w-7 h-7 rounded-lg bg-indigo-600 text-white flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </span>
                        <div>
                            <h3 class="font-bold text-slate-900 text-xs">Pengaturan Geofencing & Titik Koordinat GPS</h3>
                            <p class="text-[11px] text-slate-500">Digunakan untuk validasi jarak saat siswa melakukan presensi PKL dari smartphone.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label for="latitude" class="block font-bold uppercase tracking-wider text-slate-700 mb-1">Latitude</label>
                            <input 
                                type="number" 
                                step="any" 
                                id="latitude" 
                                name="latitude" 
                                value="{{ old('latitude', $internshipCompany->latitude) }}" 
                                class="w-full px-4 py-2.5 text-xs rounded-xl border @error('latitude') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-white @enderror focus:ring-2 focus:ring-brand/20 focus:border-brand font-mono text-slate-800 transition"
                            >
                            @error('latitude')
                                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="longitude" class="block font-bold uppercase tracking-wider text-slate-700 mb-1">Longitude</label>
                            <input 
                                type="number" 
                                step="any" 
                                id="longitude" 
                                name="longitude" 
                                value="{{ old('longitude', $internshipCompany->longitude) }}" 
                                class="w-full px-4 py-2.5 text-xs rounded-xl border @error('longitude') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-white @enderror focus:ring-2 focus:ring-brand/20 focus:border-brand font-mono text-slate-800 transition"
                            >
                            @error('longitude')
                                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="radius_meters" class="block font-bold uppercase tracking-wider text-slate-700 mb-1">Radius Presensi (Meter)</label>
                            <input 
                                type="number" 
                                id="radius_meters" 
                                name="radius_meters" 
                                value="{{ old('radius_meters', $internshipCompany->radius_meters) }}" 
                                min="10" 
                                max="5000" 
                                class="w-full px-4 py-2.5 text-xs rounded-xl border @error('radius_meters') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-white @enderror focus:ring-2 focus:ring-brand/20 focus:border-brand font-mono text-slate-800 transition"
                            >
                            @error('radius_meters')
                                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.internship-companies.index') }}" class="px-5 py-2.5 border border-slate-200 text-slate-600 hover:bg-slate-50 font-semibold rounded-xl transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-md shadow-indigo-500/20 transition">
                        Perbarui Mitra PKL
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
