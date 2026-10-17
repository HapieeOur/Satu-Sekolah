<x-public-layout title="Agenda Acara Sekolah">
    <!-- Header Banner -->
    <div class="relative bg-gradient-to-b from-violet-50/70 via-white to-slate-50 py-16 border-b border-border/80 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-2xl space-y-3">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-violet-50 text-violet-700 border border-violet-200/80">
                    Kalender Akademik
                </span>
                <h1 class="text-3xl sm:text-4xl font-black text-navy tracking-tight">Agenda &amp; Acara Sekolah</h1>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Jadwal kegiatan institusi, ujian semester, perlombaan vokasi, pameran karya siswa, dan pertemuan wali murid SatuSekolah.
                </p>
            </div>
        </div>
    </div>

    <!-- Events Listing -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($events as $item)
                <div class="group bg-white rounded-3xl border border-slate-200/90 p-6 sm:p-7 shadow-xs hover:shadow-card hover:-translate-y-1 transition-all duration-200 flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="flex items-start justify-between gap-3">
                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-violet-100 to-indigo-100 border border-violet-200/70 text-violet-700 flex flex-col items-center justify-center shrink-0 shadow-xs">
                                <span class="text-xl font-black leading-none">{{ $item->event_date ? $item->event_date->format('d') : '-' }}</span>
                                <span class="text-[10px] uppercase font-bold leading-none mt-1">{{ $item->event_date ? $item->event_date->format('M Y') : '-' }}</span>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-violet-50 text-violet-700 border border-violet-200/60">
                                Agenda
                            </span>
                        </div>

                        <div>
                            <h2 class="text-base sm:text-lg font-bold text-navy group-hover:text-violet-600 transition leading-snug line-clamp-2">
                                <a href="{{ route('public.events.show', $item->slug) }}">{{ $item->title }}</a>
                            </h2>

                            <div class="mt-3 space-y-1.5 text-xs text-slate-500">
                                <p class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-violet-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span class="truncate">{{ $item->event_location ?? 'Kampus Utama SatuSekolah' }}</span>
                                </p>
                                @if($item->event_time)
                                    <p class="flex items-center gap-2 font-mono text-[11px] text-slate-600">
                                        <svg class="w-4 h-4 text-violet-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span>{{ substr($item->event_time, 0, 5) }} WIB</span>
                                    </p>
                                @endif
                            </div>

                            <p class="text-xs text-slate-600 mt-3 line-clamp-3 leading-relaxed">
                                {{ $item->excerpt ?: Str::limit(strip_tags($item->content), 120) }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[11px] text-slate-400">Status: Dijadwalkan</span>
                        <a href="{{ route('public.events.show', $item->slug) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-violet-600 hover:underline">
                            <span>Detail Agenda</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 py-20 text-center text-slate-500 bg-white rounded-3xl border border-slate-200/80">
                    <svg class="w-12 h-12 mx-auto text-slate-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <p class="text-sm font-bold text-navy">Belum ada agenda acara saat ini.</p>
                    <p class="text-xs text-slate-400 mt-1">Jadwal kegiatan terbaru akan ditampilkan di sini.</p>
                </div>
            @endforelse
        </div>

        @if($events->hasPages())
            <div class="pt-8">
                {{ $events->links() }}
            </div>
        @endif
    </div>
</x-public-layout>
