<x-public-layout title="Berita Sekolah">
    <!-- Header Banner -->
    <div class="bg-navy text-white py-12 border-b border-navy-light/40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <span class="inline-flex items-center px-2.5 py-1 rounded text-xs font-semibold bg-brand text-white mb-3">
                Warta &amp; Publikasi
            </span>
            <h1 class="text-3xl font-bold tracking-tight">Kabar &amp; Berita Sekolah</h1>
            <p class="text-xs sm:text-sm text-slate-300 mt-2 max-w-2xl">
                Ikuti liputan kegiatan, prestasi siswa, dan perkembangan kurikulum serta kemitraan industri terbaru.
            </p>
        </div>
    </div>

    <!-- News Listing -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($newsList as $item)
                <article class="bg-white rounded-xl border border-border overflow-hidden shadow-xs hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        @if($item->featured_image)
                            <img src="{{ asset('storage/' . $item->featured_image) }}" alt="{{ $item->title }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-slate-100 border-b border-border flex items-center justify-center text-slate-400">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                            </div>
                        @endif
                        <div class="p-6">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-blue-50 text-brand border border-blue-200">
                                    Berita
                                </span>
                                <span class="text-[11px] text-slate-400 font-mono">
                                    {{ $item->published_at ? $item->published_at->format('d M Y') : '-' }}
                                </span>
                            </div>
                            <h2 class="text-base font-bold text-navy hover:text-brand transition line-clamp-2">
                                <a href="{{ route('public.news.show', $item->slug) }}">{{ $item->title }}</a>
                            </h2>
                            <p class="text-xs text-slate-600 mt-2 line-clamp-3 leading-relaxed">
                                {{ $item->excerpt ?: Str::limit(strip_tags($item->content), 120) }}
                            </p>
                        </div>
                    </div>
                    <div class="px-6 pb-6 pt-0">
                        <a href="{{ route('public.news.show', $item->slug) }}" class="text-xs font-semibold text-brand hover:underline inline-flex items-center gap-1">
                            <span>Baca Lengkap</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </article>
            @empty
                <div class="col-span-3 py-16 text-center text-slate-500 bg-white rounded-xl border border-border">
                    Belum ada berita yang dipublikasikan saat ini.
                </div>
            @endforelse
        </div>

        @if($newsList->hasPages())
            <div class="pt-6">
                {{ $newsList->links() }}
            </div>
        @endif
    </div>
</x-public-layout>
