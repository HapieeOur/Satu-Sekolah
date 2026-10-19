<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Login' }} — {{ config('app.name', 'SatuSekolah') }}</title>
    
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
            <a href="{{ route('public.home') }}" class="inline-flex items-center justify-center group mb-2">
                <img src="{{ asset('images/logo/logo.png') }}" alt="oneSchool" class="h-14 sm:h-16 w-auto object-contain group-hover:scale-[1.03] transition-transform duration-200">
            </a>
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
