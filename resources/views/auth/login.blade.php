<x-guest-layout title="Masuk - Satu-Sekolah">
    <!-- Main Modal Split Container matching Reference Image with High Contrast -->
    <div class="bg-white rounded-[32px] sm:rounded-[36px] border border-slate-200/90 shadow-2xl shadow-slate-900/10 p-4 sm:p-6 lg:p-7 grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
        
        <!-- Left Column: Authentication Form -->
        <div class="lg:col-span-6 flex flex-col justify-between py-2 sm:py-4 px-2 sm:px-6">
            
            <!-- Logo Section: Pure Logo, Centered, Full & Flexible (max-w-md) -->
            <div class="w-full max-w-md mx-auto pt-6 sm:pt-9 pb-5 flex items-center justify-center select-none text-center">
                <img src="{{ asset('images/logo/logo.png') }}" 
                     alt="oneSchool Satu-Sekolah" 
                     class="w-full max-w-sm sm:max-w-md h-auto max-h-20 sm:max-h-24 object-contain object-center mx-auto">
            </div>

            <!-- Form Body -->
            <div class="my-auto py-6 max-w-md w-full mx-auto">
                
                <!-- Headline & Intro -->
                <div class="text-center sm:text-left space-y-1.5 mb-6">
                    <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                        Masuk ke Satu-Sekolah
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

                    <!-- Email / NISN / NIS Field -->
                    <div>
                        <label for="email" class="block text-xs font-extrabold text-slate-800 mb-1.5">
                            Email / NISN / NIS <span class="text-rose-600">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                            </span>
                            <input 
                                type="text" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}" 
                                required 
                                autofocus 
                                autocomplete="username"
                                placeholder="Masukkan email atau NISN siswa"
                                class="block w-full pl-10 pr-4 py-3 rounded-xl border @error('email') border-rose-400 bg-rose-50 text-rose-950 @else border-slate-300 bg-white text-slate-900 @enderror text-xs sm:text-sm font-medium placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] transition shadow-2xs"
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
                                class="block w-full pl-10 pr-11 py-3 rounded-xl border @error('password') border-rose-400 bg-rose-50 text-rose-950 @else border-slate-300 bg-white text-slate-900 @enderror text-xs sm:text-sm font-medium placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] transition shadow-2xs"
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
                                class="w-4 h-4 rounded text-[#233DFF] focus:ring-[#233DFF]/30 border-slate-300 transition"
                            >
                            <span class="text-xs text-slate-700 font-semibold">Ingat saya</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="text-xs font-bold text-[#233DFF] hover:text-[#171B61] hover:underline transition">
                            Lupa kata sandi?
                        </a>
                    </div>

                    <!-- Submit Button: Masuk ke Portal -->
                    <div class="pt-2">
                        <button 
                            type="submit" 
                            class="w-full flex justify-center items-center gap-2 py-3.5 px-4 rounded-xl text-sm font-extrabold text-white bg-[#233DFF] hover:bg-[#1B30D9] active:bg-[#1524A3] shadow-lg shadow-indigo-600/30 hover:shadow-indigo-600/45 hover:-translate-y-0.5 transition duration-150 cursor-pointer"
                        >
                            <span>Masuk ke Portal</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Footer: Copyright & Legal Links -->
            <div class="w-full max-w-md mx-auto pt-6 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 font-medium gap-2">
                <span>Copyright &copy; Satu-Sekolah, All Rights Reserved</span>
                <div class="flex items-center gap-2">
                    <a href="{{ route('public.home') }}" class="hover:text-slate-800 hover:underline">Term &amp; Condition</a>
                    <span>&bull;</span>
                    <a href="{{ route('public.home') }}" class="hover:text-slate-800 hover:underline">Privacy Policy</a>
                </div>
            </div>
        </div>

        <!-- Right Column: Interactive 3-Slide Showcase Carousel -->
        <div id="showcase-container" class="lg:col-span-6 rounded-[28px] p-6 sm:p-8 lg:p-9 flex flex-col justify-between relative overflow-hidden shadow-2xl border border-[#1C206B] text-white select-none group/carousel min-h-[580px]"
             style="background-color: #131652; background: linear-gradient(180deg, #131652 0%, #0E103D 50%, #171B61 100%);">
            
            <!-- Grid Texture Overlay -->
            <div class="absolute inset-0 pointer-events-none opacity-20"
                 style="background-image: linear-gradient(rgba(255, 255, 255, 0.2) 1px, transparent 1px), linear-gradient(90deg, rgba(255, 255, 255, 0.2) 1px, transparent 1px); background-size: 28px 28px;"></div>

            <!-- Ambient Radial Glows -->
            <div class="absolute -top-24 -right-24 w-80 h-80 bg-[#233DFF]/30 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-[#171B61]/80 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Header of Showcase: Interactive Slide Category Badge (No Arrow Buttons, Auto-Play) -->
            <div class="relative z-20 flex items-center justify-between pb-2">
                <div id="slide-badge" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-white/10 text-white border border-white/20 backdrop-blur-md transition-all duration-300">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#F4CF52]"></span>
                    <span id="slide-badge-text">Fitur Utama &bull; Presensi &amp; KBM</span>
                </div>
            </div>

            <!-- Slides Overflow Wrapper -->
            <div class="relative w-full overflow-hidden my-auto py-2 z-10">
                <div id="carousel-track" class="flex transition-transform duration-500 ease-[cubic-bezier(0.2,0.8,0.2,1)] w-full">
                    
                    <!-- ================= Slide 1: Presensi Digital & KBM ================= -->
                    <div class="w-full shrink-0 flex flex-col justify-between space-y-6 px-1">
                        <!-- Top Floating Cards -->
                        <div class="space-y-3.5 py-1">
                            <!-- Card 1: Presensi Siswa -->
                            <div class="w-full max-w-[290px] bg-white text-slate-900 rounded-2xl p-4 shadow-2xl border border-white/90 transform -rotate-1 hover:rotate-0 transition duration-300">
                                <div class="flex items-center justify-between text-xs mb-3">
                                    <span class="font-extrabold text-slate-900">Presensi Hari Ini</span>
                                    <span class="text-[10px] font-bold text-slate-600 bg-slate-100 px-2 py-0.5 rounded-full">Sesi Pagi</span>
                                </div>
                                <div class="flex items-center gap-4">
                                    <div class="relative w-14 h-14 shrink-0 flex items-center justify-center">
                                        <svg class="w-14 h-14 -rotate-90" viewBox="0 0 36 36">
                                            <circle cx="18" cy="18" r="14" fill="none" class="stroke-slate-200" stroke-width="4"></circle>
                                            <circle cx="18" cy="18" r="14" fill="none" class="stroke-[#233DFF]" stroke-width="4" stroke-dasharray="88 100" stroke-linecap="round"></circle>
                                        </svg>
                                        <span class="absolute text-[12px] font-black text-slate-900">98%</span>
                                    </div>
                                    <div>
                                        <span class="text-xl font-black text-slate-900 block leading-tight">32 Siswa</span>
                                        <span class="text-[11px] text-emerald-700 font-extrabold block mt-0.5">&bull; Hadir Tepat Waktu</span>
                                        <span class="text-[10px] text-slate-600 font-semibold block mt-0.5">1 Izin Surat &bull; 0 Alpa</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 2: Jadwal Sesi Mengajar -->
                            <div class="w-full max-w-[320px] bg-white text-slate-900 rounded-2xl p-4 shadow-2xl border border-white/90 ml-auto -mt-4 transform rotate-1 hover:rotate-0 transition duration-300 relative z-20">
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
                                        <span class="text-[11px] font-extrabold text-[#233DFF] bg-blue-50 border border-blue-200 px-2 py-0.5 rounded-md">Lab 1</span>
                                    </div>
                                    <p class="text-[11px] text-slate-600 font-medium">Pengajar: Budi Santoso, S.Kom</p>
                                </div>
                            </div>

                            <!-- Card 3: Rekap Kehadiran Kelas -->
                            <div class="w-full max-w-[280px] bg-white text-slate-900 rounded-2xl p-3.5 shadow-2xl border border-white/90 -mt-3 transform -rotate-1 hover:rotate-0 transition duration-300 relative z-30">
                                <div class="flex items-center justify-between text-xs">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-700 font-black flex items-center justify-center text-xs border border-emerald-200">&check;</div>
                                        <div>
                                            <span class="block text-xs font-bold text-slate-900">Rekap KBM Kelas</span>
                                            <span class="block text-[10px] text-slate-500">Tingkat Kehadiran 98.4%</span>
                                        </div>
                                    </div>
                                    <span class="text-[10px] font-extrabold px-2 py-0.5 rounded bg-emerald-100 text-emerald-800">Sangat Baik</span>
                                </div>
                            </div>
                        </div>

                        <!-- Bottom Copy -->
                        <div class="pt-2 text-center">
                            <div class="w-14 h-14 rounded-2xl bg-white p-2.5 flex items-center justify-center mx-auto shadow-2xl shadow-black/60 mb-3 border border-white/40">
                                <img src="{{ asset('images/logo/icon.png') }}" alt="oneSchool" class="w-full h-full object-contain filter drop-shadow-xs">
                            </div>
                            <h2 class="text-xl sm:text-2xl font-black text-white tracking-tight leading-snug drop-shadow-md">
                                A Unified Hub for Smarter School Decision-Making
                            </h2>
                            <p class="text-xs sm:text-sm text-slate-200 font-medium max-w-md mx-auto mt-2 leading-relaxed drop-shadow-sm">
                                Satu-Sekolah empowers educators, administrators, and mentors with a unified command center &mdash; delivering deep academic insights and a 360&deg; view of your entire school ecosystem.
                            </p>
                        </div>
                    </div>

                    <!-- ================= Slide 2: Monitoring PKL Industri ================= -->
                    <div class="w-full shrink-0 flex flex-col justify-between space-y-6 px-1">
                        <!-- Top Floating Cards -->
                        <div class="space-y-3.5 py-1">
                            <!-- Card 1: Monitoring PKL Industri -->
                            <div class="w-full max-w-[290px] bg-white text-slate-900 rounded-2xl p-4 shadow-2xl border border-white/90 transform -rotate-1 hover:rotate-0 transition duration-300">
                                <div class="flex items-center justify-between text-xs mb-1.5">
                                    <span class="font-extrabold text-slate-900">Monitoring PKL DUDI</span>
                                    <span class="text-[10px] text-emerald-800 font-extrabold bg-emerald-100 px-2 py-0.5 rounded-full border border-emerald-200">
                                        Geofence GPS OK
                                    </span>
                                </div>
                                <p class="text-xs font-black text-[#171B61]">PT Inovasi Teknologi Nusantara</p>
                                <div class="mt-2.5">
                                    <div class="flex justify-between text-[11px] mb-1 font-bold text-slate-700">
                                        <span>Target Jurnal Bulanan</span>
                                        <span class="text-slate-900 font-black">85%</span>
                                    </div>
                                    <div class="w-full h-2 bg-slate-200 rounded-full overflow-hidden">
                                        <div class="h-full bg-[#233DFF] rounded-full" style="width: 85%"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 2: Logbook Siswa -->
                            <div class="w-full max-w-[320px] bg-white text-slate-900 rounded-2xl p-4 shadow-2xl border border-white/90 ml-auto -mt-4 transform rotate-1 hover:rotate-0 transition duration-300 relative z-20">
                                <div class="flex items-center justify-between text-xs mb-2 pb-1.5 border-b border-slate-200">
                                    <span class="font-extrabold text-slate-900">Verifikasi Jurnal PKL</span>
                                    <span class="text-[10px] font-bold text-blue-700 bg-blue-50 border border-blue-200 px-2 py-0.5 rounded-md">Hari Ini</span>
                                </div>
                                <div class="flex items-start gap-2.5">
                                    <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-indigo-500 to-[#233DFF] text-white flex items-center justify-center font-bold text-xs shrink-0">
                                        AP
                                    </div>
                                    <div>
                                        <span class="text-xs font-extrabold text-slate-900 block leading-tight">Aditya Pratama</span>
                                        <p class="text-[11px] text-slate-600 mt-0.5 line-clamp-1">Implementasi RESTful API &amp; Unit Test</p>
                                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-700 mt-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Disetujui Pembimbing
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 3: Evaluasi Nilai Praktik Siswa -->
                            <div class="w-full max-w-[280px] bg-white text-slate-900 rounded-2xl p-3.5 shadow-2xl border border-white/90 -mt-3 transform -rotate-1 hover:rotate-0 transition duration-300 relative z-30">
                                <div class="flex items-center justify-between text-xs">
                                    <div>
                                        <span class="block text-xs font-extrabold text-slate-900">Evaluasi Mitra Industri</span>
                                        <span class="block text-[10px] text-slate-500">Predikat Sangat Memuaskan</span>
                                    </div>
                                    <div class="flex items-baseline gap-0.5">
                                        <span class="text-lg font-black text-[#233DFF]">94.5</span>
                                        <span class="text-[10px] text-slate-400 font-bold">/100</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bottom Copy -->
                        <div class="pt-2 text-center">
                            <div class="w-14 h-14 rounded-2xl bg-white p-2.5 flex items-center justify-center mx-auto shadow-2xl shadow-black/60 mb-3 border border-white/40">
                                <img src="{{ asset('images/logo/icon.png') }}" alt="oneSchool" class="w-full h-full object-contain filter drop-shadow-xs">
                            </div>
                            <h2 class="text-xl sm:text-2xl font-black text-white tracking-tight leading-snug drop-shadow-md">
                                Monitoring PKL &amp; Kemitraan Industri DUDI
                            </h2>
                            <p class="text-xs sm:text-sm text-slate-200 font-medium max-w-md mx-auto mt-2 leading-relaxed drop-shadow-sm">
                                Fasilitasi penempatan magang, pantau presensi geofence di lokasi mitra, dan verifikasi jurnal harian siswa secara transparan dan akuntabel.
                            </p>
                        </div>
                    </div>

                    <!-- ================= Slide 3: Analitik Sekolah & Multi-Peran ================= -->
                    <div class="w-full shrink-0 flex flex-col justify-between space-y-6 px-1">
                        <!-- Top Floating Cards -->
                        <div class="space-y-3.5 py-1">
                            <!-- Card 1: Statistik Kelulusan & Nilai -->
                            <div class="w-full max-w-[290px] bg-white text-slate-900 rounded-2xl p-4 shadow-2xl border border-white/90 transform -rotate-1 hover:rotate-0 transition duration-300">
                                <div class="flex items-center justify-between text-xs mb-2">
                                    <span class="font-extrabold text-slate-900">Analitik Mutu Sekolah</span>
                                    <span class="text-[10px] font-bold text-amber-700 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-full">Akreditasi A</span>
                                </div>
                                <div class="flex items-center justify-between pt-1">
                                    <div>
                                        <span class="text-2xl font-black text-slate-900 leading-none">99.2%</span>
                                        <span class="text-[10px] text-slate-500 font-semibold block mt-1">Tingkat Kelulusan</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-2xl font-black text-[#233DFF] leading-none">89.4</span>
                                        <span class="text-[10px] text-slate-500 font-semibold block mt-1">Rata-rata Nilai Kejuruan</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 2: Akses Fleksibel Multi-Role -->
                            <div class="w-full max-w-[320px] bg-white text-slate-900 rounded-2xl p-4 shadow-2xl border border-white/90 ml-auto -mt-4 transform rotate-1 hover:rotate-0 transition duration-300 relative z-20">
                                <div class="flex items-center justify-between text-xs mb-2">
                                    <span class="font-extrabold text-slate-900">Akses Fleksibel Multi-Role</span>
                                    <span class="text-[10px] font-bold text-[#233DFF] bg-blue-50 border border-blue-200 px-2 py-0.5 rounded-full">RBAC Aktif</span>
                                </div>
                                <div class="grid grid-cols-2 gap-2 text-[11px] pt-1">
                                    <div class="p-2 rounded-xl bg-slate-50 border border-slate-200/80">
                                        <span class="block font-black text-slate-800">Siswa (NISN)</span>
                                        <span class="text-[10px] text-slate-500">Jadwal, Jurnal &amp; Nilai</span>
                                    </div>
                                    <div class="p-2 rounded-xl bg-slate-50 border border-slate-200/80">
                                        <span class="block font-black text-slate-800">Guru &amp; Walas</span>
                                        <span class="text-[10px] text-slate-500">Sesi &amp; Rekap Absensi</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 3: Notifikasi Cepat Real-time -->
                            <div class="w-full max-w-[280px] bg-white text-slate-900 rounded-2xl p-3.5 shadow-2xl border border-white/90 -mt-3 transform -rotate-1 hover:rotate-0 transition duration-300 relative z-30">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-xl bg-blue-50 text-[#233DFF] flex items-center justify-center shrink-0 border border-blue-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                                    </div>
                                    <div class="overflow-hidden">
                                        <span class="block text-xs font-bold text-slate-900 truncate">Notifikasi Instan Terintegrasi</span>
                                        <span class="block text-[10px] text-slate-500 truncate">Pengumuman &amp; izin langsung via web</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bottom Copy -->
                        <div class="pt-2 text-center">
                            <div class="w-14 h-14 rounded-2xl bg-white p-2.5 flex items-center justify-center mx-auto shadow-2xl shadow-black/60 mb-3 border border-white/40">
                                <img src="{{ asset('images/logo/icon.png') }}" alt="oneSchool" class="w-full h-full object-contain filter drop-shadow-xs">
                            </div>
                            <h2 class="text-xl sm:text-2xl font-black text-white tracking-tight leading-snug drop-shadow-md">
                                Pusat Komando &amp; Analitik Terpadu
                            </h2>
                            <p class="text-xs sm:text-sm text-slate-200 font-medium max-w-md mx-auto mt-2 leading-relaxed drop-shadow-sm">
                                Satu platform terpadu untuk kepala sekolah, guru, pembimbing PKL, dan siswa dengan analitik data komprehensif serta komunikasi real-time.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Bottom 3 Carousel Pagination Indicators -->
            <div class="relative z-20 flex items-center justify-center gap-2 pt-2">
                <button type="button" onclick="goToSlide(0)" id="indicator-0" class="h-1.5 rounded-full transition-all duration-300 w-8 bg-[#F4CF52] shadow-sm cursor-pointer" aria-label="Ke Slide 1"></button>
                <button type="button" onclick="goToSlide(1)" id="indicator-1" class="h-1.5 rounded-full transition-all duration-300 w-4 bg-white/40 hover:bg-white/70 cursor-pointer" aria-label="Ke Slide 2"></button>
                <button type="button" onclick="goToSlide(2)" id="indicator-2" class="h-1.5 rounded-full transition-all duration-300 w-4 bg-white/40 hover:bg-white/70 cursor-pointer" aria-label="Ke Slide 3"></button>
            </div>

        </div>

    </div>

    <!-- Script for Password Eye Toggle & Showcase Carousel -->
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>';
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
            }
        }

        // Interactive Showcase Carousel Controller (3 Slides)
        let currentSlide = 0;
        const totalSlides = 3;
        const badgeTexts = [
            'Fitur Utama • Presensi & KBM',
            'Program Unggulan • Monitoring PKL',
            'Sistem Terpadu • Analitik & Multi-Role'
        ];
        let autoPlayTimer = null;

        function updateCarousel() {
            const track = document.getElementById('carousel-track');
            if (track) {
                track.style.transform = `translateX(-${currentSlide * 100}%)`;
            }

            const badgeText = document.getElementById('slide-badge-text');
            if (badgeText && badgeTexts[currentSlide]) {
                badgeText.textContent = badgeTexts[currentSlide];
            }

            for (let i = 0; i < totalSlides; i++) {
                const ind = document.getElementById(`indicator-${i}`);
                if (ind) {
                    if (i === currentSlide) {
                        ind.className = 'h-1.5 rounded-full transition-all duration-300 w-8 bg-[#F4CF52] shadow-sm cursor-pointer';
                    } else {
                        ind.className = 'h-1.5 rounded-full transition-all duration-300 w-4 bg-white/40 hover:bg-white/70 cursor-pointer';
                    }
                }
            }
        }

        function goToSlide(index) {
            currentSlide = (index + totalSlides) % totalSlides;
            updateCarousel();
        }

        function showcaseNext() {
            goToSlide(currentSlide + 1);
        }

        function showcasePrev() {
            goToSlide(currentSlide - 1);
        }

        function startAutoPlay() {
            stopAutoPlay();
            autoPlayTimer = setInterval(showcaseNext, 4500);
        }

        function stopAutoPlay() {
            if (autoPlayTimer) {
                clearInterval(autoPlayTimer);
                autoPlayTimer = null;
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('showcase-container');
            if (container) {
                let touchStartX = 0;
                let touchEndX = 0;

                container.addEventListener('mouseenter', stopAutoPlay);
                container.addEventListener('mouseleave', startAutoPlay);

                container.addEventListener('touchstart', function (e) {
                    touchStartX = e.changedTouches[0].screenX;
                }, { passive: true });

                container.addEventListener('touchend', function (e) {
                    touchEndX = e.changedTouches[0].screenX;
                    if (touchStartX - touchEndX > 50) {
                        showcaseNext();
                    } else if (touchEndX - touchStartX > 50) {
                        showcasePrev();
                    }
                }, { passive: true });

                startAutoPlay();
            }
        });
    </script>
</x-guest-layout>
