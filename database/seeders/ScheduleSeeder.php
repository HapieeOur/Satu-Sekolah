<?php

namespace Database\Seeders;

use App\Enums\DayOfWeek;
use App\Enums\Semester;
use App\Models\AcademicYear;
use App\Models\Classroom;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $academicYear = AcademicYear::where('is_active', true)->first();
        if (! $academicYear) {
            return;
        }

        $kelas11Rpl = Classroom::where('name', 'XI RPL 1')->first();
        $kelas12Rpl = Classroom::where('name', 'XII RPL 1')->first();

        $mapelWeb = Subject::where('code', 'RPL-WEB')->first();
        $mapelDb = Subject::where('code', 'RPL-DB')->first();
        $mapelMtk = Subject::where('code', 'UMUM-MTK')->first();

        $teacherBudi = Teacher::where('nip', '198501102010011001')->first();
        $teacherSiti = Teacher::where('nip', '198705152012022002')->first();
        $teacherDewi = Teacher::where('nip', '199208182018022004')->first();

        $labRpl = Room::where('code', 'LAB-RPL')->first();
        $r101 = Room::where('code', 'R-101')->first();
        $r102 = Room::where('code', 'R-102')->first();

        if (! $kelas11Rpl || ! $mapelWeb || ! $teacherBudi) {
            return;
        }

        // Jadwal Kelas XI RPL 1
        $schedules11 = [
            [
                'academic_year_id' => $academicYear->id,
                'semester' => Semester::GANJIL->value,
                'classroom_id' => $kelas11Rpl->id,
                'subject_id' => $mapelWeb->id,
                'teacher_id' => $teacherBudi->id,
                'room_id' => $labRpl?->id,
                'day_of_week' => DayOfWeek::Senin->value,
                'start_time' => '07:30',
                'end_time' => '09:30',
            ],
            [
                'academic_year_id' => $academicYear->id,
                'semester' => Semester::GANJIL->value,
                'classroom_id' => $kelas11Rpl->id,
                'subject_id' => $mapelMtk->id,
                'teacher_id' => $teacherDewi->id,
                'room_id' => $r101?->id,
                'day_of_week' => DayOfWeek::Senin->value,
                'start_time' => '09:30', // Adjacent schedule allowed
                'end_time' => '11:30',
            ],
            [
                'academic_year_id' => $academicYear->id,
                'semester' => Semester::GANJIL->value,
                'classroom_id' => $kelas11Rpl->id,
                'subject_id' => $mapelDb->id,
                'teacher_id' => $teacherSiti->id,
                'room_id' => $labRpl?->id,
                'day_of_week' => DayOfWeek::Selasa->value,
                'start_time' => '08:00',
                'end_time' => '10:30',
            ],
        ];

        foreach ($schedules11 as $item) {
            Schedule::firstOrCreate(
                [
                    'academic_year_id' => $item['academic_year_id'],
                    'semester' => $item['semester'],
                    'classroom_id' => $item['classroom_id'],
                    'day_of_week' => $item['day_of_week'],
                    'start_time' => $item['start_time'],
                ],
                $item
            );
        }

        // Jadwal Kelas XII RPL 1 (berbeda jam / ruangan agar tidak bentrok)
        if ($kelas12Rpl) {
            $schedules12 = [
                [
                    'academic_year_id' => $academicYear->id,
                    'semester' => Semester::GANJIL->value,
                    'classroom_id' => $kelas12Rpl->id,
                    'subject_id' => $mapelWeb->id,
                    'teacher_id' => $teacherBudi->id,
                    'room_id' => $labRpl?->id,
                    'day_of_week' => DayOfWeek::Rabu->value,
                    'start_time' => '07:30',
                    'end_time' => '10:00',
                ],
                [
                    'academic_year_id' => $academicYear->id,
                    'semester' => Semester::GANJIL->value,
                    'classroom_id' => $kelas12Rpl->id,
                    'subject_id' => $mapelMtk->id,
                    'teacher_id' => $teacherDewi->id,
                    'room_id' => $r102?->id,
                    'day_of_week' => DayOfWeek::Kamis->value,
                    'start_time' => '08:00',
                    'end_time' => '10:00',
                ],
            ];

            foreach ($schedules12 as $item) {
                Schedule::firstOrCreate(
                    [
                        'academic_year_id' => $item['academic_year_id'],
                        'semester' => $item['semester'],
                        'classroom_id' => $item['classroom_id'],
                        'day_of_week' => $item['day_of_week'],
                        'start_time' => $item['start_time'],
                    ],
                    $item
                );
            }
        }
    }
}
