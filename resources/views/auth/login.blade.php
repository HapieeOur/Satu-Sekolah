<x-guest-layout title="Masuk ke Akun">
    <div class="mb-6 text-center sm:text-left">
        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-indigo-50 text-brand border border-indigo-200/60 mb-2">
            <span class="w-1.5 h-1.5 rounded-full bg-brand"></span>
            Autentikasi Terpadu
        </div>
        <h2 class="text-xl sm:text-2xl font-black text-navy tracking-tight">Masuk ke Portal</h2>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">Gunakan akun yang telah didaftarkan oleh Administrator.</p>
    </div>

    @if (session('success'))
        <div class="mb-5 rounded-xl bg-emerald-50 border border-emerald-200/80 p-3.5 text-xs text-emerald-800 flex items-center gap-2.5 shadow-xs">
            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-5 rounded-xl bg-rose-50 border border-rose-200/80 p-3.5 text-xs text-rose-800 shadow-xs">
            <div class="font-bold flex items-center gap-1.5 mb-1 text-rose-900">
                <svg class="w-4 h-4 text-rose-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                <span>Gagal Masuk:</span>
            </div>
            <ul class="list-disc list-inside text-[11px] space-y-0.5 text-rose-700">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
        @csrf

        <!-- Email Field -->
        <div>
            <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                Alamat Email
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                </div>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required 
                    autofocus 
                    autocomplete="username"
                    placeholder="nama@oneschool.sch.id"
                    class="block w-full pl-10 pr-3.5 py-2.5 rounded-xl border @error('email') border-rose-300 bg-rose-50/20 text-rose-900 @else border-slate-200 bg-white text-slate-900 @enderror text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition shadow-xs"
                >
            </div>
            @error('email')
                <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password Field with Toggle -->
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                    Kata Sandi
                </label>
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    required 
                    autocomplete="current-password"
                    placeholder="••••••••"
                    class="block w-full pl-10 pr-10 py-2.5 rounded-xl border @error('password') border-rose-300 bg-rose-50/20 text-rose-900 @else border-slate-200 bg-white text-slate-900 @enderror text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition shadow-xs"
                >
                <button 
                    type="button" 
                    onclick="togglePasswordVisibility()" 
                    aria-label="Toggle password visibility" 
                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 cursor-pointer"
                >
                    <svg id="eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </button>
            </div>
            @error('password')
                <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me Checkbox -->
        <div class="flex items-center justify-between pt-1">
            <label class="flex items-center gap-2 cursor-pointer select-none">
                <input 
                    type="checkbox" 
                    name="remember" 
                    class="w-4 h-4 rounded text-brand focus:ring-brand/30 border-slate-300 transition"
                >
                <span class="text-xs text-slate-600 font-medium">Ingat sesi di perangkat ini</span>
            </label>
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button 
                type="submit" 
                class="w-full flex justify-center items-center gap-2 py-3 px-4 rounded-xl text-xs sm:text-sm font-bold text-white bg-gradient-to-r from-brand via-indigo-600 to-violet-600 hover:from-brand-hover hover:to-violet-700 shadow-md hover:shadow-glow hover:-translate-y-0.5 active:translate-y-0 transition-all duration-150 cursor-pointer"
            >
                <span>Masuk ke Portal</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </button>
        </div>
    </form>

    <!-- Quick Demo Accounts Helper -->
    <div class="mt-8 pt-6 border-t border-slate-100">
        <div class="flex items-center justify-between mb-3">
            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Akun Uji Coba Cepat (Demo)</p>
            <span class="text-[10px] text-slate-400 font-medium">Klik untuk isi otomatis</span>
        </div>
        <div class="grid grid-cols-2 gap-2 text-xs">
            <button type="button" onclick="fillCredentials('admin@oneschool.sch.id', 'password')" class="text-left p-2.5 rounded-xl border border-indigo-100 bg-indigo-50/40 hover:bg-indigo-50 hover:border-brand/40 transition group cursor-pointer">
                <span class="font-bold block text-indigo-950 group-hover:text-brand flex items-center justify-between">
                    <span>Admin</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-600"></span>
                </span>
                <span class="text-slate-500 font-mono text-[10px] truncate block mt-0.5">admin@oneschool.sch.id</span>
            </button>

            <button type="button" onclick="fillCredentials('guru@oneschool.sch.id', 'password')" class="text-left p-2.5 rounded-xl border border-emerald-100 bg-emerald-50/40 hover:bg-emerald-50 hover:border-emerald-500/40 transition group cursor-pointer">
                <span class="font-bold block text-emerald-950 group-hover:text-emerald-700 flex items-center justify-between">
                    <span>Guru</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                </span>
                <span class="text-slate-500 font-mono text-[10px] truncate block mt-0.5">guru@oneschool.sch.id</span>
            </button>

            <button type="button" onclick="fillCredentials('walikelas@oneschool.sch.id', 'password')" class="text-left p-2.5 rounded-xl border border-amber-100 bg-amber-50/40 hover:bg-amber-50 hover:border-amber-500/40 transition group cursor-pointer">
                <span class="font-bold block text-amber-950 group-hover:text-amber-700 flex items-center justify-between">
                    <span>Wali Kelas</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                </span>
                <span class="text-slate-500 font-mono text-[10px] truncate block mt-0.5">walikelas@...</span>
            </button>

            <button type="button" onclick="fillCredentials('pembimbing@oneschool.sch.id', 'password')" class="text-left p-2.5 rounded-xl border border-sky-100 bg-sky-50/40 hover:bg-sky-50 hover:border-sky-500/40 transition group cursor-pointer">
                <span class="font-bold block text-sky-950 group-hover:text-sky-700 flex items-center justify-between">
                    <span>Pembimbing PKL</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>
                </span>
                <span class="text-slate-500 font-mono text-[10px] truncate block mt-0.5">pembimbing@...</span>
            </button>
        </div>
    </div>

    <script>
        function fillCredentials(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }

        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        }
    </script>
</x-guest-layout>
