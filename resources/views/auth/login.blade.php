<x-guest-layout title="Masuk ke Portal">
    <!-- Main Modal Split Container matching Reference Image with High Contrast -->
    <div class="bg-white rounded-[32px] sm:rounded-[36px] border border-slate-200/90 shadow-2xl shadow-slate-900/10 p-4 sm:p-6 lg:p-7 grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
        
        <!-- Left Column: Authentication Form -->
        <div class="lg:col-span-6 flex flex-col justify-between py-2 sm:py-4 px-2 sm:px-6">
            
            <!-- Top Bar: Brand Logo & Public Link -->
            <div class="flex items-center justify-between">
                <a href="{{ route('public.home') }}" class="inline-flex items-center gap-2.5 group">
                    <img src="{{ asset('images/logo/logo.png') }}" alt="oneSchool Satu-Sekolah" class="h-10 sm:h-11 w-auto object-contain group-hover:scale-[1.02] transition-transform duration-200">
                    <span class="sr-only">Satu-Sekolah</span>
                </a>

                <a href="{{ route('public.home') }}" class="text-xs font-bold text-slate-600 hover:text-[#16646A] flex items-center gap-1.5 transition px-3 py-1.5 rounded-xl bg-slate-100/80 hover:bg-slate-200/80">
                    <span>Ke Beranda</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <!-- Form Body -->
            <div class="my-auto py-8 max-w-md w-full mx-auto">
                
                <!-- Headline & Intro -->
                <div class="text-center sm:text-left space-y-1.5 mb-6">
                    <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                        Masuk ke Portal Satu-Sekolah
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-600 font-medium leading-relaxed">
                        Silakan masukkan kredensial akun Anda untuk mengakses sistem akademik & administrasi.
                    </p>
                </div>

                <!-- Session Feedback & Error Notifications -->
                @if (session('info'))
                    <div class="mb-5 rounded-2xl bg-blue-50 border border-blue-300 p-3.5 text-xs text-blue-900 flex items-center gap-2.5 font-medium shadow-xs">
                        <svg class="w-4 h-4 text-blue-700 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ session('info') }}</span>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-5 rounded-2xl bg-emerald-50 border border-emerald-300 p-3.5 text-xs text-emerald-900 flex items-center gap-2.5 font-medium shadow-xs">
                        <svg class="w-4 h-4 text-emerald-700 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-5 rounded-2xl bg-rose-50 border border-rose-300 p-3.5 text-xs text-rose-900 shadow-xs">
                        <div class="font-bold flex items-center gap-1.5 mb-1 text-rose-950">
                            <svg class="w-4 h-4 text-rose-700" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            <span>Gagal Masuk:</span>
                        </div>
                        <ul class="list-disc list-inside text-xs space-y-0.5 text-rose-800 font-medium">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form Inputs -->
                <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
                    @csrf

                    <!-- Email Address Field -->
                    <div>
                        <label for="email" class="block text-xs font-extrabold text-slate-800 mb-1.5">
                            Email Address <span class="text-rose-600">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                            </span>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}" 
                                required 
                                autofocus 
                                autocomplete="username"
                                placeholder="Enter your email address"
                                class="block w-full pl-10 pr-4 py-3 rounded-xl border @error('email') border-rose-400 bg-rose-50 text-rose-950 @else border-slate-300 bg-white text-slate-900 @enderror text-xs sm:text-sm font-medium placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#16646A]/25 focus:border-[#16646A] transition shadow-2xs"
                            >
                        </div>
                        @error('email')
                            <p class="mt-1 text-xs text-rose-700 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-xs font-extrabold text-slate-800">
                                Password <span class="text-rose-600">*</span>
                            </label>
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </span>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                required 
                                autocomplete="current-password"
                                placeholder="Enter your password"
                                class="block w-full pl-10 pr-11 py-3 rounded-xl border @error('password') border-rose-400 bg-rose-50 text-rose-950 @else border-slate-300 bg-white text-slate-900 @enderror text-xs sm:text-sm font-medium placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#16646A]/25 focus:border-[#16646A] transition shadow-2xs"
                            >
                            <button 
                                type="button" 
                                onclick="togglePasswordVisibility()" 
                                aria-label="Toggle password visibility" 
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-500 hover:text-slate-800 cursor-pointer"
                            >
                                <svg id="eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-xs text-rose-700 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between pt-0.5">
                        <label class="flex items-center gap-2 cursor-pointer select-none">
                            <input 
                                type="checkbox" 
                                name="remember" 
                                class="w-4 h-4 rounded text-[#16646A] focus:ring-[#16646A]/30 border-slate-300 transition"
                            >
                            <span class="text-xs text-slate-700 font-semibold">Ingat saya</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="text-xs font-bold text-[#16646A] hover:text-[#0E4145] hover:underline transition">
                            Lupa kata sandi?
                        </a>
                    </div>

                    <!-- Submit Button: Masuk ke Portal -->
                    <div class="pt-2">
                        <button 
                            type="submit" 
                            class="w-full flex justify-center items-center gap-2 py-3.5 px-4 rounded-xl text-sm font-extrabold text-white bg-[#16646A] hover:bg-[#125257] active:bg-[#0E4145] shadow-lg shadow-[#16646A]/30 hover:shadow-[#16646A]/45 hover:-translate-y-0.5 transition duration-150 cursor-pointer"
                        >
                            <span>Masuk ke Portal</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </div>
                </form>

                <!-- Divider & Google OAuth SSO Button -->
                <div class="mt-6 pt-5 border-t border-slate-200">
                    <div class="relative flex items-center justify-center mb-4">
                        <span class="px-3 bg-white text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                            Atau masuk dengan
                        </span>
                    </div>

                    <a href="{{ route('oauth.google') }}" class="w-full flex items-center justify-center gap-3 py-3 px-4 rounded-xl text-xs sm:text-sm font-bold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 hover:border-slate-300 shadow-xs hover:shadow-sm transition-all duration-150 cursor-pointer group">
                        <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                        </svg>
                        <span class="group-hover:text-slate-900 transition-colors">Masuk dengan Google</span>
                    </a>
                </div>
            </div>

            <!-- Footer: Copyright & Legal Links -->
            <div class="pt-6 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 font-medium gap-2">
                <span>Copyright &copy; Satu-Sekolah, All Rights Reserved</span>
                <div class="flex items-center gap-2">
                    <a href="{{ route('public.home') }}" class="hover:text-slate-800 hover:underline">Term &amp; Condition</a>
                    <span>&bull;</span>
                    <a href="{{ route('public.home') }}" class="hover:text-slate-800 hover:underline">Privacy Policy</a>
                </div>
            </div>
        </div>

        <!-- Right Column: Visual Showcase Container with Crisp High Contrast -->
        <div class="lg:col-span-6 rounded-[28px] bg-gradient-to-b from-[#0C2B2E] via-[#081F22] to-[#0A2629] p-7 sm:p-9 lg:p-10 flex flex-col justify-between relative overflow-hidden shadow-2xl border border-teal-900/40"
             style="background-image: linear-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px), linear-gradient(90deg, rgba(255, 255, 255, 0.05) 1px, transparent 1px); background-size: 32px 32px;">
            
            <!-- Ambient Radial Glow in Top Corner -->
            <div class="absolute -top-16 -right-16 w-80 h-80 bg-[#22B4BB]/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-16 -left-16 w-80 h-80 bg-[#16646A]/30 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Top Floating UI Mockup Cards (High Contrast Dark Text on White Cards) -->
            <div class="relative py-4 z-10 space-y-4">
                
                <!-- Card 1: Presensi Siswa (Top / Center) -->
                <div class="w-full max-w-[290px] bg-white text-slate-900 rounded-2xl p-4 shadow-2xl border border-white/90 transform -rotate-1 hover:rotate-0 transition duration-300">
                    <div class="flex items-center justify-between text-xs mb-3">
                        <span class="font-extrabold text-slate-900">Presensi Hari Ini</span>
                        <span class="text-[10px] font-bold text-slate-600 bg-slate-100 px-2 py-0.5 rounded-full">Sesi Pagi</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <!-- Donut Graphic Ring -->
                        <div class="relative w-14 h-14 shrink-0 flex items-center justify-center">
                            <svg class="w-14 h-14 -rotate-90" viewBox="0 0 36 36">
                                <circle cx="18" cy="18" r="14" fill="none" class="stroke-slate-200" stroke-width="4"></circle>
                                <circle cx="18" cy="18" r="14" fill="none" class="stroke-[#16646A]" stroke-width="4" stroke-dasharray="88 100" stroke-linecap="round"></circle>
                            </svg>
                            <span class="absolute text-[12px] font-black text-slate-900">98%</span>
                        </div>
                        <div>
                            <span class="text-xl font-black text-slate-900 block leading-tight">32 Siswa</span>
                            <span class="text-[11px] text-emerald-700 font-extrabold block mt-0.5">● Hadir Tepat Waktu</span>
                            <span class="text-[10px] text-slate-600 font-semibold block mt-0.5">1 Izin Surat &bull; 0 Alpa</span>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Monitoring PKL Industri (Middle / Right) -->
                <div class="w-full max-w-[300px] bg-white text-slate-900 rounded-2xl p-4 shadow-2xl border border-white/90 ml-auto -mt-6 transform rotate-2 hover:rotate-0 transition duration-300 relative z-20">
                    <div class="flex items-center justify-between text-xs mb-1.5">
                        <span class="font-extrabold text-slate-900">Monitoring PKL</span>
                        <span class="text-[10px] text-emerald-800 font-extrabold bg-emerald-100 px-2 py-0.5 rounded-full border border-emerald-200">
                            Geofence GPS OK
                        </span>
                    </div>
                    <p class="text-xs font-black text-[#16646A]">PT Inovasi Teknologi Nusantara</p>
                    <div class="mt-2.5">
                        <div class="flex justify-between text-[11px] mb-1 font-bold text-slate-700">
                            <span>Target Jurnal Bulanan</span>
                            <span class="text-slate-900 font-black">85%</span>
                        </div>
                        <div class="w-full h-2 bg-slate-200 rounded-full overflow-hidden">
                            <div class="h-full bg-[#16646A] rounded-full" style="width: 85%"></div>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Jadwal Mengajar KBM (Lower / Left) -->
                <div class="w-full max-w-[320px] bg-white text-slate-900 rounded-2xl p-4 shadow-2xl border border-white/90 -mt-5 transform -rotate-1 hover:rotate-0 transition duration-300 relative z-30">
                    <div class="flex items-center justify-between text-xs mb-2 pb-1.5 border-b border-slate-200">
                        <div class="flex items-center gap-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span class="font-extrabold text-slate-900">Jadwal Sesi Berjalan</span>
                        </div>
                        <span class="text-[11px] text-slate-700 font-mono font-bold bg-slate-100 px-2 py-0.5 rounded">08:00 - 09:30</span>
                    </div>
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between text-xs">
                            <span class="font-extrabold text-slate-900">XI RPL 1 &bull; Pemrograman Web</span>
                            <span class="text-[11px] font-extrabold text-[#16646A] bg-teal-50 border border-teal-200 px-2 py-0.5 rounded-md">Lab 1</span>
                        </div>
                        <p class="text-[11px] text-slate-600 font-medium">Pengajar: Budi Santoso, S.Kom</p>
                    </div>
                </div>

            </div>

            <!-- Bottom Showcase Section: Brand Emblem, Headline, Copy & Carousel Dots -->
            <div class="relative z-10 pt-6 text-center">
                <!-- Glowing Brand Emblem Badge with uploaded icon.png -->
                <div class="w-16 h-16 rounded-2xl bg-white p-2.5 flex items-center justify-center mx-auto shadow-2xl shadow-black/40 mb-4 border border-white/30 hover:scale-105 transition-transform duration-200">
                    <img src="{{ asset('images/logo/icon.png') }}" alt="oneSchool" class="w-full h-full object-contain">
                </div>

                <!-- Headline (Crisp Bright Pure White) -->
                <h2 class="text-xl sm:text-2xl font-black text-white tracking-tight leading-snug">
                    A Unified Hub for Smarter School Decision-Making
                </h2>

                <!-- Description (High Contrast Bright Text) -->
                <p class="text-xs sm:text-sm text-slate-100 font-normal max-w-md mx-auto mt-2 leading-relaxed">
                    Satu-Sekolah empowers educators, administrators, and mentors with a unified command center — delivering deep academic insights and a 360&deg; view of your entire school ecosystem.
                </p>

                <!-- 4 Carousel Pagination Bars (Matching Screenshot) -->
                <div class="flex items-center justify-center gap-1.5 mt-6">
                    <span class="w-8 h-1 bg-white rounded-full transition-all"></span>
                    <span class="w-5 h-1 bg-white/40 rounded-full transition-all"></span>
                    <span class="w-5 h-1 bg-white/40 rounded-full transition-all"></span>
                    <span class="w-5 h-1 bg-white/40 rounded-full transition-all"></span>
                </div>
            </div>

        </div>

    </div>

    <!-- Script for Password Eye Toggle -->
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>';
            } else {
                input = document.getElementById('password');
                passwordInput.type = 'password';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
            }
        }
    </script>
</x-guest-layout>
