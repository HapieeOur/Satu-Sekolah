<x-public-layout title="Agenda Acara Sekolah" metaDescription="Kalender kegiatan resmi, workshop industri, dan agenda acara penting di lingkungan Satu-Sekolah.">
    <!-- Header Banner -->
    <div class="bg-navy text-white py-12 border-b border-navy-light/40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <span class="text-xs uppercase tracking-wider font-bold text-purple-400">Kalender Kegiatan</span>
            <h1 class="text-3xl font-extrabold text-white mt-1">Agenda Acara Sekolah</h1>
            <p class="text-slate-300 text-xs sm:text-sm mt-1.5 max-w-2xl">Rangkaian acara akademik, expo kemitraan industri, dan seminar pengembangan siswa.</p>
        </div>
    </div>

    <!-- Events Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($events as $event)
                <div class="p-6 rounded-2xl bg-surface border border-border shadow-xs flex flex-col justify-between hover:border-slate-300 transition">
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-14 h-14 rounded-xl bg-navy text-white flex flex-col items-center justify-center shrink-0">
                                <span class="text-base font-extrabold leading-none">{{ $event->event_date ? $event->event_date->format('d') : '—' }}</span>
                                <span class="text-[10px] uppercase font-bold leading-none mt-1 text-blue-200">{{ $event->event_date ? $event->event_date->format('M Y') : 'Acara' }}</span>
                            </div>
                            <div class="text-xs">
                                <span class="text-slate-400 block font-medium">
                                    {{ $event->event_time ? date('H:i', strtotime($event->event_time)) . ' WIB' : 'Waktu menyusul' }}
                                </span>
                                <span class="text-slate-700 font-bold block truncate">
                                    {{ $event->event_location ?? 'Kampus Sekolah' }}
                                </span>
                            </div>
                        </div>

                        <h2 class="font-bold text-navy text-base leading-snug hover:text-brand transition">
                            <a href="{{ route('public.events.show', $event->slug) }}">
                                {{ $event->title }}
                            </a>
                        </h2>

                        <p class="text-xs text-slate-500 leading-relaxed line-clamp-3">
                            {{ $event->excerpt ?? Str::limit(strip_tags($event->content), 120) }}
                        </p>
                    </div>

                    <div class="mt-6 pt-4 border-t border-border flex items-center justify-between text-xs">
                        <span class="text-slate-400 text-[11px]">Terbuka</span>
                        <a href="{{ route('public.events.show', $event->slug) }}" class="font-bold text-brand hover:underline">
                            Rincian Acara &rarr;
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 p-12 text-center bg-surface rounded-2xl border border-border text-slate-400 text-sm">
                    Belum ada agenda acara mendatang yang dijadwalkan saat ini.
                </div>
            @endforelse
        </div>

        @if ($events->hasPages())
            <div class="mt-8">
                {{ $events->links() }}
            </div>
        @endif
    </div>
</x-public-layout>
