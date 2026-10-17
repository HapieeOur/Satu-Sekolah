<x-app-layout title="Edit Data Guru">
    <x-slot name="header">
        Administrasi: Edit Data Guru
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.teachers.index') }}" 
                   class="w-10 h-10 rounded-xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-center text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition"
                   title="Kembali ke Daftar Guru">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <div>
                    <h1 class="text-xl font-bold text-slate-900">Edit Profil Guru: {{ $teacher->user->name }}</h1>
                    <p class="text-xs text-slate-500 mt-0.5">Perbarui biodata kepegawaian guru serta alokasi mata pelajaran yang diampu</p>
                </div>
            </div>
            <a href="{{ route('admin.teachers.index') }}" class="text-xs font-semibold text-slate-500 hover:text-indigo-600 transition hidden sm:inline-block">
                &larr; Kembali ke Daftar Guru
            </a>
        </div>

        <!-- Associated User Badge Banner -->
        <div class="p-4 bg-indigo-50/70 border border-indigo-200/60 rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-indigo-600 text-white font-bold text-xs flex items-center justify-center shrink-0 shadow-sm">
                    {{ strtoupper(substr($teacher->user->name, 0, 2)) }}
                </div>
                <div>
                    <span class="text-slate-500 text-[11px] block font-medium">Akun Pengguna Terkait:</span>
                    <span class="font-bold text-slate-900">{{ $teacher->user->name }}</span>
                    <span class="text-slate-500">({{ $teacher->user->email }})</span>
                </div>
            </div>
            <a href="{{ route('admin.users.edit', $teacher->user) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white border border-indigo-200 text-indigo-700 hover:bg-indigo-100/50 font-semibold text-xs transition shadow-2xs self-start sm:self-auto">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <span>Edit Akun Pengguna</span>
            </a>
        </div>

        <!-- Main Form Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 md:p-8">
            <form method="POST" action="{{ route('admin.teachers.update', $teacher) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Section 1: Identitas Kepegawaian -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                        <div class="w-6 h-6 rounded-md bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs font-bold">1</div>
                        <h2 class="text-xs font-bold uppercase tracking-wider text-slate-800">Nomor Induk Kepegawaian</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="nip" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                NIP (Nomor Induk Pegawai)
                            </label>
                            <input 
                                type="text" 
                                id="nip" 
                                name="nip" 
                                value="{{ old('nip', $teacher->nip) }}" 
                                placeholder="Contoh: 198001012005011001"
                                class="w-full px-3.5 py-2.5 text-xs rounded-xl border @error('nip') border-rose-400 bg-rose-50/30 text-rose-900 @else border-slate-200 bg-white text-slate-800 @enderror focus:ring-2 focus:ring-indigo-100 focus:border-indigo-600 font-mono transition"
                            >
                            @error('nip')
                                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nuptk" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                NUPTK
                            </label>
                            <input 
                                type="text" 
                                id="nuptk" 
                                name="nuptk" 
                                value="{{ old('nuptk', $teacher->nuptk) }}" 
                                placeholder="Contoh: 1234567890123456"
                                class="w-full px-3.5 py-2.5 text-xs rounded-xl border @error('nuptk') border-rose-400 bg-rose-50/30 text-rose-900 @else border-slate-200 bg-white text-slate-800 @enderror focus:ring-2 focus:ring-indigo-100 focus:border-indigo-600 font-mono transition"
                            >
                            @error('nuptk')
                                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 2: Biodata & Kontak -->
                <div class="space-y-4 pt-4 border-t border-slate-100">
                    <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                        <div class="w-6 h-6 rounded-md bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs font-bold">2</div>
                        <h2 class="text-xs font-bold uppercase tracking-wider text-slate-800">Biodata & Kontak Guru</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="gender" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Jenis Kelamin <span class="text-rose-500">*</span>
                            </label>
                            <select 
                                id="gender" 
                                name="gender" 
                                required
                                class="w-full px-3.5 py-2.5 text-xs rounded-xl border @error('gender') border-rose-400 bg-rose-50/30 text-rose-900 @else border-slate-200 bg-white text-slate-800 @enderror focus:ring-2 focus:ring-indigo-100 focus:border-indigo-600 transition"
                            >
                                <option value="L" {{ old('gender', $teacher->gender) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('gender', $teacher->gender) === 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('gender')
                                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                No. Telepon / WhatsApp
                            </label>
                            <input 
                                type="text" 
                                id="phone" 
                                name="phone" 
                                value="{{ old('phone', $teacher->phone) }}" 
                                placeholder="Contoh: 08123456789"
                                class="w-full px-3.5 py-2.5 text-xs rounded-xl border @error('phone') border-rose-400 bg-rose-50/30 text-rose-900 @else border-slate-200 bg-white text-slate-800 @enderror focus:ring-2 focus:ring-indigo-100 focus:border-indigo-600 font-mono transition"
                            >
                            @error('phone')
                                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="address" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Alamat Tinggal
                        </label>
                        <textarea 
                            id="address" 
                            name="address" 
                            rows="2"
                            placeholder="Alamat lengkap tempat tinggal guru saat ini..."
                            class="w-full px-3.5 py-2.5 text-xs rounded-xl border @error('address') border-rose-400 bg-rose-50/30 text-rose-900 @else border-slate-200 bg-white text-slate-800 @enderror focus:ring-2 focus:ring-indigo-100 focus:border-indigo-600 transition"
                        >{{ old('address', $teacher->address) }}</textarea>
                        @error('address')
                            <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Section 3: Mata Pelajaran yang Diampu -->
                @php
                    $currentSubjectIds = old('subject_ids', $teacher->subjects->pluck('id')->toArray());
                @endphp

                <div class="space-y-4 pt-4 border-t border-slate-100">
                    <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-md bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs font-bold">3</div>
                            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-800">Penugasan Mata Pelajaran</h2>
                        </div>
                        <span class="text-[11px] text-slate-500">Pilih satu atau lebih mapel</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2.5 p-4 rounded-2xl border border-slate-200/80 bg-slate-50/50 max-h-56 overflow-y-auto">
                        @forelse ($subjects as $subject)
                            <label class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-white hover:shadow-2xs text-slate-700 cursor-pointer border border-transparent hover:border-slate-200/60 transition group">
                                <input 
                                    type="checkbox" 
                                    name="subject_ids[]" 
                                    value="{{ $subject->id }}"
                                    {{ in_array($subject->id, $currentSubjectIds) ? 'checked' : '' }}
                                    class="w-4 h-4 rounded-md text-indigo-600 focus:ring-indigo-500 border-slate-300 transition"
                                >
                                <span class="truncate text-xs">
                                    <span class="font-bold text-slate-900 group-hover:text-indigo-600">{{ $subject->code }}</span>
                                    <span class="text-slate-500">&bull; {{ $subject->name }}</span>
                                </span>
                            </label>
                        @empty
                            <p class="text-slate-400 col-span-3 text-center py-4 italic">Belum ada mata pelajaran terdaftar di sistem.</p>
                        @endforelse
                    </div>
                    @error('subject_ids')
                        <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit / Cancel Actions -->
                <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.teachers.index') }}" class="px-5 py-2.5 border border-slate-200 text-slate-600 hover:bg-slate-50 font-semibold text-xs rounded-xl transition">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs rounded-xl shadow-md shadow-indigo-600/20 hover:shadow-indigo-600/30 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Perbarui Data Guru</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
