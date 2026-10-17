<x-app-layout title="Tulis Konten Baru">
    <x-slot name="header">
        Publikasi Sekolah: Tulis Baru
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Back Navigation -->
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.posts.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600 hover:text-indigo-600 transition group">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Daftar Publikasi</span>
            </a>
            <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200">
                Editor Publikasi Sekolah
            </span>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="p-6 bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white">
                <h2 class="text-lg font-bold">Tulis Berita, Pengumuman, atau Agenda Acara</h2>
                <p class="text-xs text-slate-300 mt-1">Lengkapi informasi konten untuk diterbitkan ke halaman beranda dan portal sekolah.</p>
            </div>

            <form method="POST" action="{{ route('admin.posts.store') }}" class="p-6 md:p-8 space-y-5 text-xs">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div class="sm:col-span-2">
                        <label for="title" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Judul Konten <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="Contoh: Penerimaan Peserta Didik Baru (PPDB) Tahun 2026/2027"
                               class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800 transition">
                        @error('title')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="category" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Kategori Konten <span class="text-rose-500">*</span>
                        </label>
                        <select name="category" id="category" required onchange="toggleEventFields(this.value)"
                                class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800 transition font-medium">
                            <option value="berita" {{ old('category') == 'berita' ? 'selected' : '' }}>Berita Sekolah</option>
                            <option value="pengumuman" {{ old('category') == 'pengumuman' ? 'selected' : '' }}>Pengumuman Resmi</option>
                            <option value="acara" {{ old('category') == 'acara' ? 'selected' : '' }}>Agenda / Acara</option>
                        </select>
                        @error('category')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Event Specific Fields -->
                <div id="eventFields" class="{{ old('category') == 'acara' ? '' : 'hidden' }} p-5 bg-indigo-50/40 border border-indigo-100 rounded-2xl space-y-4">
                    <div class="flex items-center gap-2">
                        <span class="w-7 h-7 rounded-lg bg-indigo-600 text-white flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </span>
                        <div>
                            <p class="text-xs font-bold text-slate-900 uppercase tracking-wider">Detail Pelaksanaan Acara</p>
                            <p class="text-[11px] text-slate-500">Tentukan tanggal, waktu mulai, dan lokasi penyelenggaraan acara.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label for="event_date" class="block font-bold uppercase tracking-wider text-slate-700 mb-1">Tanggal Acara</label>
                            <input type="date" name="event_date" id="event_date" value="{{ old('event_date') }}"
                                   class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand/20 focus:border-brand bg-white text-slate-800 font-mono transition">
                        </div>
                        <div>
                            <label for="event_time" class="block font-bold uppercase tracking-wider text-slate-700 mb-1">Waktu / Jam (HH:mm)</label>
                            <input type="text" name="event_time" id="event_time" value="{{ old('event_time') }}" placeholder="08:00"
                                   class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand/20 focus:border-brand bg-white text-slate-800 font-mono transition">
                        </div>
                        <div>
                            <label for="event_location" class="block font-bold uppercase tracking-wider text-slate-700 mb-1">Lokasi / Ruangan</label>
                            <input type="text" name="event_location" id="event_location" value="{{ old('event_location') }}" placeholder="Contoh: Aula Utama Gedung B"
                                   class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand/20 focus:border-brand bg-white text-slate-800 transition">
                        </div>
                    </div>
                </div>

                <div>
                    <label for="excerpt" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Ringkasan Singkat (Excerpt)
                    </label>
                    <textarea name="excerpt" id="excerpt" rows="2" placeholder="Ringkasan 1-2 kalimat pemikat yang akan tampil pada kartu artikel beranda..."
                              class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800 transition leading-relaxed">{{ old('excerpt') }}</textarea>
                    @error('excerpt')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="content" class="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Isi Konten Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="content" id="content" rows="8" required placeholder="Tuliskan isi berita, rincian pengumuman, atau petunjuk acara secara komprehensif..."
                              class="w-full px-4 py-3 text-xs rounded-xl border border-slate-200 focus:bg-white focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800 transition leading-relaxed font-sans">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/60">
                    <label class="inline-flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }}
                               class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500 border-slate-300">
                        <div>
                            <span class="font-bold text-slate-800 text-xs">Terbitkan langsung ke publik</span>
                            <p class="text-[11px] text-slate-500 mt-0.5">Jika tidak dicentang, konten disimpan sebagai draf dan tidak tampil di portal depan.</p>
                        </div>
                    </label>
                </div>

                <!-- Action Buttons -->
                <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.posts.index') }}" class="px-5 py-2.5 border border-slate-200 text-slate-600 hover:bg-slate-50 font-semibold rounded-xl transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-md shadow-indigo-500/20 transition">
                        Simpan & Publikasikan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleEventFields(category) {
            const el = document.getElementById('eventFields');
            if (category === 'acara') {
                el.classList.remove('hidden');
            } else {
                el.classList.add('hidden');
            }
        }
    </script>
</x-app-layout>
