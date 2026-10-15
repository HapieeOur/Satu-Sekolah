<x-public-layout title="Beranda" metaDescription="Selamat datang di website resmi Satu-Sekolah. Pusat informasi akademik, profil sekolah, berita kegiatan, dan pengumuman resmi.">
    <!-- HERO SECTION -->
    <section class="relative bg-navy text-white overflow-hidden py-20 lg:py-28 border-b border-navy-light/40">
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0,0 L100,0 L100,100 L0,100 Z" fill="none" stroke="currentColor" stroke-width="0.5" stroke-dasharray="2,2"/>
                <circle cx="50" cy="50" r="40" fill="none" stroke="currentColor" stroke-width="0.5"/>
            </svg>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-7 space-y-6">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-brand/20 border border-brand/40 text-blue-200 text-xs font-semibold">
                        <span class="w-2 h-2 rounded-full bg-blue-400"></span>
                        Portal Resmi Institusi Pendidikan
                    </div>
                    <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight leading-tight text-white">
                        Membina Generasi Cerdas, Berkarakter, dan Siap Bersaing di Era Digital
                    </h1>
                    <p class="text-slate-300 text-base sm:text-lg leading-relaxed max-w-2xl">
                        Satu-Sekolah mewujudkan ekosistem manajemen sekolah terpadu yang menghubungkan kurikulum akademik berkualitas, monitoring Praktik Kerja Lapangan (PKL) industri terpercaya, dan transparansi administrasi.
                    </p>
                    <div class="pt-2 flex flex-wrap gap-4">
                        <a href="{{ route('public.profile') }}" class="px-6 py-3 rounded-lg bg-brand hover:bg-brand-hover text-white text-sm font-bold shadow-md transition inline-flex items-center gap-2">
                            <span>Pelajari Profil Sekolah</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                        <a href="{{ route('public.news.index') }}" class="px-6 py-3 rounded-lg bg-navy-light/60 hover:bg-navy-light text-slate-200 border border-slate-600 text-sm font-semibold transition">
                            Lihat Berita Kegiatan
                        </a>
                    </div>
                </div>

                <!-- Hero Graphic Card -->
                <div class="lg:col-span-5">
                    <div class="bg-surface/10 backdrop-blur-md rounded-2xl border border-white/10 p-6 sm:p-8 space-y-6 shadow-xl">
                        <div class="border-b border-white/10 pb-4">
                            <span class="text-xs uppercase tracking-wider font-bold text-blue-300">Satu Platform Terpadu</span>
                            <h3 class="text-xl font-bold text-white mt-1">Layanan Manajemen Pendidikan</h3>
                        </div>

                        <div class="space-y-4 text-xs">
                            <div class="flex items-start gap-3.5 p-3 rounded-xl bg-white/5 border border-white/10">
                                <div class="w-8 h-8 rounded-lg bg-brand flex items-center justify-center shrink-0 text-white font-bold">
                                    1
                                </div>
                                <div>
                                    <h4 class="font-bold text-white text-sm">Akademik & Jadwal Pelajaran</h4>
                                    <p class="text-slate-300 mt-0.5">Penjadwalan terstruktur dan bebas konflik untuk seluruh kelas dan guru.</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3.5 p-3 rounded-xl bg-white/5 border border-white/10">
                                <div class="w-8 h-8 rounded-lg bg-emerald-600 flex items-center justify-center shrink-0 text-white font-bold">
                                    2
                                </div>
                                <div>
                                    <h4 class="font-bold text-white text-sm">Monitoring PKL Industri</h4>
                                    <p class="text-slate-300 mt-0.5">Pengawasan kegiatan magang, presensi foto & GPS, dan jurnal harian terverifikasi.</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3.5 p-3 rounded-xl bg-white/5 border border-white/10">
                                <div class="w-8 h-8 rounded-lg bg-amber-600 flex items-center justify-center shrink-0 text-white font-bold">
                                    3
                                </div>
                                <div>
                                    <h4 class="font-bold text-white text-sm">Aplikasi Mobile Siswa</h4>
                                    <p class="text-slate-300 mt-0.5">Khusus siswa untuk absensi terverifikasi dan pelaporan jurnal lapangan.</p>
                                </div>
                            </div>
                        </div>

                        <div class="pt-2">
                            <a href="{{ route('login') }}" class="w-full text-center block py-2.5 px-4 rounded-lg bg-white text-navy font-bold text-xs hover:bg-slate-100 transition shadow-sm">
                                Masuk Portal Pendidik & Staf
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4 PILAR UTAMA SEKOLAH -->
    <section class="py-16 bg-surface border-b border-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="text-xs font-bold uppercase tracking-wider text-brand">Komitmen Institusi</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-navy mt-1.5">Pilar Keunggulan Sekolah</h2>
                <p class="text-slate-500 text-sm mt-2">Fondasi utama dalam membentuk lingkungan belajar yang aman, produktif, dan siap kerja.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="p-6 rounded-xl bg-canvas border border-border shadow-xs hover:border-brand/40 transition">
                    <div class="w-10 h-10 rounded-lg bg-blue-50 text-brand flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <h3 class="font-bold text-navy text-base mb-1.5">Akademik Terstandar</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Kurikulum yang adaptif, tenaga pendidik bersertifikasi, dan pengajaran berbasis kompetensi praktis.</p>
                </div>

                <div class="p-6 rounded-xl bg-canvas border border-border shadow-xs hover:border-brand/40 transition">
                    <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="font-bold text-navy text-base mb-1.5">Kemitraan DUDI Luas</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Jejaring industri resmi untuk pelaksanaan Praktik Kerja Lapangan dan penyerapan lulusan kerja.</p>
                </div>

                <div class="p-6 rounded-xl bg-canvas border border-border shadow-xs hover:border-brand/40 transition">
                    <div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="font-bold text-navy text-base mb-1.5">Karakter & Kedisiplinan</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Penanaman integritas, tanggung jawab kerja, budi pekerti, dan kepemimpinan berakhlak mulia.</p>
                </div>

                <div class="p-6 rounded-xl bg-canvas border border-border shadow-xs hover:border-brand/40 transition">
                    <div class="w-10 h-10 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="font-bold text-navy text-base mb-1.5">Digitalisasi Sekolah</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Administrasi terpadu dengan pelaporan presensi otomatis dan keamanan data tersertifikasi.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- BERITA TERBARU & PENGUMUMAN PENTING -->
    <section class="py-16 bg-canvas">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                <!-- Berita Terbaru (8 Cols) -->
                <div class="lg:col-span-8 space-y-6">
                    <div class="flex items-center justify-between border-b border-border pb-4">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-brand">Warta Sekolah</span>
                            <h2 class="text-xl sm:text-2xl font-bold text-navy">Kabar & Berita Terkini</h2>
                        </div>
                        <a href="{{ route('public.news.index') }}" class="text-xs font-bold text-brand hover:underline">
                            Lihat Semua Berita &rarr;
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @forelse ($latestNews as $news)
                            <article class="bg-surface rounded-xl border border-border shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition">
                                <div class="p-5 space-y-3">
                                    <div class="flex items-center justify-between text-xs text-slate-400">
                                        <span class="font-medium">{{ $news->published_at ? $news->published_at->translatedFormat('d M Y') : 'Baru' }}</span>
                                        <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-blue-50 text-brand">Berita</span>
                                    </div>
                                    <h3 class="font-bold text-navy text-base line-clamp-2 hover:text-brand transition">
                                        <a href="{{ route('public.news.show', $news->slug) }}">{{ $news->title }}</a>
                                    </h3>
                                    <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed">
                                        {{ $news->excerpt ?? Str::limit(strip_tags($news->content), 120) }}
                                    </p>
                                </div>
                                <div class="px-5 py-3 bg-canvas/60 border-t border-border flex items-center justify-between">
                                    <span class="text-[11px] text-slate-400">Penulis: {{ $news->author?->name ?? 'Admin Sekolah' }}</span>
                                    <a href="{{ route('public.news.show', $news->slug) }}" class="text-xs font-bold text-brand hover:underline">
                                        Baca Selengkapnya
                                    </a>
                                </div>
                            </article>
                        @empty
                            <div class="col-span-2 p-8 text-center bg-surface rounded-xl border border-border text-slate-400 text-xs">
                                Belum ada berita yang diterbitkan saat ini.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Pengumuman Publik (4 Cols) -->
                <div class="lg:col-span-4 space-y-6">
                    <div class="flex items-center justify-between border-b border-border pb-4">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-amber-600">Pemberitahuan</span>
                            <h2 class="text-xl sm:text-2xl font-bold text-navy">Pengumuman</h2>
                        </div>
                        <a href="{{ route('public.announcements.index') }}" class="text-xs font-bold text-brand hover:underline">
                            Semua &rarr;
                        </a>
                    </div>

                    <div class="space-y-4">
                        @forelse ($announcements as $announcement)
                            <div class="bg-surface p-4 rounded-xl border border-border shadow-xs hover:border-slate-300 transition space-y-2">
                                <div class="flex items-center justify-between text-[11px] text-slate-400">
                                    <span class="font-medium">{{ $announcement->published_at ? $announcement->published_at->translatedFormat('d F Y') : '' }}</span>
                                    <span class="px-1.5 py-0.5 rounded bg-amber-50 text-amber-700 font-semibold text-[10px]">Penting</span>
                                </div>
                                <h4 class="font-bold text-navy text-xs leading-snug hover:text-brand transition">
                                    <a href="{{ route('public.announcements.show', $announcement->slug) }}">
                                        {{ $announcement->title }}
                                    </a>
                                </h4>
                                <p class="text-[11px] text-slate-500 line-clamp-2">
                                    {{ $announcement->excerpt ?? Str::limit(strip_tags($announcement->content), 80) }}
                                </p>
                            </div>
                        @empty
                            <div class="p-6 text-center bg-surface rounded-xl border border-border text-slate-400 text-xs">
                                Tidak ada pengumuman publik saat ini.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- AGENDA ACARA SEKOLAH MENDATANG -->
    <section class="py-16 bg-surface border-t border-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-10 gap-4">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-purple-600">Kalender Kegiatan</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-navy mt-1">Agenda Acara Sekolah</h2>
                    <p class="text-slate-500 text-xs sm:text-sm mt-1">Rangkaian acara resmi, expo industri, dan kegiatan siswa mendatang.</p>
                </div>
                <a href="{{ route('public.events.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-brand hover:underline shrink-0">
                    Lihat Kalender Lengkap &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse ($upcomingEvents as $event)
                    <div class="p-5 rounded-xl bg-canvas border border-border shadow-xs flex flex-col justify-between hover:border-slate-300 transition">
                        <div class="space-y-3">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-navy text-white flex flex-col items-center justify-center shrink-0">
                                    <span class="text-xs font-bold leading-none">{{ $event->event_date ? $event->event_date->format('d') : '—' }}</span>
                                    <span class="text-[10px] uppercase font-semibold leading-none mt-0.5 text-blue-200">{{ $event->event_date ? $event->event_date->format('M') : 'Acara' }}</span>
                                </div>
                                <div>
                                    <span class="text-[11px] text-slate-400 font-medium block">
                                        {{ $event->event_time ? date('H:i', strtotime($event->event_time)) . ' WIB' : 'Waktu menyusul' }}
                                    </span>
                                    <span class="text-[11px] text-slate-600 font-semibold block truncate">
                                        {{ $event->event_location ?? 'Kampus Utama' }}
                                    </span>
                                </div>
                            </div>

                            <h3 class="font-bold text-navy text-sm leading-snug">
                                <a href="{{ route('public.events.show', $event->slug) }}" class="hover:text-brand transition">
                                    {{ $event->title }}
                                </a>
                            </h3>

                            <p class="text-xs text-slate-500 line-clamp-2">
                                {{ $event->excerpt ?? Str::limit(strip_tags($event->content), 100) }}
                            </p>
                        </div>

                        <div class="mt-4 pt-3 border-t border-border/80">
                            <a href="{{ route('public.events.show', $event->slug) }}" class="text-xs font-bold text-brand hover:underline inline-flex items-center gap-1">
                                Detail Acara &rarr;
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 p-10 text-center bg-canvas rounded-xl border border-border text-slate-400 text-xs">
                        Belum ada agenda kegiatan mendatang yang dijadwalkan.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- BANNER KHUSUS GURU & ADMIN -->
    <section class="py-14 bg-navy-light text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-white">Portal Tenaga Pendidik & Administrasi</h2>
            <p class="text-xs sm:text-sm text-slate-300 max-w-xl mx-auto">
                Akses manajemen data siswa, jadwal mengajar, dan supervisi monitoring siswa PKL diperuntukkan khusus bagi Dewan Guru dan Administrator.
            </p>
            <div class="pt-2">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-brand hover:bg-brand-hover text-white text-xs font-bold shadow-md transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    Masuk ke Portal Internal Sekolah
                </a>
            </div>
        </div>
    </section>
</x-public-layout>
