<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Attendance Working Hours Limits
    |--------------------------------------------------------------------------
    |
    | Batas waktu operasional presensi untuk siswa (KBM Akademik & PKL).
    | - Masuk maksimal: 08:00 WIB (setelah jam ini tercatat Terlambat).
    | - Pulang maksimal: 17:00 WIB (setelah jam ini presensi pulang ditutup).
    |
    */
    'check_in_max_time' => env('ATTENDANCE_CHECK_IN_MAX', '08:00:00'),
    'check_out_max_time' => env('ATTENDANCE_CHECK_OUT_MAX', '17:00:00'),
    'timezone' => env('APP_TIMEZONE', 'Asia/Jakarta'),
];
