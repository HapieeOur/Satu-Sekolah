<x-public-layout :title="$post->title" :metaDescription="$post->excerpt ?? Str::limit(strip_tags($post->content), 150)">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Breadcrumb & Back -->
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('public.news.index') }}" class="text-xs font-semibold text-brand hover:underline inline-flex items-center gap-1">
                &larr; Kembali ke Daftar Berita
            </a>
            <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-blue-50 text-brand border border-blue-200">
                Warta Sekolah
            </span>
        </div>

        <!-- Article Card -->
        <article class="bg-surface rounded-2xl border border-border shadow-xs p-6 sm:p-10 space-y-6">
            <div class="space-y-3 pb-6 border-b border-border">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-navy leading-tight">
                    {{ $post->title }}
                </h1>
                <div class="flex flex-wrap items-center gap-4 text-xs text-slate-500">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ $post->published_at ? $post->published_at->translatedFormat('l, d F Y') : 'Baru' }}
                    </span>
                    <span>•</span>
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Oleh: {{ $post->author?->name ?? 'Administrator' }}
                    </span>
                </div>
            </div>

            <!-- Content Body -->
            <div class="prose max-w-none text-slate-700 text-sm leading-relaxed space-y-4">
                {!! nl2br(e($post->content)) !!}
            </div>

            <!-- Bottom Share / Info -->
            <div class="pt-8 border-t border-border flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-xs text-slate-400">
                <p>Kategori: <strong class="text-slate-600 capitalize">{{ $post->category }}</strong></p>
                <a href="{{ route('public.news.index') }}" class="font-bold text-brand hover:underline">
                    Lihat Berita Lainnya &rarr;
                </a>
            </div>
        </article>
    </div>
</x-public-layout>
