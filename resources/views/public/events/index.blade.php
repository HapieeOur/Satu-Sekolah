<x-public-layout title="Agenda Acara Sekolah">
    <!-- Header Banner -->
    <div class="bg-navy text-white py-12 border-b border-navy-light/40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <span class="inline-flex items-center px-2.5 py-1 rounded text-xs font-semibold bg-purple-600 text-white mb-3">
                Kalender Kegiatan
            </span>
            <h1 class="text-3xl font-bold tracking-tight">Agenda &amp; Acara Sekolah</h1>
            <p class="text-xs sm:text-sm text-slate-300 mt-2 max-w-2xl">
                Jadwal kegiatan akademik, ujian, perlombaan, dan agenda pertemuan institusi.
            </p>
        </div>
    </div>

    <!-- Events Listing -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($events as $item)
                <div class="bg-white rounded-xl border border-border p-6 shadow-xs hover:border-brand/40 transition flex flex-col justify-between">
                    <div>
                        <div class="flex items-start justify-between gap-3 mb-4">
                            <div class="w-14 h-14 rounded-xl bg-purple-50 border border-purple-200 text-purple-700 flex flex-col items-center justify-center shrink-0">
                                <span class="text-base font-extrabold leading-none">{{ $item->event_date ? $item->event_date->format('d') : '-' }}</span>
                                <span class="text-[11px] uppercase font-bold leading-none mt-1">{{ $item->event_date ? $item->event_date->format('M Y') : '-' }}</span>
                            </div>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-purple-50 text-purple-700 border border-purple-200">
                                Agenda
                            </span>
                        </div>
                        <h2 class="text-base font-bold text-navy hover:text-brand transition">
                            <a href="{{ route('public.events.show', $item->slug) }}">{{ $item->title }}</a>
                        </h2>
                        <div class="mt-3 space-y-1 text-xs text-slate-500">
                            <p class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>{{ $item->event_location ?? 'Kampus Sekolah' }}</span>
                            </p>
                            @if($item->event_time)
                                <p class="flex items-center gap-1.5 font-mono">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>{{ substr($item->event_time, 0, 5) }} WIB</span>
                                </p>
                            @endif
                        </div>
                        <p class="text-xs text-slate-600 mt-3 line-clamp-2 leading-relaxed">
                            {{ $item->excerpt ?: Str::limit(strip_tags($item->content), 100) }}
                        </p>
                    </div>
                    <div class="mt-6 pt-3 border-t border-slate-100">
                        <a href="{{ route('public.events.show', $item->slug) }}" class="text-xs font-semibold text-brand hover:underline inline-flex items-center gap-1">
                            <span>Detail Agenda</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 py-16 text-center text-slate-500 bg-white rounded-xl border border-border">
                    Belum ada agenda acara yang dijadwalkan saat ini.
                </div>
            @endforelse
        </div>

        @if($events->hasPages())
            <div class="pt-6">
                {{ $events->links() }}
            </div>
        @endif
    </div>
</x-public-layout>
