<x-app-layout title="Edit Konten Publikasi">
    <x-slot name="header">
        Publikasi Sekolah: Edit Konten
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Back Navigation & Title -->
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.posts.index') }}" class="p-2 rounded-lg bg-surface hover:bg-slate-100 text-slate-600 border border-border transition min-h-[44px] min-w-[44px] flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h1 class="text-xl font-bold text-navy">Edit Konten Publikasi</h1>
                <p class="text-xs text-slate-600 mt-0.5">Perbarui informasi untuk "{{ $post->title }}".</p>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-surface rounded-xl border border-border p-6 shadow-sm">
            <form method="POST" action="{{ route('admin.posts.update', $post->id) }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-2">
                        <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Judul Konten <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" required
                               class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
                        @error('title')
                            <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="category" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kategori Konten <span class="text-danger">*</span></label>
                        <select name="category" id="category" required onchange="toggleEventFields(this.value)"
                                class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
                            <option value="berita" {{ old('category', $post->category) == 'berita' ? 'selected' : '' }}>Berita</option>
                            <option value="pengumuman" {{ old('category', $post->category) == 'pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                            <option value="acara" {{ old('category', $post->category) == 'acara' ? 'selected' : '' }}>Acara Sekolah</option>
                        </select>
                        @error('category')
                            <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Event Specific Fields -->
                <div id="eventFields" class="{{ old('category', $post->category) == 'acara' ? '' : 'hidden' }} p-4 bg-slate-50 border border-slate-200 rounded-lg space-y-4">
                    <p class="text-xs font-bold text-navy uppercase tracking-wider">Detail Acara Sekolah</p>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label for="event_date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal Acara</label>
                            <input type="date" name="event_date" id="event_date" value="{{ old('event_date', $post->event_date?->format('Y-m-d')) }}"
                                   class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
                        </div>
                        <div>
                            <label for="event_time" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Waktu / Jam (HH:mm)</label>
                            <input type="text" name="event_time" id="event_time" value="{{ old('event_time', $post->event_time ? substr($post->event_time, 0, 5) : '') }}" placeholder="08:00"
                                   class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800 font-mono">
                        </div>
                        <div>
                            <label for="event_location" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Lokasi / Ruangan</label>
                            <input type="text" name="event_location" id="event_location" value="{{ old('event_location', $post->event_location) }}" placeholder="Contoh: Aula Gedung A"
                                   class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
                        </div>
                    </div>
                </div>

                <div>
                    <label for="excerpt" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Ringkasan Singkat (Excerpt)</label>
                    <textarea name="excerpt" id="excerpt" rows="2"
                              class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">{{ old('excerpt', $post->excerpt) }}</textarea>
                    @error('excerpt')
                        <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="content" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Isi Konten Lengkap <span class="text-danger">*</span></label>
                    <textarea name="content" id="content" rows="8" required
                              class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800 font-sans leading-relaxed">{{ old('content', $post->content) }}</textarea>
                    @error('content')
                        <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="hidden" name="is_published" value="0">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published', $post->is_published) ? 'checked' : '' }}
                               class="rounded border-border text-brand focus:ring-brand h-4 w-4">
                        <span class="text-xs font-semibold text-slate-800">Terbitkan langsung ke publik</span>
                    </label>
                    <p class="text-[11px] text-slate-500 mt-0.5 ml-6">Jika tidak dicentang, konten disimpan sebagai draf dan tidak tampil di halaman depan.</p>
                </div>

                <!-- Submit Button -->
                <div class="pt-4 border-t border-border flex items-center justify-end gap-3">
                    <a href="{{ route('admin.posts.index') }}" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:text-navy hover:bg-slate-100 rounded-lg transition min-h-[44px] flex items-center">
                        Batal
                    </a>
                    <button type="submit" class="px-5 py-2.5 text-xs font-semibold text-white bg-brand rounded-lg hover:bg-brand-hover shadow-sm transition min-h-[44px]">
                        Perbarui Konten
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
