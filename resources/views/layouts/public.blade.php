<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Satu-Sekolah' }} — Portal Informasi Sekolah Terpadu</title>
    <meta name="description" content="Sistem Informasi Sekolah Satu-Sekolah — Portal Administrasi Akademik, Presensi, dan Monitoring Praktik Kerja Lapangan.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
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
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="min-h-full font-sans antialiased text-slate-800 bg-[#F8FAFC] flex flex-col justify-between" x-data="{ mobileMenuOpen: false }">

    <!-- Top Navigation Bar -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-border shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Brand / Logo -->
                <a href="{{ route('public.home') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-navy text-white flex items-center justify-center font-extrabold text-lg shadow-sm">
                        S
                    </div>
                    <div>
                        <span class="font-bold text-navy text-base leading-tight block tracking-tight">Satu-Sekolah</span>
                        <span class="text-[11px] text-slate-500 font-medium block">Sistem Informasi Sekolah</span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center gap-6 text-sm font-medium">
                    <a href="{{ route('public.home') }}" class="transition {{ request()->routeIs('public.home') ? 'text-brand font-bold' : 'text-slate-600 hover:text-navy' }}">
                        Beranda
                    </a>
                    <a href="{{ route('public.profile') }}" class="transition {{ request()->routeIs('public.profile') ? 'text-brand font-bold' : 'text-slate-600 hover:text-navy' }}">
                        Profil
                    </a>
                    <a href="{{ route('public.news') }}" class="transition {{ request()->routeIs('public.news*') ? 'text-brand font-bold' : 'text-slate-600 hover:text-navy' }}">
                        Berita
                    </a>
                    <a href="{{ route('public.announcements') }}" class="transition {{ request()->routeIs('public.announcements*') ? 'text-brand font-bold' : 'text-slate-600 hover:text-navy' }}">
                        Pengumuman
                    </a>
                    <a href="{{ route('public.events') }}" class="transition {{ request()->routeIs('public.events*') ? 'text-brand font-bold' : 'text-slate-600 hover:text-navy' }}">
                        Agenda Acara
                    </a>
                </nav>

                <!-- Auth Action Button -->
                <div class="hidden md:flex items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-bold text-white bg-brand hover:bg-brand-hover rounded-lg shadow-sm transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            <span>Ke Dashboard</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-bold text-white bg-navy hover:bg-navy-light rounded-lg shadow-sm transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                            <span>Masuk Portal Guru & Admin</span>
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex items-center md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="p-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div x-show="mobileMenuOpen" x-transition class="md:hidden border-b border-border bg-white px-4 pt-2 pb-4 space-y-2">
            <a href="{{ route('public.home') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('public.home') ? 'bg-blue-50 text-brand' : 'text-slate-700 hover:bg-slate-50' }}">
                Beranda
            </a>
            <a href="{{ route('public.profile') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('public.profile') ? 'bg-blue-50 text-brand' : 'text-slate-700 hover:bg-slate-50' }}">
                Profil Sekolah
            </a>
            <a href="{{ route('public.news') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('public.news*') ? 'bg-blue-50 text-brand' : 'text-slate-700 hover:bg-slate-50' }}">
                Berita Sekolah
            </a>
            <a href="{{ route('public.announcements') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('public.announcements*') ? 'bg-blue-50 text-brand' : 'text-slate-700 hover:bg-slate-50' }}">
                Pengumuman
            </a>
            <a href="{{ route('public.events') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('public.events*') ? 'bg-blue-50 text-brand' : 'text-slate-700 hover:bg-slate-50' }}">
                Agenda Acara
            </a>
            <div class="pt-3 border-t border-slate-100">
                @auth
                    <a href="{{ route('dashboard') }}" class="block w-full text-center px-4 py-2.5 text-xs font-bold text-white bg-brand rounded-lg shadow-sm">
                        Ke Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2.5 text-xs font-bold text-white bg-navy rounded-lg shadow-sm">
                        Masuk Portal Guru & Admin
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-navy text-slate-300 border-t border-navy-light/40 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Col 1: About -->
                <div class="space-y-4 md:col-span-2">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-brand text-white flex items-center justify-center font-extrabold text-base">
                            S
                        </div>
                        <span class="font-bold text-white text-lg tracking-tight">Satu-Sekolah</span>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed max-w-md">
                        Sistem Informasi Manajemen Sekolah Terpadu untuk penyelenggaraan administrasi akademik, pemantauan kehadiran, serta monitoring komprehensif Praktik Kerja Lapangan (PKL) industri.
                    </p>
                    <div class="text-xs text-slate-400 space-y-1">
                        <p>Alamat: Jl. Pendidikan No. 01, Kawasan Edukasi Terpadu</p>
                        <p>Telepon: (021) 7890-1234 &bull; Email: info@satusekolah.sch.id</p>
                    </div>
                </div>

                <!-- Col 2: Quick Links -->
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-white mb-3">Tautan Cepat</h3>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('public.home') }}" class="hover:text-white transition">Beranda Utama</a></li>
                        <li><a href="{{ route('public.profile') }}" class="hover:text-white transition">Profil & Visi Misi</a></li>
                        <li><a href="{{ route('public.news') }}" class="hover:text-white transition">Berita & Informasi</a></li>
                        <li><a href="{{ route('public.announcements') }}" class="hover:text-white transition">Papan Pengumuman</a></li>
                        <li><a href="{{ route('public.events') }}" class="hover:text-white transition">Kalender Acara</a></li>
                    </ul>
                </div>

                <!-- Col 3: Portal Access -->
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-white mb-3">Akses Aplikasi</h3>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('login') }}" class="hover:text-white transition">Portal Guru & Admin</a></li>
                        <li><span class="text-slate-500">Aplikasi Siswa (Khusus Mobile App)</span></li>
                    </ul>
                    <div class="mt-4 p-3 rounded-lg bg-navy-light/40 border border-slate-700/60 text-[11px] text-slate-400">
                        <span class="font-semibold text-slate-300 block mb-1">Catatan Keamanan</span>
                        Akses web diperuntukkan khusus bagi Dewan Guru, Wali Kelas, Pembimbing PKL, dan Administrator.
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-8 border-t border-navy-light/40 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} Satu-Sekolah. Hak Cipta Dilindungi Undang-Undang.</p>
                <p class="mt-2 sm:mt-0 font-mono text-[11px]">Sistem Informasi Akademik & Monitoring PKL</p>
            </div>
        </div>
    </footer>

</body>
</html>
