<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Satu-Sekolah' }} — Portal Informasi Sekolah Terpadu</title>
    <meta name="description" content="Sistem Informasi Sekolah Satu-Sekolah — Portal Administrasi Akademik, Presensi, dan Monitoring Praktik Kerja Lapangan.">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: {
                            DEFAULT: '#0F172A', // Slate 900
                            light: '#1E293B',   // Slate 800
                            dark: '#020617',    // Slate 950
                            subtle: '#334155',  // Slate 700
                        },
                        brand: {
                            DEFAULT: '#4F46E5', // Indigo 600
                            hover: '#4338CA',   // Indigo 700
                            light: '#EEF2FF',   // Indigo 50
                            dark: '#3730A3',    // Indigo 800
                        },
                        accent: {
                            cyan: '#06B6D4',
                            emerald: '#10B981',
                            amber: '#F59E0B',
                            violet: '#8B5CF6',
                        },
                        canvas: '#F8FAFC',
                        surface: '#FFFFFF',
                        border: '#E2E8F0',
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                    boxShadow: {
                        'card': '0 4px 20px -2px rgba(15, 23, 42, 0.05), 0 2px 6px -1px rgba(15, 23, 42, 0.02)',
                        'glow': '0 0 25px -5px rgba(79, 70, 229, 0.35)',
                    }
                }
            }
        }
    </script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* Smooth transitions & anti-slop micro-effects */
        .glass-nav {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }
        .hero-pattern {
            background-color: #F8FAFC;
            background-image: radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.12) 0px, transparent 50%),
                              radial-gradient(at 100% 0%, rgba(139, 92, 246, 0.10) 0px, transparent 50%),
                              radial-gradient(at 50% 100%, rgba(6, 182, 212, 0.08) 0px, transparent 50%);
        }
    </style>
</head>
<body class="min-h-full font-sans antialiased text-slate-800 bg-[#F8FAFC] flex flex-col justify-between selection:bg-brand selection:text-white" x-data="{ mobileMenuOpen: false }">

    <!-- Top Announcement Ticker / Info Bar -->
    <div class="bg-gradient-to-r from-navy via-navy-light to-navy text-white text-[11px] font-medium py-1.5 px-4 border-b border-white/10 hidden sm:block">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-brand text-white shadow-xs">
                    SMK Unggulan
                </span>
                <span class="text-slate-300">Pusat Keunggulan Teknologi & Monitoring PKL Terintegrasi DUDI</span>
            </div>
            <div class="flex items-center gap-4 text-slate-400">
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    Terakreditasi A (BAN-S/M)
                </span>
                <span class="text-slate-600">•</span>
                <span class="text-slate-300">Hubungi: (021) 7890-1234</span>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <header class="sticky top-0 z-50 glass-nav border-b border-border/80 transition-all duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-18">
                <!-- Brand / Logo -->
                <a href="{{ route('public.home') }}" class="flex items-center gap-3.5 group cursor-pointer">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand via-indigo-600 to-violet-600 text-white flex items-center justify-center font-extrabold text-lg shadow-md shadow-brand/25 group-hover:scale-105 transition-transform duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5">
                            <span class="font-extrabold text-navy text-lg leading-tight tracking-tight group-hover:text-brand transition">SatuSekolah</span>
                            <span class="px-1.5 py-0.2 rounded text-[9px] font-bold uppercase tracking-wider bg-indigo-50 text-brand border border-indigo-200/60">Digital</span>
                        </div>
                        <span class="text-[11px] text-slate-500 font-medium block">Sistem Informasi Akademik &amp; PKL</span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center gap-1 bg-slate-100/70 p-1.5 rounded-full border border-slate-200/60 text-xs font-semibold">
                    <a href="{{ route('public.home') }}" class="px-3.5 py-1.5 rounded-full transition-all duration-150 {{ request()->routeIs('public.home') ? 'bg-white text-brand shadow-xs font-bold' : 'text-slate-600 hover:text-navy hover:bg-white/50' }}">
                        Beranda
                    </a>
                    <a href="{{ route('public.profile') }}" class="px-3.5 py-1.5 rounded-full transition-all duration-150 {{ request()->routeIs('public.profile') ? 'bg-white text-brand shadow-xs font-bold' : 'text-slate-600 hover:text-navy hover:bg-white/50' }}">
                        Profil Sekolah
                    </a>
                    <a href="{{ route('public.news') }}" class="px-3.5 py-1.5 rounded-full transition-all duration-150 {{ request()->routeIs('public.news*') ? 'bg-white text-brand shadow-xs font-bold' : 'text-slate-600 hover:text-navy hover:bg-white/50' }}">
                        Kabar &amp; Berita
                    </a>
                    <a href="{{ route('public.announcements') }}" class="px-3.5 py-1.5 rounded-full transition-all duration-150 {{ request()->routeIs('public.announcements*') ? 'bg-white text-brand shadow-xs font-bold' : 'text-slate-600 hover:text-navy hover:bg-white/50' }}">
                        Pengumuman
                    </a>
                    <a href="{{ route('public.events') }}" class="px-3.5 py-1.5 rounded-full transition-all duration-150 {{ request()->routeIs('public.events*') ? 'bg-white text-brand shadow-xs font-bold' : 'text-slate-600 hover:text-navy hover:bg-white/50' }}">
                        Agenda Acara
                    </a>
                </nav>

                <!-- Auth Action Button -->
                <div class="hidden md:flex items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-bold text-white bg-gradient-to-r from-brand to-violet-600 hover:from-brand-hover hover:to-violet-700 rounded-xl shadow-sm hover:shadow-glow transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            <span>Ke Dashboard</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-xs font-bold text-white bg-navy hover:bg-navy-light rounded-xl shadow-sm hover:shadow-md transition-all duration-200 group">
                            <span>Masuk Portal</span>
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            <svg class="w-3.5 h-3.5 text-slate-300 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex items-center md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" aria-label="Toggle Menu" class="p-2.5 rounded-xl text-slate-700 hover:text-navy hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-brand/30 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="md:hidden border-b border-border bg-white/95 backdrop-blur-md px-4 pt-3 pb-5 space-y-1.5 shadow-xl">
            <a href="{{ route('public.home') }}" class="block px-3.5 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('public.home') ? 'bg-indigo-50 text-brand font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                Beranda
            </a>
            <a href="{{ route('public.profile') }}" class="block px-3.5 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('public.profile') ? 'bg-indigo-50 text-brand font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                Profil Sekolah
            </a>
            <a href="{{ route('public.news') }}" class="block px-3.5 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('public.news*') ? 'bg-indigo-50 text-brand font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                Kabar &amp; Berita
            </a>
            <a href="{{ route('public.announcements') }}" class="block px-3.5 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('public.announcements*') ? 'bg-indigo-50 text-brand font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                Pengumuman
            </a>
            <a href="{{ route('public.events') }}" class="block px-3.5 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('public.events*') ? 'bg-indigo-50 text-brand font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                Agenda Acara
            </a>
            <div class="pt-3 mt-2 border-t border-slate-100">
                @auth
                    <a href="{{ route('dashboard') }}" class="flex items-center justify-center gap-2 w-full py-2.5 px-4 text-xs font-bold text-white bg-brand rounded-xl shadow-sm">
                        <span>Ke Dashboard</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 w-full py-2.5 px-4 text-xs font-bold text-white bg-navy rounded-xl shadow-sm">
                        <span>Masuk Portal Guru &amp; Tenaga Pendidik</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content Slot -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Modern Footer -->
    <footer class="bg-navy text-slate-300 border-t border-slate-800 mt-20 relative overflow-hidden">
        <!-- Subtle Background Glow -->
        <div class="absolute -top-24 left-1/2 -translate-x-1/2 w-96 h-96 bg-brand/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-10">
                <!-- Col 1: About & Identity -->
                <div class="space-y-4 md:col-span-5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand to-violet-600 text-white flex items-center justify-center font-extrabold text-lg shadow-md shadow-brand/30">
                            S
                        </div>
                        <div>
                            <span class="font-extrabold text-white text-lg tracking-tight block">SatuSekolah</span>
                            <span class="text-[11px] text-indigo-300 font-medium">Sistem Informasi Manajemen Sekolah Terpadu</span>
                        </div>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed max-w-sm">
                        Mendukung ekosistem pendidikan cerdas dengan administrasi akademik digital, transparansi presensi, dan sistem monitoring Praktik Kerja Lapangan (PKL) presisi tinggi berbasis geofence.
                    </p>
                    <div class="pt-2 text-xs text-slate-400 space-y-1.5">
                        <p class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Jl. Pendidikan No. 01, Kompleks Edukasi Modern</span>
                        </p>
                        <p class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>info@satusekolah.sch.id &bull; (021) 7890-1234</span>
                        </p>
                    </div>
                </div>

                <!-- Col 2: Navigation Links -->
                <div class="md:col-span-3 space-y-3">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-white">Navigasi Cepat</h3>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('public.home') }}" class="hover:text-indigo-400 transition flex items-center gap-1.5">&rsaquo; Beranda Utama</a></li>
                        <li><a href="{{ route('public.profile') }}" class="hover:text-indigo-400 transition flex items-center gap-1.5">&rsaquo; Profil &amp; Visi Misi</a></li>
                        <li><a href="{{ route('public.news') }}" class="hover:text-indigo-400 transition flex items-center gap-1.5">&rsaquo; Warta &amp; Kabar Sekolah</a></li>
                        <li><a href="{{ route('public.announcements') }}" class="hover:text-indigo-400 transition flex items-center gap-1.5">&rsaquo; Papan Pengumuman</a></li>
                        <li><a href="{{ route('public.events') }}" class="hover:text-indigo-400 transition flex items-center gap-1.5">&rsaquo; Kalender Agenda Sekolah</a></li>
                    </ul>
                </div>

                <!-- Col 3: Portal Access & Info -->
                <div class="md:col-span-4 space-y-3">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-white">Akses Portal Terpadu</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Gerbang operasional terintegrasi untuk Administrator, Tenaga Pendidik, Wali Kelas, dan Pembimbing PKL Industri.
                    </p>
                    <div class="pt-2">
                        @auth
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-bold text-white bg-brand hover:bg-brand-hover rounded-xl shadow-xs transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                <span>Buka Dashboard</span>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-bold text-white bg-slate-800 hover:bg-slate-700 border border-slate-700 rounded-xl transition">
                                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                                <span>Masuk ke Akun Pendidik</span>
                            </a>
                        @endauth
                    </div>
                    <div class="p-3 rounded-xl bg-slate-800/60 border border-slate-700/60 text-[11px] text-slate-400">
                        <span class="text-emerald-400 font-semibold block mb-0.5">Siswa PKL:</span>
                        Gunakan aplikasi mobile dengan GPS aktif untuk mencatat presensi dan jurnal harian.
                    </div>
                </div>
            </div>

            <!-- Bottom Copyright & Badges -->
            <div class="mt-12 pt-8 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
                <p>&copy; {{ date('Y') }} SatuSekolah. Seluruh hak cipta dilindungi undang-undang.</p>
                <div class="flex items-center gap-4 text-[11px] text-slate-400">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-slate-800 border border-slate-700">
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        Status Sistem: Normal (99.9% Uptime)
                    </span>
                    <span>Versi 2.4-Modern</span>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
