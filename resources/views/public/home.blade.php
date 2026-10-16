<x-public-layout title="Beranda">
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-b from-blue-50/60 to-transparent py-16 lg:py-24 border-b border-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-7 space-y-6">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-brand border border-blue-200">
                        <span class="w-2 h-2 rounded-full bg-brand animate-pulse"></span>
                        Portal Resmi Sistem Informasi Satu-Sekolah
                    </div>
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-navy tracking-tight leading-tight">
                        Transformasi Digital Manajemen Pendidikan & Monitoring PKL
                    </h1>
                    <p class="text-sm sm:text-base text-slate-600 leading-relaxed max-w-2xl">
                        Platform terintegrasi untuk pengelolaan administrasi akademik, jadwal pelajaran terstruktur, rekapitulasi kehadiran, serta pemantauan aktivitas Praktik Kerja Lapangan berbasis geofence dan bukti nyata.
                    </p>
                    <div class="flex flex-wrap items-center gap-3 pt-2">
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-5 py-3 text-sm font-bold text-white bg-navy hover:bg-navy-light rounded-xl shadow-sm transition">
                            <span>Masuk Portal Guru & Admin</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                        <a href="{{ route('public.profile') }}" class="inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-border rounded-xl shadow-xs transition">
                            <span>Pelajari Profil Sekolah</span>
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-5">
                    <!-- School Stats & Highlights Card -->
                    <div class="bg-white rounded-2xl border border-border p-6 shadow-sm space-y-6">
                        <h2 class="text-xs font-bold uppercase tracking-wider text-navy border-b border-border pb-3">Ringkasan Institusi</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-4 rounded-xl bg-slate-50 border border-border/80">
                                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">Status Akreditasi</span>
                                <span class="text-2xl font-extrabold text-navy mt-1 block">A (Unggul)</span>
                                <span class="text-[11px] text-emerald-700 font-medium">BAN-S/M Nasional</span>
                            </div>
                            <div class="p-4 rounded-xl bg-slate-50 border border-border/80">
                                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">Program Studi</span>
                                <span class="text-2xl font-extrabold text-navy mt-1 block">Kejuruan</span>
                                <span class="text-[11px] text-slate-600 font-medium">RPL &amp; TKJ Terpadu</span>
                            </div>
                            <div class="p-4 rounded-xl bg-slate-50 border border-border/80">
                                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">Mitra Industri</span>
                                <span class="text-2xl font-extrabold text-navy mt-1 block">Terakreditasi</span>
                                <span class="text-[11px] text-slate-600 font-medium">Kemitraan DUDI PKL</span>
                            </div>
                            <div class="p-4 rounded-xl bg-slate-50 border border-border/80">
                                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">Monitoring PKL</span>
                                <span class="text-2xl font-extrabold text-emerald-700 mt-1 block">Real-Time</span>
                                <span class="text-[11px] text-slate-600 font-medium">GPS Geofence + Foto</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest News & Announcements Section -->
    <section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
        <!-- News Grid -->
        <div>
            <div class="flex items-center justify-between mb-8">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-brand block mb-1">Informasi Terkini</span>
                    <h2 class="text-2xl font-bold text-navy">Kabar &amp; Berita Sekolah</h2>
                </div>
                <a href="{{ route('public.news') }}" class="text-xs font-bold text-brand hover:underline inline-flex items-center gap-1">
                    <span>Lihat Semua Berita</span>
                    <span>&rarr;</span>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($latestNews as $news)
                    <article class="bg-white rounded-xl border border-border overflow-hidden shadow-xs hover:shadow-md transition flex flex-col justify-between">
                        <div>
                            @if($news->featured_image)
                                <img src="{{ asset('storage/' . $news->featured_image) }}" alt="{{ $news->title }}" class="w-full h-44 object-cover">
                            @else
                                <div class="w-full h-44 bg-slate-100 border-b border-border flex items-center justify-center text-slate-400">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                </div>
                            @endif
                            <div class="p-5">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-blue-50 text-brand border border-blue-200">
                                        Berita
                                    </span>
                                    <span class="text-[11px] text-slate-400 font-mono">
                                        {{ $news->published_at ? $news->published_at->format('d/m/Y') : '-' }}
                                    </span>
                                </div>
                                <h3 class="text-base font-bold text-navy hover:text-brand transition line-clamp-2">
                                    <a href="{{ route('public.news.show', $news->slug) }}">{{ $news->title }}</a>
                                </h3>
                                <p class="text-xs text-slate-600 mt-2 line-clamp-3">
                                    {{ $news->excerpt ?: Str::limit(strip_tags($news->content), 120) }}
                                </p>
                            </div>
                        </div>
                        <div class="px-5 pb-5 pt-0">
                            <a href="{{ route('public.news.show', $news->slug) }}" class="text-xs font-semibold text-brand hover:underline inline-flex items-center gap-1">
                                <span>Baca Selengkapnya</span>
                                <span>&rarr;</span>
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="col-span-3 py-12 text-center text-slate-500 bg-white rounded-xl border border-border">
                        Belum ada berita resmi yang dipublikasikan.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Announcements & Events Two-Column -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Announcements -->
            <div class="bg-white rounded-xl border border-border p-6 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-4 border-b border-border mb-4">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-amber-700 block">Papan Pengumuman</span>
                            <h2 class="text-lg font-bold text-navy">Pengumuman Resmi</h2>
                        </div>
                        <a href="{{ route('public.announcements') }}" class="text-xs font-bold text-brand hover:underline">
                            Semua &rarr;
                        </a>
                    </div>

                    <div class="space-y-4">
                        @forelse($announcements as $announcement)
                            <div class="p-3.5 rounded-lg bg-slate-50 border border-border/80 hover:bg-slate-100/75 transition">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                        Penting
                                    </span>
                                    <span class="text-[11px] text-slate-400 font-mono">
                                        {{ $announcement->published_at ? $announcement->published_at->format('d/m/Y') : '-' }}
                                    </span>
                                </div>
                                <h4 class="text-xs font-bold text-navy hover:text-brand transition">
                                    <a href="{{ route('public.announcements.show', $announcement->slug) }}">{{ $announcement->title }}</a>
                                </h4>
                                <p class="text-[11px] text-slate-600 mt-1 line-clamp-2">
                                    {{ $announcement->excerpt ?: Str::limit(strip_tags($announcement->content), 100) }}
                                </p>
                            </div>
                        @empty
                            <p class="text-xs text-slate-500 py-6 text-center">Belum ada pengumuman saat ini.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Upcoming Events -->
            <div class="bg-white rounded-xl border border-border p-6 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-4 border-b border-border mb-4">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-purple-700 block">Kalender Akademik</span>
                            <h2 class="text-lg font-bold text-navy">Agenda &amp; Acara Mendatang</h2>
                        </div>
                        <a href="{{ route('public.events') }}" class="text-xs font-bold text-brand hover:underline">
                            Semua &rarr;
                        </a>
                    </div>

                    <div class="space-y-4">
                        @forelse($upcomingEvents as $event)
                            <div class="p-3.5 rounded-lg bg-slate-50 border border-border/80 flex items-start gap-4 hover:bg-slate-100/75 transition">
                                <div class="w-12 h-12 rounded-lg bg-purple-50 border border-purple-200 text-purple-700 flex flex-col items-center justify-center shrink-0">
                                    <span class="text-xs font-bold leading-none">{{ $event->event_date ? $event->event_date->format('d') : '-' }}</span>
                                    <span class="text-[10px] uppercase font-semibold leading-none mt-1">{{ $event->event_date ? $event->event_date->format('M') : '-' }}</span>
                                </div>
                                <div class="space-y-1 min-w-0">
                                    <h4 class="text-xs font-bold text-navy hover:text-brand transition truncate">
                                        <a href="{{ route('public.events.show', $event->slug) }}">{{ $event->title }}</a>
                                    </h4>
                                    <p class="text-[11px] text-slate-500 flex items-center gap-2">
                                        <span>Lokasi: {{ $event->event_location ?? 'Kampus Sekolah' }}</span>
                                        @if($event->event_time)
                                            <span>&bull; {{ substr($event->event_time, 0, 5) }} WIB</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-slate-500 py-6 text-center">Tidak ada agenda acara terdekat.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-public-layout>
