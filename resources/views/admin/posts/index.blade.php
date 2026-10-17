<x-app-layout title="Manajemen Berita, Pengumuman & Acara">
    <x-slot name="header">
        Administrasi: Publikasi Sekolah
    </x-slot>

    <div class="space-y-6">
        <!-- Top Hero / Page Header -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 p-6 md:p-8 text-white shadow-xl">
            <div class="absolute -right-12 -top-12 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -left-12 -bottom-12 w-64 h-64 bg-brand/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/20 border border-indigo-400/30 text-indigo-300 text-xs font-semibold mb-3">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        <span>Portal Komunikasi & Berita</span>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-white">Publikasi Informasi Sekolah</h1>
                    <p class="text-sm text-slate-300 mt-1 max-w-xl">
                        Kelola berita resmi, pengumuman kedinasan, dan agenda acara penting untuk siswa, guru, wali murid, dan publik.
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.posts.create') }}"
                       class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold text-xs shadow-lg shadow-indigo-500/25 transition duration-150 transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        <span>Tulis Konten Baru</span>
                    </a>
                </div>
            </div>

            <!-- Bento Stats Sub-row -->
            <div class="relative z-10 grid grid-cols-2 sm:grid-cols-4 gap-3 mt-6 pt-6 border-t border-white/10">
                <div class="p-3 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <span class="text-[11px] font-medium text-slate-400 block">Total Publikasi</span>
                    <span class="text-xl font-bold text-white mt-0.5 block">{{ $posts->total() }} Artikel</span>
                </div>
                <div class="p-3 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <span class="text-[11px] font-medium text-slate-400 block">Berita Terbit</span>
                    <span class="text-xl font-bold text-sky-400 mt-0.5 block">{{ $posts->where('category', 'berita')->count() }} Berita</span>
                </div>
                <div class="p-3 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <span class="text-[11px] font-medium text-slate-400 block">Pengumuman</span>
                    <span class="text-xl font-bold text-amber-400 mt-0.5 block">{{ $posts->where('category', 'pengumuman')->count() }} Pengumuman</span>
                </div>
                <div class="p-3 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <span class="text-[11px] font-medium text-slate-400 block">Agenda Acara</span>
                    <span class="text-xl font-bold text-purple-400 mt-0.5 block">{{ $posts->where('category', 'acara')->count() }} Acara</span>
                </div>
            </div>
        </div>

        <!-- Filter Bar Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5">
            <form method="GET" action="{{ route('admin.posts.index') }}" class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Cari Judul / Isi</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </span>
                        <input type="text" name="search" id="search" value="{{ $filters['search'] ?? '' }}" placeholder="Judul atau kata kunci..."
                               class="w-full pl-9 pr-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800">
                    </div>
                </div>

                <div>
                    <label for="category" class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Kategori</label>
                    <select name="category" id="category" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800">
                        <option value="">Semua Kategori</option>
                        <option value="berita" {{ ($filters['category'] ?? '') == 'berita' ? 'selected' : '' }}>Berita</option>
                        <option value="pengumuman" {{ ($filters['category'] ?? '') == 'pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                        <option value="acara" {{ ($filters['category'] ?? '') == 'acara' ? 'selected' : '' }}>Acara Sekolah</option>
                    </select>
                </div>

                <div>
                    <label for="is_published" class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Status Publikasi</label>
                    <select name="is_published" id="is_published" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand/20 focus:border-brand bg-slate-50/50 text-slate-800">
                        <option value="">Semua Status</option>
                        <option value="1" {{ ($filters['is_published'] ?? '') === '1' ? 'selected' : '' }}>Diterbitkan (Publik)</option>
                        <option value="0" {{ ($filters['is_published'] ?? '') === '0' ? 'selected' : '' }}>Draf (Tersimpan)</option>
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold rounded-xl shadow-sm transition min-h-[42px]">
                        Filter
                    </button>
                    @if (! empty(array_filter($filters)))
                        <a href="{{ route('admin.posts.index') }}" class="px-3.5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl transition min-h-[42px] flex items-center shrink-0">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Posts Table Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50/75 border-b border-slate-200 text-[11px] font-bold uppercase tracking-wider text-slate-600">
                            <th scope="col" class="py-3.5 px-4 w-12 text-center">No</th>
                            <th scope="col" class="py-3.5 px-4">Judul & Ringkasan</th>
                            <th scope="col" class="py-3.5 px-4">Kategori</th>
                            <th scope="col" class="py-3.5 px-4">Penulis & Tanggal</th>
                            <th scope="col" class="py-3.5 px-4">Detail Acara (Khusus Agenda)</th>
                            <th scope="col" class="py-3.5 px-4">Status Publikasi</th>
                            <th scope="col" class="py-3.5 px-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($posts as $index => $post)
                            <tr class="hover:bg-indigo-50/30 transition-colors duration-150">
                                <td class="py-4 px-4 text-center font-mono text-slate-400">
                                    {{ $posts->firstItem() + $index }}
                                </td>
                                <td class="py-4 px-4 max-w-sm">
                                    <p class="font-bold text-slate-900 text-sm line-clamp-1">{{ $post->title }}</p>
                                    <p class="text-[11px] text-slate-400 line-clamp-1 mt-0.5 leading-relaxed">
                                        {{ $post->excerpt ?: strip_tags($post->content) }}
                                    </p>
                                </td>
                                <td class="py-4 px-4">
                                    @if ($post->category === 'berita')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>
                                            Berita
                                        </span>
                                    @elseif ($post->category === 'pengumuman')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            Pengumuman
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                                            Acara
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    <p class="font-semibold text-slate-800">{{ $post->author?->name ?? 'Admin Sekolah' }}</p>
                                    <p class="text-[11px] text-slate-400 font-mono mt-0.5">
                                        {{ $post->published_at ? $post->published_at->format('d/m/Y H:i') : 'Dibuat: '.$post->created_at->format('d/m/Y') }}
                                    </p>
                                </td>
                                <td class="py-4 px-4 text-slate-600">
                                    @if ($post->category === 'acara' && $post->event_date)
                                        <p class="font-bold text-slate-800 font-mono">{{ $post->event_date->format('d/m/Y') }} {{ $post->event_time ? substr($post->event_time, 0, 5) : '' }}</p>
                                        <p class="text-[11px] text-slate-400 mt-0.5">{{ $post->event_location ?: 'Lokasi belum diset' }}</p>
                                    @else
                                        <span class="text-slate-300 font-mono">-</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    @if ($post->is_published)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-300">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Diterbitkan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-300">
                                            Draf
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-5 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5">
                                        <form method="POST" action="{{ route('admin.posts.toggle-publish', $post->id) }}" class="inline-block">
                                            @csrf
                                            <button type="submit"
                                                    class="px-2.5 py-1 text-xs font-semibold {{ $post->is_published ? 'text-amber-700 hover:text-amber-900 bg-amber-50 hover:bg-amber-100 border border-amber-200' : 'text-emerald-700 hover:text-emerald-900 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200' }} rounded-lg transition min-h-[34px]">
                                                {{ $post->is_published ? 'Tarik Draf' : 'Terbitkan' }}
                                            </button>
                                        </form>

                                        <a href="{{ route('admin.posts.edit', $post->id) }}"
                                           class="p-2 text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition"
                                           title="Edit Konten">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        </a>

                                        <form method="POST" action="{{ route('admin.posts.destroy', $post->id) }}"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus konten ini?');"
                                              class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition"
                                                    title="Hapus Konten">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center">
                                    <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                    </div>
                                    <h4 class="text-sm font-bold text-slate-800">Tidak Ditemukan Konten Publikasi</h4>
                                    <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1 mb-4">
                                        Belum ada artikel berita, pengumuman, atau acara yang sesuai dengan kriteria filter Anda.
                                    </p>
                                    <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl shadow-sm transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        Tulis Konten Baru
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($posts->hasPages())
                <div class="px-5 py-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
