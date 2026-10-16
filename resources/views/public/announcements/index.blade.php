<x-public-layout title="Pengumuman Sekolah">
    <!-- Header Banner -->
    <div class="bg-navy text-white py-12 border-b border-navy-light/40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <span class="inline-flex items-center px-2.5 py-1 rounded text-xs font-semibold bg-amber-600 text-white mb-3">
                Informasi Penting
            </span>
            <h1 class="text-3xl font-bold tracking-tight">Papan Pengumuman Resmi</h1>
            <p class="text-xs sm:text-sm text-slate-300 mt-2 max-w-2xl">
                Pengumuman operasional, jadwal administratif, dan edaran resmi dari pihak manajemen sekolah.
            </p>
        </div>
    </div>

    <!-- Announcements Listing -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-6">
        <div class="space-y-4">
            @forelse($announcements as $item)
                <div class="bg-white rounded-xl border border-border p-6 shadow-xs hover:border-brand/40 transition">
                    <div class="flex items-center justify-between gap-4 mb-2">
                        <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-amber-50 text-amber-800 border border-amber-200">
                            Pengumuman
                        </span>
                        <span class="text-xs text-slate-400 font-mono">
                            {{ $item->published_at ? $item->published_at->format('d/m/Y') : '-' }}
                        </span>
                    </div>
                    <h2 class="text-base font-bold text-navy hover:text-brand transition">
                        <a href="{{ route('public.announcements.show', $item->slug) }}">{{ $item->title }}</a>
                    </h2>
                    <p class="text-xs text-slate-600 mt-2 line-clamp-2 leading-relaxed">
                        {{ $item->excerpt ?: Str::limit(strip_tags($item->content), 150) }}
                    </p>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[11px] text-slate-400">Oleh: {{ $item->author?->name ?? 'Admin Sekolah' }}</span>
                        <a href="{{ route('public.announcements.show', $item->slug) }}" class="text-xs font-semibold text-brand hover:underline inline-flex items-center gap-1">
                            <span>Baca Lengkap</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="py-16 text-center text-slate-500 bg-white rounded-xl border border-border">
                    Belum ada pengumuman yang diterbitkan saat ini.
                </div>
            @endforelse
        </div>

        @if($announcements->hasPages())
            <div class="pt-6">
                {{ $announcements->links() }}
            </div>
        @endif
    </div>
</x-public-layout>
