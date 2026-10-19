<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} — {{ config('app.name', 'SatuSekolah') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

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
                        canvas: '#F8FAFC',
                        surface: '#FFFFFF',
                        border: '#E2E8F0',
                        success: '#059669',
                        warning: '#D97706',
                        danger: '#E11D48',
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                    boxShadow: {
                        'card': '0 4px 20px -2px rgba(15, 23, 42, 0.05), 0 2px 6px -1px rgba(15, 23, 42, 0.02)',
                        'glow': '0 0 20px -3px rgba(79, 70, 229, 0.35)',
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
<body class="h-full font-sans antialiased text-slate-800 flex overflow-hidden bg-slate-50 selection:bg-brand selection:text-white">

    <!-- Sidebar Overlay (Mobile) -->
    <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 z-40 bg-slate-950/60 backdrop-blur-xs lg:hidden hidden transition-opacity"></div>

    <!-- Sidebar Desktop & Mobile -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 border-r border-slate-800 text-slate-200 flex flex-col transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0 lg:static lg:inset-auto lg:z-auto shadow-2xl lg:shadow-none">
        
        <!-- Brand / Header -->
        <div class="h-16 flex items-center justify-between px-5 border-b border-slate-800 bg-slate-950/40">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                <div class="w-9 h-9 rounded-xl bg-white p-1 flex items-center justify-center shadow-md shadow-brand/20 group-hover:scale-105 transition-transform duration-200">
                    <img src="{{ asset('images/logo/icon.png') }}" alt="oneSchool" class="w-full h-full object-contain">
                </div>
                <div>
                    <div class="flex items-center gap-1.5">
                        <span class="font-extrabold text-white text-base tracking-tight leading-tight">oneSchool</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    </div>
                    <span class="text-[10px] text-slate-400 font-medium">Digital Learning Platform</span>
                </div>
            </a>
            <button onclick="toggleSidebar()" class="lg:hidden p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 px-3 py-4 overflow-y-auto space-y-5 text-xs sidebar-scroll">
            
            <!-- Menu Utama -->
            <div>
                <p class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Menu Utama</p>
                <div class="space-y-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-semibold transition-all duration-150 {{ request()->routeIs('*.dashboard') || request()->routeIs('dashboard') ? 'bg-gradient-to-r from-brand to-indigo-600 text-white shadow-md shadow-brand/25' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('*.dashboard') || request()->routeIs('dashboard') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span>Dashboard</span>
                    </a>
                </div>
            </div>

            <!-- Bagian Administrasi (Khusus Admin) -->
            @role('admin')
            <div>
                <p class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Administrasi</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-r from-brand to-indigo-600 text-white shadow-md shadow-brand/25 font-bold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <span>Kelola Pengguna</span>
                    </a>
                </div>
            </div>

            <!-- Data Master (Khusus Admin) -->
            <div>
                <p class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Data Master</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.academic-years.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('admin.academic-years.*') ? 'bg-gradient-to-r from-brand to-indigo-600 text-white shadow-md shadow-brand/25 font-bold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.academic-years.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Tahun Ajaran</span>
                    </a>
                    <a href="{{ route('admin.teachers.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('admin.teachers.*') ? 'bg-gradient-to-r from-brand to-indigo-600 text-white shadow-md shadow-brand/25 font-bold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.teachers.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        <span>Data Guru</span>
                    </a>
                    <a href="{{ route('admin.classrooms.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('admin.classrooms.*') ? 'bg-gradient-to-r from-brand to-indigo-600 text-white shadow-md shadow-brand/25 font-bold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.classrooms.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <span>Data Rombel / Kelas</span>
                    </a>
                    <a href="{{ route('admin.students.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('admin.students.*') ? 'bg-gradient-to-r from-brand to-indigo-600 text-white shadow-md shadow-brand/25 font-bold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.students.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg>
                        <span>Data Siswa</span>
                    </a>
                    <a href="{{ route('admin.subjects.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('admin.subjects.*') ? 'bg-gradient-to-r from-brand to-indigo-600 text-white shadow-md shadow-brand/25 font-bold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.subjects.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        <span>Mata Pelajaran</span>
                    </a>
                    <a href="{{ route('admin.rooms.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('admin.rooms.*') ? 'bg-gradient-to-r from-brand to-indigo-600 text-white shadow-md shadow-brand/25 font-bold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.rooms.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>
                        <span>Ruangan</span>
                    </a>
                    <a href="{{ route('admin.internship-companies.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('admin.internship-companies.*') ? 'bg-gradient-to-r from-brand to-indigo-600 text-white shadow-md shadow-brand/25 font-bold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.internship-companies.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>Mitra Industri PKL</span>
                    </a>
                </div>
            </div>

            <!-- Akademik & Jadwal (Admin) -->
            <div>
                <p class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Akademik</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.schedules.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('admin.schedules.*') ? 'bg-gradient-to-r from-brand to-indigo-600 text-white shadow-md shadow-brand/25 font-bold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.schedules.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Jadwal Pelajaran</span>
                    </a>
                </div>
            </div>

            <!-- Monitoring PKL (Admin) -->
            <div>
                <p class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Monitoring PKL</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.internships.placements.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('admin.internships.placements.*') ? 'bg-gradient-to-r from-brand to-indigo-600 text-white shadow-md shadow-brand/25 font-bold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.internships.placements.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <span>Penempatan Siswa</span>
                    </a>
                    <a href="{{ route('admin.internships.attendances.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('admin.internships.attendances.*') ? 'bg-gradient-to-r from-brand to-indigo-600 text-white shadow-md shadow-brand/25 font-bold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.internships.attendances.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        <span>Presensi &amp; Koreksi PKL</span>
                    </a>
                </div>
            </div>

            <!-- Publikasi & Konten (Admin) -->
            <div>
                <p class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Publikasi Informasi</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.posts.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('admin.posts.*') ? 'bg-gradient-to-r from-brand to-indigo-600 text-white shadow-md shadow-brand/25 font-bold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.posts.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        <span>Berita, Pengumuman, &amp; Acara</span>
                    </a>
                </div>
            </div>

            <!-- Laporan Institusi (Admin) -->
            <div>
                <p class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Laporan Institusi</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.reports.academic') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('admin.reports.academic') ? 'bg-gradient-to-r from-brand to-indigo-600 text-white shadow-md shadow-brand/25 font-bold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.reports.academic') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Rekap Akademik</span>
                    </a>
                    <a href="{{ route('admin.reports.internship') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('admin.reports.internship') ? 'bg-gradient-to-r from-brand to-indigo-600 text-white shadow-md shadow-brand/25 font-bold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.reports.internship') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Rekapitulasi PKL</span>
                    </a>
                </div>
            </div>
            @endrole

            <!-- Kegiatan Guru -->
            @role('guru')
            <div>
                <p class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Portal Guru</p>
                <div class="space-y-1">
                    <a href="{{ route('teacher.schedules.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('teacher.schedules.*') ? 'bg-gradient-to-r from-brand to-indigo-600 text-white shadow-md shadow-brand/25 font-bold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('teacher.schedules.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Jadwal Mengajar</span>
                    </a>
                    <a href="{{ route('teacher.attendances.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('teacher.attendances.*') ? 'bg-gradient-to-r from-brand to-indigo-600 text-white shadow-md shadow-brand/25 font-bold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('teacher.attendances.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        <span>Presensi Siswa Mapel</span>
                    </a>
                </div>
            </div>
            @endrole

            <!-- Wali Kelas -->
            @role('wali_kelas')
            <div>
                <p class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Wali Kelas</p>
                <div class="space-y-1">
                    <a href="{{ route('homeroom.dashboard') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('homeroom.dashboard') ? 'bg-gradient-to-r from-brand to-indigo-600 text-white shadow-md shadow-brand/25 font-bold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('homeroom.dashboard') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <span>Kelas Binaan Saya</span>
                    </a>
                    <a href="{{ route('homeroom.attendances.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('homeroom.attendances.*') ? 'bg-gradient-to-r from-brand to-indigo-600 text-white shadow-md shadow-brand/25 font-bold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('homeroom.attendances.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Rekap Presensi Harian</span>
                    </a>
                </div>
            </div>
            @endrole

            <!-- Pembimbing PKL -->
            @role('guru_pembimbing_pkl')
            <div>
                <p class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Bimbingan PKL</p>
                <div class="space-y-1">
                    <a href="{{ route('internship-mentor.dashboard') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('internship-mentor.dashboard') ? 'bg-gradient-to-r from-brand to-indigo-600 text-white shadow-md shadow-brand/25 font-bold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('internship-mentor.dashboard') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        <span>Dashboard Pembimbing</span>
                    </a>
                    <a href="{{ route('internship-mentor.students.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('internship-mentor.students.*') ? 'bg-gradient-to-r from-brand to-indigo-600 text-white shadow-md shadow-brand/25 font-bold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('internship-mentor.students.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <span>Siswa Bimbingan</span>
                    </a>
                    <a href="{{ route('internship-mentor.attendances.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('internship-mentor.attendances.*') ? 'bg-gradient-to-r from-brand to-indigo-600 text-white shadow-md shadow-brand/25 font-bold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('internship-mentor.attendances.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Presensi &amp; GPS PKL</span>
                    </a>
                    <a href="{{ route('internship-mentor.journals.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('internship-mentor.journals.*') ? 'bg-gradient-to-r from-brand to-indigo-600 text-white shadow-md shadow-brand/25 font-bold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('internship-mentor.journals.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        <span>Jurnal Harian Siswa</span>
                    </a>
                    <a href="{{ route('internship-mentor.leaves.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('internship-mentor.leaves.*') ? 'bg-gradient-to-r from-brand to-indigo-600 text-white shadow-md shadow-brand/25 font-bold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('internship-mentor.leaves.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Pengajuan Izin / Sakit</span>
                    </a>
                    <a href="{{ route('internship-mentor.tasks.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 {{ request()->routeIs('internship-mentor.tasks.*') ? 'bg-gradient-to-r from-brand to-indigo-600 text-white shadow-md shadow-brand/25 font-bold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('internship-mentor.tasks.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        <span>Tugas &amp; Proyek PKL</span>
                    </a>
                </div>
            </div>
            @endrole

            <!-- Info Role Aktif Pengguna -->
            <div class="pt-3 border-t border-slate-800/80">
                <p class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Peran Aktif</p>
                <div class="px-3 flex flex-wrap gap-1.5">
                    @foreach (Auth::user()->roles as $role)
                        @php
                            $badgeColor = match($role->name) {
                                'admin' => 'bg-indigo-950/80 text-indigo-300 border-indigo-700/50',
                                'guru' => 'bg-emerald-950/80 text-emerald-300 border-emerald-700/50',
                                'wali_kelas' => 'bg-amber-950/80 text-amber-300 border-amber-700/50',
                                'guru_pembimbing_pkl' => 'bg-sky-950/80 text-sky-300 border-sky-700/50',
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
        <div class="p-3.5 border-t border-slate-800 bg-slate-950/50 flex items-center justify-between">
            <div class="flex items-center gap-2.5 min-w-0">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-brand to-violet-500 text-white flex items-center justify-center font-bold text-xs uppercase shrink-0 shadow-xs">
                    {{ substr(Auth::user()->name, 0, 2) }}
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-bold text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-slate-400 truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" title="Keluar dari Portal" class="p-2 rounded-xl text-slate-400 hover:text-rose-400 hover:bg-rose-500/10 transition-colors cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-slate-50">
        
        <!-- Topbar -->
        <header class="h-16 bg-white/90 backdrop-blur-md border-b border-slate-200/80 flex items-center justify-between px-4 sm:px-6 z-10 shrink-0">
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()" aria-label="Toggle Sidebar" class="lg:hidden p-2 rounded-xl text-slate-600 hover:text-navy hover:bg-slate-100 transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div class="flex items-center gap-2">
                    <h1 class="text-base sm:text-lg font-extrabold text-navy truncate tracking-tight">{{ $header ?? 'Dashboard' }}</h1>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <!-- Jump to Public Web Link -->
                <a href="{{ route('public.home') }}" target="_blank" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-slate-600 hover:text-brand bg-slate-100 hover:bg-indigo-50 border border-slate-200/80 transition-all">
                    <span>Web Sekolah</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>

                <div class="hidden sm:flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100/80 border border-slate-200/60 text-xs font-medium text-slate-600">
                    <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>{{ now()->translatedFormat('l, d F Y') }}</span>
                </div>

                <div class="flex items-center gap-1.5">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/80">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Sesi Aktif
                    </span>
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
            {{ $slot }}
        </main>
    </div>

    <!-- Mobile Sidebar Toggle Script -->
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
    </script>
</body>
</html>
