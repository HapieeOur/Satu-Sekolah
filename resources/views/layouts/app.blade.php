<!DOCTYPE html>
<html lang="id" class="h-full bg-[#F7F8FA]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} — {{ config('app.name', 'Satu-Sekolah') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

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
<body class="h-full font-sans antialiased text-slate-800 flex overflow-hidden">

    <!-- Sidebar Overlay (Mobile) -->
    <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm lg:hidden hidden"></div>

    <!-- Sidebar Desktop & Mobile -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-navy text-slate-200 flex flex-col transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0 lg:static lg:inset-auto lg:z-auto">
        <!-- Brand / Header -->
        <div class="h-16 flex items-center justify-between px-6 border-b border-navy-light/40">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-brand text-white flex items-center justify-center font-bold text-lg shadow-sm">
                    S
                </div>
                <div>
                    <span class="font-bold text-white tracking-tight leading-none block">Satu-Sekolah</span>
                    <span class="text-[11px] text-slate-400 font-medium">Sistem Informasi</span>
                </div>
            </a>
            <button onclick="toggleSidebar()" class="lg:hidden p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-navy-light">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 px-4 py-5 overflow-y-auto space-y-6 text-sm">
            <!-- Menu Utama -->
            <div>
                <p class="px-3 text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-2">Menu Utama</p>
                <div class="space-y-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium transition {{ request()->routeIs('*.dashboard') || request()->routeIs('dashboard') ? 'bg-brand text-white' : 'text-slate-300 hover:bg-navy-light hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Dashboard
                    </a>
                </div>
            </div>

            <!-- Bagian Administrasi (Khusus Admin) -->
            @role('admin')
            <div>
                <p class="px-3 text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-2">Administrasi</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium transition {{ request()->routeIs('admin.users.*') ? 'bg-brand text-white' : 'text-slate-300 hover:bg-navy-light hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        Kelola Pengguna
                    </a>
                </div>
            </div>

            <!-- Data Master (Khusus Admin) -->
            <div>
                <p class="px-3 text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-2">Data Master</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.academic-years.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium transition {{ request()->routeIs('admin.academic-years.*') ? 'bg-brand text-white' : 'text-slate-300 hover:bg-navy-light hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Tahun Ajaran
                    </a>
                    <a href="{{ route('admin.teachers.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium transition {{ request()->routeIs('admin.teachers.*') ? 'bg-brand text-white' : 'text-slate-300 hover:bg-navy-light hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        Data Guru
                    </a>
                    <a href="{{ route('admin.classrooms.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium transition {{ request()->routeIs('admin.classrooms.*') ? 'bg-brand text-white' : 'text-slate-300 hover:bg-navy-light hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        Data Kelas
                    </a>
                    <a href="{{ route('admin.students.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium transition {{ request()->routeIs('admin.students.*') ? 'bg-brand text-white' : 'text-slate-300 hover:bg-navy-light hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg>
                        Data Siswa
                    </a>
                    <a href="{{ route('admin.subjects.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium transition {{ request()->routeIs('admin.subjects.*') ? 'bg-brand text-white' : 'text-slate-300 hover:bg-navy-light hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        Mata Pelajaran
                    </a>
                    <a href="{{ route('admin.rooms.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium transition {{ request()->routeIs('admin.rooms.*') ? 'bg-brand text-white' : 'text-slate-300 hover:bg-navy-light hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>
                        Ruangan
                    </a>
                    <a href="{{ route('admin.internship-companies.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium transition {{ request()->routeIs('admin.internship-companies.*') ? 'bg-brand text-white' : 'text-slate-300 hover:bg-navy-light hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Mitra PKL
                    </a>
                </div>
            </div>

            <!-- Akademik & Jadwal (Admin) -->
            <div>
                <p class="px-3 text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-2">Akademik</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.schedules.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium transition {{ request()->routeIs('admin.schedules.*') ? 'bg-brand text-white' : 'text-slate-300 hover:bg-navy-light hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Jadwal Pelajaran
                    </a>
                </div>
            </div>
            @endrole

            <!-- Kegiatan Guru -->
            @role('guru')
            <div>
                <p class="px-3 text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-2">Kegiatan Guru</p>
                <div class="space-y-1">
                    <a href="{{ route('teacher.schedules.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium transition {{ request()->routeIs('teacher.schedules.*') ? 'bg-brand text-white' : 'text-slate-300 hover:bg-navy-light hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Jadwal Mengajar
                    </a>
                    <a href="{{ route('teacher.attendances.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium transition {{ request()->routeIs('teacher.attendances.*') ? 'bg-brand text-white' : 'text-slate-300 hover:bg-navy-light hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        Presensi Siswa Mapel
                    </a>
                </div>
            </div>
            @endrole

            <!-- Wali Kelas -->
            @role('wali_kelas')
            <div>
                <p class="px-3 text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-2">Wali Kelas</p>
                <div class="space-y-1">
                    <a href="{{ route('homeroom.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium transition {{ request()->routeIs('homeroom.dashboard') ? 'bg-brand text-white' : 'text-slate-300 hover:bg-navy-light hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        Dashboard Kelas Binaan
                    </a>
                    <a href="{{ route('homeroom.attendances.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium transition {{ request()->routeIs('homeroom.attendances.*') ? 'bg-brand text-white' : 'text-slate-300 hover:bg-navy-light hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Presensi Kelas Binaan
                    </a>
                </div>
            </div>
            @endrole

            <!-- Info Role Aktif Pengguna -->
            <div class="pt-4 border-t border-navy-light/40">
                <p class="px-3 text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-2">Peran Anda</p>
                <div class="px-3 flex flex-wrap gap-1.5">
                    @foreach (Auth::user()->roles as $role)
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-navy-light text-slate-300 border border-slate-600/50">
                            {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                        </span>
                    @endforeach
                </div>
            </div>
        </nav>

        <!-- Sidebar Footer / User Profile -->
        <div class="p-4 border-t border-navy-light/40 bg-navy-dark/40 flex items-center justify-between">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-8 h-8 rounded-full bg-slate-600 text-white flex items-center justify-center font-bold text-xs uppercase shrink-0">
                    {{ substr(Auth::user()->name, 0, 2) }}
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[11px] text-slate-400 truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" title="Keluar" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-300 hover:bg-rose-900/30 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        <!-- Topbar -->
        <header class="h-16 bg-surface border-b border-border flex items-center justify-between px-6 z-10 shrink-0">
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h1 class="text-lg font-bold text-navy truncate">{{ $header ?? 'Dashboard' }}</h1>
            </div>

            <div class="flex items-center gap-4">
                <div class="hidden sm:flex items-center gap-2 text-xs text-slate-500">
                    <span>{{ now()->translatedFormat('l, d F Y') }}</span>
                </div>
                <div class="h-4 w-px bg-border hidden sm:block"></div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                        Aktif
                    </span>
                </div>
            </div>
        </header>

        <!-- Main Body / View Content -->
        <main class="flex-1 overflow-y-auto p-6 bg-canvas">
            <div class="max-w-7xl mx-auto space-y-6">
                <!-- Flash Messages -->
                @if (session('success'))
                    <div class="rounded-lg bg-emerald-50 border border-emerald-200 p-4 text-sm text-emerald-800 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="rounded-lg bg-rose-50 border border-rose-200 p-4 text-sm text-rose-800">
                        <div class="font-medium mb-1">Perhatian:</div>
                        <ul class="list-disc list-inside text-xs space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{ $slot ?? '' }}
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Toggle Script for Mobile -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>
</body>
</html>
