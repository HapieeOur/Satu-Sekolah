<?php

namespace Database\Seeders;

use App\Enums\AttendanceStatus;
use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Schedule;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kelas11Rpl = Classroom::where('name', 'XI RPL 1')->first();
        $kelas12Rpl = Classroom::where('name', 'XII RPL 1')->first();

        if (! $kelas11Rpl || ! $kelas12Rpl) {
            return;
        }

        $students11 = Student::where('classroom_id', $kelas11Rpl->id)->get();
        $students12 = Student::where('classroom_id', $kelas12Rpl->id)->get();

        $scheduleWeb11 = Schedule::where('classroom_id', $kelas11Rpl->id)->first();
        $scheduleWeb12 = Schedule::where('classroom_id', $kelas12Rpl->id)->first();

        $today = Carbon::today()->format('Y-m-d');
        $yesterday = Carbon::yesterday()->format('Y-m-d');
        $twoDaysAgo = Carbon::today()->subDays(2)->format('Y-m-d');

        // Records for XI RPL 1 on Today (using scheduleWeb11 session)
        if ($students11->isNotEmpty()) {
            // Student 1: Hadir tepat waktu
            Attendance::firstOrCreate(
                [
                    'student_id' => $students11[0]->id,
                    'date' => $today,
                    'schedule_id' => $scheduleWeb11?->id,
                ],
                [
                    'classroom_id' => $kelas11Rpl->id,
                    'status' => AttendanceStatus::Hadir,
                    'check_in_time' => '07:12:00',
                    'notes' => 'Presensi mandiri melalui aplikasi mobile',
                ]
            );

            // Student 2: Terlambat
            if (isset($students11[1])) {
                Attendance::firstOrCreate(
                    [
                        'student_id' => $students11[1]->id,
                        'date' => $today,
                        'schedule_id' => $scheduleWeb11?->id,
                    ],
                    [
                        'classroom_id' => $kelas11Rpl->id,
                        'status' => AttendanceStatus::Terlambat,
                        'check_in_time' => '07:45:00',
                        'notes' => 'Kendala transportasi umum',
                    ]
                );
            }

            // Student 3: Sakit
            if (isset($students11[2])) {
                Attendance::firstOrCreate(
                    [
                        'student_id' => $students11[2]->id,
                        'date' => $today,
                        'schedule_id' => $scheduleWeb11?->id,
                    ],
                    [
                        'classroom_id' => $kelas11Rpl->id,
                        'status' => AttendanceStatus::Sakit,
                        'check_in_time' => null,
                        'notes' => 'Surat dokter terlampir di pos satpam',
                    ]
                );
            }

            // Records for XI RPL 1 on Yesterday
            Attendance::firstOrCreate(
                [
                    'student_id' => $students11[0]->id,
                    'date' => $yesterday,
                    'schedule_id' => null, // Homeroom daily check-in
                ],
                [
                    'classroom_id' => $kelas11Rpl->id,
                    'status' => AttendanceStatus::Hadir,
                    'check_in_time' => '07:05:00',
                    'notes' => null,
                ]
            );

            if (isset($students11[1])) {
                Attendance::firstOrCreate(
                    [
                        'student_id' => $students11[1]->id,
                        'date' => $yesterday,
                        'schedule_id' => null,
                    ],
                    [
                        'classroom_id' => $kelas11Rpl->id,
                        'status' => AttendanceStatus::Hadir,
                        'check_in_time' => '07:10:00',
                        'notes' => null,
                    ]
                );
            }

            if (isset($students11[2])) {
                Attendance::firstOrCreate(
                    [
                        'student_id' => $students11[2]->id,
                        'date' => $yesterday,
                        'schedule_id' => null,
                    ],
                    [
                        'classroom_id' => $kelas11Rpl->id,
                        'status' => AttendanceStatus::Izin,
                        'check_in_time' => null,
                        'notes' => 'Izin keperluan dinas keluarga',
                    ]
                );
            }

            // Records for XI RPL 1 on 2 days ago
            Attendance::firstOrCreate(
                [
                    'student_id' => $students11[0]->id,
                    'date' => $twoDaysAgo,
                    'schedule_id' => null,
                ],
                [
                    'classroom_id' => $kelas11Rpl->id,
                    'status' => AttendanceStatus::Hadir,
                    'check_in_time' => '07:15:00',
                    'notes' => null,
                ]
            );

            if (isset($students11[1])) {
                Attendance::firstOrCreate(
                    [
                        'student_id' => $students11[1]->id,
                        'date' => $twoDaysAgo,
                        'schedule_id' => null,
                    ],
                    [
                        'classroom_id' => $kelas11Rpl->id,
                        'status' => AttendanceStatus::Hadir,
                        'check_in_time' => '07:18:00',
                        'notes' => null,
                    ]
                );
            }

            if (isset($students11[2])) {
                Attendance::firstOrCreate(
                    [
                        'student_id' => $students11[2]->id,
                        'date' => $twoDaysAgo,
                        'schedule_id' => null,
                    ],
                    [
                        'classroom_id' => $kelas11Rpl->id,
                        'status' => AttendanceStatus::Alpa,
                        'check_in_time' => null,
                        'notes' => 'Tidak ada kabar atau keterangan',
                    ]
                );
            }
        }

        // Records for XII RPL 1 on Today
        if ($students12->isNotEmpty()) {
            Attendance::firstOrCreate(
                [
                    'student_id' => $students12[0]->id,
                    'date' => $today,
                    'schedule_id' => $scheduleWeb12?->id,
                ],
                [
                    'classroom_id' => $kelas12Rpl->id,
                    'status' => AttendanceStatus::Hadir,
                    'check_in_time' => '07:10:00',
                    'notes' => null,
                ]
            );

            if (isset($students12[1])) {
                Attendance::firstOrCreate(
                    [
                        'student_id' => $students12[1]->id,
                        'date' => $today,
                        'schedule_id' => $scheduleWeb12?->id,
                    ],
                    [
                        'classroom_id' => $kelas12Rpl->id,
                        'status' => AttendanceStatus::Izin,
                        'check_in_time' => null,
                        'notes' => 'Mengikuti lomba olimpiade tingkat kota',
                    ]
                );
            }
        }
    }
}
