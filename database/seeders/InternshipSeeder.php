<?php

namespace Database\Seeders;

use App\Enums\InternshipAttendanceStatus;
use App\Enums\InternshipJournalStatus;
use App\Enums\InternshipLeaveStatus;
use App\Enums\InternshipLeaveType;
use App\Enums\InternshipPlacementStatus;
use App\Enums\InternshipTaskSubmissionStatus;
use App\Enums\InternshipVerificationStatus;
use App\Models\AcademicYear;
use App\Models\InternshipAttendance;
use App\Models\InternshipCompany;
use App\Models\InternshipJournal;
use App\Models\InternshipLeaveRequest;
use App\Models\InternshipPlacement;
use App\Models\InternshipTask;
use App\Models\InternshipTaskSubmission;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class InternshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $academicYear = AcademicYear::where('is_active', true)->first();
        $pembimbingUser = User::where('email', 'pembimbing@oneschool.sch.id')->first();
        $teacherFauzi = Teacher::where('user_id', $pembimbingUser?->id)->first();

        $comp1 = InternshipCompany::where('name', 'PT Inovasi Teknologi Nusantara')->first();
        $comp2 = InternshipCompany::where('name', 'like', '%Solusi%')->first() ?? InternshipCompany::first();

        $studentFajar = Student::where('nis', '20261201')->first();
        $studentGita = Student::where('nis', '20261202')->first();

        if (! $academicYear || ! $teacherFauzi || ! $comp1 || ! $studentFajar) {
            return;
        }

        $today = Carbon::today()->toDateString();
        $yesterday = Carbon::yesterday()->toDateString();

        // 1. Placements
        $placementFajar = InternshipPlacement::firstOrCreate(
            [
                'student_id' => $studentFajar->id,
                'academic_year_id' => $academicYear->id,
            ],
            [
                'internship_company_id' => $comp1->id,
                'teacher_id' => $teacherFauzi->id,
                'start_date' => Carbon::now()->subMonth()->toDateString(),
                'end_date' => Carbon::now()->addMonths(2)->toDateString(),
                'department' => 'Software Engineering & QA',
                'status' => InternshipPlacementStatus::Active,
                'notes' => 'Surat Pengantar No: 421.5/PKL/2026/089',
            ]
        );

        $placementGita = null;
        if ($studentGita) {
            $placementGita = InternshipPlacement::firstOrCreate(
                [
                    'student_id' => $studentGita->id,
                    'academic_year_id' => $academicYear->id,
                ],
                [
                    'internship_company_id' => $comp2->id,
                    'teacher_id' => $teacherFauzi->id,
                    'start_date' => Carbon::now()->subMonth()->toDateString(),
                    'end_date' => Carbon::now()->addMonths(2)->toDateString(),
                    'department' => 'UI/UX & Digital Creative',
                    'status' => InternshipPlacementStatus::Active,
                    'notes' => 'Surat Pengantar No: 421.5/PKL/2026/090',
                ]
            );
        }

        // 2. Attendances
        InternshipAttendance::firstOrCreate(
            [
                'internship_placement_id' => $placementFajar->id,
                'date' => $today,
            ],
            [
                'status' => InternshipAttendanceStatus::Hadir,
                'check_in_time' => '07:42:00',
                'check_in_latitude' => -6.2234120,
                'check_in_longitude' => 106.8291450,
                'check_in_distance_meters' => 35,
                'check_in_within_radius' => true,
                'check_out_time' => null,
                'verification_status' => InternshipVerificationStatus::Verified,
                'notes' => 'Presensi masuk terverifikasi dalam geofence kantor',
            ]
        );

        InternshipAttendance::firstOrCreate(
            [
                'internship_placement_id' => $placementFajar->id,
                'date' => $yesterday,
            ],
            [
                'status' => InternshipAttendanceStatus::Hadir,
                'check_in_time' => '07:38:00',
                'check_in_latitude' => -6.2234050,
                'check_in_longitude' => 106.8291200,
                'check_in_distance_meters' => 28,
                'check_in_within_radius' => true,
                'check_out_time' => '16:30:00',
                'check_out_latitude' => -6.2234020,
                'check_out_longitude' => 106.8291150,
                'check_out_distance_meters' => 25,
                'check_out_within_radius' => true,
                'verification_status' => InternshipVerificationStatus::Verified,
            ]
        );

        if ($placementGita) {
            InternshipAttendance::firstOrCreate(
                [
                    'internship_placement_id' => $placementGita->id,
                    'date' => $today,
                ],
                [
                    'status' => InternshipAttendanceStatus::Terlambat,
                    'check_in_time' => '08:15:00',
                    'check_in_latitude' => -6.1754200,
                    'check_in_longitude' => 106.8272300,
                    'check_in_distance_meters' => 45,
                    'check_in_within_radius' => true,
                    'verification_status' => InternshipVerificationStatus::Pending,
                    'notes' => 'Keterlambatan armada TransJakarta',
                ]
            );
        }

        // 3. Journals
        InternshipJournal::firstOrCreate(
            [
                'internship_placement_id' => $placementFajar->id,
                'date' => $today,
            ],
            [
                'title' => 'Implementasi Endpoint RESTful API untuk Presensi',
                'activity_description' => 'Mengerjakan pembuatan endpoint autentikasi dan presensi menggunakan framework Laravel. Menyiapkan validasi koordinat GPS latitude dan longitude sesuai radius geofence mitra industri.',
                'status' => InternshipJournalStatus::Submitted,
            ]
        );

        InternshipJournal::firstOrCreate(
            [
                'internship_placement_id' => $placementFajar->id,
                'date' => $yesterday,
            ],
            [
                'title' => 'Setup Database Migration dan Skema Relasi Entity',
                'activity_description' => 'Merancang tabel relasional menggunakan foreign key cascade dan index komposit pada database MariaDB untuk modul monitoring presensi.',
                'status' => InternshipJournalStatus::Approved,
                'mentor_notes' => 'Rancangan skema sudah baik dan mengikuti kaidah normalisasi database.',
                'reviewed_by' => $pembimbingUser->id,
                'reviewed_at' => Carbon::yesterday()->setHour(17),
            ]
        );

        if ($placementGita) {
            InternshipJournal::firstOrCreate(
                [
                    'internship_placement_id' => $placementGita->id,
                    'date' => $yesterday,
                ],
                [
                    'title' => 'Eksplorasi Design System & Palet Warna Institusi',
                    'activity_description' => 'Menyusun wireframe dan komponen desain sistem UI untuk dashboard web institusi sesuai standar aksesibilitas WCAG AA.',
                    'status' => InternshipJournalStatus::RevisionRequested,
                    'mentor_notes' => 'Tolong sertakan lampiran rasio kontras warna untuk komponen form input.',
                    'reviewed_by' => $pembimbingUser->id,
                    'reviewed_at' => Carbon::yesterday()->setHour(16),
                ]
            );
        }

        // 4. Tasks
        $task = InternshipTask::firstOrCreate(
            [
                'teacher_id' => $teacherFauzi->id,
                'title' => 'Laporan Mingguan Analisis Alur Kerja Tim Industri',
            ],
            [
                'internship_company_id' => null, // Seluruh siswa binaan
                'description' => "Susun laporan rangkuman mingguan yang memuat:\n1. Deskripsi divisi dan tanggung jawab peran Anda.\n2. Alur koordinasi dan tools manajemen tugas yang digunakan oleh tim.\n3. Kendala teknis yang dihadapi dan solusi penyelesaian yang telah diterapkan.",
                'due_date' => Carbon::now()->addDays(5)->toDateString(),
            ]
        );

        // 5. Submissions
        InternshipTaskSubmission::firstOrCreate(
            [
                'internship_task_id' => $task->id,
                'student_id' => $studentFajar->id,
            ],
            [
                'submission_file_path' => 'submissions/fajar_laporan_mingguan_1.pdf',
                'student_notes' => 'Berikut berkas laporan analisis alur kerja tim IT Backend PT Inovasi Teknologi Nusantara.',
                'submitted_at' => Carbon::yesterday()->setHour(14),
                'status' => InternshipTaskSubmissionStatus::Graded,
                'grade' => 90,
                'mentor_feedback' => 'Analisis alur Scrum dan CI/CD pipeline dipaparkan dengan sangat baik dan jelas.',
                'graded_by' => $pembimbingUser->id,
                'graded_at' => Carbon::yesterday()->setHour(18),
            ]
        );

        // 6. Leave Requests
        if ($placementGita) {
            InternshipLeaveRequest::firstOrCreate(
                [
                    'internship_placement_id' => $placementGita->id,
                    'start_date' => Carbon::now()->addDays(3)->toDateString(),
                ],
                [
                    'type' => InternshipLeaveType::Izin,
                    'end_date' => Carbon::now()->addDays(3)->toDateString(),
                    'reason' => 'Mengikuti kegiatan seleksi beasiswa tingkat provinsi.',
                    'status' => InternshipLeaveStatus::Pending,
                ]
            );
        }
    }
}
