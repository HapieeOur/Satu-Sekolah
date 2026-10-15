<!DOCTYPE html>
<html lang="id" class="h-full bg-[#F7F8FA] scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $title ?? 'Satu-Sekolah' }} — Sistem Informasi & Portal Resmi Sekolah</title>
    <meta name="description" content="{{ $metaDescription ?? 'Portal resmi Satu-Sekolah menyajikan profil sekolah, berita kegiatan terkini, pengumuman akademik, dan agenda acara sekolah.' }}">
    
    <!-- Open Graph -->
    <meta property="og:title" content="{{ $title ?? 'Satu-Sekolah' }} — Sistem Informasi & Portal Resmi Sekolah">
    <meta property="og:description" content="{{ $metaDescription ?? 'Portal resmi Satu-Sekolah menyajikan profil sekolah, berita kegiatan terkini, pengumuman akademik, dan agenda acara sekolah.' }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (CDN for standalone execution) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: {
                            DEFAULT: '#172B4D',
                            light: '#253858',
                            dark: '#091E42',
                        },
                        brand: {
                            DEFAULT: '#315E8A',
                            hover: '#24476B',
                            light: '#EBF3FB',
                        },
                        canvas: '#F7F8FA',
                        surface: '#FFFFFF',
                        border: '#DCE2E9',
                        success: '#247A58',
                        warning: '#946200',
                        danger: '#B42318',
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-full font-sans antialiased text-slate-800 flex flex-col justify-between selection:bg-brand selection:text-white">

    <!-- Public Navigation Bar -->
    <header class="sticky top-0 z-50 bg-surface/95 backdrop-blur-md border-b border-border shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-18">
                <!-- Brand / Logo -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 rounded-xl bg-navy text-white flex items-center justify-center font-bold text-xl shadow-xs group-hover:bg-brand transition">
                            S
                        </div>
                        <div>
                            <span class="font-extrabold text-navy text-lg tracking-tight block leading-tight group-hover:text-brand transition">Satu-Sekolah</span>
                            <span class="text-[11px] font-medium text-slate-500 uppercase tracking-wider block">Institusi Pendidikan Terpadu</span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center gap-1 text-sm font-semibold text-slate-600">
                    <a href="{{ route('home') }}" class="px-3.5 py-2 rounded-lg transition {{ request()->routeIs('home') ? 'text-brand bg-brand-light' : 'hover:text-navy hover:bg-slate-100' }}">
                        Beranda
                    </a>
                    <a href="{{ route('public.profile') }}" class="px-3.5 py-2 rounded-lg transition {{ request()->routeIs('public.profile') ? 'text-brand bg-brand-light' : 'hover:text-navy hover:bg-slate-100' }}">
                        Profil Sekolah
                    </a>
                    <a href="{{ route('public.news.index') }}" class="px-3.5 py-2 rounded-lg transition {{ request()->routeIs('public.news.*') ? 'text-brand bg-brand-light' : 'hover:text-navy hover:bg-slate-100' }}">
                        Berita
                    </a>
                    <a href="{{ route('public.announcements.index') }}" class="px-3.5 py-2 rounded-lg transition {{ request()->routeIs('public.announcements.*') ? 'text-brand bg-brand-light' : 'hover:text-navy hover:bg-slate-100' }}">
                        Pengumuman
                    </a>
                    <a href="{{ route('public.events.index') }}" class="px-3.5 py-2 rounded-lg transition {{ request()->routeIs('public.events.*') ? 'text-brand bg-brand-light' : 'hover:text-navy hover:bg-slate-100' }}">
                        Agenda Acara
                    </a>
                </nav>

                <!-- Auth Action Button (Desktop) -->
                <div class="hidden md:flex items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-navy hover:bg-navy-light text-white text-xs font-bold shadow-xs transition">
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                            Buka Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-4.5 py-2.5 rounded-lg bg-brand hover:bg-brand-hover text-white text-xs font-bold shadow-xs transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                            Masuk Portal (Guru & Admin)
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button type="button" onclick="togglePublicMobileMenu()" class="p-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 focus:outline-hidden">
                        <svg id="menu-open-icon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <svg id="menu-close-icon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu Dropdown -->
            <div id="mobile-menu" class="hidden md:hidden border-t border-border py-4 space-y-2">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('home') ? 'text-brand bg-brand-light' : 'text-slate-700 hover:bg-slate-50' }}">
                    Beranda
                </a>
                <a href="{{ route('public.profile') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('public.profile') ? 'text-brand bg-brand-light' : 'text-slate-700 hover:bg-slate-50' }}">
                    Profil Sekolah
                </a>
                <a href="{{ route('public.news.index') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('public.news.*') ? 'text-brand bg-brand-light' : 'text-slate-700 hover:bg-slate-50' }}">
                    Berita
                </a>
                <a href="{{ route('public.announcements.index') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('public.announcements.*') ? 'text-brand bg-brand-light' : 'text-slate-700 hover:bg-slate-50' }}">
                    Pengumuman
                </a>
                <a href="{{ route('public.events.index') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('public.events.*') ? 'text-brand bg-brand-light' : 'text-slate-700 hover:bg-slate-50' }}">
                    Agenda Acara
                </a>
                <div class="pt-3 border-t border-border">
                    @auth
                        <a href="{{ route('dashboard') }}" class="w-full text-center block px-4 py-2.5 rounded-lg bg-navy text-white text-xs font-bold">
                            Buka Dashboard Internal
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="w-full text-center block px-4 py-2.5 rounded-lg bg-brand text-white text-xs font-bold">
                            Masuk Portal (Guru & Admin)
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Public Main Content -->
    <main class="flex-1">
        {{ $slot }}
    </main>

    <!-- Public Footer -->
    <footer class="bg-navy text-slate-300 pt-16 pb-12 border-t border-navy-light/40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 pb-12 border-b border-slate-700/60">
                <!-- Col 1: Identity -->
                <div class="md:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-brand text-white flex items-center justify-center font-bold text-xl">
                            S
                        </div>
                        <span class="font-bold text-white text-xl tracking-tight">Satu-Sekolah</span>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed max-w-md">
                        Satu-Sekolah adalah platform sistem informasi manajemen sekolah modern yang mengintegrasikan akademik, presensi terverifikasi, jadwal pelajaran, kegiatan Praktik Kerja Lapangan (PKL), dan administrasi sekolah dalam satu ekosistem terpadu.
                    </p>
                    <div class="pt-2 text-xs text-slate-400 space-y-1">
                        <p><strong class="text-slate-300">Alamat:</strong> Jl. Pendidikan No. 123, Komplek Pendidikan Terpadu, Kota Pendidikan</p>
                        <p><strong class="text-slate-300">Email Resmi:</strong> info@oneschool.sch.id | tu@oneschool.sch.id</p>
                        <p><strong class="text-slate-300">Telepon / Fax:</strong> (021) 7890-1234</p>
                    </div>
                </div>

                <!-- Col 2: Navigasi Cepat -->
                <div>
                    <h3 class="text-xs font-bold text-white uppercase tracking-wider mb-4">Navigasi Informasi</h3>
                    <ul class="space-y-2 text-xs text-slate-400">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition">Beranda Utama</a></li>
                        <li><a href="{{ route('public.profile') }}" class="hover:text-white transition">Profil & Visi Misi</a></li>
                        <li><a href="{{ route('public.news.index') }}" class="hover:text-white transition">Kabar & Berita Sekolah</a></li>
                        <li><a href="{{ route('public.announcements.index') }}" class="hover:text-white transition">Pengumuman Akademik</a></li>
                        <li><a href="{{ route('public.events.index') }}" class="hover:text-white transition">Agenda Acara Mendatang</a></li>
                    </ul>
                </div>

                <!-- Col 3: Akses Sistem -->
                <div>
                    <h3 class="text-xs font-bold text-white uppercase tracking-wider mb-4">Akses Sistem</h3>
                    <ul class="space-y-2 text-xs text-slate-400">
                        <li><a href="{{ route('login') }}" class="hover:text-white transition">Portal Guru & Admin Web</a></li>
                        <li><span class="text-slate-500 cursor-not-allowed">Aplikasi Mobile Siswa (Android / iOS)</span></li>
                        <li><span class="text-slate-500 cursor-not-allowed">Portal Monitoring PKL Industri</span></li>
                    </ul>
                    <div class="mt-6 p-3 rounded-lg bg-navy-dark/60 border border-slate-700/60 text-[11px] text-slate-400">
                        <strong class="text-slate-200 block mb-1">Catatan Keamanan:</strong>
                        Siswa melakukan absensi dan pengisian jurnal kegiatan PKL khusus melalui aplikasi mobile.
                    </div>
                </div>
            </div>

            <!-- Bottom Copyright -->
            <div class="pt-8 flex flex-col sm:flex-row sm:items-center justify-between text-xs text-slate-500 gap-4">
                <p>&copy; {{ date('Y') }} Satu-Sekolah. Hak Cipta Dilindungi Undang-Undang.</p>
                <p class="text-[11px]">Dikembangkan dengan prinsip keamanan data institusi pendidikan.</p>
            </div>
        </div>
    </footer>

    <!-- Interactive script for mobile menu -->
    <script>
        function togglePublicMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const openIcon = document.getElementById('menu-open-icon');
            const closeIcon = document.getElementById('menu-close-icon');
            menu.classList.toggle('hidden');
            openIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
        }
    </script>
</body>
</html>
