<x-app-layout title="Manajemen Berita, Pengumuman & Acara">
    <x-slot name="header">
        Administrasi: Publikasi Sekolah
    </x-slot>

    <div class="space-y-6">
        <!-- Header & Action -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-navy">Berita, Pengumuman & Acara Sekolah</h1>
                <p class="text-xs text-slate-600 mt-1">Kelola publikasi informasi resmi untuk siswa, tenaga pendidik, dan masyarakat umum.</p>
            </div>
            <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-xs font-semibold text-white bg-brand rounded-lg hover:bg-brand-hover shadow-sm transition shrink-0 min-h-[44px]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Tulis Konten Baru</span>
            </a>
        </div>

        <!-- Filter Bar -->
        <div class="bg-surface rounded-xl border border-border p-5 shadow-sm">
            <form method="GET" action="{{ route('admin.posts.index') }}" class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pencarian</label>
                    <input type="text" name="search" id="search" value="{{ $filters['search'] ?? '' }}" placeholder="Judul / ringkasan..."
                           class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
                </div>

                <div>
                    <label for="category" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kategori</label>
                    <select name="category" id="category" class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
                        <option value="">Semua Kategori</option>
                        <option value="berita" {{ ($filters['category'] ?? '') == 'berita' ? 'selected' : '' }}>Berita</option>
                        <option value="pengumuman" {{ ($filters['category'] ?? '') == 'pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                        <option value="acara" {{ ($filters['category'] ?? '') == 'acara' ? 'selected' : '' }}>Acara Sekolah</option>
                    </select>
                </div>

                <div>
                    <label for="is_published" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status Publikasi</label>
                    <select name="is_published" id="is_published" class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800">
                        <option value="">Semua Status</option>
                        <option value="1" {{ ($filters['is_published'] ?? '') === '1' ? 'selected' : '' }}>Diterbitkan (Publik)</option>
                        <option value="0" {{ ($filters['is_published'] ?? '') === '0' ? 'selected' : '' }}>Draf (Arsip)</option>
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="w-full px-4 py-2 bg-navy hover:bg-navy-light text-white text-xs font-semibold rounded-lg transition min-h-[38px]">
                        Filter
                    </button>
                    @if (! empty(array_filter($filters)))
                        <a href="{{ route('admin.posts.index') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition min-h-[38px] flex items-center shrink-0">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="bg-surface rounded-xl border border-border shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-800">
                    <thead class="bg-slate-50 border-b border-border text-slate-700 font-semibold uppercase tracking-wider text-[11px]">
                        <tr>
                            <th scope="col" class="py-3 px-4 w-12 text-center">No</th>
                            <th scope="col" class="py-3 px-4">Judul Konten</th>
                            <th scope="col" class="py-3 px-4">Kategori</th>
                            <th scope="col" class="py-3 px-4">Penulis & Tanggal</th>
                            <th scope="col" class="py-3 px-4">Detail Acara (Khusus Acara)</th>
                            <th scope="col" class="py-3 px-4">Status</th>
                            <th scope="col" class="py-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse ($posts as $index => $post)
                            <tr class="hover:bg-slate-50/75 transition">
                                <td class="py-3.5 px-4 text-center font-mono text-slate-500">
                                    {{ $posts->firstItem() + $index }}
                                </td>
                                <td class="py-3.5 px-4 max-w-xs">
                                    <p class="font-bold text-navy line-clamp-1">{{ $post->title }}</p>
                                    <p class="text-[11px] text-slate-500 line-clamp-1 mt-0.5">{{ $post->excerpt ?: strip_tags($post->content) }}</p>
                                </td>
                                <td class="py-3.5 px-4">
                                    @if ($post->category === 'berita')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-blue-50 text-blue-800 border border-blue-200">
                                            Berita
                                        </span>
                                    @elseif ($post->category === 'pengumuman')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-amber-50 text-amber-800 border border-amber-200">
                                            Pengumuman
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-purple-50 text-purple-800 border border-purple-200">
                                            Acara
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 font-mono text-slate-600">
                                    <p class="text-slate-800 font-medium">{{ $post->author?->name ?? 'Admin Sekolah' }}</p>
                                    <p class="text-[11px] text-slate-500 mt-0.5">{{ $post->published_at ? $post->published_at->format('d/m/Y H:i') : 'Dibuat: '.$post->created_at->format('d/m/Y') }}</p>
                                </td>
                                <td class="py-3.5 px-4 text-slate-600">
                                    @if ($post->category === 'acara' && $post->event_date)
                                        <p class="font-semibold text-slate-800 font-mono">{{ $post->event_date->format('d/m/Y') }} {{ $post->event_time ? substr($post->event_time, 0, 5) : '' }}</p>
                                        <p class="text-[11px] text-slate-500 mt-0.5">{{ $post->event_location ?: '-' }}</p>
                                    @else
                                        <span class="text-slate-400 font-mono">-</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4">
                                    @if ($post->is_published)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-300">
                                            Diterbitkan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-slate-100 text-slate-700 border border-slate-300">
                                            Draf
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5">
                                        <form method="POST" action="{{ route('admin.posts.toggle-publish', $post->id) }}" class="inline-block">
                                            @csrf
                                            <button type="submit"
                                                    class="px-2.5 py-1 text-xs font-semibold {{ $post->is_published ? 'text-amber-700 hover:text-amber-900 hover:bg-amber-50' : 'text-emerald-700 hover:text-emerald-900 hover:bg-emerald-50' }} rounded transition min-h-[36px]">
                                                {{ $post->is_published ? 'Tarik Draf' : 'Terbitkan' }}
                                            </button>
                                        </form>

                                        <a href="{{ route('admin.posts.edit', $post->id) }}"
                                           class="px-2.5 py-1 text-xs font-semibold text-brand hover:text-brand-hover hover:bg-slate-100 rounded transition min-h-[36px] flex items-center">
                                            Edit
                                        </a>

                                        <form method="POST" action="{{ route('admin.posts.destroy', $post->id) }}"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus konten ini?');"
                                              class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-2.5 py-1 text-xs font-semibold text-rose-700 hover:text-rose-900 hover:bg-rose-50 rounded transition min-h-[36px]">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-10 text-center text-slate-500">
                                    Belum ada konten publikasi yang sesuai dengan kriteria filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($posts->hasPages())
                <div class="p-4 border-t border-border bg-slate-50">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
