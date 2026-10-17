<x-public-layout :title="$post->title">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
        <!-- Back Navigation Breadcrumb -->
        <div>
            <a href="{{ route('public.news') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-600 hover:text-brand bg-white px-3.5 py-2 rounded-xl border border-slate-200/80 shadow-xs hover:border-brand/40 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Warta Sekolah</span>
            </a>
        </div>

        <!-- Article Card -->
        <article class="bg-white rounded-3xl border border-slate-200/90 p-6 sm:p-10 lg:p-12 shadow-sm space-y-8">
            <header class="space-y-4 pb-8 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-indigo-50 text-brand border border-indigo-200/60">
                        Warta Resmi
                    </span>
                    <span class="text-xs text-slate-400 font-mono">
                        {{ $post->published_at ? $post->published_at->format('l, d F Y') : '-' }}
                    </span>
                </div>

                <h1 class="text-2xl sm:text-4xl font-black text-navy tracking-tight leading-tight">
                    {{ $post->title }}
                </h1>

                <div class="flex items-center gap-3 pt-2">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-brand to-violet-500 text-white flex items-center justify-center font-bold text-xs uppercase shadow-xs">
                        {{ substr($post->author?->name ?? 'Admin', 0, 2) }}
                    </div>
                    <div>
                        <p class="text-xs font-bold text-navy">{{ $post->author?->name ?? 'Humas SatuSekolah' }}</p>
                        <p class="text-[11px] text-slate-400">Tim Publikasi &amp; Komunikasi Institusi</p>
                    </div>
                </div>
            </header>

            @if($post->featured_image)
                <div class="rounded-2xl overflow-hidden border border-slate-200/80 shadow-xs">
                    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full max-h-[460px] object-cover">
                </div>
            @endif

            <div class="prose prose-slate max-w-none text-slate-700 text-sm sm:text-base leading-relaxed space-y-4">
                {!! $post->content !!}
            </div>

            <!-- Share / Return Footer -->
            <div class="pt-8 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-400">Terima kasih telah membaca publikasi resmi SatuSekolah.</span>
                <a href="{{ route('public.news') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-brand hover:underline">
                    <span>Lihat Berita Lainnya</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </article>
    </div>
</x-public-layout>
