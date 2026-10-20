<x-guest-layout title="Verifikasi Kode OTP">
    <div class="max-w-md mx-auto">
        <div class="bg-white rounded-[32px] border border-slate-200/90 shadow-2xl shadow-slate-900/10 p-6 sm:p-8">
            
            <!-- Logo & Brand Header -->
            <div class="text-center mb-6">
                <a href="{{ route('public.home') }}" class="inline-block group mb-3">
                    <img src="{{ asset('images/logo/logo.png') }}" alt="oneSchool Satu-Sekolah" class="h-10 w-auto object-contain mx-auto group-hover:scale-105 transition-transform duration-200">
                </a>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">
                    Verifikasi Kode OTP
                </h1>
                <p class="text-xs sm:text-sm text-slate-600 font-medium mt-1 leading-relaxed">
                    Masukkan 6 digit kode OTP yang telah dikirimkan ke email:
                </p>
                <div class="inline-flex items-center gap-1.5 mt-2 px-3 py-1 bg-slate-100 rounded-full border border-slate-200 text-xs font-bold text-slate-800">
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span>{{ $email }}</span>
                    <a href="{{ route('password.request') }}" class="text-[11px] text-[#233DFF] hover:underline ml-1">Ubah</a>
                </div>
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
                        <span>Verifikasi Gagal:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-0.5 text-rose-800 font-medium">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Verify OTP -->
            <form method="POST" action="{{ route('password.verify-otp') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="otp" class="block text-xs font-extrabold text-slate-800 mb-1.5 text-center">
                        Masukkan 6 Digit Angka OTP <span class="text-rose-600">*</span>
                    </label>
                    <div class="relative">
                        <input 
                            type="text" 
                            id="otp" 
                            name="otp" 
                            maxlength="6"
                            pattern="[0-9]*"
                            inputmode="numeric"
                            autocomplete="one-time-code"
                            required 
                            autofocus 
                            placeholder="······"
                            class="block w-full py-3.5 px-4 text-center font-mono text-2xl tracking-[12px] sm:tracking-[16px] font-black rounded-2xl border @error('otp') border-rose-400 bg-rose-50 text-rose-950 @else border-slate-300 bg-white text-slate-900 @enderror placeholder:text-slate-300 focus:outline-none focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] transition shadow-2xs"
                        >
                    </div>
                    @error('otp')
                        <p class="mt-1 text-xs text-rose-700 font-bold text-center">{{ $message }}</p>
                    @enderror
                    <p class="text-[11px] text-slate-400 text-center mt-2">
                        Kode OTP berlaku selama 10 menit sejak dikirimkan.
                    </p>
                </div>

                <div class="pt-2">
                    <button 
                        type="submit" 
                        class="w-full flex justify-center items-center gap-2 py-3.5 px-4 rounded-xl text-sm font-extrabold text-white bg-[#233DFF] hover:bg-[#1B30D9] active:bg-[#1524A3] shadow-lg shadow-indigo-600/30 hover:shadow-indigo-600/45 hover:-translate-y-0.5 transition duration-150 cursor-pointer"
                    >
                        <span>Verifikasi &amp; Lanjutkan</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </div>
            </form>

            <!-- Resend OTP Action Form -->
            <div class="mt-6 pt-5 border-t border-slate-200 text-center">
                <form method="POST" action="{{ route('password.resend-otp') }}" class="inline-block">
                    @csrf
                    <p class="text-xs text-slate-600">
                        Tidak menerima kode OTP? 
                        <button type="submit" class="font-extrabold text-[#233DFF] hover:text-[#171B61] hover:underline cursor-pointer">
                            Kirim Ulang OTP
                        </button>
                    </p>
                </form>

                <div class="mt-4">
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-slate-800 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        <span>Kembali ke Halaman Masuk</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-guest-layout>
