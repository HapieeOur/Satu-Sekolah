<x-public-layout title="Pengumuman Sekolah">
    <!-- Header Banner -->
    <div class="relative bg-gradient-to-b from-amber-50/70 via-white to-slate-50 py-16 border-b border-border/80 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-2xl space-y-3">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-amber-50 text-amber-800 border border-amber-200/80">
                    Papan Pengumuman Resmi
                </span>
                <h1 class="text-3xl sm:text-4xl font-black text-navy tracking-tight">Pengumuman &amp; Edaran Sekolah</h1>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Surat edaran resmi, jadwal kegiatan operasional, batas waktu administratif, dan pemberitahuan penting manajemen SatuSekolah.
                </p>
            </div>
        </div>
    </div>

    <!-- Announcements Listing -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-6">
        <div class="space-y-4">
            @forelse($announcements as $item)
                <div class="bg-white rounded-3xl border border-slate-200/90 p-6 sm:p-7 shadow-xs hover:shadow-card hover:border-amber-400/50 transition-all duration-200">
                    <div class="flex items-center justify-between gap-4 mb-3">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-50 text-amber-800 border border-amber-200">
                            Pemberitahuan Resmi
                        </span>
                        <span class="text-xs text-slate-400 font-mono">
                            {{ $item->published_at ? $item->published_at->format('d/m/Y') : '-' }}
                        </span>
                    </div>
                    <h2 class="text-base sm:text-lg font-bold text-navy hover:text-amber-700 transition leading-snug">
                        <a href="{{ route('public.announcements.show', $item->slug) }}">{{ $item->title }}</a>
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600 mt-2 line-clamp-2 leading-relaxed">
                        {{ $item->excerpt ?: Str::limit(strip_tags($item->content), 160) }}
                    </p>
                    <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[11px] text-slate-400">Diterbitkan: {{ $item->author?->name ?? 'Tata Usaha / Manajemen Sekolah' }}</span>
                        <a href="{{ route('public.announcements.show', $item->slug) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-amber-700 hover:text-amber-800 hover:underline">
                            <span>Baca Selengkapnya</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="py-20 text-center text-slate-500 bg-white rounded-3xl border border-slate-200/80">
                    <svg class="w-12 h-12 mx-auto text-slate-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    <p class="text-sm font-bold text-navy">Belum ada pengumuman saat ini.</p>
                    <p class="text-xs text-slate-400 mt-1">Pemberitahuan baru akan tampil di halaman ini.</p>
                </div>
            @endforelse
        </div>

        @if($announcements->hasPages())
            <div class="pt-8">
                {{ $announcements->links() }}
            </div>
        @endif
    </div>
</x-public-layout>
