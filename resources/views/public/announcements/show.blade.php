<x-public-layout :title="$post->title">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
        <!-- Back Navigation -->
        <div>
            <a href="{{ route('public.announcements') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600 hover:text-navy transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Papan Pengumuman</span>
            </a>
        </div>

        <!-- Article Card -->
        <article class="bg-white rounded-2xl border border-border p-6 sm:p-10 shadow-xs space-y-6">
            <header class="space-y-3 pb-6 border-b border-border">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded text-[11px] font-bold uppercase tracking-wider bg-amber-50 text-amber-800 border border-amber-200">
                        Pengumuman
                    </span>
                    <span class="text-xs text-slate-400 font-mono">
                        {{ $post->published_at ? $post->published_at->format('l, d F Y') : '-' }}
                    </span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-navy tracking-tight leading-tight">
                    {{ $post->title }}
                </h1>
                <p class="text-xs text-slate-500">
                    Otoritas Penerbit: <span class="font-semibold text-slate-700">{{ $post->author?->name ?? 'Admin Sekolah' }}</span>
                </p>
            </header>

            <div class="prose max-w-none text-slate-700 text-sm leading-relaxed space-y-4">
                {!! $post->content !!}
            </div>
        </article>
    </div>
</x-public-layout>
