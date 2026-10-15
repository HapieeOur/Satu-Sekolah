<x-public-layout title="Pengumuman Sekolah" metaDescription="Daftar pengumuman resmi dari manajemen Satu-Sekolah untuk siswa, orang tua, dan masyarakat umum.">
    <!-- Header Banner -->
    <div class="bg-navy text-white py-12 border-b border-navy-light/40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <span class="text-xs uppercase tracking-wider font-bold text-amber-400">Pemberitahuan Resmi</span>
            <h1 class="text-3xl font-extrabold text-white mt-1">Pengumuman Sekolah</h1>
            <p class="text-slate-300 text-xs sm:text-sm mt-1.5 max-w-2xl">Informasi penting terkait kalender akademik, jadwal operasional, dan edaran resmi.</p>
        </div>
    </div>

    <!-- Announcements List -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-4">
        @forelse ($announcements as $item)
            <div class="bg-surface rounded-xl border border-border p-6 shadow-xs hover:border-slate-300 transition space-y-3">
                <div class="flex items-center justify-between text-xs text-slate-400">
                    <span class="font-medium">{{ $item->published_at ? $item->published_at->translatedFormat('l, d F Y') : '' }}</span>
                    <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">Pengumuman</span>
                </div>

                <h2 class="text-base font-bold text-navy hover:text-brand transition">
                    <a href="{{ route('public.announcements.show', $item->slug) }}">
                        {{ $item->title }}
                    </a>
                </h2>

                <p class="text-xs text-slate-500 leading-relaxed">
                    {{ $item->excerpt ?? Str::limit(strip_tags($item->content), 140) }}
                </p>

                <div class="pt-2 flex items-center justify-between text-xs">
                    <span class="text-slate-400 text-[11px]">Diterbitkan oleh: {{ $item->author?->name ?? 'Tata Usaha' }}</span>
                    <a href="{{ route('public.announcements.show', $item->slug) }}" class="font-bold text-brand hover:underline">
                        Lihat Rincian &rarr;
                    </a>
                </div>
            </div>
        @empty
            <div class="p-12 text-center bg-surface rounded-2xl border border-border text-slate-400 text-sm">
                Belum ada pengumuman publik yang diterbitkan.
            </div>
        @endforelse

        @if ($announcements->hasPages())
            <div class="mt-8">
                {{ $announcements->links() }}
            </div>
        @endif
    </div>
</x-public-layout>
