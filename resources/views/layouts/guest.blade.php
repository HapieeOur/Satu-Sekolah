<!DOCTYPE html>
<html lang="id" class="h-full bg-[#F7F8FA]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Login' }} — {{ config('app.name', 'Satu-Sekolah') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (CDN for zero-dependency standalone execution) -->
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
</head>
<body class="h-full font-sans antialiased text-slate-800 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <!-- School Logo & Header -->
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-xl bg-navy text-white shadow-md mb-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-navy">Satu-Sekolah</h1>
            <p class="mt-1 text-sm text-slate-500">Sistem Informasi Manajemen Sekolah Terpadu</p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-surface py-8 px-6 shadow-sm border border-border rounded-xl sm:px-10">
            {{ $slot }}
        </div>

        <p class="mt-6 text-center text-xs text-slate-400">
            &copy; {{ date('Y') }} Satu-Sekolah. Portal Khusus Tenaga Pendidik & Administrasi.
        </p>
    </div>
</body>
</html>
