<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\Classroom;
use App\Models\InternshipCompany;
use App\Models\Room;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DataMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Tahun Ajaran
        $academicYearActive = AcademicYear::firstOrCreate(
            ['name' => '2026/2027', 'semester' => 'ganjil'],
            [
                'is_active' => true,
                'start_date' => '2026-07-15',
                'end_date' => '2026-12-20',
            ]
        );

        AcademicYear::firstOrCreate(
            ['name' => '2025/2026', 'semester' => 'genap'],
            [
                'is_active' => false,
                'start_date' => '2026-01-05',
                'end_date' => '2026-06-25',
            ]
        );

        // 2. Hubungkan User Guru yang sudah ada ke data Teacher
        $budiUser = User::where('email', 'guru@oneschool.sch.id')->first();
        $sitiUser = User::where('email', 'walikelas@oneschool.sch.id')->first();
        $fauziUser = User::where('email', 'pembimbing@oneschool.sch.id')->first();

        $teacherBudi = Teacher::firstOrCreate(
            ['user_id' => $budiUser->id],
            [
                'nip' => '198501102010011001',
                'nuptk' => '8439201928301928',
                'gender' => 'L',
                'phone' => '081234567891',
                'address' => 'Jl. Merpati No. 12, Kota Pendidikan',
            ]
        );

        $teacherSiti = Teacher::firstOrCreate(
            ['user_id' => $sitiUser->id],
            [
                'nip' => '198705152012022002',
                'nuptk' => '9482019283910293',
                'gender' => 'P',
                'phone' => '081234567892',
                'address' => 'Jl. Cendrawasih No. 45, Kota Pendidikan',
            ]
        );

        $teacherFauzi = Teacher::firstOrCreate(
            ['user_id' => $fauziUser->id],
            [
                'nip' => '199003202015031003',
                'nuptk' => '7291029384019284',
                'gender' => 'L',
                'phone' => '081234567893',
                'address' => 'Jl. Kenari Indah No. 8, Kota Pendidikan',
            ]
        );

        // Tambah 1 guru umum
        $dewiUser = User::firstOrCreate(
            ['email' => 'dewi@oneschool.sch.id'],
            [
                'name' => 'Dewi Lestari, S.Pd.',
                'phone' => '081234567894',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );
        $dewiUser->syncRoles(['guru']);

        $teacherDewi = Teacher::firstOrCreate(
            ['user_id' => $dewiUser->id],
            [
                'nip' => '199208182018022004',
                'nuptk' => '5192830192830192',
                'gender' => 'P',
                'phone' => '081234567894',
                'address' => 'Jl. Flamboyan No. 21, Kota Pendidikan',
            ]
        );

        // 3. Kelas (Classrooms)
        $kelas11Rpl = Classroom::firstOrCreate(
            ['name' => 'XI RPL 1', 'academic_year_id' => $academicYearActive->id],
            [
                'grade_level' => 11,
                'major' => 'Rekayasa Perangkat Lunak',
                'teacher_id' => $teacherSiti->id, // Wali kelas: Bu Siti
            ]
        );

        $kelas12Rpl = Classroom::firstOrCreate(
            ['name' => 'XII RPL 1', 'academic_year_id' => $academicYearActive->id],
            [
                'grade_level' => 12,
                'major' => 'Rekayasa Perangkat Lunak',
                'teacher_id' => $teacherFauzi->id, // Wali kelas: Pak Fauzi
            ]
        );

        Classroom::firstOrCreate(
            ['name' => 'X RPL 1', 'academic_year_id' => $academicYearActive->id],
            [
                'grade_level' => 10,
                'major' => 'Rekayasa Perangkat Lunak',
                'teacher_id' => $teacherBudi->id,
            ]
        );

        Classroom::firstOrCreate(
            ['name' => 'X TKJ 1', 'academic_year_id' => $academicYearActive->id],
            [
                'grade_level' => 10,
                'major' => 'Teknik Komputer & Jaringan',
                'teacher_id' => null,
            ]
        );

        // 4. Mata Pelajaran (Subjects)
        $mapelWeb = Subject::firstOrCreate(
            ['code' => 'RPL-WEB'],
            ['name' => 'Pemrograman Web & Perangkat Bergerak', 'description' => 'Mata pelajaran produktif keahlian RPL']
        );

        $mapelDb = Subject::firstOrCreate(
            ['code' => 'RPL-DB'],
            ['name' => 'Basis Data Relasional & Lanjut', 'description' => 'Mata pelajaran perancangan dan implementasi database']
        );

        $mapelMtk = Subject::firstOrCreate(
            ['code' => 'UMUM-MTK'],
            ['name' => 'Matematika Terapan', 'description' => 'Matematika kejuruan dan logika']
        );

        $mapelInggris = Subject::firstOrCreate(
            ['code' => 'UMUM-ING'],
            ['name' => 'Bahasa Inggris Bisnis', 'description' => 'Komunikasi profesional bahasa Inggris']
        );

        // 5. Relasi Guru - Mata Pelajaran (subject_teacher pivot)
        $teacherBudi->subjects()->syncWithoutDetaching([$mapelWeb->id, $mapelDb->id]);
        $teacherFauzi->subjects()->syncWithoutDetaching([$mapelWeb->id]);
        $teacherSiti->subjects()->syncWithoutDetaching([$mapelDb->id]);
        $teacherDewi->subjects()->syncWithoutDetaching([$mapelMtk->id]);

        // 6. Ruangan (Rooms)
        Room::firstOrCreate(['code' => 'LAB-RPL'], ['name' => 'Laboratorium Software Engineering', 'capacity' => 36, 'description' => 'Lantai 2 Gedung C']);
        Room::firstOrCreate(['code' => 'LAB-TKJ'], ['name' => 'Laboratorium Jaringan Komputer', 'capacity' => 36, 'description' => 'Lantai 2 Gedung C']);
        Room::firstOrCreate(['code' => 'R-101'], ['name' => 'Ruang Teori 101', 'capacity' => 36, 'description' => 'Lantai 1 Gedung A']);
        Room::firstOrCreate(['code' => 'R-102'], ['name' => 'Ruang Teori 102', 'capacity' => 36, 'description' => 'Lantai 1 Gedung A']);

        // 7. Siswa (Students)
        $studentsData = [
            ['nis' => '20261101', 'nisn' => '0071234501', 'name' => 'Aditya Pratama', 'gender' => 'L', 'classroom_id' => $kelas11Rpl->id, 'phone' => '082100000001', 'parent_name' => 'Bambang Pratama', 'parent_phone' => '081300000001'],
            ['nis' => '20261102', 'nisn' => '0071234502', 'name' => 'Bella Anindya', 'gender' => 'P', 'classroom_id' => $kelas11Rpl->id, 'phone' => '082100000002', 'parent_name' => 'Surya Anindya', 'parent_phone' => '081300000002'],
            ['nis' => '20261103', 'nisn' => '0071234503', 'name' => 'Dimas Arya Putra', 'gender' => 'L', 'classroom_id' => $kelas11Rpl->id, 'phone' => '082100000003', 'parent_name' => 'Agus Arya', 'parent_phone' => '081300000003'],
            ['nis' => '20261201', 'nisn' => '0061234501', 'name' => 'Fajar Hidayat', 'gender' => 'L', 'classroom_id' => $kelas12Rpl->id, 'phone' => '082100000004', 'parent_name' => 'Hendro Hidayat', 'parent_phone' => '081300000004'],
            ['nis' => '20261202', 'nisn' => '0061234502', 'name' => 'Gita Maharani', 'gender' => 'P', 'classroom_id' => $kelas12Rpl->id, 'phone' => '082100000005', 'parent_name' => 'Wahyudi', 'parent_phone' => '081300000005'],
        ];

        foreach ($studentsData as $studentRow) {
            $user = User::firstOrCreate(
                ['email' => $studentRow['nis'].'@student.oneschool.sch.id'],
                [
                    'name' => $studentRow['name'],
                    'phone' => $studentRow['phone'],
                    'password' => Hash::make('password'),
                    'is_active' => true,
                ]
            );
            $user->syncRoles(['siswa']);

            $studentRow['user_id'] = $user->id;
            $student = Student::firstOrCreate(['nis' => $studentRow['nis']], $studentRow);
            if (! $student->user_id) {
                $student->update(['user_id' => $user->id]);
            }
        }

        // 8. Mitra DUDI PKL (Internship Companies)
        $defaultMentorId = $teacherFauzi?->id ?? Teacher::first()?->id;

        InternshipCompany::firstOrCreate(
            ['name' => 'PT Inovasi Teknologi Nusantara'],
            [
                'teacher_id' => $defaultMentorId,
                'address' => 'Gedung Cyber 2 Lantai 15, Jl. H.R. Rasuna Said, Jakarta Selatan',
                'contact_person' => 'Irfan Hakim (HR Director)',
                'phone' => '0215551234',
                'email' => 'internship@inovasiteknologi.co.id',
                'latitude' => -6.2234000,
                'longitude' => 106.8291000,
                'radius_meters' => 150,
            ]
        );

        InternshipCompany::firstOrCreate(
            ['name' => 'PT Solusi Cloud Indonesia'],
            [
                'teacher_id' => $defaultMentorId,
                'address' => 'Jl. Dago Asri No. 88, Coblong, Kota Bandung',
                'contact_person' => 'Rina Kartika (People Operations)',
                'phone' => '0227775678',
                'email' => 'career@solusicloud.id',
                'latitude' => -6.8821000,
                'longitude' => 107.6189000,
                'radius_meters' => 100,
            ]
        );

        InternshipCompany::firstOrCreate(
            ['name' => 'CV Digital Kreatif Media'],
            [
                'teacher_id' => $defaultMentorId,
                'address' => 'Jl. Pemuda No. 45, Embong Kaliasin, Surabaya',
                'contact_person' => 'Eko Prasetyo (Studio Lead)',
                'phone' => '0318889900',
                'email' => 'hrd@digitalkreatif.com',
                'latitude' => -7.2654000,
                'longitude' => 112.7483000,
                'radius_meters' => 100,
            ]
        );
    }
}
