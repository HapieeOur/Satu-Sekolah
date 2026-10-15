<x-public-layout :title="$post->title" :metaDescription="$post->excerpt ?? Str::limit(strip_tags($post->content), 150)">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('public.events.index') }}" class="text-xs font-semibold text-brand hover:underline inline-flex items-center gap-1">
                &larr; Kembali ke Agenda Acara
            </a>
            <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-purple-50 text-purple-700 border border-purple-200">
                Agenda Kegiatan
            </span>
        </div>

        <article class="bg-surface rounded-2xl border border-border shadow-xs p-6 sm:p-10 space-y-8">
            <div class="space-y-4 pb-6 border-b border-border">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-navy leading-tight">
                    {{ $post->title }}
                </h1>

                <!-- Event Details Badge Bar -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 p-4 bg-canvas rounded-xl border border-border text-xs">
                    <div>
                        <span class="text-slate-400 block text-[10px] uppercase font-bold tracking-wider">Tanggal</span>
                        <span class="font-bold text-navy text-sm">
                            {{ $post->event_date ? $post->event_date->translatedFormat('d F Y') : 'Menyusul' }}
                        </span>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[10px] uppercase font-bold tracking-wider">Waktu Pelaksanaan</span>
                        <span class="font-bold text-navy text-sm">
                            {{ $post->event_time ? date('H:i', strtotime($post->event_time)) . ' WIB' : 'Menyusul' }}
                        </span>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[10px] uppercase font-bold tracking-wider">Lokasi Acara</span>
                        <span class="font-bold text-navy text-sm truncate block">
                            {{ $post->event_location ?? 'Kampus Utama' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Content Description -->
            <div class="space-y-2">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Deskripsi Acara</h3>
                <div class="prose max-w-none text-slate-700 text-sm leading-relaxed space-y-4">
                    {!! nl2br(e($post->content)) !!}
                </div>
            </div>

            <div class="pt-8 border-t border-border flex items-center justify-between text-xs text-slate-400">
                <p>Acara Resmi Sekolah</p>
                <a href="{{ route('public.events.index') }}" class="font-bold text-brand hover:underline">
                    Daftar Acara Lainnya &rarr;
                </a>
            </div>
        </article>
    </div>
</x-public-layout>
