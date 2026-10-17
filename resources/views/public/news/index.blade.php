<x-public-layout title="Berita Sekolah">
    <!-- Header Banner -->
    <div class="relative bg-gradient-to-b from-indigo-50/80 via-white to-slate-50 py-16 border-b border-border/80 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-2xl space-y-3">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-indigo-50 text-brand border border-indigo-200/60">
                    Warta &amp; Publikasi
                </span>
                <h1 class="text-3xl sm:text-4xl font-black text-navy tracking-tight">Kabar &amp; Berita Sekolah</h1>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Liputan kegiatan akademik, inovasi siswa, prestasi kompetisi, dan kerja sama kemitraan industri terkini di SatuSekolah.
                </p>
            </div>
        </div>
    </div>

    <!-- News Listing -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($newsList as $item)
                <article class="group bg-white rounded-3xl border border-slate-200/90 overflow-hidden shadow-xs hover:shadow-card hover:-translate-y-1 transition-all duration-200 flex flex-col justify-between">
                    <div>
                        @if($item->featured_image)
                            <div class="overflow-hidden h-52 bg-slate-100">
                                <img src="{{ asset('storage/' . $item->featured_image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            </div>
                        @else
                            <div class="w-full h-52 bg-gradient-to-br from-indigo-50 to-slate-100 border-b border-slate-100 flex items-center justify-center text-indigo-300">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                            </div>
                        @endif

                        <div class="p-6 sm:p-7 space-y-3">
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-indigo-50 text-brand border border-indigo-200/60">
                                    Berita Resmi
                                </span>
                                <span class="text-[11px] text-slate-400 font-mono">
                                    {{ $item->published_at ? $item->published_at->format('d M Y') : '-' }}
                                </span>
                            </div>
                            <h2 class="text-base sm:text-lg font-bold text-navy group-hover:text-brand transition line-clamp-2 leading-snug">
                                <a href="{{ route('public.news.show', $item->slug) }}">{{ $item->title }}</a>
                            </h2>
                            <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed">
                                {{ $item->excerpt ?: Str::limit(strip_tags($item->content), 130) }}
                            </p>
                        </div>
                    </div>

                    <div class="px-6 sm:px-7 pb-6 sm:pb-7 pt-0 flex items-center justify-between border-t border-slate-100 mt-2">
                        <span class="text-[11px] text-slate-400">Oleh: {{ $item->author?->name ?? 'Admin Sekolah' }}</span>
                        <a href="{{ route('public.news.show', $item->slug) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-brand hover:underline">
                            <span>Baca Lengkap</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </article>
            @empty
                <div class="col-span-3 py-20 text-center text-slate-500 bg-white rounded-3xl border border-slate-200/80">
                    <svg class="w-12 h-12 mx-auto text-slate-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    <p class="text-sm font-bold text-navy">Belum ada berita yang dipublikasikan.</p>
                    <p class="text-xs text-slate-400 mt-1">Silakan kembali lagi nanti untuk informasi terbaru.</p>
                </div>
            @endforelse
        </div>

        @if($newsList->hasPages())
            <div class="pt-8">
                {{ $newsList->links() }}
            </div>
        @endif
    </div>
</x-public-layout>
