<x-public-layout title="Beranda">
    <!-- Hero Section (Following Reference Image B) -->
    <section class="relative bg-gradient-to-b from-[#F0F4FA] via-[#F8FAFD] to-[#FFFFFF] pt-12 pb-20 lg:pt-20 lg:pb-32 border-b border-slate-200/80 overflow-hidden">
        <!-- Subtle Vector Wave & Decorative Background Shapes (Reference Image B) -->
        <svg class="absolute top-0 right-0 w-1/2 h-full opacity-35 pointer-events-none text-indigo-300" viewBox="0 0 500 500" fill="none" preserveAspectRatio="none">
            <path d="M50 0 C150 120 50 250 200 350 C300 420 400 480 500 500 L500 0 Z" stroke="currentColor" stroke-width="1.2" stroke-dasharray="3 3"/>
            <path d="M120 0 C220 150 140 280 280 390 C360 450 440 480 500 500" stroke="currentColor" stroke-width="1"/>
        </svg>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">

                <!-- Hero Left: Typography & Dual CTAs (Reference Image B) -->
                <div class="lg:col-span-6 space-y-6 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-[11px] font-extrabold uppercase tracking-widest text-[#233DFF] bg-[#E5ECFF] border border-blue-200/80 shadow-xs">
                        <span class="w-2 h-2 rounded-full bg-[#233DFF] animate-pulse"></span>
                        <span>Portal Resmi Sistem Informasi Satu-Sekolah</span>
                    </div>

                    <h1 class="text-4xl sm:text-6xl lg:text-[58px] font-normal text-[#20211F] tracking-tight leading-[1.12]">
                        Wujudkan <span class="font-extrabold text-[#171B61]">Masa Depan</span><br>
                        <span class="font-extrabold text-[#233DFF]">Generasi Unggul</span> Berkarakter
                    </h1>

                    <p class="text-base sm:text-lg text-[#707581] leading-relaxed max-w-xl mx-auto lg:mx-0 font-normal">
                        Platform pendidikan terpadu satu pintu untuk pembelajaran vokasi modern, presensi digital presisi, transparansi nilai, serta sistem pemantauan Praktik Kerja Lapangan (PKL) presisi tinggi berbasis GPS.
                    </p>

                    <!-- CTAs: Warm Yellow Button + Circular Play Action (Reference Image B) -->
                    <div class="flex flex-wrap items-center justify-center lg:justify-start gap-5 pt-3">
                        @auth
                            <a href="{{ route('dashboard') }}" class="px-8 py-4 rounded-full font-extrabold text-sm text-[#171B61] bg-[#F4CF52] hover:bg-[#e5be42] shadow-md shadow-amber-300/30 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-150 cursor-pointer">
                                Ke Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-8 py-4 rounded-full font-extrabold text-sm text-[#171B61] bg-[#F4CF52] hover:bg-[#e5be42] shadow-md shadow-amber-300/30 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-150 cursor-pointer">
                                Masuk Portal Guru & Admin
                            </a>
                        @endauth

                        <a href="{{ route('public.profile') }}" class="inline-flex items-center gap-3 text-xs sm:text-sm font-extrabold uppercase tracking-wider text-[#171B61] hover:text-[#233DFF] group transition-colors cursor-pointer">
                            <span class="w-11 h-11 rounded-full bg-[#233DFF] text-white flex items-center justify-center shadow-md shadow-indigo-600/30 group-hover:scale-110 transition-transform duration-200">
                                <svg class="w-4 h-4 translate-x-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            </span>
                            <span class="underline decoration-2 underline-offset-4">LIHAT PROFIL SEKOLAH</span>
                        </a>
                    </div>

                    <!-- Trust Indicators -->
                    <div class="pt-6 flex flex-wrap items-center justify-center lg:justify-start gap-6 text-xs text-[#707581] font-semibold border-t border-slate-200/80">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span>Terakreditasi A BAN-S/M</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#233DFF]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span>Kemitraan Industri DUDI Aktif</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span>Geofencing Presensi PKL</span>
                        </div>
                    </div>
                </div>

                <!-- Hero Right: Asymmetrical Collage (Reference Image B) -->
                <div class="lg:col-span-6 relative">
                    <!-- Decorative Graphic Shapes -->
                    <div class="absolute -top-6 right-8 w-32 h-32 rounded-full bg-[#F4CF52] -z-10"></div>
                    <div class="absolute bottom-6 -left-6 w-10 h-10 rounded-full bg-[#233DFF]/20 -z-10"></div>
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-[#ECEBFA] -z-10"></div>

                    <!-- 4-Piece Asymmetrical Image Collage -->
                    <div class="grid grid-cols-2 gap-4 max-w-lg mx-auto relative z-10">
                        <!-- Top Left: Circular Frame (Reference Image B) -->
                        <div class="flex justify-end items-end p-2">
                            <div class="w-44 h-44 sm:w-52 sm:h-52 rounded-full overflow-hidden border-4 border-white shadow-xl shadow-indigo-950/10 relative group bg-gradient-to-tr from-indigo-100 to-blue-50">
                                <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=600&q=80" 
                                     alt="Siswa Berprestasi" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                     onerror="this.style.display='none'">
                            </div>
                        </div>

                        <!-- Top Right: Rounded Rectangle with Yellow Accent (Reference Image B) -->
                        <div class="flex justify-start items-end p-2">
                            <div class="w-44 h-52 sm:w-52 sm:h-60 rounded-3xl overflow-hidden border-4 border-white shadow-xl shadow-indigo-950/10 relative group bg-gradient-to-br from-amber-50 to-indigo-50">
                                <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=600&q=80" 
                                     alt="Aktivitas Belajar" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                     onerror="this.style.display='none'">
                            </div>
                        </div>

                        <!-- Bottom Left: Rounded Square with Soft Corner (Reference Image B) -->
                        <div class="flex justify-end items-start p-2">
                            <div class="w-44 h-52 sm:w-52 sm:h-56 rounded-3xl overflow-hidden border-4 border-white shadow-xl shadow-indigo-950/10 relative group bg-gradient-to-tr from-purple-50 to-indigo-50">
                                <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=600&q=80" 
                                     alt="Kerja Sama Tim Siswa" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                     onerror="this.style.display='none'">
                            </div>
                        </div>

                        <!-- Bottom Right: Pill-Curved Card (Reference Image B) -->
                        <div class="flex justify-start items-start p-2">
                            <div class="w-44 h-48 sm:w-52 sm:h-52 rounded-t-[50px] rounded-b-3xl overflow-hidden border-4 border-white shadow-xl shadow-indigo-950/10 relative group bg-gradient-to-br from-emerald-50 to-blue-50">
                                <img src="https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&w=600&q=80" 
                                     alt="Praktik Kerja Lapangan" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                     onerror="this.style.display='none'">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Institutional Statistics & Bento Metrics Showcase -->
    <section class="py-16 sm:py-24 bg-[#F4F6FB] border-b border-slate-200/80 relative overflow-hidden">
        <!-- Subtle Glow & Accents -->
        <div class="absolute -top-32 right-10 w-96 h-96 bg-blue-200/30 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-32 left-10 w-96 h-96 bg-amber-100/40 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Section Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 sm:mb-16 gap-6">
                <div class="max-w-2xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-widest text-[#233DFF] bg-[#E5ECFF] border border-blue-200/80 mb-3">
                        <span class="w-2 h-2 rounded-full bg-[#233DFF]"></span>
                        <span>STATISTIK & KINERJA SATU-SEKOLAH</span>
                    </div>
                    <h2 class="text-3xl sm:text-4xl lg:text-[42px] font-normal text-[#20211F] tracking-tight leading-tight">
                        Pencapaian Nyata & <span class="font-black text-[#171B61]">Standar Mutu Vokasi</span>
                    </h2>
                    <p class="text-sm sm:text-base text-[#707581] mt-3 leading-relaxed">
                        Data riil terintegrasi dari sistem manajemen akademik, kehadiran digital, dan monitoring kemitraan industri Praktik Kerja Lapangan (PKL) Satu-Sekolah.
                    </p>
                </div>
                
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-white border border-slate-200/80 shadow-xs text-xs font-bold text-slate-700">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Data Terverifikasi Real-Time
                    </span>
                </div>
            </div>

            <!-- Bento Grid 6-Card Layout -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-6">
                <!-- Card 1: Featured Indigo Card (Students) - lg:col-span-4 -->
                <div class="lg:col-span-4 rounded-3xl bg-[#171B61] text-white p-8 relative overflow-hidden shadow-xl shadow-indigo-950/20 flex flex-col justify-between group hover:-translate-y-1 transition-all duration-300">
                    <div class="absolute -right-6 -bottom-6 w-40 h-40 bg-white/5 rounded-full blur-xl pointer-events-none"></div>
                    <div class="space-y-4 relative z-10">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 rounded-full text-[11px] font-extrabold uppercase tracking-wider bg-white/10 text-[#F4CF52] border border-white/15">
                                Siswa Vokasi
                            </span>
                            <div class="w-10 h-10 rounded-2xl bg-white/10 flex items-center justify-center text-[#F4CF52]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg>
                            </div>
                        </div>

                        <div>
                            <span class="text-4xl sm:text-5xl font-black text-white tracking-tight block">
                                {{ number_format($stats['students'] ?? 850) }}+
                            </span>
                            <h3 class="text-lg font-bold text-slate-100 mt-1">Peserta Didik Aktif</h3>
                            <p class="text-xs text-indigo-200 mt-2 leading-relaxed">
                                Tersebar di jurusan unggulan RPL &amp; TKJ dengan pembinaan kurikulum link-and-match dan sertifikasi keahlian.
                            </p>
                        </div>
                    </div>

                    <div class="pt-6 mt-6 border-t border-white/10 flex items-center justify-between text-xs text-indigo-200 relative z-10">
                        <span>Konsentrasi: RPL &amp; TKJ</span>
                        <span class="font-bold text-[#F4CF52]">100% Aktif Belajar</span>
                    </div>
                </div>

                <!-- Card 2: White Surface Card (Teachers) - lg:col-span-4 -->
                <div class="lg:col-span-4 rounded-3xl bg-white border border-slate-200/90 p-8 shadow-xs hover:shadow-card hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 rounded-full text-[11px] font-extrabold uppercase tracking-wider bg-blue-50 text-[#233DFF] border border-blue-100">
                                Tenaga Pendidik
                            </span>
                            <div class="w-10 h-10 rounded-2xl bg-[#E5ECFF] flex items-center justify-center text-[#233DFF]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            </div>
                        </div>

                        <div>
                            <span class="text-4xl sm:text-5xl font-black text-[#171B61] tracking-tight block">
                                {{ $stats['teachers'] ?? 48 }}+
                            </span>
                            <h3 class="text-lg font-bold text-[#171B61] mt-1">Guru &amp; Instruktur Ahli</h3>
                            <p class="text-xs text-[#707581] mt-2 leading-relaxed">
                                Tenaga pendidik bergelar sarjana/magister serta instruktur tamu dari kalangan praktisi industri digital.
                            </p>
                        </div>
                    </div>

                    <div class="pt-6 mt-6 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                        <span>Sertifikasi BNSP</span>
                        <span class="font-bold text-[#233DFF]">{{ $stats['certified_teachers_rate'] ?? '100%' }} Terakreditasi</span>
                    </div>
                </div>

                <!-- Card 3: White Surface Card (Industry Partners) - lg:col-span-4 -->
                <div class="lg:col-span-4 rounded-3xl bg-white border border-slate-200/90 p-8 shadow-xs hover:shadow-card hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 rounded-full text-[11px] font-extrabold uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-100">
                                Kemitraan DUDI
                            </span>
                            <div class="w-10 h-10 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </div>
                        </div>

                        <div>
                            <span class="text-4xl sm:text-5xl font-black text-[#171B61] tracking-tight block">
                                {{ $stats['companies'] ?? 35 }}+
                            </span>
                            <h3 class="text-lg font-bold text-[#171B61] mt-1">Mitra Industri Aktif</h3>
                            <p class="text-xs text-[#707581] mt-2 leading-relaxed">
                                Perusahaan mitra resmi penempatan magang PKL, uji sertifikasi kompetensi, dan rekrutmen kerja langsung.
                            </p>
                        </div>
                    </div>

                    <div class="pt-6 mt-6 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                        <span>Penempatan PKL</span>
                        <span class="font-bold text-emerald-600">100% Terfasilitasi</span>
                    </div>
                </div>

                <!-- Card 4: Classrooms & Lab Card - lg:col-span-4 -->
                <div class="lg:col-span-4 rounded-3xl bg-white border border-slate-200/90 p-8 shadow-xs hover:shadow-card hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 rounded-full text-[11px] font-extrabold uppercase tracking-wider bg-amber-50 text-amber-800 border border-amber-200">
                                Sarana Prasarana
                            </span>
                            <div class="w-10 h-10 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                        </div>

                        <div>
                            <span class="text-4xl sm:text-5xl font-black text-[#171B61] tracking-tight block">
                                {{ $stats['classrooms'] ?? 24 }}
                            </span>
                            <h3 class="text-lg font-bold text-[#171B61] mt-1">Rombel &amp; Laboratorium</h3>
                            <p class="text-xs text-[#707581] mt-2 leading-relaxed">
                                Laboratorium Rekayasa Perangkat Lunak, Lab Komputer Jaringan, studio multimedia, dan ruang kelas ber-AC modern.
                            </p>
                        </div>
                    </div>

                    <div class="pt-6 mt-6 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                        <span>Konektivitas</span>
                        <span class="font-bold text-amber-700">Fiber Optic 1 Gbps</span>
                    </div>
                </div>

                <!-- Card 5: Keterserapan Lulusan - lg:col-span-4 -->
                <div class="lg:col-span-4 rounded-3xl bg-white border border-slate-200/90 p-8 shadow-xs hover:shadow-card hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 rounded-full text-[11px] font-extrabold uppercase tracking-wider bg-indigo-50 text-[#233DFF] border border-indigo-100">
                                Keterserapan Kerja
                            </span>
                            <div class="w-10 h-10 rounded-2xl bg-[#ECEBFA] flex items-center justify-center text-[#171B61]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            </div>
                        </div>

                        <div>
                            <span class="text-4xl sm:text-5xl font-black text-[#233DFF] tracking-tight block">
                                {{ $stats['absorption_rate'] ?? '98.4%' }}
                            </span>
                            <h3 class="text-lg font-bold text-[#171B61] mt-1">Lulusan Siap Kerja</h3>
                            <p class="text-xs text-[#707581] mt-2 leading-relaxed">
                                Presentase lulusan yang langsung diserap industri teknologi, berwirausaha mandiri, atau melanjutkan ke perguruan tinggi.
                            </p>
                        </div>
                    </div>

                    <!-- Visual Mini Progress Bar -->
                    <div class="pt-6 mt-6 border-t border-slate-100 space-y-1.5">
                        <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                            <div class="bg-gradient-to-r from-[#233DFF] to-blue-400 h-full rounded-full" style="width: 98.4%"></div>
                        </div>
                        <div class="flex items-center justify-between text-[11px] text-slate-400 font-semibold">
                            <span>Tracer Study Vokasi</span>
                            <span class="text-[#233DFF] font-bold">Target 95% Terlampaui</span>
                        </div>
                    </div>
                </div>

                <!-- Card 6: Geofence Attendance Rate - lg:col-span-4 -->
                <div class="lg:col-span-4 rounded-3xl bg-white border border-slate-200/90 p-8 shadow-xs hover:shadow-card hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 rounded-full text-[11px] font-extrabold uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-100">
                                Kedisiplinan Siswa
                            </span>
                            <div class="w-10 h-10 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                        </div>

                        <div>
                            <span class="text-4xl sm:text-5xl font-black text-emerald-600 tracking-tight block">
                                {{ $stats['attendance_rate'] ?? '96.8%' }}
                            </span>
                            <h3 class="text-lg font-bold text-[#171B61] mt-1">Presensi Presisi GPS</h3>
                            <p class="text-xs text-[#707581] mt-2 leading-relaxed">
                                Rata-rata tingkat kehadiran harian siswa di sekolah dan di tempat PKL dengan radius validasi geofencing instan.
                            </p>
                        </div>
                    </div>

                    <!-- Visual Mini Progress Bar -->
                    <div class="pt-6 mt-6 border-t border-slate-100 space-y-1.5">
                        <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                            <div class="bg-gradient-to-r from-emerald-500 to-teal-400 h-full rounded-full" style="width: 96.8%"></div>
                        </div>
                        <div class="flex items-center justify-between text-[11px] text-slate-400 font-semibold">
                            <span>Verifikasi Titik Koordinat</span>
                            <span class="text-emerald-600 font-bold">Akurasi &lt; 25 Meter</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us / Experience The Magic of Learning (Reference Image B) -->
    <section class="py-20 bg-white border-b border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <span class="text-xs font-extrabold uppercase tracking-widest text-[#233DFF] block mb-2">MENGAPA MEMILIH KAMI</span>
                <h2 class="text-3xl sm:text-4xl font-normal text-[#20211F] tracking-tight">
                    Rasakan Pengalaman Belajar <span class="font-extrabold text-[#171B61]">Terbaik &amp; Nyata</span>
                </h2>
                <p class="text-sm text-[#707581] mt-3">
                    Kurikulum berbasis industri, tenaga pendidik berkompeten, dan pendampingan Praktik Kerja Lapangan (PKL) berstandar profesional.
                </p>
            </div>

            <!-- 4 Rounded Highlight Cards (Direct from Reference Image B) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1 -->
                <div class="group rounded-3xl bg-[#F4F6FB] border border-slate-200/80 overflow-hidden shadow-xs hover:shadow-xl hover:shadow-indigo-950/5 transition-all duration-300">
                    <div class="h-44 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=600&q=80" 
                             alt="Kelas Vokasi" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                             onerror="this.style.display='none'">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        <span class="absolute bottom-3 left-4 text-xs font-bold text-white uppercase tracking-wider">Kurikulum Terapan</span>
                    </div>
                    <div class="p-6">
                        <h3 class="text-base font-bold text-[#171B61] group-hover:text-[#233DFF] transition-colors">
                            Kurikulum Selaras Industri
                        </h3>
                        <p class="text-xs text-[#707581] mt-2 leading-relaxed">
                            Materi ajar disusun langsung bersama mitra Dunia Usaha dan Dunia Industri (DUDI) untuk menjamin relevansi kompetensi lulusan.
                        </p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="group rounded-3xl bg-[#F4F6FB] border border-slate-200/80 overflow-hidden shadow-xs hover:shadow-xl hover:shadow-indigo-950/5 transition-all duration-300">
                    <div class="h-44 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1532094349884-543bc11b234d?auto=format&fit=crop&w=600&q=80" 
                             alt="Laboratorium Modern" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                             onerror="this.style.display='none'">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        <span class="absolute bottom-3 left-4 text-xs font-bold text-white uppercase tracking-wider">Fasilitas Modern</span>
                    </div>
                    <div class="p-6">
                        <h3 class="text-base font-bold text-[#171B61] group-hover:text-[#233DFF] transition-colors">
                            Laboratorium &amp; Workshop
                        </h3>
                        <p class="text-xs text-[#707581] mt-2 leading-relaxed">
                            Fasilitas komputer spesifikasi tinggi dan perangkat jaringan mutakhir untuk mendukung praktik langsung siswa setiap hari.
                        </p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="group rounded-3xl bg-[#F4F6FB] border border-slate-200/80 overflow-hidden shadow-xs hover:shadow-xl hover:shadow-indigo-950/5 transition-all duration-300">
                    <div class="h-44 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=600&q=80" 
                             alt="Sistem Terintegrasi" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                             onerror="this.style.display='none'">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        <span class="absolute bottom-3 left-4 text-xs font-bold text-white uppercase tracking-wider">Geofence GPS</span>
                    </div>
                    <div class="p-6">
                        <h3 class="text-base font-bold text-[#171B61] group-hover:text-[#233DFF] transition-colors">
                            Monitoring PKL Real-Time
                        </h3>
                        <p class="text-xs text-[#707581] mt-2 leading-relaxed">
                            Pemantauan kehadiran dan jurnal harian siswa magang dengan verifikasi lokasi GPS dan bukti foto terenkripsi.
                        </p>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="group rounded-3xl bg-[#F4F6FB] border border-slate-200/80 overflow-hidden shadow-xs hover:shadow-xl hover:shadow-indigo-950/5 transition-all duration-300">
                    <div class="h-44 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=600&q=80" 
                             alt="Bimbingan Karir" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                             onerror="this.style.display='none'">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        <span class="absolute bottom-3 left-4 text-xs font-bold text-white uppercase tracking-wider">Kesiapan Kerja</span>
                    </div>
                    <div class="p-6">
                        <h3 class="text-base font-bold text-[#171B61] group-hover:text-[#233DFF] transition-colors">
                            Penyaluran Lulusan
                        </h3>
                        <p class="text-xs text-[#707581] mt-2 leading-relaxed">
                            Jalur rekrutmen langsung ke perusahaan mitra bagi siswa berprestasi selama masa praktik industri.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- News & Announcements Section (Backed by Real Database Data) -->
    <section class="py-20 bg-[#F4F6FB] border-b border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
                <div>
                    <span class="text-xs font-extrabold uppercase tracking-widest text-[#233DFF] block mb-2">KABAR TERKINI</span>
                    <h2 class="text-3xl font-extrabold text-[#171B61] tracking-tight">Warta &amp; Berita Sekolah</h2>
                    <p class="text-sm text-[#707581] mt-1">Publikasi informasi resmi seputar prestasi dan kegiatan Satu-Sekolah.</p>
                </div>
                <a href="{{ route('public.news') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#233DFF] hover:text-[#171B61] transition group">
                    <span>Lihat Semua Berita</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($latestNews as $news)
                    <article class="bg-white rounded-3xl border border-slate-200/80 overflow-hidden shadow-xs hover:shadow-xl hover:shadow-indigo-950/5 hover:-translate-y-1 transition-all duration-200 flex flex-col justify-between">
                        <div class="p-6 space-y-3">
                            <div class="flex items-center justify-between text-xs text-slate-400">
                                <span class="px-2.5 py-1 rounded-full font-bold uppercase tracking-wider text-[10px] bg-[#E5ECFF] text-[#233DFF]">
                                    Berita
                                </span>
                                <span>{{ $news->published_at ? $news->published_at->translatedFormat('d M Y') : '-' }}</span>
                            </div>
                            <h3 class="text-base font-bold text-[#171B61] hover:text-[#233DFF] transition-colors leading-snug line-clamp-2">
                                <a href="{{ route('public.news.show', $news->slug) }}">{{ $news->title }}</a>
                            </h3>
                            <p class="text-xs text-[#707581] leading-relaxed line-clamp-3">
                                {{ $news->excerpt ?? Str::limit(strip_tags($news->content), 120) }}
                            </p>
                        </div>
                        <div class="px-6 py-4 bg-slate-50/70 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-[11px] text-slate-400 font-medium">Oleh: {{ $news->author?->name ?? 'Admin Sekolah' }}</span>
                            <a href="{{ route('public.news.show', $news->slug) }}" class="text-xs font-bold text-[#233DFF] hover:underline inline-flex items-center gap-1">
                                <span>Baca</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="col-span-3 p-12 text-center bg-white rounded-3xl border border-slate-200/80">
                        <p class="text-sm font-bold text-[#171B61]">Belum ada berita yang dipublikasikan.</p>
                        <p class="text-xs text-[#707581] mt-1">Silakan kembali lagi nanti untuk membaca berita terbaru.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Public Announcements & Events Grid (Database-Backed) -->
    <section class="py-20 bg-white border-b border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

                <!-- Announcements Column -->
                <div class="lg:col-span-6 space-y-6">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-200/80">
                        <div>
                            <span class="text-xs font-extrabold uppercase tracking-widest text-[#233DFF] block mb-1">PENGUMUMAN</span>
                            <h2 class="text-2xl font-extrabold text-[#171B61]">Papan Pengumuman Resmi</h2>
                        </div>
                        <a href="{{ route('public.announcements') }}" class="text-xs font-bold text-[#233DFF] hover:underline">Semua &rarr;</a>
                    </div>

                    <div class="space-y-4">
                        @forelse($announcements as $announcement)
                            <div class="p-5 rounded-2xl bg-[#F4F6FB] border border-slate-200/80 hover:border-blue-200 transition-all flex items-start gap-4">
                                <div class="w-10 h-10 rounded-2xl bg-[#E5ECFF] text-[#233DFF] flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <span class="text-[11px] font-bold text-slate-400 block mb-0.5">
                                        {{ $announcement->published_at ? $announcement->published_at->translatedFormat('d F Y') : '-' }}
                                    </span>
                                    <h3 class="text-sm font-bold text-[#171B61] hover:text-[#233DFF] transition truncate">
                                        <a href="{{ route('public.announcements.show', $announcement->slug) }}">{{ $announcement->title }}</a>
                                    </h3>
                                    <p class="text-xs text-[#707581] mt-1 line-clamp-2">
                                        {{ $announcement->excerpt ?? Str::limit(strip_tags($announcement->content), 100) }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center bg-[#F4F6FB] rounded-2xl border border-slate-200/80">
                                <p class="text-xs font-bold text-[#171B61]">Tidak ada pengumuman publik aktif saat ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Events Column -->
                <div class="lg:col-span-6 space-y-6">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-200/80">
                        <div>
                            <span class="text-xs font-extrabold uppercase tracking-widest text-[#233DFF] block mb-1">AGENDA AKADEMIK</span>
                            <h2 class="text-2xl font-extrabold text-[#171B61]">Agenda &amp; Acara Sekolah</h2>
                        </div>
                        <a href="{{ route('public.events') }}" class="text-xs font-bold text-[#233DFF] hover:underline">Semua &rarr;</a>
                    </div>

                    <div class="space-y-4">
                        @forelse($upcomingEvents as $event)
                            <div class="p-5 rounded-2xl bg-[#F4F6FB] border border-slate-200/80 hover:border-indigo-200 transition-all flex items-start gap-4">
                                <div class="w-12 h-14 rounded-2xl bg-[#171B61] text-white flex flex-col items-center justify-center shrink-0 shadow-sm">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-amber-300">
                                        {{ $event->published_at ? $event->published_at->translatedFormat('M') : 'AGENDA' }}
                                    </span>
                                    <span class="text-lg font-black leading-none">
                                        {{ $event->published_at ? $event->published_at->format('d') : '•' }}
                                    </span>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-[#233DFF] mb-0.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        {{ $event->published_at ? $event->published_at->translatedFormat('l, d F Y') : 'Terjadwal' }}
                                    </span>
                                    <h3 class="text-sm font-bold text-[#171B61] hover:text-[#233DFF] transition truncate">
                                        <a href="{{ route('public.events.show', $event->slug) }}">{{ $event->title }}</a>
                                    </h3>
                                    <p class="text-xs text-[#707581] mt-1 line-clamp-2">
                                        {{ $event->excerpt ?? Str::limit(strip_tags($event->content), 100) }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center bg-[#F4F6FB] rounded-2xl border border-slate-200/80">
                                <p class="text-xs font-bold text-[#171B61]">Tidak ada agenda acara mendatang saat ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- School Contact & Location Section -->
    <section id="kontak" class="py-20 bg-[#F4F6FB]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-5 space-y-4">
                    <span class="text-xs font-extrabold uppercase tracking-widest text-[#233DFF] block">LAYANAN INFORMASI</span>
                    <h2 class="text-3xl font-extrabold text-[#171B61] tracking-tight">Hubungi Satu-Sekolah</h2>
                    <p class="text-sm text-[#707581] leading-relaxed">
                        Pintu komunikasi terbuka bagi calon peserta didik, orang tua/wali murid, serta mitra industri DUDI.
                    </p>
                    <div class="space-y-3 pt-2 text-xs text-slate-700">
                        <div class="flex items-center gap-3 p-3.5 rounded-2xl bg-white border border-slate-200/80">
                            <div class="w-8 h-8 rounded-xl bg-[#E5ECFF] text-[#233DFF] flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <span>Jl. Pendidikan No. 01, Kompleks Edukasi Modern, Indonesia</span>
                        </div>
                        <div class="flex items-center gap-3 p-3.5 rounded-2xl bg-white border border-slate-200/80">
                            <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <span>(021) 7890-1234 (Jam Kerja: 07.30 - 16.00 WIB)</span>
                        </div>
                        <div class="flex items-center gap-3 p-3.5 rounded-2xl bg-white border border-slate-200/80">
                            <div class="w-8 h-8 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <span>info@satusekolah.sch.id &bull; humas@satusekolah.sch.id</span>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-7">
                    <div class="bg-white p-8 rounded-3xl border border-slate-200/80 shadow-md shadow-indigo-950/5 space-y-4">
                        <h3 class="text-lg font-bold text-[#171B61]">Portal Informasi Terpadu</h3>
                        <p class="text-xs text-[#707581] leading-relaxed">
                            Aplikasi web Satu-Sekolah mengintegrasikan seluruh layanan administrasi kepegawaian, proses belajar mengajar, serta pengawasan Praktik Kerja Lapangan (PKL) secara daring dan akuntabel.
                        </p>
                        <div class="grid grid-cols-2 gap-4 pt-2">
                            <div class="p-4 rounded-2xl bg-[#ECEBFA] text-[#171B61]">
                                <span class="text-xs font-bold block">Tenaga Pendidik &amp; Guru</span>
                                <span class="text-[11px] text-[#707581] mt-0.5 block">Akses jadwal mengajar dan presensi kelas harian.</span>
                            </div>
                            <div class="p-4 rounded-2xl bg-[#E5ECFF] text-[#171B61]">
                                <span class="text-xs font-bold block">Pembimbing PKL</span>
                                <span class="text-[11px] text-[#707581] mt-0.5 block">Review jurnal, izin, dan rekapitulasi kehadiran magang.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-public-layout>