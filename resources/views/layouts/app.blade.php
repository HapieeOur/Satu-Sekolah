<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? (trim($__env->yieldContent('title')) ?: 'Dashboard') }} — Satu-Sekolah</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS with Reference Image A Tokens -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: {
                            DEFAULT: '#171B61',
                            sidebar: '#131652',
                            dark: '#0D1040',
                            light: '#1F257D',
                            subtle: '#272E8A',
                        },
                        brand: {
                            DEFAULT: '#233DFF',
                            hover: '#1B30D9',
                            light: '#E5ECFF',
                            lavender: '#ECEBFA',
                            dark: '#171B61',
                        },
                        canvas: '#F4F6FB',
                        surface: '#FFFFFF',
                        border: '#E8EDF5',
                        accent: {
                            yellow: '#F4CF52',
                            blue: '#E5ECFF',
                            lavender: '#ECEBFA',
                            active: '#233DFF',
                        },
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                    boxShadow: {
                        'card': '0 4px 20px -2px rgba(23, 27, 97, 0.05), 0 2px 6px -1px rgba(23, 27, 97, 0.02)',
                        'glow': '0 0 20px -3px rgba(35, 61, 255, 0.35)',
                    }
                }
            }
        }
    </script>
    <style>
        /* Custom sleek scrollbar for sidebar */
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.2);
            border-radius: 9999px;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(148, 163, 184, 0.4);
        }
    </style>
</head>
<body class="h-full font-sans antialiased text-slate-800 flex overflow-hidden bg-[#F4F6FB] selection:bg-brand selection:text-white">

    <!-- Sidebar Overlay (Mobile) -->
    <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 z-40 bg-slate-950/60 backdrop-blur-xs lg:hidden hidden transition-opacity"></div>

    <!-- Sidebar Desktop & Mobile (Reference Image A Dark Indigo Vertical Sidebar) -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-[#131652] border-r border-[#1C206B] text-slate-200 flex flex-col transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0 lg:static lg:inset-auto lg:z-auto shadow-2xl lg:shadow-none">
        
        <!-- Brand / Header with spacious breathing room -->
        <div class="h-20 min-h-[80px] flex items-center justify-between px-6 py-4 border-b border-[#1C206B] bg-[#0E103D]">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3.5 group">
                <div class="w-11 h-11 rounded-2xl bg-white p-2 flex items-center justify-center shadow-lg shadow-black/20 group-hover:scale-105 transition-transform duration-200 shrink-0">
                    <img src="{{ asset('images/logo/icon.png') }}" alt="oneSchool" class="w-full h-full object-contain">
                </div>
                <div class="min-w-0">
                    <div class="flex items-center gap-1.5">
                        <span class="font-black text-white text-base tracking-tight leading-tight">SATU-SEKOLAH</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-[#F4CF52] shrink-0"></span>
                    </div>
                    <span class="text-[10px] text-indigo-300 font-medium tracking-wide block truncate">Digital School Platform</span>
                </div>
            </a>
            <button onclick="toggleSidebar()" aria-label="Tutup Menu" class="lg:hidden p-2 rounded-xl text-indigo-300 hover:text-white hover:bg-[#1D2275] transition shrink-0 ml-1 cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 px-3 py-4 overflow-y-auto space-y-5 text-xs sidebar-scroll">
            
            <!-- Menu Utama -->
            <div>
                <p class="px-3 text-[10px] font-bold text-indigo-300/70 uppercase tracking-wider mb-1.5">Menu Utama</p>
                <div class="space-y-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-semibold transition-all duration-150 {{ request()->routeIs('*.dashboard') || request()->routeIs('dashboard') ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40' : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('*.dashboard') || request()->routeIs('dashboard') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span>Dashboard</span>
                    </a>
                </div>
            </div>

            <!-- Bagian Administrasi (Khusus Admin) -->
            @role('admin')
            <div>
                <p class="px-3 text-[10px] font-bold text-indigo-300/70 uppercase tracking-wider mb-1.5">Administrasi</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('admin.users.*') ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold' : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <span>Kelola Pengguna</span>
                    </a>
                </div>
            </div>

            <!-- Data Master (Khusus Admin) -->
            <div>
                <p class="px-3 text-[10px] font-bold text-indigo-300/70 uppercase tracking-wider mb-1.5">Data Master</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.academic-years.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('admin.academic-years.*') ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold' : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.academic-years.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Tahun Ajaran</span>
                    </a>
                    <a href="{{ route('admin.teachers.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('admin.teachers.*') ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold' : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.teachers.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        <span>Data Guru</span>
                    </a>
                    <a href="{{ route('admin.classrooms.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('admin.classrooms.*') ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold' : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.classrooms.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <span>Data Rombel / Kelas</span>
                    </a>
                    <a href="{{ route('admin.students.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('admin.students.*') ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold' : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.students.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg>
                        <span>Data Siswa</span>
                    </a>
                    <a href="{{ route('admin.subjects.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('admin.subjects.*') ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold' : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.subjects.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        <span>Mata Pelajaran</span>
                    </a>
                    <a href="{{ route('admin.rooms.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('admin.rooms.*') ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold' : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.rooms.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>
                        <span>Ruangan</span>
                    </a>
                    <a href="{{ route('admin.internship-companies.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('admin.internship-companies.*') ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold' : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.internship-companies.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>Mitra Industri PKL</span>
                    </a>
                </div>
            </div>

            <!-- Akademik & Jadwal (Admin) -->
            <div>
                <p class="px-3 text-[10px] font-bold text-indigo-300/70 uppercase tracking-wider mb-1.5">Akademik</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.schedules.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('admin.schedules.*') ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold' : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.schedules.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Jadwal Pelajaran</span>
                    </a>
                </div>
            </div>

            <!-- Monitoring PKL (Admin) -->
            <div>
                <p class="px-3 text-[10px] font-bold text-indigo-300/70 uppercase tracking-wider mb-1.5">Monitoring PKL</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.internships.placements.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('admin.internships.placements.*') ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold' : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.internships.placements.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <span>Penempatan Siswa</span>
                    </a>
                    <a href="{{ route('admin.internships.attendances.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('admin.internships.attendances.*') ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold' : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.internships.attendances.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        <span>Presensi &amp; Koreksi PKL</span>
                    </a>
                </div>
            </div>

            <!-- Publikasi & Konten (Admin) -->
            <div>
                <p class="px-3 text-[10px] font-bold text-indigo-300/70 uppercase tracking-wider mb-1.5">Publikasi Informasi</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.posts.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('admin.posts.*') ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold' : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.posts.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        <span>Berita, Pengumuman, &amp; Acara</span>
                    </a>
                </div>
            </div>

            <!-- Laporan Institusi (Admin) -->
            <div>
                <p class="px-3 text-[10px] font-bold text-indigo-300/70 uppercase tracking-wider mb-1.5">Laporan Institusi</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.reports.academic') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('admin.reports.academic') ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold' : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.reports.academic') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Rekap Akademik</span>
                    </a>
                    <a href="{{ route('admin.reports.internship') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('admin.reports.internship') ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold' : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.reports.internship') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Rekapitulasi PKL</span>
                    </a>
                </div>
            </div>
            @endrole

            <!-- Kegiatan Guru -->
            @role('guru')
            <div>
                <p class="px-3 text-[10px] font-bold text-indigo-300/70 uppercase tracking-wider mb-1.5">Portal Guru</p>
                <div class="space-y-1">
                    <a href="{{ route('teacher.schedules.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('teacher.schedules.*') ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold' : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('teacher.schedules.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Jadwal Mengajar</span>
                    </a>
                    <a href="{{ route('teacher.attendances.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('teacher.attendances.*') ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold' : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('teacher.attendances.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        <span>Presensi Siswa Mapel</span>
                    </a>
                    <a href="{{ route('teacher.tasks.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('teacher.tasks.*') ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold' : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('teacher.tasks.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        <span>Tugas &amp; Penugasan</span>
                    </a>
                    <a href="{{ route('teacher.exams.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('teacher.exams.*') ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold' : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('teacher.exams.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Ujian Harian</span>
                    </a>
                    <a href="{{ route('teacher.grades.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('teacher.grades.*') ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold' : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('teacher.grades.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        <span>Input &amp; Rekap Nilai</span>
                    </a>
                </div>
            </div>
            @endrole

            <!-- Wali Kelas -->
            @role('wali_kelas')
            <div>
                <p class="px-3 text-[10px] font-bold text-indigo-300/70 uppercase tracking-wider mb-1.5">Wali Kelas</p>
                <div class="space-y-1">
                    <a href="{{ route('homeroom.dashboard') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('homeroom.dashboard') ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold' : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('homeroom.dashboard') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <span>Kelas Binaan Saya</span>
                    </a>
                    <a href="{{ route('homeroom.students.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('homeroom.students.*') ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold' : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('homeroom.students.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <span>Daftar Siswa Binaan</span>
                    </a>
                    <a href="{{ route('homeroom.attendances.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('homeroom.attendances.*') ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold' : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('homeroom.attendances.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Rekap Presensi Harian</span>
                    </a>
                    <a href="{{ route('homeroom.grades.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('homeroom.grades.*') ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold' : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('homeroom.grades.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        <span>Buku Nilai Kelas</span>
                    </a>
                </div>
            </div>
            @endrole

            <!-- Pembimbing PKL -->
            @role('guru_pembimbing_pkl')
            <div>
                <p class="px-3 text-[10px] font-bold text-indigo-300/70 uppercase tracking-wider mb-1.5">Bimbingan PKL</p>
                <div class="space-y-1">
                    <a href="{{ route('internship-mentor.dashboard') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('internship-mentor.dashboard') ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold' : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('internship-mentor.dashboard') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        <span>Dashboard Pembimbing</span>
                    </a>
                    <a href="{{ route('internship-mentor.students.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('internship-mentor.students.*') ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold' : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('internship-mentor.students.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <span>Siswa Bimbingan</span>
                    </a>
                    <a href="{{ route('internship-mentor.attendances.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('internship-mentor.attendances.*') ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold' : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('internship-mentor.attendances.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Presensi &amp; GPS PKL</span>
                    </a>
                    <a href="{{ route('internship-mentor.journals.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('internship-mentor.journals.*') ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold' : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('internship-mentor.journals.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        <span>Jurnal Harian Siswa</span>
                    </a>
                    <a href="{{ route('internship-mentor.leaves.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('internship-mentor.leaves.*') ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold' : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('internship-mentor.leaves.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Pengajuan Izin / Sakit</span>
                    </a>
                    <a href="{{ route('internship-mentor.tasks.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('internship-mentor.tasks.*') ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold' : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('internship-mentor.tasks.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        <span>Tugas &amp; Proyek PKL</span>
                    </a>
                </div>
            </div>
            @endrole

            <!-- Portal Siswa -->
            @role('siswa')
            <div>
                <p class="px-3 text-[10px] font-bold text-indigo-300/70 uppercase tracking-wider mb-1.5">Portal Siswa</p>
                <div class="space-y-1">
                    <a href="{{ route('student.dashboard') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('student.dashboard') ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold' : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('student.dashboard') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span>Beranda Siswa</span>
                    </a>
                    <a href="{{ route('student.schedules.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('student.schedules.*') ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold' : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('student.schedules.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Jadwal Pelajaran</span>
                    </a>
                    <a href="{{ route('student.attendances.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('student.attendances.*') ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold' : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('student.attendances.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Presensi Saya</span>
                    </a>
                    <a href="{{ route('student.tasks.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('student.tasks.*') ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold' : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('student.tasks.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        <span>Tugas Saya</span>
                    </a>
                    <a href="{{ route('student.exams.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('student.exams.*') ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold' : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('student.exams.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Ujian Harian</span>
                    </a>
                    <a href="{{ route('student.internship.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('student.internship.*') ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold' : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('student.internship.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <span>Informasi PKL</span>
                    </a>
                </div>
            </div>
            @endrole

            <!-- Info Role Aktif Pengguna -->
            <div class="pt-3 border-t border-slate-800/80">
                <p class="px-3 text-[10px] font-bold text-indigo-300/70 uppercase tracking-wider mb-2">Peran Aktif</p>
                <div class="px-3 flex flex-wrap gap-1.5">
                    @foreach (Auth::user()->roles as $role)
                        @php
                            $badgeColor = match($role->name) {
                                'admin' => 'bg-indigo-950/80 text-indigo-300 border-indigo-700/50',
                                'guru' => 'bg-emerald-950/80 text-emerald-300 border-emerald-700/50',
                                'wali_kelas' => 'bg-amber-950/80 text-amber-300 border-amber-700/50',
                                'guru_pembimbing_pkl' => 'bg-sky-950/80 text-sky-300 border-sky-700/50',
                                'siswa' => 'bg-cyan-950/80 text-cyan-300 border-cyan-700/50',
                                default => 'bg-slate-800 text-slate-300 border-slate-700'
                            };
                        @endphp
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold border {{ $badgeColor }}">
                            {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                        </span>
                    @endforeach
                </div>
            </div>
        </nav>

        <!-- Sidebar Footer / User Profile & Logout -->
        <div class="p-4 border-t border-[#1C206B] bg-[#0E103D] flex items-center justify-between">
            <a href="{{ route('profile.show') }}" title="Lihat Profil Saya" class="flex items-center gap-2.5 min-w-0 group hover:opacity-90 transition">
                <div class="w-8 h-8 rounded-full bg-[#233DFF] text-white flex items-center justify-center font-bold text-xs uppercase shrink-0 shadow-xs group-hover:ring-2 group-hover:ring-white/40 transition">
                    {{ substr(Auth::user()->name, 0, 2) }}
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-bold text-white truncate group-hover:text-indigo-200 transition">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-indigo-300/70 truncate">Lihat profil &rarr;</p>
                </div>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" title="Keluar dari Portal" class="p-2 rounded-xl text-indigo-300 hover:text-rose-400 hover:bg-rose-500/10 transition-colors cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-[#F4F6FB]">
        
        <!-- Topbar (Reference Image A Header: Date Navigator, Search, Notification, Profile) -->
        <header class="h-20 min-h-[80px] bg-white/95 backdrop-blur-md border-b border-slate-200/80 flex items-center justify-between px-4 sm:px-6 lg:px-8 z-10 shrink-0">
            <!-- Left: Date Navigator & Header (Reference Image A) -->
            <div class="flex items-center gap-4">
                <button onclick="toggleSidebar()" aria-label="Toggle Sidebar" class="lg:hidden p-2 rounded-xl text-slate-600 hover:text-navy hover:bg-slate-100 transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>

                <!-- Date Navigation (Reference Image A: < Montag, 22 März 2021 >) -->
                <div class="hidden sm:flex items-center gap-2">
                    <div class="inline-flex items-center gap-1.5 p-1 rounded-full bg-slate-100/90 border border-slate-200/80 text-xs font-semibold text-slate-700">
                        <button type="button" aria-label="Tanggal Sebelumnya" class="w-6 h-6 rounded-full bg-white text-slate-600 hover:text-[#233DFF] flex items-center justify-center shadow-xs transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <span class="px-2 font-bold text-[#171B61] text-xs">
                            {{ now()->translatedFormat('l, d F Y') }}
                        </span>
                        <button type="button" aria-label="Tanggal Berikutnya" class="w-6 h-6 rounded-full bg-white text-slate-600 hover:text-[#233DFF] flex items-center justify-center shadow-xs transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>

                    <button type="button" title="Kalender Akademik" class="p-1.5 rounded-xl text-slate-400 hover:text-[#233DFF] hover:bg-slate-100 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </button>
                </div>

                <div class="flex items-center gap-2">
                    <h1 class="text-sm sm:text-base font-extrabold text-[#171B61] truncate tracking-tight">{{ $header ?? 'Dashboard' }}</h1>
                </div>
            </div>

            <!-- Right Controls (Reference Image A: Quick Badge, Search, Bell, Profile) -->
            <div class="flex items-center gap-3">
                <!-- Jump to Public Web Link -->
                <a href="{{ route('public.home') }}" target="_blank" class="hidden md:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold text-slate-600 hover:text-[#233DFF] bg-slate-100/90 hover:bg-blue-50 border border-slate-200/80 transition-all">
                    <span>Web Sekolah</span>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>

                <!-- Search Action (Interactive Modal Trigger) -->
                <button type="button"
                        onclick="openSearchModal()"
                        aria-label="Pencarian Cepat"
                        title="Pencarian Global (Ctrl+K)"
                        class="w-9 h-9 rounded-full bg-slate-100/80 hover:bg-slate-200/80 text-slate-600 hover:text-[#171B61] flex items-center justify-center transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </button>

                <!-- Notifications Bell & Dropdown -->
                <div class="relative" id="notifications-wrapper">
                    <button type="button"
                            onclick="toggleNotificationDropdown()"
                            id="notifications-btn"
                            aria-label="Notifikasi"
                            class="w-9 h-9 rounded-full bg-slate-100/80 hover:bg-slate-200/80 text-slate-600 hover:text-[#171B61] flex items-center justify-center relative transition cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        @if(isset($headerUnreadCount) && $headerUnreadCount > 0)
                            <span class="absolute top-1.5 right-1.5 flex h-2.5 w-2.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#233DFF] opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-[#233DFF] ring-2 ring-white"></span>
                            </span>
                        @endif
                    </button>

                    <!-- Notifications Dropdown Menu -->
                    <div id="notifications-dropdown" class="hidden absolute right-0 mt-2 w-80 sm:w-96 bg-white rounded-2xl shadow-xl border border-slate-200/90 z-50 overflow-hidden">
                        <div class="p-3.5 bg-slate-50/90 border-b border-slate-200/80 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-xs uppercase tracking-wider text-slate-700">Notifikasi</span>
                                @if(isset($headerUnreadCount) && $headerUnreadCount > 0)
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#233DFF] text-white">
                                        {{ $headerUnreadCount }} Baru
                                    </span>
                                @endif
                            </div>
                            <a href="{{ route('notifications.index') }}" class="text-[11px] font-semibold text-[#233DFF] hover:underline">
                                Lihat Semua &rarr;
                            </a>
                        </div>

                        <div class="max-h-80 overflow-y-auto divide-y divide-slate-100">
                            @if(isset($headerNotifications) && $headerNotifications->count() > 0)
                                @foreach($headerNotifications as $notif)
                                    <a href="{{ $notif['url'] }}" class="block p-3.5 hover:bg-slate-50/80 transition-colors {{ $notif['is_unread'] ? 'bg-blue-50/30' : '' }}">
                                        <div class="flex items-start gap-2.5">
                                            <span class="w-2 h-2 rounded-full mt-1.5 shrink-0 {{ $notif['is_unread'] ? 'bg-[#233DFF]' : 'bg-slate-300' }}"></span>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-xs font-bold text-slate-900 truncate">{{ $notif['title'] }}</p>
                                                <p class="text-[11px] text-slate-500 line-clamp-1 mt-0.5">{{ $notif['description'] }}</p>
                                                <span class="text-[10px] text-slate-400 mt-1 block">
                                                    {{ isset($notif['time']) && $notif['time'] ? \Carbon\Carbon::parse($notif['time'])->diffForHumans() : 'Baru saja' }}
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @else
                                <div class="p-6 text-center text-slate-400">
                                    <p class="text-xs">Belum ada pemberitahuan baru.</p>
                                </div>
                            @endif
                        </div>

                        <div class="p-2.5 bg-slate-50/80 border-t border-slate-200/80 text-center">
                            <a href="{{ route('notifications.index') }}" class="text-xs font-bold text-[#171B61] hover:text-[#233DFF] transition-colors">
                                Buka Halaman Notifikasi Lengkap &rarr;
                            </a>
                        </div>
                    </div>
                </div>

                <!-- User Profile Pill & Dropdown -->
                <div class="relative" id="user-profile-wrapper">
                    <button type="button"
                            onclick="toggleUserDropdown()"
                            id="user-profile-btn"
                            class="flex items-center gap-2 pl-2 border-l border-slate-200 hover:opacity-90 transition cursor-pointer">
                        <div class="w-8 h-8 rounded-full bg-[#233DFF] text-white flex items-center justify-center text-xs font-bold uppercase shadow-xs">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="hidden sm:flex flex-col text-left">
                            <span class="text-xs font-bold text-[#171B61] max-w-[120px] truncate leading-tight">
                                {{ Auth::user()->name }}
                            </span>
                            <span class="text-[10px] text-slate-400 leading-tight">
                                {{ ucfirst(str_replace('_', ' ', Auth::user()->roles->first()?->name ?? 'User')) }}
                            </span>
                        </div>
                        <svg class="w-3.5 h-3.5 text-slate-400 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <!-- User Profile Dropdown Menu -->
                    <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-200/90 z-50 overflow-hidden divide-y divide-slate-100">
                        <div class="p-3 bg-slate-50/80">
                            <p class="text-xs font-bold text-slate-900 truncate">{{ Auth::user()->name }}</p>
                            <p class="text-[11px] text-slate-500 truncate">{{ Auth::user()->email }}</p>
                            <div class="mt-1.5 flex flex-wrap gap-1">
                                @foreach (Auth::user()->roles as $role)
                                    <span class="px-1.5 py-0.5 rounded text-[9px] font-bold uppercase bg-blue-50 text-[#233DFF] border border-blue-200/50">
                                        {{ str_replace('_', ' ', $role->name) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <div class="py-1">
                            <a href="{{ route('profile.show') }}" class="flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-[#233DFF] transition-colors">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                <span>Profil Saya</span>
                            </a>
                            <a href="{{ route('notifications.index') }}" class="flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-[#233DFF] transition-colors">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                                <span>Pusat Notifikasi</span>
                            </a>
                            <a href="{{ route('search.index') }}" class="flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-[#233DFF] transition-colors">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                <span>Pencarian Data</span>
                            </a>
                        </div>

                        <div class="p-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50 rounded-lg transition-colors cursor-pointer text-left">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    <span>Keluar dari Portal</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="mx-4 sm:mx-6 mt-4 p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200/80 text-emerald-900 text-xs sm:text-sm font-medium flex items-center justify-between shadow-xs" role="alert">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    </div>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-950 p-1 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="mx-4 sm:mx-6 mt-4 p-3.5 rounded-2xl bg-rose-50 border border-rose-200/80 text-rose-900 text-xs sm:text-sm font-medium flex items-center justify-between shadow-xs" role="alert">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-lg bg-rose-100 text-rose-700 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    </div>
                    <span>{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-700 hover:text-rose-950 p-1 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif

        <!-- Main Scrollable Content -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 space-y-6">
            {{ $slot ?? '' }}
            @yield('content')
        </main>
    </div>

    <!-- Command Palette / Global Search Modal -->
    <div id="search-modal" onclick="handleSearchBackdropClick(event)" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs hidden transition-opacity flex items-start justify-center p-4 sm:p-6 md:p-20">
        <div class="relative w-full max-w-xl bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all">
            <!-- Modal Header / Search Form -->
            <form action="{{ route('search.index') }}" method="GET" class="relative border-b border-slate-200">
                <div class="flex items-center px-4">
                    <svg class="w-5 h-5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text"
                           id="modal-search-input"
                           name="q"
                           placeholder="Cari siswa, NIS, guru, kelas, mapel, atau berita..."
                           autocomplete="off"
                           class="w-full py-4 pl-3 pr-10 text-sm font-medium text-slate-900 placeholder-slate-400 bg-transparent focus:outline-none">
                    <button type="button" onclick="closeSearchModal()" class="p-1 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition">
                        <kbd class="px-1.5 py-0.5 rounded bg-slate-100 border border-slate-200 text-slate-500 font-mono text-[10px]">ESC</kbd>
                    </button>
                </div>
            </form>

            <!-- Live Search Results Container -->
            <div id="modal-search-results" class="max-h-80 overflow-y-auto divide-y divide-slate-100 p-2 text-xs">
                <div class="py-8 text-center text-slate-400" id="search-default-hint">
                    <p class="font-medium text-slate-600">Ketik nama siswa, guru, kelas, atau mapel untuk mencari</p>
                    <p class="text-[11px] text-slate-400 mt-1">Tekan Enter untuk melihat semua hasil lengkap di halaman pencarian.</p>
                </div>
                <div id="search-results-list" class="space-y-1 hidden"></div>
            </div>

            <!-- Modal Footer -->
            <div class="p-2.5 bg-slate-50 border-t border-slate-200/80 flex items-center justify-between text-[11px] text-slate-500">
                <span class="flex items-center gap-1.5 font-medium">
                    <span class="w-2 h-2 rounded-full bg-[#233DFF]"></span>
                    Pencarian Global Satu-Sekolah
                </span>
                <span>Tekan <kbd class="px-1.5 py-0.5 rounded bg-white border border-slate-200 font-mono text-[10px] text-slate-600 font-bold shadow-xs">Enter</kbd> untuk buka semua</span>
            </div>
        </div>
    </div>

    <!-- UI Scripts for Sidebar, Dropdowns, and Search -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }

        // Notification Dropdown
        function toggleNotificationDropdown() {
            const dropdown = document.getElementById('notifications-dropdown');
            const userDropdown = document.getElementById('user-dropdown');
            if (userDropdown) userDropdown.classList.add('hidden');
            dropdown.classList.toggle('hidden');
        }

        // User Profile Dropdown
        function toggleUserDropdown() {
            const dropdown = document.getElementById('user-dropdown');
            const notifDropdown = document.getElementById('notifications-dropdown');
            if (notifDropdown) notifDropdown.classList.add('hidden');
            dropdown.classList.toggle('hidden');
        }

        // Search Modal Handlers
        function openSearchModal() {
            const modal = document.getElementById('search-modal');
            const input = document.getElementById('modal-search-input');
            const notifDropdown = document.getElementById('notifications-dropdown');
            const userDropdown = document.getElementById('user-dropdown');
            if (notifDropdown) notifDropdown.classList.add('hidden');
            if (userDropdown) userDropdown.classList.add('hidden');

            modal.classList.remove('hidden');
            setTimeout(() => input.focus(), 50);
        }

        function closeSearchModal() {
            const modal = document.getElementById('search-modal');
            modal.classList.add('hidden');
        }

        function handleSearchBackdropClick(event) {
            if (event.target.id === 'search-modal') {
                closeSearchModal();
            }
        }

        // Global Click Outside & Keyboard Shortcuts
        document.addEventListener('click', function(e) {
            const notifWrapper = document.getElementById('notifications-wrapper');
            const userWrapper = document.getElementById('user-profile-wrapper');
            const notifDropdown = document.getElementById('notifications-dropdown');
            const userDropdown = document.getElementById('user-dropdown');

            if (notifDropdown && notifWrapper && !notifWrapper.contains(e.target)) {
                notifDropdown.classList.add('hidden');
            }
            if (userDropdown && userWrapper && !userWrapper.contains(e.target)) {
                userDropdown.classList.add('hidden');
            }
        });

        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && (e.key === 'k' || e.key === 'K')) {
                e.preventDefault();
                openSearchModal();
            }
            if (e.key === 'Escape') {
                closeSearchModal();
                const notifDropdown = document.getElementById('notifications-dropdown');
                const userDropdown = document.getElementById('user-dropdown');
                if (notifDropdown) notifDropdown.classList.add('hidden');
                if (userDropdown) userDropdown.classList.add('hidden');
            }
        });

        // Instant Autocomplete Search Debounce
        let searchTimeout = null;
        const searchInput = document.getElementById('modal-search-input');
        const defaultHint = document.getElementById('search-default-hint');
        const resultsList = document.getElementById('search-results-list');

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const query = this.value.trim();

                if (query.length < 2) {
                    defaultHint.classList.remove('hidden');
                    resultsList.classList.add('hidden');
                    resultsList.innerHTML = '';
                    return;
                }

                searchTimeout = setTimeout(() => {
                    fetch(`{{ route('search.api') }}?q=${encodeURIComponent(query)}`)
                        .then(res => res.json())
                        .then(data => {
                            if (data.items && data.items.length > 0) {
                                defaultHint.classList.add('hidden');
                                resultsList.classList.remove('hidden');
                                resultsList.innerHTML = data.items.map(item => `
                                    <a href="${item.url}" class="flex items-center justify-between p-2.5 rounded-xl hover:bg-slate-50 transition-colors">
                                        <div class="min-w-0 flex-1 pr-3">
                                            <p class="font-bold text-slate-900 truncate">${item.title}</p>
                                            <p class="text-[11px] text-slate-500 truncate">${item.subtitle}</p>
                                        </div>
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-600 shrink-0">
                                            ${item.category}
                                        </span>
                                    </a>
                                `).join('') + `
                                    <div class="pt-2 px-2 border-t border-slate-100 text-center">
                                        <a href="{{ route('search.index') }}?q=${encodeURIComponent(query)}" class="text-xs font-bold text-[#233DFF] hover:underline">
                                            Lihat semua hasil untuk "${query}" &rarr;
                                        </a>
                                    </div>
                                `;
                            } else {
                                defaultHint.classList.add('hidden');
                                resultsList.classList.remove('hidden');
                                resultsList.innerHTML = `
                                    <div class="py-6 text-center text-slate-400">
                                        <p class="text-xs">Tidak ditemukan hasil cepat untuk "${query}".</p>
                                        <a href="{{ route('search.index') }}?q=${encodeURIComponent(query)}" class="mt-1.5 inline-block text-xs font-bold text-[#233DFF] hover:underline">
                                            Cari di semua modul &rarr;
                                        </a>
                                    </div>
                                `;
                            }
                        })
                        .catch(() => {
                            // Silently fail or fallback
                        });
                }, 250);
            });
        }
    </script>
</body>
</html>
