<x-app-layout title="Edit Data Guru">
    <x-slot name="header">
        Edit Data Guru
    </x-slot>

    <div class="max-w-3xl bg-surface rounded-xl border border-border shadow-sm p-6">
        <div class="mb-6 pb-4 border-b border-border flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-navy">Edit Data Guru: {{ $teacher->user->name }}</h2>
                <p class="text-xs text-slate-500 mt-0.5">Perbarui profil guru dan penugasan mata pelajaran.</p>
            </div>
            <a href="{{ route('admin.teachers.index') }}" class="text-xs font-semibold text-slate-600 hover:text-navy transition">
                &larr; Kembali
            </a>
        </div>

        <div class="mb-4 p-3 bg-slate-50 rounded-lg border border-border flex items-center justify-between text-xs">
            <div>
                <span class="text-slate-500">Akun Pengguna Terkait:</span>
                <span class="font-bold text-navy ml-1">{{ $teacher->user->name }}</span>
                <span class="text-slate-500">({{ $teacher->user->email }})</span>
            </div>
            <a href="{{ route('admin.users.edit', $teacher->user) }}" class="text-brand hover:underline font-semibold">
                Edit Akun &rarr;
            </a>
        </div>

        <form method="POST" action="{{ route('admin.teachers.update', $teacher) }}" class="space-y-4 text-xs">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="nip" class="block font-semibold text-slate-700 mb-1">NIP (Nomor Induk Pegawai)</label>
                    <input 
                        type="text" 
                        id="nip" 
                        name="nip" 
                        value="{{ old('nip', $teacher->nip) }}" 
                        placeholder="Contoh: 198001012005011001"
                        class="w-full px-3.5 py-2 text-xs rounded-lg border @error('nip') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand"
                    >
                    @error('nip')
                        <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nuptk" class="block font-semibold text-slate-700 mb-1">NUPTK</label>
                    <input 
                        type="text" 
                        id="nuptk" 
                        name="nuptk" 
                        value="{{ old('nuptk', $teacher->nuptk) }}" 
                        placeholder="Contoh: 1234567890123456"
                        class="w-full px-3.5 py-2 text-xs rounded-lg border @error('nuptk') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand"
                    >
                    @error('nuptk')
                        <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="gender" class="block font-semibold text-slate-700 mb-1">Jenis Kelamin <span class="text-danger">*</span></label>
                    <select 
                        id="gender" 
                        name="gender" 
                        required
                        class="w-full px-3.5 py-2 text-xs rounded-lg border @error('gender') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand bg-white"
                    >
                        <option value="L" {{ old('gender', $teacher->gender) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('gender', $teacher->gender) === 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('gender')
                        <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block font-semibold text-slate-700 mb-1">No. Telepon / WhatsApp</label>
                    <input 
                        type="text" 
                        id="phone" 
                        name="phone" 
                        value="{{ old('phone', $teacher->phone) }}" 
                        placeholder="Contoh: 08123456789"
                        class="w-full px-3.5 py-2 text-xs rounded-lg border @error('phone') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand"
                    >
                    @error('phone')
                        <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="address" class="block font-semibold text-slate-700 mb-1">Alamat Tinggal</label>
                <textarea 
                    id="address" 
                    name="address" 
                    rows="2"
                    class="w-full px-3.5 py-2 text-xs rounded-lg border @error('address') border-danger @else border-border @enderror focus:ring-1 focus:ring-brand focus:border-brand"
                >{{ old('address', $teacher->address) }}</textarea>
                @error('address')
                    <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            @php
                $currentSubjectIds = old('subject_ids', $teacher->subjects->pluck('id')->toArray());
            @endphp

            <div class="pt-2">
                <label class="block font-semibold text-slate-700 mb-2">Mata Pelajaran yang Diampu</label>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5 p-3 rounded-lg border border-border bg-slate-50/50 max-h-48 overflow-y-auto">
                    @forelse ($subjects as $subject)
                        <label class="flex items-center gap-2 p-1.5 rounded hover:bg-white text-slate-700 cursor-pointer">
                            <input 
                                type="checkbox" 
                                name="subject_ids[]" 
                                value="{{ $subject->id }}"
                                {{ in_array($subject->id, $currentSubjectIds) ? 'checked' : '' }}
                                class="w-4 h-4 rounded text-brand focus:ring-brand border-border"
                            >
                            <span class="truncate">
                                <span class="font-semibold text-slate-900">{{ $subject->code }}</span> - {{ $subject->name }}
                            </span>
                        </label>
                    @empty
                        <p class="text-slate-400 col-span-3 italic">Belum ada mata pelajaran terdaftar.</p>
                    @endforelse
                </div>
                @error('subject_ids')
                    <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 border-t border-border flex items-center justify-end gap-3">
                <a href="{{ route('admin.teachers.index') }}" class="px-4 py-2 border border-border text-slate-700 hover:bg-slate-50 font-semibold rounded-lg transition">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-brand hover:bg-brand-hover text-white font-semibold rounded-lg shadow-sm transition">
                    Perbarui Data Guru
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
