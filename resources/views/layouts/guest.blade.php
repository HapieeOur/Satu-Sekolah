<!DOCTYPE html>
<html lang="id" class="h-full bg-[#F4F6FB]">
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
                        navy: {
                            DEFAULT: '#171B61',
                            sidebar: '#131652',
                            dark: '#0D1040',
                            light: '#1F257D',
                        },
                        brand: {
                            DEFAULT: '#233DFF',
                            hover: '#1B30D9',
                            light: '#E5ECFF',
                            lavender: '#ECEBFA',
                            dark: '#171B61',
                        },
                        accent: {
                            yellow: '#F4CF52',
                            blue: '#E5ECFF',
                            lavender: '#ECEBFA',
                        },
                        canvas: '#F4F6FB',
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-full font-sans antialiased text-slate-800 flex items-center justify-center p-3 sm:p-6 lg:p-8 relative overflow-x-hidden bg-[#F4F6FB] selection:bg-[#233DFF] selection:text-white">

    <!-- Subtle Ambient Background Glows -->
    <div class="fixed -top-40 -left-40 w-[500px] h-[500px] bg-blue-200/30 rounded-full blur-3xl pointer-events-none"></div>
    <div class="fixed -bottom-40 -right-40 w-[500px] h-[500px] bg-indigo-200/30 rounded-full blur-3xl pointer-events-none"></div>
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] bg-white/50 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative z-10 w-full max-w-6xl my-auto">
        {{ $slot }}
    </div>

</body>
</html>
