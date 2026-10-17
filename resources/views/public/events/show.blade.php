<x-public-layout :title="$post->title">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
        <!-- Back Navigation -->
        <div>
            <a href="{{ route('public.events') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-600 hover:text-navy bg-white px-3.5 py-2 rounded-xl border border-slate-200/80 shadow-xs hover:border-slate-300 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Agenda Acara</span>
            </a>
        </div>

        <!-- Event Detail Card -->
        <article class="bg-white rounded-3xl border border-slate-200/90 p-6 sm:p-10 lg:p-12 shadow-sm space-y-8">
            <header class="space-y-4 pb-8 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-violet-50 text-violet-700 border border-violet-200/80">
                        Agenda Acara
                    </span>
                    <span class="text-xs text-slate-400 font-mono">
                        {{ $post->event_date ? $post->event_date->format('l, d F Y') : '-' }}
                    </span>
                </div>

                <h1 class="text-2xl sm:text-4xl font-black text-navy tracking-tight leading-tight">
                    {{ $post->title }}
                </h1>
                
                <!-- Event Info Bento Box -->
                <div class="p-5 rounded-2xl bg-gradient-to-br from-violet-50/60 to-indigo-50/40 border border-violet-100 grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-xl bg-violet-100 text-violet-700 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[10px] font-bold uppercase tracking-wider">Tanggal &amp; Waktu</span>
                            <span class="font-extrabold text-navy mt-0.5 block text-xs sm:text-sm">
                                {{ $post->event_date ? $post->event_date->format('d F Y') : 'Menunggu Konfirmasi' }}
                                @if($post->event_time)
                                    &bull; {{ substr($post->event_time, 0, 5) }} WIB
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-xl bg-indigo-100 text-brand flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[10px] font-bold uppercase tracking-wider">Lokasi / Ruang</span>
                            <span class="font-extrabold text-navy mt-0.5 block text-xs sm:text-sm">
                                {{ $post->event_location ?? 'Kampus Utama SatuSekolah' }}
                            </span>
                        </div>
                    </div>
                </div>
            </header>

            <div class="prose prose-slate max-w-none text-slate-700 text-sm sm:text-base leading-relaxed space-y-4">
                {!! $post->content !!}
            </div>

            <div class="pt-8 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-400">Harap hadir tepat waktu sesuai jadwal agenda.</span>
                <a href="{{ route('public.events') }}" class="text-xs font-bold text-violet-600 hover:underline">
                    &larr; Lihat Agenda Lainnya
                </a>
            </div>
        </article>
    </div>
</x-public-layout>
