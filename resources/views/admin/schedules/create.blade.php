<x-app-layout title="Tambah Jadwal Pelajaran">
    <x-slot name="header">
        Akademik: Tambah Jadwal Pelajaran
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Breadcrumb / Header -->
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('admin.schedules.index', ['classroom_id' => $defaultClassroomId, 'academic_year_id' => $defaultAcademicYearId, 'semester' => $defaultSemester]) }}"
                   class="text-xs font-semibold text-slate-500 hover:text-navy transition inline-flex items-center gap-1 focus:outline-none focus:underline">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Jadwal Pelajaran
                </a>
                <h1 class="text-xl font-bold text-navy mt-1">Tambah Jadwal Pelajaran</h1>
                <p class="text-xs text-slate-600 mt-0.5">Alokasikan mata pelajaran, guru, jam, dan ruangan. Sistem memeriksa potensi konflik jadwal di sisi server.</p>
            </div>
        </div>

        <!-- Policy & Anti-Conflict Explanatory Notice -->
        <div class="bg-surface rounded-xl border border-border p-4 shadow-sm flex items-start gap-3.5">
            <div class="w-8 h-8 rounded-lg bg-slate-100 text-brand flex items-center justify-center shrink-0 mt-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="text-xs text-slate-700 leading-relaxed">
                <strong class="font-bold text-navy block mb-0.5">Ketentuan Anti-Bentrok:</strong>
                Pilihan guru disaring otomatis berdasarkan penugasan resmi mata pelajaran. Sistem memvalidasi agar tidak terjadi tabrakan waktu pada kelas, guru pengajar, maupun ruangan. Jadwal beruntun (misal selesai 09:30 dan mulai 09:30) diperbolehkan.
            </div>
        </div>

        <!-- Main Form Card -->
        <div class="bg-surface rounded-xl border border-border p-6 shadow-sm">
            <form method="POST" action="{{ route('admin.schedules.store') }}" class="space-y-6" id="schedule-form">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Academic Year -->
                    <div>
                        <label for="academic_year_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Tahun Ajaran <span class="text-danger">*</span>
                        </label>
                        <select name="academic_year_id" id="academic_year_id" required class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800 @error('academic_year_id') border-danger @enderror">
                            @foreach ($academicYears as $year)
                                <option value="{{ $year->id }}" {{ old('academic_year_id', $defaultAcademicYearId) == $year->id ? 'selected' : '' }}>
                                    {{ $year->name }} {{ $year->is_active ? '(Aktif)' : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('academic_year_id')
                            <p class="mt-1.5 text-xs text-danger font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Semester -->
                    <div>
                        <label for="semester" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Semester <span class="text-danger">*</span>
                        </label>
                        <select name="semester" id="semester" required class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800 @error('semester') border-danger @enderror">
                            <option value="ganjil" {{ old('semester', $defaultSemester) === 'ganjil' ? 'selected' : '' }}>Semester Ganjil (1)</option>
                            <option value="genap" {{ old('semester', $defaultSemester) === 'genap' ? 'selected' : '' }}>Semester Genap (2)</option>
                        </select>
                        @error('semester')
                            <p class="mt-1.5 text-xs text-danger font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Classroom -->
                    <div>
                        <label for="classroom_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Kelas <span class="text-danger">*</span>
                        </label>
                        <select name="classroom_id" id="classroom_id" required class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800 @error('classroom_id') border-danger @enderror">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach ($classrooms as $cls)
                                <option value="{{ $cls->id }}" {{ old('classroom_id', $defaultClassroomId) == $cls->id ? 'selected' : '' }}>
                                    {{ $cls->name }} (Kelas {{ $cls->grade_level }} • {{ $cls->major }})
                                </option>
                            @endforeach
                        </select>
                        @error('classroom_id')
                            <p class="mt-1.5 text-xs text-danger font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Day of Week -->
                    <div>
                        <label for="day_of_week" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Hari <span class="text-danger">*</span>
                        </label>
                        <select name="day_of_week" id="day_of_week" required class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800 @error('day_of_week') border-danger @enderror">
                            <option value="">-- Pilih Hari --</option>
                            @foreach ($days as $val => $lbl)
                                <option value="{{ $val }}" {{ old('day_of_week', request('day_of_week')) === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                            @endforeach
                        </select>
                        @error('day_of_week')
                            <p class="mt-1.5 text-xs text-danger font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Subject -->
                    <div>
                        <label for="subject_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Mata Pelajaran <span class="text-danger">*</span>
                        </label>
                        <select name="subject_id" id="subject_id" required class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800 @error('subject_id') border-danger @enderror">
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach ($subjects as $sbj)
                                <option value="{{ $sbj->id }}" {{ old('subject_id') == $sbj->id ? 'selected' : '' }}>
                                    {{ $sbj->name }} ({{ $sbj->code }})
                                </option>
                            @endforeach
                        </select>
                        @error('subject_id')
                            <p class="mt-1.5 text-xs text-danger font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Teacher (Dynamic based on Subject) -->
                    <div>
                        <label for="teacher_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Guru Pengajar <span class="text-danger">*</span>
                        </label>
                        <select name="teacher_id" id="teacher_id" required class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800 @error('teacher_id') border-danger @enderror">
                            <option value="">-- Pilih Mapel Terlebih Dahulu --</option>
                        </select>
                        <p id="teacher_help" class="mt-1 text-[11px] text-slate-500">Daftar guru terfilter otomatis berdasarkan data relasi penugasan mata pelajaran.</p>
                        @error('teacher_id')
                            <p class="mt-1.5 text-xs text-danger font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Start Time -->
                    <div>
                        <label for="start_time" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Jam Mulai <span class="text-danger">*</span>
                        </label>
                        <input type="time" name="start_time" id="start_time" required value="{{ old('start_time', '07:30') }}"
                               class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800 @error('start_time') border-danger @enderror">
                        @error('start_time')
                            <p class="mt-1.5 text-xs text-danger font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- End Time -->
                    <div>
                        <label for="end_time" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Jam Selesai <span class="text-danger">*</span>
                        </label>
                        <input type="time" name="end_time" id="end_time" required value="{{ old('end_time', '09:00') }}"
                               class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800 @error('end_time') border-danger @enderror">
                        @error('end_time')
                            <p class="mt-1.5 text-xs text-danger font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Room (Optional) -->
                    <div class="md:col-span-2">
                        <label for="room_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Ruangan (Opsional)
                        </label>
                        <select name="room_id" id="room_id" class="w-full text-xs rounded-lg border-border focus:border-brand focus:ring-1 focus:ring-brand bg-white text-slate-800 @error('room_id') border-danger @enderror">
                            <option value="">-- Ruang Kelas Standar / Tanpa Ruang Khusus --</option>
                            @foreach ($rooms as $rm)
                                <option value="{{ $rm->id }}" {{ old('room_id') == $rm->id ? 'selected' : '' }}>
                                    {{ $rm->name }} ({{ $rm->code }}) — Kapasitas: {{ $rm->capacity ?? '-' }}
                                </option>
                            @endforeach
                        </select>
                        @error('room_id')
                            <p class="mt-1.5 text-xs text-danger font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-3 pt-6 border-t border-border">
                    <a href="{{ route('admin.schedules.index', ['classroom_id' => $defaultClassroomId, 'academic_year_id' => $defaultAcademicYearId, 'semester' => $defaultSemester]) }}"
                       class="px-4 py-2 border border-border text-slate-700 text-xs font-semibold rounded-lg hover:bg-slate-100 transition focus:outline-none focus:ring-2 focus:ring-slate-300">
                        Batal
                    </a>
                    <button type="submit" class="px-5 py-2 bg-brand hover:bg-brand-hover text-white text-xs font-semibold rounded-lg shadow-sm transition focus:outline-none focus:ring-2 focus:ring-brand focus:ring-offset-2">
                        Simpan Jadwal
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
            const oldTeacherId = "{{ old('teacher_id') }}";

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
                    teacherHelp.className = 'mt-1 text-[11px] text-danger font-medium';
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
                updateTeachers(subjectSelect.value, oldTeacherId);
            } else {
                teacherSelect.disabled = true;
            }
        });
    </script>
</x-app-layout>
