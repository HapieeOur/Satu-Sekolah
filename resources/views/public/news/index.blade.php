<x-public-layout title="Berita & Kabar Sekolah" metaDescription="Daftar berita, liputan kegiatan siswa, prestasi akademik, dan aktivitas resmi Satu-Sekolah.">
    <!-- Header Banner -->
    <div class="bg-navy text-white py-12 border-b border-navy-light/40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <span class="text-xs uppercase tracking-wider font-bold text-blue-300">Warta Sekolah</span>
            <h1 class="text-3xl font-extrabold text-white mt-1">Kabar & Berita Terkini</h1>
            <p class="text-slate-300 text-xs sm:text-sm mt-1.5 max-w-2xl">Informasi seputar prestasi, kegiatan belajar, dan kemitraan industri sekolah.</p>
        </div>
    </div>

    <!-- News Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($newsList as $news)
                <article class="bg-surface rounded-xl border border-border shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition">
                    <div class="p-6 space-y-3">
                        <div class="flex items-center justify-between text-xs text-slate-400">
                            <span>{{ $news->published_at ? $news->published_at->translatedFormat('d F Y') : 'Baru' }}</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-blue-50 text-brand">Berita</span>
                        </div>
                        <h2 class="font-bold text-navy text-base line-clamp-2 hover:text-brand transition">
                            <a href="{{ route('public.news.show', $news->slug) }}">{{ $news->title }}</a>
                        </h2>
                        <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed">
                            {{ $news->excerpt ?? Str::limit(strip_tags($news->content), 120) }}
                        </p>
                    </div>

                    <div class="px-6 py-3.5 bg-canvas/60 border-t border-border flex items-center justify-between text-xs">
                        <span class="text-slate-400 text-[11px]">{{ $news->author?->name ?? 'Admin Sekolah' }}</span>
                        <a href="{{ route('public.news.show', $news->slug) }}" class="font-bold text-brand hover:underline">
                            Baca Berita &rarr;
                        </a>
                    </div>
                </article>
            @empty
                <div class="col-span-3 p-12 text-center bg-surface rounded-2xl border border-border text-slate-400 text-sm">
                    Belum ada artikel berita yang diterbitkan saat ini.
                </div>
            @endforelse
        </div>

        @if ($newsList->hasPages())
            <div class="mt-8">
                {{ $newsList->links() }}
            </div>
        @endif
    </div>
</x-public-layout>
