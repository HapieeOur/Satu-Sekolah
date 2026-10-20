<x-app-layout title="Buku Nilai & Penilaian Siswa">
    <x-slot name="header">
        {{ $isHomeroomRoute ? 'Wali Kelas: Buku Nilai Kelas Binaan' : 'Portal Guru: Input & Rekap Nilai Siswa' }}
    </x-slot>

    <div class="space-y-6">
        <!-- Top Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $isHomeroomRoute ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-indigo-50 text-indigo-700 border border-indigo-200' }}">
                        {{ $isHomeroomRoute ? 'Buku Nilai Kelas Binaan' : 'Buku Nilai Mata Pelajaran' }}
                    </span>
                    @if($selectedClassroom)
                        <span class="text-xs text-slate-400">&bull;</span>
                        <span class="text-xs text-slate-600 font-bold">Kelas {{ $selectedClassroom->name }}</span>
                    @endif
                </div>
                <h1 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight mt-1">Input &amp; Rekap Nilai Siswa</h1>
                <p class="text-xs text-slate-500 mt-0.5">Kelola rekapitulasi nilai tugas, ulangan harian, UTS, dan UAS siswa secara terpadu</p>
            </div>
        </div>

        @if (session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200/80 text-emerald-800 text-xs flex items-center gap-2.5">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Filter & Selector Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <form method="GET" action="{{ url()->current() }}" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Classroom Selector -->
                    <div>
                        <label for="classroom_id" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Kelas / Rombel</label>
                        <select name="classroom_id" id="classroom_id" onchange="this.form.submit()"
                                class="w-full text-xs rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 p-2.5 text-slate-800 transition">
                            @foreach ($classrooms as $c)
                                <option value="{{ $c->id }}" {{ $selectedClassroom?->id == $c->id ? 'selected' : '' }}>
                                    {{ $c->name }} ({{ $c->major }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Subject Selector -->
                    <div>
                        <label for="subject_id" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Mata Pelajaran</label>
                        <select name="subject_id" id="subject_id" onchange="this.form.submit()"
                                class="w-full text-xs rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 p-2.5 text-slate-800 transition">
                            @foreach ($subjects as $s)
                                <option value="{{ $s->id }}" {{ $selectedSubject?->id == $s->id ? 'selected' : '' }}>
                                    {{ $s->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Component Type -->
                    <div>
                        <label for="type" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Komponen Penilaian</label>
                        <select name="type" id="type" onchange="this.form.submit()"
                                class="w-full text-xs rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 p-2.5 text-slate-800 transition">
                            <option value="tugas" {{ $type === 'tugas' ? 'selected' : '' }}>Tugas / Praktik Mandiri</option>
                            <option value="ulangan_harian" {{ $type === 'ulangan_harian' ? 'selected' : '' }}>Ulangan Harian (UH)</option>
                            <option value="uts" {{ $type === 'uts' ? 'selected' : '' }}>Penilaian Tengah Semester (PTS/UTS)</option>
                            <option value="uas" {{ $type === 'uas' ? 'selected' : '' }}>Penilaian Akhir Semester (PAS/UAS)</option>
                            <option value="akhir" {{ $type === 'akhir' ? 'selected' : '' }}>Nilai Akhir / Rapor</option>
                        </select>
                    </div>

                    <!-- Title / Label -->
                    <div>
                        <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Label Penilaian</label>
                        <div class="flex gap-2">
                            <input type="text" name="title" id="title" value="{{ $title }}" placeholder="Misal: Tugas 1, UH 1"
                                   class="w-full text-xs rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 p-2.5 text-slate-800 transition">
                            <button type="submit" class="px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shrink-0 transition">
                                Terapkan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        @if ($selectedClassroom && $selectedSubject)
            <!-- Stats Bento Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs">
                    <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Rata-Rata Kelas</span>
                    <p class="text-2xl font-black text-slate-900 mt-1">{{ $averageScore !== null ? $averageScore : '-' }}</p>
                    <span class="text-[10px] text-slate-400 font-medium">dari 100 poin</span>
                </div>

                <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs">
                    <span class="text-[11px] font-bold text-emerald-600 uppercase tracking-wider">Nilai Tertinggi</span>
                    <p class="text-2xl font-black text-emerald-600 mt-1">{{ $highestScore !== null ? $highestScore : '-' }}</p>
                    <span class="text-[10px] text-slate-400 font-medium">skor terbaik kelas</span>
                </div>

                <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs">
                    <span class="text-[11px] font-bold text-amber-600 uppercase tracking-wider">Nilai Terendah</span>
                    <p class="text-2xl font-black text-amber-600 mt-1">{{ $lowestScore !== null ? $lowestScore : '-' }}</p>
                    <span class="text-[10px] text-slate-400 font-medium">skor terendah</span>
                </div>

                <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs">
                    <span class="text-[11px] font-bold text-indigo-600 uppercase tracking-wider">Tuntas KKM (&ge; 75)</span>
                    <p class="text-2xl font-black text-indigo-600 mt-1">{{ $passedCount }} <span class="text-xs text-slate-400 font-normal">/ {{ $students->count() }}</span></p>
                    <span class="text-[10px] text-slate-400 font-medium">peserta tuntas KKM</span>
                </div>
            </div>

            <!-- Gradebook Table Form -->
            <form method="POST" action="{{ $isHomeroomRoute ? route('homeroom.grades.store') : route('teacher.grades.store') }}">
                @csrf
                <input type="hidden" name="classroom_id" value="{{ $selectedClassroom->id }}">
                <input type="hidden" name="subject_id" value="{{ $selectedSubject->id }}">
                <input type="hidden" name="type" value="{{ $type }}">
                <input type="hidden" name="title" value="{{ $title }}">

                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                    <div class="p-5 md:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <h3 class="text-base font-bold text-slate-900">Rekap Nilai: {{ $title }}</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Mata Pelajaran: <span class="font-bold text-slate-700">{{ $selectedSubject->name }}</span> &bull; Kelas: <span class="font-bold text-slate-700">{{ $selectedClassroom->name }}</span></p>
                        </div>
                        <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md shadow-indigo-600/20 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Simpan Rekap Nilai</span>
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-slate-800">
                            <thead class="bg-[#F4F6FB] border-b border-slate-200/80 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">
                                <tr>
                                    <th scope="col" class="py-3.5 px-4 w-12 text-center">No</th>
                                    <th scope="col" class="py-3.5 px-4">Nama Siswa</th>
                                    <th scope="col" class="py-3.5 px-4">NIS</th>
                                    <th scope="col" class="py-3.5 px-4 w-36">Nilai (0 - 100)</th>
                                    <th scope="col" class="py-3.5 px-4 text-center">Ketuntasan (KKM 75)</th>
                                    <th scope="col" class="py-3.5 px-4">Catatan Evaluasi Guru</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($students as $index => $stu)
                                    @php
                                        $gradeRecord = $existingGrades->get($stu->id);
                                        $scoreVal = old("grades.{$index}.score", $gradeRecord?->score);
                                    @endphp
                                    <tr class="hover:bg-indigo-50/25 transition">
                                        <td class="py-3.5 px-4 text-center font-mono text-slate-400">
                                            {{ $index + 1 }}
                                            <input type="hidden" name="grades[{{ $index }}][student_id]" value="{{ $stu->id }}">
                                        </td>
                                        <td class="py-3.5 px-4 font-bold text-slate-900">
                                            {{ $stu->name }}
                                        </td>
                                        <td class="py-3.5 px-4 font-mono text-slate-500">
                                            {{ $stu->nis ?? '-' }}
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <input type="number" step="0.1" min="0" max="100"
                                                   name="grades[{{ $index }}][score]"
                                                   value="{{ $scoreVal }}"
                                                   placeholder="0 - 100"
                                                   class="w-28 text-xs font-bold rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 p-2 text-slate-900">
                                        </td>
                                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                            @if ($scoreVal !== null && $scoreVal !== '')
                                                @if ((float)$scoreVal >= 75)
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                        ✓ Tuntas
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                                        ⚠ Remedial
                                                    </span>
                                                @endif
                                            @else
                                                <span class="text-slate-400 text-xs italic">Kosong</span>
                                            @endif
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <input type="text"
                                                   name="grades[{{ $index }}][notes]"
                                                   value="{{ old("grades.{$index}.notes", $gradeRecord?->notes) }}"
                                                   placeholder="Catatan prestasi / remedial..."
                                                   class="w-full text-xs rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 p-2 text-slate-800">
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-10 text-center text-slate-400">
                                            Tidak ada data siswa terdaftar di kelas ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="p-4 bg-slate-50/80 border-t border-slate-100 flex items-center justify-between">
                        <p class="text-[11px] text-slate-500">Nilai yang dikosongkan akan menghapus rekaman nilai sebelumnya untuk komponen ini.</p>
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md shadow-indigo-600/20 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Simpan Rekap Nilai</span>
                        </button>
                    </div>
                </div>
            </form>
        @else
            <div class="bg-white rounded-2xl p-12 border border-slate-200/80 text-center shadow-xs">
                <p class="text-xs text-slate-500">Silakan pilih kelas dan mata pelajaran untuk mulai menginput nilai siswa.</p>
            </div>
        @endif
    </div>
</x-app-layout>
