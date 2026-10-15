<x-app-layout title="Tambah Mitra PKL Baru">
    <x-slot name="header">
        Tambah Mitra PKL
    </x-slot>

    <div class="max-w-3xl bg-surface rounded-xl border border-border shadow-sm p-6">
        <div class="mb-6 pb-4 border-b border-border flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-navy">Form Mitra Industri Baru</h2>
                <p class="text-xs text-slate-500 mt-0.5">Lengkapi profil perusahaan / industri tempat PKL siswa beserta geofence GPS presensi.</p>
            </div>
            <a href="{{ route('admin.internship-companies.index') }}" class="text-xs font-semibold text-slate-600 hover:text-navy transition">
                &larr; Kembali
            </a>
        </div>

        <form method="POST" action="{{ route('admin.internship-companies.store') }}" class="space-y-4 text-xs">
            @csrf

            <div>
                <label for="name" class="block font-semibold text-slate-700 mb-1">Nama Perusahaan / Instansi <span class="text-danger">*</span></label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name') }}" 
                    placeholder="Contoh: PT. Telkom Indonesia Witel Malang" 
                    required
                    class="w-full px-3.5 py-2 text-xs rounded-lg border @error('name') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand"
                >
                @error('name')
                    <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="address" class="block font-semibold text-slate-700 mb-1">Alamat Lengkap Perusahaan <span class="text-danger">*</span></label>
                <textarea 
                    id="address" 
                    name="address" 
                    rows="2"
                    placeholder="Alamat fisik instansi/perusahaan..."
                    required
                    class="w-full px-3.5 py-2 text-xs rounded-lg border @error('address') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand"
                >{{ old('address') }}</textarea>
                @error('address')
                    <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="contact_person" class="block font-semibold text-slate-700 mb-1">Nama Penanggung Jawab (PIC)</label>
                    <input 
                        type="text" 
                        id="contact_person" 
                        name="contact_person" 
                        value="{{ old('contact_person') }}" 
                        placeholder="Contoh: Bpk. Haryono" 
                        class="w-full px-3.5 py-2 text-xs rounded-lg border @error('contact_person') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand"
                    >
                    @error('contact_person')
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
                        placeholder="Contoh: 081234567890" 
                        class="w-full px-3.5 py-2 text-xs rounded-lg border @error('phone') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand"
                    >
                    @error('phone')
                        <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block font-semibold text-slate-700 mb-1">Email Resmi</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        placeholder="Contoh: hrd@perusahaan.com" 
                        class="w-full px-3.5 py-2 text-xs rounded-lg border @error('email') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand"
                    >
                    @error('email')
                        <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Geofencing & GPS -->
            <div class="p-4 rounded-lg border border-border bg-slate-50/50 space-y-3">
                <div>
                    <h3 class="font-bold text-navy text-xs">Pengaturan Geofencing & Koordinat GPS</h3>
                    <p class="text-[11px] text-slate-500">Digunakan untuk validasi jarak saat siswa melakukan presensi PKL dari aplikasi mobile.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="latitude" class="block font-semibold text-slate-700 mb-1">Latitude</label>
                        <input 
                            type="number" 
                            step="any" 
                            id="latitude" 
                            name="latitude" 
                            value="{{ old('latitude') }}" 
                            placeholder="Contoh: -7.9826" 
                            class="w-full px-3.5 py-2 text-xs rounded-lg border @error('latitude') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand"
                        >
                        @error('latitude')
                            <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="longitude" class="block font-semibold text-slate-700 mb-1">Longitude</label>
                        <input 
                            type="number" 
                            step="any" 
                            id="longitude" 
                            name="longitude" 
                            value="{{ old('longitude') }}" 
                            placeholder="Contoh: 112.6308" 
                            class="w-full px-3.5 py-2 text-xs rounded-lg border @error('longitude') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand"
                        >
                        @error('longitude')
                            <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="radius_meters" class="block font-semibold text-slate-700 mb-1">Radius Presensi (Meter)</label>
                        <input 
                            type="number" 
                            id="radius_meters" 
                            name="radius_meters" 
                            value="{{ old('radius_meters', 100) }}" 
                            min="10" 
                            max="5000" 
                            placeholder="Contoh: 100" 
                            class="w-full px-3.5 py-2 text-xs rounded-lg border @error('radius_meters') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand"
                        >
                        @error('radius_meters')
                            <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-border flex items-center justify-end gap-3">
                <a href="{{ route('admin.internship-companies.index') }}" class="px-4 py-2 border border-border text-slate-700 hover:bg-slate-50 font-semibold rounded-lg transition">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-brand hover:bg-brand-hover text-white font-semibold rounded-lg shadow-sm transition">
                    Simpan Mitra PKL
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
