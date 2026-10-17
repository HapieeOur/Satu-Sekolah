<x-public-layout title="Beranda">
    <!-- Hero Section -->
    <section class="relative hero-pattern pt-12 pb-20 lg:pt-20 lg:pb-28 border-b border-border/80 overflow-hidden">
        <!-- Floating Ambient Glows -->
        <div class="absolute top-1/4 -left-20 w-80 h-80 bg-brand/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-10 right-0 w-96 h-96 bg-violet-500/10 rounded-full blur-3xl pointer-events-none">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">

                <!-- Hero Left: Text & CTA -->
                <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                    <div
                        class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-bold bg-white text-brand border border-indigo-100 shadow-xs">
                        <span class="w-2 h-2 rounded-full bg-brand animate-pulse"></span>
                        <span>Portal Resmi Sistem Informasi Satu-Sekolah</span>
                        <span class="text-slate-300">•</span>
                        <span class="text-slate-500 font-semibold">T.A. 2026/2027</span>
                    </div>

                    <h1 class="text-3xl sm:text-5xl lg:text-5xl font-black text-navy tracking-tight leading-[1.15]">
                        Transformasi Digital <br class="hidden sm:inline">
                        <span
                            class="bg-gradient-to-r from-brand via-indigo-600 to-violet-600 bg-clip-text text-transparent">Pendidikan
                            Vokasi</span> Unggul &amp; Mandiri
                    </h1>

                    <p
                        class="text-sm sm:text-base text-slate-600 leading-relaxed max-w-2xl mx-auto lg:mx-0 font-normal">
                        Platform terintegrasi satu pintu untuk administrasi pembelajaran, presensi digital presisi,
                        transparansi nilai, serta pemantauan Praktik Kerja Lapangan (PKL) berbasis GPS geofence dan
                        bukti foto harian.
                    </p>

                    <div class="flex flex-wrap items-center justify-center lg:justify-start gap-3.5 pt-2">
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center gap-2.5 px-6 py-3.5 text-xs sm:text-sm font-bold text-white bg-gradient-to-r from-brand via-indigo-600 to-violet-600 hover:from-brand-hover hover:to-violet-700 rounded-xl shadow-md hover:shadow-glow hover:-translate-y-0.5 transition-all duration-200">
                            <span>Masuk Portal Guru & Admin</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                        <a href="{{ route('public.profile') }}"
                            class="inline-flex items-center gap-2 px-5 py-3.5 text-xs sm:text-sm font-bold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200/90 rounded-xl shadow-xs hover:border-slate-300 transition-all duration-150">
                            <span>Pelajari Profil Sekolah</span>
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>

                    <!-- Trust Indicators -->
                    <div
                        class="pt-4 flex flex-wrap items-center justify-center lg:justify-start gap-6 text-xs text-slate-500 font-medium">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span>Terakreditasi A Nasional</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-5 h-5 rounded-full bg-indigo-100 text-brand flex items-center justify-center">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span>Kurikulum Berbasis Industri (DUDI)</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div
                                class="w-5 h-5 rounded-full bg-violet-100 text-violet-600 flex items-center justify-center">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span>Geofencing Presensi PKL</span>
                        </div>
                    </div>
                </div>

                <!-- Hero Right: Modern Bento Grid Showcase -->
                <div class="lg:col-span-5">
                    <div
                        class="bg-white/90 backdrop-blur-md rounded-3xl border border-slate-200/80 p-6 sm:p-7 shadow-xl shadow-slate-200/50 space-y-5">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div>
                                <h3 class="text-xs font-bold uppercase tracking-wider text-navy">Indikator Mutu &amp;
                                    Capaian</h3>
                                <p class="text-[11px] text-slate-400">Ringkasan operasional SatuSekolah</p>
                            </div>
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                Real-Time Sync
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-3.5">
                            <!-- Card 1 -->
                            <div
                                class="p-4 rounded-2xl bg-gradient-to-br from-indigo-50/80 to-slate-50 border border-indigo-100/60 hover:shadow-xs transition">
                                <div
                                    class="w-8 h-8 rounded-xl bg-brand text-white flex items-center justify-center shadow-xs mb-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">Status
                                    Akreditasi</span>
                                <span class="text-xl font-extrabold text-navy mt-0.5 block">A (Unggul)</span>
                                <span class="text-[10px] text-indigo-600 font-semibold mt-0.5 block">BAN-S/M
                                    Kemendikbud</span>
                            </div>

                            <!-- Card 2 -->
                            <div
                                class="p-4 rounded-2xl bg-gradient-to-br from-violet-50/80 to-slate-50 border border-violet-100/60 hover:shadow-xs transition">
                                <div
                                    class="w-8 h-8 rounded-xl bg-violet-600 text-white flex items-center justify-center shadow-xs mb-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <span
                                    class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">Program
                                    Studi</span>
                                <span class="text-xl font-extrabold text-navy mt-0.5 block">RPL &amp; TKJ</span>
                                <span class="text-[10px] text-violet-600 font-semibold mt-0.5 block">Rekayasa &amp;
                                    Jaringan</span>
                            </div>

                            <!-- Card 3 -->
                            <div
                                class="p-4 rounded-2xl bg-gradient-to-br from-emerald-50/80 to-slate-50 border border-emerald-100/60 hover:shadow-xs transition">
                                <div
                                    class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center shadow-xs mb-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <span
                                    class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">Geofence
                                    PKL</span>
                                <span class="text-xl font-extrabold text-emerald-700 mt-0.5 block">100 M Radius</span>
                                <span class="text-[10px] text-emerald-600 font-semibold mt-0.5 block">Akurasi GPS
                                    Presisi</span>
                            </div>

                            <!-- Card 4 -->
                            <div
                                class="p-4 rounded-2xl bg-gradient-to-br from-amber-50/80 to-slate-50 border border-amber-100/60 hover:shadow-xs transition">
                                <div
                                    class="w-8 h-8 rounded-xl bg-amber-500 text-white flex items-center justify-center shadow-xs mb-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">Mitra
                                    Industri</span>
                                <span class="text-xl font-extrabold text-navy mt-0.5 block">DUDI Aktif</span>
                                <span class="text-[10px] text-amber-700 font-semibold mt-0.5 block">Software House &amp;
                                    ISP</span>
                            </div>
                        </div>

                        <!-- Live Pulse Banner -->
                        <div class="p-3.5 rounded-xl bg-slate-900 text-white flex items-center justify-between text-xs">
                            <div class="flex items-center gap-2.5">
                                <span class="relative flex h-2.5 w-2.5">
                                    <span
                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                                </span>
                                <span class="text-slate-300 font-medium">Akses Portal Tenaga Pendidik Aktif</span>
                            </div>
                            <a href="{{ route('login') }}"
                                class="font-bold text-indigo-300 hover:text-white transition">Masuk &rarr;</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Core Features Showcase (Students & Teachers Love This) -->
    <section class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-14 space-y-3">
            <span
                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-indigo-50 text-brand border border-indigo-200/60">
                Fitur Unggulan Sistem
            </span>
            <h2 class="text-2xl sm:text-3xl font-black text-navy tracking-tight">
                Didesain Spesifik untuk Siswa, Pendidik &amp; Mitra Industri
            </h2>
            <p class="text-xs sm:text-sm text-slate-600">
                Solusi modern menyeluruh mulai dari kegiatan belajar mengajar harian hingga pengawasan siswa magang di
                tempat kerja.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Feature 1 -->
            <div
                class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs hover:shadow-card hover:-translate-y-1 transition-all duration-200 space-y-4">
                <div
                    class="w-12 h-12 rounded-2xl bg-indigo-50 text-brand flex items-center justify-center border border-indigo-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4v1m6 11h2m-6 0a2 2 0 01-2-2v-5a2 2 0 012-2h4a2 2 0 012 2v5a2 2 0 01-2 2h-4zm-8 4v-4m0 0h2m-2 0H4m4-4a2 2 0 012-2h4a2 2 0 012 2v5a2 2 0 01-2 2H8a2 2 0 01-2-2V9z" />
                    </svg>
                </div>
                <h3 class="text-base font-extrabold text-navy">Presensi GPS Geofencing</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Siswa PKL melakukan presensi masuk dan pulang wajib berada dalam radius resmi kantor mitra dengan
                    validasi koordinat GPS dan foto selfie.
                </p>
            </div>

            <!-- Feature 2 -->
            <div
                class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs hover:shadow-card hover:-translate-y-1 transition-all duration-200 space-y-4">
                <div
                    class="w-12 h-12 rounded-2xl bg-violet-50 text-violet-600 flex items-center justify-center border border-violet-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h3 class="text-base font-extrabold text-navy">Jurnal Kegiatan Harian</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Catatan harian kerja praktek siswa diverifikasi langsung oleh guru pembimbing dengan fitur status
                    Disetujui, Perlu Revisi, atau Ditolak.
                </p>
            </div>

            <!-- Feature 3 -->
            <div
                class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs hover:shadow-card hover:-translate-y-1 transition-all duration-200 space-y-4">
                <div
                    class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-base font-extrabold text-navy">Jadwal &amp; Presensi Kelas</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Bapak/Ibu guru dapat melihat agenda mengajar harian secara terstruktur dan mencatat kehadiran siswa
                    mata pelajaran dalam hitungan detik.
                </p>
            </div>

            <!-- Feature 4 -->
            <div
                class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs hover:shadow-card hover:-translate-y-1 transition-all duration-200 space-y-4">
                <div
                    class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="text-base font-extrabold text-navy">Laporan Terpadu Institusi</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Rekapitulasi otomatis presensi siswa per kelas binaan bagi Wali Kelas serta laporan akademik dan
                    evaluasi PKL bagi pihak manajemen sekolah.
                </p>
            </div>
        </div>
    </section>

    <!-- Latest News & Information Section -->
    <section class="py-16 bg-white border-y border-border/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            <!-- News Header -->
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-brand block mb-1">Publikasi
                        Resmi</span>
                    <h2 class="text-2xl sm:text-3xl font-black text-navy tracking-tight">Kabar &amp; Prestasi Sekolah
                    </h2>
                </div>
                <a href="{{ route('public.news') }}"
                    class="inline-flex items-center gap-1.5 text-xs font-bold text-brand hover:text-brand-hover group">
                    <span>Lihat Semua Berita</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>

            <!-- News Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($latestNews as $news)
                    <article
                        class="group bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-xs hover:shadow-card hover:-translate-y-1 transition-all duration-200 flex flex-col justify-between">
                        <div>
                            @if($news->featured_image)
                                <div class="overflow-hidden h-48 bg-slate-100">
                                    <img src="{{ asset('storage/' . $news->featured_image) }}" alt="{{ $news->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                </div>
                            @else
                                <div
                                    class="w-full h-48 bg-gradient-to-br from-indigo-50 to-slate-100 border-b border-slate-100 flex items-center justify-center text-indigo-300">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                    </svg>
                                </div>
                            @endif

                            <div class="p-6 space-y-2.5">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-indigo-50 text-brand border border-indigo-200/60">
                                        Warta
                                    </span>
                                    <span class="text-[11px] text-slate-400 font-mono">
                                        {{ $news->published_at ? $news->published_at->format('d M Y') : '-' }}
                                    </span>
                                </div>
                                <h3
                                    class="text-base font-bold text-navy group-hover:text-brand transition line-clamp-2 leading-snug">
                                    <a href="{{ route('public.news.show', $news->slug) }}">{{ $news->title }}</a>
                                </h3>
                                <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed">
                                    {{ $news->excerpt ?: Str::limit(strip_tags($news->content), 120) }}
                                </p>
                            </div>
                        </div>

                        <div class="px-6 pb-6 pt-0">
                            <a href="{{ route('public.news.show', $news->slug) }}"
                                class="inline-flex items-center gap-1.5 text-xs font-bold text-brand hover:underline">
                                <span>Baca Selengkapnya</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </article>
                @empty
                    <div
                        class="col-span-3 py-16 text-center text-slate-500 bg-slate-50 rounded-2xl border border-slate-200/80">
                        <svg class="w-10 h-10 mx-auto text-slate-400 mb-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        <p class="text-xs font-semibold text-navy">Belum ada berita yang dipublikasikan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Announcements & Upcoming Events Dual Section -->
    <section class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            <!-- Announcements Column -->
            <div
                class="bg-white rounded-3xl border border-slate-200/90 p-6 sm:p-8 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-6">
                        <div>
                            <span
                                class="text-xs font-bold uppercase tracking-wider text-amber-600 block">Pemberitahuan</span>
                            <h2 class="text-xl font-extrabold text-navy">Papan Pengumuman Resmi</h2>
                        </div>
                        <a href="{{ route('public.announcements') }}"
                            class="text-xs font-bold text-brand hover:underline inline-flex items-center gap-1">
                            <span>Lihat Semua</span>
                            <span>&rarr;</span>
                        </a>
                    </div>

                    <div class="space-y-3.5">
                        @forelse($announcements as $announcement)
                            <div
                                class="p-4 rounded-2xl bg-slate-50 border border-slate-200/70 hover:bg-slate-100/75 transition-all duration-150">
                                <div class="flex items-center justify-between gap-2 mb-1.5">
                                    <span
                                        class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                        Penting
                                    </span>
                                    <span class="text-[11px] text-slate-400 font-mono">
                                        {{ $announcement->published_at ? $announcement->published_at->format('d/m/Y') : '-' }}
                                    </span>
                                </div>
                                <h4 class="text-xs sm:text-sm font-bold text-navy hover:text-brand transition">
                                    <a
                                        href="{{ route('public.announcements.show', $announcement->slug) }}">{{ $announcement->title }}</a>
                                </h4>
                                <p class="text-xs text-slate-600 mt-1 line-clamp-2 leading-relaxed">
                                    {{ $announcement->excerpt ?: Str::limit(strip_tags($announcement->content), 100) }}
                                </p>
                            </div>
                        @empty
                            <div class="text-center py-8 text-slate-500 text-xs">
                                Belum ada pengumuman baru saat ini.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Upcoming Events Column -->
            <div
                class="bg-white rounded-3xl border border-slate-200/90 p-6 sm:p-8 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-6">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-violet-600 block">Kalender
                                Akademik</span>
                            <h2 class="text-xl font-extrabold text-navy">Agenda &amp; Acara Mendatang</h2>
                        </div>
                        <a href="{{ route('public.events') }}"
                            class="text-xs font-bold text-brand hover:underline inline-flex items-center gap-1">
                            <span>Lihat Semua</span>
                            <span>&rarr;</span>
                        </a>
                    </div>

                    <div class="space-y-3.5">
                        @forelse($upcomingEvents as $event)
                            <div
                                class="p-4 rounded-2xl bg-slate-50 border border-slate-200/70 flex items-start gap-4 hover:bg-slate-100/75 transition-all duration-150">
                                <div
                                    class="w-14 h-14 rounded-2xl bg-gradient-to-br from-violet-100 to-indigo-100 border border-violet-200/60 text-violet-700 flex flex-col items-center justify-center shrink-0 shadow-xs">
                                    <span
                                        class="text-base font-black leading-none">{{ $event->event_date ? $event->event_date->format('d') : '-' }}</span>
                                    <span
                                        class="text-[10px] uppercase font-bold leading-none mt-1">{{ $event->event_date ? $event->event_date->format('M Y') : '-' }}</span>
                                </div>
                                <div class="space-y-1 min-w-0">
                                    <h4 class="text-xs sm:text-sm font-bold text-navy hover:text-brand transition truncate">
                                        <a href="{{ route('public.events.show', $event->slug) }}">{{ $event->title }}</a>
                                    </h4>
                                    <div class="text-xs text-slate-500 space-y-0.5">
                                        <p class="flex items-center gap-1.5 truncate">
                                            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span>{{ $event->event_location ?? 'Kampus Utama' }}</span>
                                        </p>
                                        @if($event->event_time)
                                            <p class="flex items-center gap-1.5 font-mono text-[11px] text-slate-600">
                                                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span>{{ substr($event->event_time, 0, 5) }} WIB</span>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-slate-500 text-xs">
                                Tidak ada agenda terdekat saat ini.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- School Motto & Community Callout CTA -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div
            class="relative rounded-3xl bg-gradient-to-r from-navy via-slate-900 to-indigo-950 p-8 sm:p-12 text-white overflow-hidden shadow-2xl border border-slate-800">
            <!-- Background Glow -->
            <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-brand/30 rounded-full blur-3xl pointer-events-none">
            </div>

            <div class="relative z-10 max-w-2xl space-y-4">
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-white/10 text-indigo-300 border border-white/15">
                    Maju Bersama SMK Vokasi
                </span>
                <h3 class="text-2xl sm:text-3xl font-black tracking-tight">
                    Bersinergi Menghadirkan Generasi Digital yang Kompeten &amp; Berkarakter
                </h3>
                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-normal">
                    Didukung sarana laboratorium komputasi terkini, pengajar bersertifikasi industri, dan kerjasama
                    penempatan PKL di puluhan perusahaan teknologi terpercaya.
                </p>
                <div class="pt-2 flex flex-wrap items-center gap-3">
                    <a href="{{ route('public.profile') }}"
                        class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-white text-navy font-bold text-xs sm:text-sm shadow-md hover:bg-slate-100 transition">
                        <span>Lihat Profil Kejuruan</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-white/10 hover:bg-white/15 text-white font-bold text-xs sm:text-sm border border-white/20 transition">
                        <span>Portal Masuk Guru &amp; Admin</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-public-layout>