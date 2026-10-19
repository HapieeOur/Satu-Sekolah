<x-guest-layout title="Lupa Kata Sandi">
    <div class="max-w-md mx-auto">
        <div class="bg-white rounded-[32px] border border-slate-200/90 shadow-2xl shadow-slate-900/10 p-6 sm:p-8">
            
            <!-- Logo & Brand Header -->
            <div class="text-center mb-6">
                <a href="{{ route('public.home') }}" class="inline-block group mb-3">
                    <img src="{{ asset('images/logo/logo.png') }}" alt="oneSchool Satu-Sekolah" class="h-10 w-auto object-contain mx-auto group-hover:scale-105 transition-transform duration-200">
                </a>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">
                    Lupa Kata Sandi?
                </h1>
                <p class="text-xs sm:text-sm text-slate-600 font-medium mt-1 leading-relaxed">
                    Masukkan email Anda yang terdaftar. Kami akan mengirimkan kode OTP 6-digit untuk memverifikasi kepemilikan akun.
                </p>
            </div>

            <!-- Feedback Alerts -->
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
                        <svg class="w-4 h-4 text-rose-700 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        <span>Gagal Mengirim OTP:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-0.5 text-rose-800 font-medium">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-extrabold text-slate-800 mb-1.5">
                        Alamat Email Terdaftar <span class="text-rose-600">*</span>
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
                            autocomplete="email"
                            placeholder="nama@sekolah.sch.id"
                            class="block w-full pl-10 pr-4 py-3 rounded-xl border @error('email') border-rose-400 bg-rose-50 text-rose-950 @else border-slate-300 bg-white text-slate-900 @enderror text-xs sm:text-sm font-medium placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#16646A]/25 focus:border-[#16646A] transition shadow-2xs"
                        >
                    </div>
                    @error('email')
                        <p class="mt-1 text-xs text-rose-700 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-2">
                    <button 
                        type="submit" 
                        class="w-full flex justify-center items-center gap-2 py-3.5 px-4 rounded-xl text-sm font-extrabold text-white bg-[#16646A] hover:bg-[#125257] active:bg-[#0E4145] shadow-lg shadow-[#16646A]/30 hover:shadow-[#16646A]/45 hover:-translate-y-0.5 transition duration-150 cursor-pointer"
                    >
                        <span>Kirim Kode OTP</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </div>
            </form>

            <div class="mt-6 pt-5 border-t border-slate-200 text-center">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-[#16646A] transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Kembali ke Halaman Masuk</span>
                </a>
            </div>

        </div>
    </div>
</x-guest-layout>
