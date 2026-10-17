<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Login' }} — {{ config('app.name', 'SatuSekolah') }}</title>
    
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
                            DEFAULT: '#0F172A',
                            light: '#1E293B',
                            dark: '#020617',
                        },
                        brand: {
                            DEFAULT: '#4F46E5',
                            hover: '#4338CA',
                            light: '#EEF2FF',
                            dark: '#3730A3',
                        },
                        canvas: '#F8FAFC',
                        surface: '#FFFFFF',
                        border: '#E2E8F0',
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-full font-sans antialiased text-slate-800 flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden bg-gradient-to-br from-indigo-50/70 via-slate-50 to-blue-50/60 selection:bg-brand selection:text-white">

    <!-- Decorative Animated Background Orbs -->
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-brand/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-violet-400/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative z-10 sm:mx-auto sm:w-full sm:max-w-md">
        <!-- School Logo & Header -->
        <div class="text-center">
            <a href="{{ route('public.home') }}" class="inline-flex items-center justify-center gap-3 group">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-brand via-indigo-600 to-violet-600 text-white flex items-center justify-center shadow-lg shadow-brand/30 group-hover:scale-105 transition-transform duration-200">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                    </svg>
                </div>
            </a>
            <h1 class="mt-4 text-2xl font-extrabold tracking-tight text-navy">Satu-Sekolah</h1>
            <p class="mt-1 text-xs sm:text-sm text-slate-500 font-medium">Sistem Informasi Manajemen Sekolah &amp; Monitoring PKL</p>
        </div>
    </div>

    <div class="mt-6 relative z-10 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white/95 backdrop-blur-md py-8 px-6 shadow-xl shadow-slate-200/50 border border-slate-200/80 rounded-2xl sm:px-10">
            {{ $slot }}
        </div>

        <!-- Back to Website Link & Footer Note -->
        <div class="mt-6 flex flex-col items-center gap-2 text-xs text-slate-500">
            <a href="{{ route('public.home') }}" class="inline-flex items-center gap-1.5 text-brand font-semibold hover:underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Halaman Utama</span>
            </a>
            <p class="text-[11px] text-slate-400 mt-1">
                &copy; {{ date('Y') }} SatuSekolah. Portal Kepegawaian &amp; Akademik Terpadu.
            </p>
        </div>
    </div>
</body>
</html>
