<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@oneschool.sch.id'],
            [
                'name' => 'Administrator Sekolah',
                'password' => Hash::make('password'),
                'phone' => '081234567890',
                'is_active' => true,
            ]
        );
        $admin->syncRoles(['admin']);

        // 2. Guru Pengajar Biasa
        $guru = User::firstOrCreate(
            ['email' => 'guru@oneschool.sch.id'],
            [
                'name' => 'Budi Santoso, S.Pd.',
                'password' => Hash::make('password'),
                'phone' => '081234567891',
                'is_active' => true,
            ]
        );
        $guru->syncRoles(['guru']);

        // 3. Wali Kelas (juga bertindak sebagai guru)
        $waliKelas = User::firstOrCreate(
            ['email' => 'walikelas@oneschool.sch.id'],
            [
                'name' => 'Siti Rahmawati, M.Pd.',
                'password' => Hash::make('password'),
                'phone' => '081234567892',
                'is_active' => true,
            ]
        );
        $waliKelas->syncRoles(['guru', 'wali_kelas']);

        // 4. Guru Pembimbing PKL (juga bertindak sebagai guru)
        $pembimbing = User::firstOrCreate(
            ['email' => 'pembimbing@oneschool.sch.id'],
            [
                'name' => 'Ahmad Fauzi, S.Kom.',
                'password' => Hash::make('password'),
                'phone' => '081234567893',
                'is_active' => true,
            ]
        );
        $pembimbing->syncRoles(['guru', 'guru_pembimbing_pkl']);

        // 5. Akun Nonaktif untuk pengujian status akun
        $nonaktif = User::firstOrCreate(
            ['email' => 'nonaktif@oneschool.sch.id'],
            [
                'name' => 'Akun Dinonaktifkan',
                'password' => Hash::make('password'),
                'phone' => '081234567899',
                'is_active' => false,
            ]
        );
        $nonaktif->syncRoles(['guru']);
    }
}
