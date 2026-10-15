<x-guest-layout title="Masuk ke Akun">
    <div class="mb-6">
        <h2 class="text-xl font-bold text-navy">Masuk ke Portal</h2>
        <p class="text-sm text-slate-500 mt-1">Gunakan akun yang telah didaftarkan oleh Administrator.</p>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded-lg bg-emerald-50 border border-emerald-200 p-3 text-sm text-emerald-800 flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 rounded-lg bg-rose-50 border border-rose-200 p-3 text-sm text-rose-800">
            <div class="font-medium mb-1">Gagal masuk:</div>
            <ul class="list-disc list-inside text-xs space-y-0.5">
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
            <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                Alamat Email
            </label>
            <div class="relative">
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required 
                    autofocus 
                    autocomplete="username"
                    placeholder="nama@oneschool.sch.id"
                    class="block w-full px-3.5 py-2.5 rounded-lg border @error('email') border-rose-400 bg-rose-50/30 @else border-border bg-white @enderror text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-brand focus:border-brand transition"
                >
            </div>
            @error('email')
                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password Field -->
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-600">
                    Password
                </label>
            </div>
            <div class="relative">
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    required 
                    autocomplete="current-password"
                    placeholder="••••••••"
                    class="block w-full px-3.5 py-2.5 rounded-lg border @error('password') border-rose-400 bg-rose-50/30 @else border-border bg-white @enderror text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-brand focus:border-brand transition"
                >
            </div>
            @error('password')
                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me Checkbox -->
        <div class="flex items-center justify-between pt-1">
            <label class="flex items-center gap-2 cursor-pointer">
                <input 
                    type="checkbox" 
                    name="remember" 
                    class="w-4 h-4 rounded border-border text-brand focus:ring-brand"
                >
                <span class="text-xs text-slate-600">Ingat sesi saya</span>
            </label>
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button 
                type="submit" 
                class="w-full flex justify-center items-center py-2.5 px-4 rounded-lg text-sm font-semibold text-white bg-brand hover:bg-brand-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand shadow-sm transition"
            >
                Masuk ke Portal
            </button>
        </div>
    </form>

    <!-- Quick Demo Accounts Helper -->
    <div class="mt-8 pt-6 border-t border-border">
        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-3 text-center">Akun Uji Coba (Demo)</p>
        <div class="grid grid-cols-2 gap-2 text-xs">
            <button type="button" onclick="fillCredentials('admin@oneschool.sch.id', 'password')" class="text-left p-2 rounded border border-slate-200 hover:bg-slate-50 transition">
                <span class="font-semibold block text-slate-700">Admin</span>
                <span class="text-slate-500 font-mono text-[11px]">admin@oneschool.sch.id</span>
            </button>
            <button type="button" onclick="fillCredentials('guru@oneschool.sch.id', 'password')" class="text-left p-2 rounded border border-slate-200 hover:bg-slate-50 transition">
                <span class="font-semibold block text-slate-700">Guru</span>
                <span class="text-slate-500 font-mono text-[11px]">guru@oneschool.sch.id</span>
            </button>
            <button type="button" onclick="fillCredentials('walikelas@oneschool.sch.id', 'password')" class="text-left p-2 rounded border border-slate-200 hover:bg-slate-50 transition">
                <span class="font-semibold block text-slate-700">Wali Kelas</span>
                <span class="text-slate-500 font-mono text-[11px]">walikelas@oneschool.sch.id</span>
            </button>
            <button type="button" onclick="fillCredentials('pembimbing@oneschool.sch.id', 'password')" class="text-left p-2 rounded border border-slate-200 hover:bg-slate-50 transition">
                <span class="font-semibold block text-slate-700">Pembimbing PKL</span>
                <span class="text-slate-500 font-mono text-[11px]">pembimbing@oneschool.sch.id</span>
            </button>
        </div>
    </div>

    <script>
        function fillCredentials(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }
    </script>
</x-guest-layout>
