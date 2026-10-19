<!DOCTYPE html>
<html lang="id" class="h-full bg-[#EEF3F5]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Masuk ke Portal' }} — Satu-Sekolah</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS with Reference Tokens -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        spruce: {
                            DEFAULT: '#16646A',
                            hover: '#125257',
                            dark: '#0C2B2E',
                            darker: '#081E21',
                            light: '#22B4BB',
                            surface: '#EBF4F5',
                        },
                        navy: {
                            DEFAULT: '#171B61',
                            sidebar: '#131652',
                            dark: '#0D1040',
                        },
                        brand: {
                            DEFAULT: '#16646A',
                            hover: '#125257',
                            indigo: '#233DFF',
                        },
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-full font-sans antialiased text-slate-800 flex items-center justify-center p-3 sm:p-6 lg:p-8 relative overflow-x-hidden bg-[#EEF3F5] selection:bg-[#16646A] selection:text-white">

    <!-- Subtle Ambient Background Glows -->
    <div class="fixed -top-40 -left-40 w-[500px] h-[500px] bg-teal-200/35 rounded-full blur-3xl pointer-events-none"></div>
    <div class="fixed -bottom-40 -right-40 w-[500px] h-[500px] bg-sky-200/35 rounded-full blur-3xl pointer-events-none"></div>
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] bg-white/40 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative z-10 w-full max-w-6xl my-auto">
        {{ $slot }}
    </div>

</body>
</html>
