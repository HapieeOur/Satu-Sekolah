<x-app-layout title="Edit Jadwal Pelajaran">
    <x-slot name="header">
        Akademik: Edit Jadwal Pelajaran
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.schedules.index', ['classroom_id' => $schedule->classroom_id, 'academic_year_id' => $schedule->academic_year_id, 'semester' => $schedule->semester->value]) }}"
                   class="w-10 h-10 rounded-xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-center text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition"
                   title="Kembali ke Jadwal Pelajaran">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <div>
                    <h1 class="text-xl font-bold text-slate-900">Edit Jadwal Pelajaran</h1>
                    <p class="text-xs text-slate-500 mt-0.5">Perbarui alokasi waktu dan guru pengajar. Sistem memverifikasi bentrok jadwal secara otomatis</p>
                </div>
            </div>
            <a href="{{ route('admin.schedules.index', ['classroom_id' => $schedule->classroom_id, 'academic_year_id' => $schedule->academic_year_id, 'semester' => $schedule->semester->value]) }}"
               class="text-xs font-semibold text-slate-500 hover:text-indigo-600 transition hidden sm:inline-block">
                &larr; Kembali ke Jadwal
            </a>
        </div>

        <!-- Main Form Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 md:p-8 shadow-sm">
            <form method="POST" action="{{ route('admin.schedules.update', $schedule) }}" class="space-y-6" id="schedule-form">
                @csrf
                @method('PUT')

                <!-- Section 1: Periode & Rombel -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                        <div class="w-6 h-6 rounded-md bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs font-bold">1</div>
                        <h2 class="text-xs font-bold uppercase tracking-wider text-slate-800">Tahun Ajaran & Kelas</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Academic Year -->
                        <div>
                            <label for="academic_year_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Tahun Ajaran <span class="text-rose-500">*</span>
                            </label>
                            <select name="academic_year_id" id="academic_year_id" required class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 bg-white text-slate-800 transition @error('academic_year_id') border-rose-400 @enderror">
                                @foreach ($academicYears as $year)
                                    <option value="{{ $year->id }}" {{ old('academic_year_id', $schedule->academic_year_id) == $year->id ? 'selected' : '' }}>
                                        {{ $year->name }} {{ $year->is_active ? '(Aktif)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('academic_year_id')
                                <p class="mt-1 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Semester -->
                        <div>
                            <label for="semester" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Semester <span class="text-rose-500">*</span>
                            </label>
                            <select name="semester" id="semester" required class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 bg-white text-slate-800 transition @error('semester') border-rose-400 @enderror">
                                <option value="ganjil" {{ old('semester', $schedule->semester->value) === 'ganjil' ? 'selected' : '' }}>Semester Ganjil (1)</option>
                                <option value="genap" {{ old('semester', $schedule->semester->value) === 'genap' ? 'selected' : '' }}>Semester Genap (2)</option>
                            </select>
                            @error('semester')
                                <p class="mt-1 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Classroom -->
                        <div>
                            <label for="classroom_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Kelas / Rombel <span class="text-rose-500">*</span>
                            </label>
                            <select name="classroom_id" id="classroom_id" required class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 bg-white text-slate-800 transition @error('classroom_id') border-rose-400 @enderror">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach ($classrooms as $cls)
                                    <option value="{{ $cls->id }}" {{ old('classroom_id', $schedule->classroom_id) == $cls->id ? 'selected' : '' }}>
                                        {{ $cls->name }} (Kelas {{ $cls->grade_level }} • {{ $cls->major }})
                                    </option>
                                @endforeach
                            </select>
                            @error('classroom_id')
                                <p class="mt-1 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 2: Mata Pelajaran & Pengajar -->
                <div class="space-y-4 pt-4 border-t border-slate-100">
                    <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                        <div class="w-6 h-6 rounded-md bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs font-bold">2</div>
                        <h2 class="text-xs font-bold uppercase tracking-wider text-slate-800">Mata Pelajaran & Guru Pengajar</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Subject -->
                        <div>
                            <label for="subject_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Mata Pelajaran <span class="text-rose-500">*</span>
                            </label>
                            <select name="subject_id" id="subject_id" required class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 bg-white text-slate-800 transition @error('subject_id') border-rose-400 @enderror">
                                <option value="">-- Pilih Mata Pelajaran --</option>
                                @foreach ($subjects as $sbj)
                                    <option value="{{ $sbj->id }}" {{ old('subject_id', $schedule->subject_id) == $sbj->id ? 'selected' : '' }}>
                                        {{ $sbj->name }} ({{ $sbj->code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('subject_id')
                                <p class="mt-1 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Teacher (Dynamic based on Subject) -->
                        <div>
                            <label for="teacher_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Guru Pengajar <span class="text-rose-500">*</span>
                            </label>
                            <select name="teacher_id" id="teacher_id" required class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 bg-white text-slate-800 transition disabled:opacity-50 @error('teacher_id') border-rose-400 @enderror">
                                <option value="">-- Pilih Mapel Terlebih Dahulu --</option>
                            </select>
                            <p id="teacher_help" class="mt-1 text-[11px] text-slate-500">Daftar guru terfilter otomatis berdasarkan data relasi penugasan mata pelajaran.</p>
                            @error('teacher_id')
                                <p class="mt-1 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 3: Waktu & Ruangan -->
                <div class="space-y-4 pt-4 border-t border-slate-100">
                    <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                        <div class="w-6 h-6 rounded-md bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs font-bold">3</div>
                        <h2 class="text-xs font-bold uppercase tracking-wider text-slate-800">Hari, Jam Pelajaran & Ruangan</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Day of Week -->
                        <div>
                            <label for="day_of_week" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Hari <span class="text-rose-500">*</span>
                            </label>
                            <select name="day_of_week" id="day_of_week" required class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 bg-white text-slate-800 transition @error('day_of_week') border-rose-400 @enderror">
                                <option value="">-- Pilih Hari --</option>
                                @foreach ($days as $val => $lbl)
                                    <option value="{{ $val }}" {{ old('day_of_week', $schedule->day_of_week->value) === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                                @endforeach
                            </select>
                            @error('day_of_week')
                                <p class="mt-1 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Start Time -->
                        <div>
                            <label for="start_time" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Jam Mulai <span class="text-rose-500">*</span>
                            </label>
                            <input type="time" name="start_time" id="start_time" required value="{{ old('start_time', substr((string) $schedule->start_time, 0, 5)) }}"
                                   class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 bg-white text-slate-800 font-mono transition @error('start_time') border-rose-400 @enderror">
                            @error('start_time')
                                <p class="mt-1 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- End Time -->
                        <div>
                            <label for="end_time" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Jam Selesai <span class="text-rose-500">*</span>
                            </label>
                            <input type="time" name="end_time" id="end_time" required value="{{ old('end_time', substr((string) $schedule->end_time, 0, 5)) }}"
                                   class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 bg-white text-slate-800 font-mono transition @error('end_time') border-rose-400 @enderror">
                            @error('end_time')
                                <p class="mt-1 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Room (Optional) -->
                        <div>
                            <label for="room_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Ruangan (Opsional)
                            </label>
                            <select name="room_id" id="room_id" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 bg-white text-slate-800 transition @error('room_id') border-rose-400 @enderror">
                                <option value="">-- Ruang Standar Kelas --</option>
                                @foreach ($rooms as $rm)
                                    <option value="{{ $rm->id }}" {{ old('room_id', $schedule->room_id) == $rm->id ? 'selected' : '' }}>
                                        {{ $rm->name }} ({{ $rm->code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('room_id')
                                <p class="mt-1 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                    <a href="{{ route('admin.schedules.index', ['classroom_id' => $schedule->classroom_id, 'academic_year_id' => $schedule->academic_year_id, 'semester' => $schedule->semester->value]) }}"
                       class="px-5 py-2.5 border border-slate-200 text-slate-600 text-xs font-semibold rounded-xl hover:bg-slate-50 transition">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl shadow-md shadow-indigo-600/20 hover:shadow-indigo-600/30 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Simpan Perubahan Jadwal</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Dynamic Teacher Dropdown JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const subjectSelect = document.getElementById('subject_id');
            const teacherSelect = document.getElementById('teacher_id');
            const teacherHelp = document.getElementById('teacher_help');
            const currentTeacherId = "{{ old('teacher_id', $schedule->teacher_id) }}";

            const subjectsData = {
                @foreach ($subjects as $sbj)
                    "{{ $sbj->id }}": [
                        @foreach ($sbj->teachers as $tch)
                            {
                                id: "{{ $tch->id }}",
                                name: "{{ addslashes($tch->name) }}",
                                nip: "{{ $tch->nip ?? '-' }}"
                            },
                        @endforeach
                    ],
                @endforeach
            };

            function updateTeachers(selectedSubjectId, selectedTeacherId = null) {
                teacherSelect.innerHTML = '';

                if (!selectedSubjectId) {
                    teacherSelect.innerHTML = '<option value="">-- Pilih Mapel Terlebih Dahulu --</option>';
                    teacherSelect.disabled = true;
                    teacherHelp.textContent = 'Pilih mata pelajaran terlebih dahulu untuk melihat daftar guru pengajar.';
                    teacherHelp.className = 'mt-1 text-[11px] text-slate-500';
                    return;
                }

                const teachers = subjectsData[selectedSubjectId] || [];

                if (teachers.length === 0) {
                    teacherSelect.innerHTML = '<option value="">-- Tidak ada guru pengajar untuk mapel ini --</option>';
                    teacherSelect.disabled = true;
                    teacherHelp.textContent = 'Mata pelajaran ini belum memiliki guru yang ditugaskan di Data Master Mata Pelajaran.';
                    teacherHelp.className = 'mt-1 text-[11px] text-rose-600 font-medium';
                    return;
                }

                teacherSelect.disabled = false;
                teacherHelp.textContent = 'Daftar guru terfilter otomatis berdasarkan data relasi penugasan mata pelajaran.';
                teacherHelp.className = 'mt-1 text-[11px] text-slate-500';

                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = '-- Pilih Guru Pengajar --';
                teacherSelect.appendChild(defaultOption);

                teachers.forEach(function (teacher) {
                    const opt = document.createElement('option');
                    opt.value = teacher.id;
                    opt.textContent = `${teacher.name} (NIP: ${teacher.nip})`;
                    if (selectedTeacherId && selectedTeacherId == teacher.id) {
                        opt.selected = true;
                    }
                    teacherSelect.appendChild(opt);
                });
            }

            subjectSelect.addEventListener('change', function () {
                updateTeachers(this.value);
            });

            if (subjectSelect.value) {
                updateTeachers(subjectSelect.value, currentTeacherId);
            }
        });
    </script>
</x-app-layout>
