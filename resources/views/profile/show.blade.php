<x-app-layout title="Profil Pengguna">
    <x-slot name="header">
        Profil Akun Saya
    </x-slot>

    <!-- Top Profile Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-[#171B61] to-[#233DFF] p-6 sm:p-8 text-white shadow-lg">
        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center font-black text-2xl text-white shadow-xl shrink-0">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-white/20 text-white backdrop-blur-xs">
                            Profil Resmi
                        </span>
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-200 border border-emerald-400/30">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            Akun Aktif
                        </span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight mt-1">{{ $user->name }}</h1>
                    <p class="text-xs text-indigo-100 font-medium mt-0.5">{{ $user->email }} &bull; Terdaftar sejak {{ $user->created_at->translatedFormat('d F Y') }}</p>
                </div>
            </div>

            <!-- Role Badges in Header -->
            <div class="flex flex-wrap sm:flex-col items-start sm:items-end gap-1.5">
                <span class="text-[11px] font-bold uppercase tracking-wider text-indigo-200">Peran Pengguna</span>
                <div class="flex flex-wrap gap-1.5">
                    @foreach ($user->roles as $role)
                        @php
                            $badgeColor = match($role->name) {
                                'admin' => 'bg-indigo-900/90 text-indigo-100 border-indigo-500/40',
                                'guru' => 'bg-emerald-900/90 text-emerald-100 border-emerald-500/40',
                                'wali_kelas' => 'bg-amber-900/90 text-amber-100 border-amber-500/40',
                                'guru_pembimbing_pkl' => 'bg-sky-900/90 text-sky-100 border-sky-500/40',
                                default => 'bg-slate-800 text-slate-100 border-slate-700'
                            };
                            $roleLabel = match($role->name) {
                                'admin' => 'Administrator',
                                'guru' => 'Guru Pengajar',
                                'wali_kelas' => 'Wali Kelas',
                                'guru_pembimbing_pkl' => 'Pembimbing PKL',
                                default => ucfirst($role->name)
                            };
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $badgeColor }}">
                            {{ $roleLabel }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="absolute -right-12 -bottom-12 w-64 h-64 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>
    </div>

    <!-- Main Profile Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Left Column: Identity & Professional Data (lg:col-span-4) -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Professional Details Card -->
            <div class="bg-white rounded-2xl border border-slate-200/90 p-5 sm:p-6 shadow-xs space-y-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Data Kepegawaian &amp; Akademik</h3>
                
                @if ($teacher)
                    <div class="space-y-3 text-xs">
                        <div class="flex justify-between py-2 border-b border-slate-100">
                            <span class="text-slate-500">NIP Pendidik</span>
                            <span class="font-mono font-bold text-slate-900">{{ $teacher->nip ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-slate-100">
                            <span class="text-slate-500">NUPTK</span>
                            <span class="font-mono font-bold text-slate-900">{{ $teacher->nuptk ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-slate-100">
                            <span class="text-slate-500">Jenis Kelamin</span>
                            <span class="font-bold text-slate-900">{{ $teacher->gender === 'L' ? 'Laki-laki' : ($teacher->gender === 'P' ? 'Perempuan' : '-') }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-slate-100">
                            <span class="text-slate-500">No. Kontak / WA</span>
                            <span class="font-bold text-slate-900">{{ $teacher->phone ?? '-' }}</span>
                        </div>

                        <!-- Classrooms as Walas -->
                        @if ($teacher->classrooms->isNotEmpty())
                            <div class="py-2 border-b border-slate-100">
                                <span class="text-slate-500 block mb-1.5">Kelas Binaan (Wali Kelas)</span>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach ($teacher->classrooms as $cls)
                                        <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-[#ECEBFA] text-[#171B61] border border-[#171B61]/15">
                                            {{ $cls->name }} ({{ $cls->major }})
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Assigned Subjects -->
                        @if ($teacher->subjects->isNotEmpty())
                            <div class="py-2">
                                <span class="text-slate-500 block mb-1.5">Mata Pelajaran yang Diampu</span>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach ($teacher->subjects as $subj)
                                        <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-[#E5ECFF] text-[#233DFF] border border-[#233DFF]/20">
                                            {{ $subj->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @elseif ($student)
                    <div class="space-y-3 text-xs">
                        <div class="flex justify-between py-2 border-b border-slate-100">
                            <span class="text-slate-500">NIS Siswa</span>
                            <span class="font-mono font-bold text-slate-900">{{ $student->nis }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-slate-100">
                            <span class="text-slate-500">NISN</span>
                            <span class="font-mono font-bold text-slate-900">{{ $student->nisn ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-slate-100">
                            <span class="text-slate-500">Rombel Kelas</span>
                            <span class="font-bold text-slate-900">{{ $student->classroom?->name ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="text-slate-500">Program Keahlian</span>
                            <span class="font-bold text-slate-900">{{ $student->classroom?->major ?? '-' }}</span>
                        </div>
                    </div>
                @else
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80 text-xs text-slate-600 leading-relaxed">
                        Akun ini memiliki hak akses <strong>Administrator Sistem</strong> untuk mengelola data master, jadwal, monitoring PKL, dan publikasi institusi.
                    </div>
                @endif
            </div>

            <!-- Quick Access / Security Status Card -->
            <div class="bg-white rounded-2xl border border-slate-200/90 p-5 sm:p-6 shadow-xs">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Keamanan &amp; Sesi</h3>
                <div class="space-y-3 text-xs">
                    <div class="flex items-center justify-between text-slate-600">
                        <span>Autentikasi Dua Faktor</span>
                        <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-slate-100 text-slate-600">Standar</span>
                    </div>
                    <div class="flex items-center justify-between text-slate-600">
                        <span>Sesi Perangkat</span>
                        <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-emerald-50 text-emerald-700">Aktif</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Edit Profile & Password Change Forms (lg:col-span-8) -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- Update Profile Information Form -->
            <div class="bg-white rounded-2xl border border-slate-200/90 p-6 sm:p-8 shadow-xs">
                <div class="pb-4 border-b border-slate-100 mb-6">
                    <h2 class="text-base font-extrabold text-[#171B61]">Perbarui Informasi Akun</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Ubah nama tampilan resmi dan alamat email kontak akun Anda.</p>
                </div>

                <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!-- Full Name -->
                        <div>
                            <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Nama Lengkap <span class="text-rose-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                value="{{ old('name', $user->name) }}" 
                                required
                                class="w-full text-xs sm:text-sm rounded-xl border-slate-200 bg-white text-slate-900 py-2.5 px-3.5 focus:border-[#233DFF] focus:ring-2 focus:ring-[#233DFF]/20 transition shadow-2xs"
                            >
                            @error('name')
                                <p class="mt-1.5 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Alamat Email <span class="text-rose-500">*</span>
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ old('email', $user->email) }}" 
                                required
                                class="w-full text-xs sm:text-sm rounded-xl border-slate-200 bg-white text-slate-900 py-2.5 px-3.5 focus:border-[#233DFF] focus:ring-2 focus:ring-[#233DFF]/20 transition shadow-2xs"
                            >
                            @error('email')
                                <p class="mt-1.5 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    @if ($teacher)
                        <!-- Phone / WA -->
                        <div class="max-w-md">
                            <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Nomor WhatsApp / Telepon
                            </label>
                            <input 
                                type="text" 
                                id="phone" 
                                name="phone" 
                                value="{{ old('phone', $teacher->phone) }}" 
                                placeholder="081234567890"
                                class="w-full text-xs sm:text-sm rounded-xl border-slate-200 bg-white text-slate-900 py-2.5 px-3.5 focus:border-[#233DFF] focus:ring-2 focus:ring-[#233DFF]/20 transition shadow-2xs"
                            >
                            @error('phone')
                                <p class="mt-1.5 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs text-slate-400">Pastikan data yang dimasukkan valid.</span>
                        <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-[#233DFF] hover:bg-[#1a30d8] shadow-md shadow-[#233DFF]/25 hover:-translate-y-0.5 transition cursor-pointer">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Change Password Card -->
            <div class="bg-white rounded-2xl border border-slate-200/90 p-6 sm:p-8 shadow-xs">
                <div class="pb-4 border-b border-slate-100 mb-6">
                    <h2 class="text-base font-extrabold text-[#171B61]">Ganti Kata Sandi</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Disarankan menggunakan kombinasi minimal 8 karakter dengan huruf dan angka.</p>
                </div>

                <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="name" value="{{ $user->name }}">
                    <input type="hidden" name="email" value="{{ $user->email }}">

                    <div>
                        <label for="current_password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Kata Sandi Saat Ini
                        </label>
                        <input 
                            type="password" 
                            id="current_password" 
                            name="current_password" 
                            placeholder="••••••••"
                            class="w-full max-w-md text-xs sm:text-sm rounded-xl border-slate-200 bg-white text-slate-900 py-2.5 px-3.5 focus:border-[#233DFF] focus:ring-2 focus:ring-[#233DFF]/20 transition shadow-2xs"
                        >
                        @error('current_password')
                            <p class="mt-1.5 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-2xl">
                        <div>
                            <label for="new_password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Kata Sandi Baru
                            </label>
                            <input 
                                type="password" 
                                id="new_password" 
                                name="new_password" 
                                placeholder="••••••••"
                                class="w-full text-xs sm:text-sm rounded-xl border-slate-200 bg-white text-slate-900 py-2.5 px-3.5 focus:border-[#233DFF] focus:ring-2 focus:ring-[#233DFF]/20 transition shadow-2xs"
                            >
                            @error('new_password')
                                <p class="mt-1.5 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="new_password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Konfirmasi Kata Sandi Baru
                            </label>
                            <input 
                                type="password" 
                                id="new_password_confirmation" 
                                name="new_password_confirmation" 
                                placeholder="••••••••"
                                class="w-full text-xs sm:text-sm rounded-xl border-slate-200 bg-white text-slate-900 py-2.5 px-3.5 focus:border-[#233DFF] focus:ring-2 focus:ring-[#233DFF]/20 transition shadow-2xs"
                            >
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs text-slate-400">Kosongkan jika tidak ingin mengubah kata sandi.</span>
                        <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 hover:text-slate-900 transition cursor-pointer">
                            Perbarui Kata Sandi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
