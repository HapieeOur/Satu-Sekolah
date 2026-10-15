<x-public-layout :title="$post->title" :metaDescription="$post->excerpt ?? Str::limit(strip_tags($post->content), 150)">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('public.announcements.index') }}" class="text-xs font-semibold text-brand hover:underline inline-flex items-center gap-1">
                &larr; Kembali ke Daftar Pengumuman
            </a>
            <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                Pemberitahuan
            </span>
        </div>

        <article class="bg-surface rounded-2xl border border-border shadow-xs p-6 sm:p-10 space-y-6">
            <div class="space-y-3 pb-6 border-b border-border">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-navy leading-tight">
                    {{ $post->title }}
                </h1>
                <div class="flex flex-wrap items-center gap-4 text-xs text-slate-500">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Tanggal Edar: {{ $post->published_at ? $post->published_at->translatedFormat('l, d F Y') : '' }}
                    </span>
                    <span>•</span>
                    <span>Penanggung Jawab: {{ $post->author?->name ?? 'Tata Usaha' }}</span>
                </div>
            </div>

            <div class="prose max-w-none text-slate-700 text-sm leading-relaxed space-y-4">
                {!! nl2br(e($post->content)) !!}
            </div>

            <div class="pt-8 border-t border-border flex items-center justify-between text-xs text-slate-400">
                <p>Dokumen Resmi Sekolah</p>
                <a href="{{ route('public.announcements.index') }}" class="font-bold text-brand hover:underline">
                    Daftar Pengumuman Lainnya &rarr;
                </a>
            </div>
        </article>
    </div>
</x-public-layout>
