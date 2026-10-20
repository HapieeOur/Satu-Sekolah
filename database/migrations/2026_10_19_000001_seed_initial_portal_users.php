<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Pastikan seluruh role dasar tersedia
        $roles = [
            'admin',
            'guru',
            'wali_kelas',
            'guru_pembimbing_pkl',
            'siswa',
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        // 2. Akun Utama Developer / Pengguna (Dapat digunakan untuk Google OAuth & Lupa Password OTP Nyata)
        $owner = User::firstOrCreate(
            ['email' => 'ahmadanjkuy@gmail.com'],
            [
                'name' => 'Ahmad (Administrator)',
                'password' => Hash::make('password'),
                'phone' => '081234567890',
                'is_active' => true,
            ]
        );
        $owner->syncRoles(['admin']);

        // 3. Akun Administrator Sistem
        $admin = User::firstOrCreate(
            ['email' => 'admin@oneschool.sch.id'],
            [
                'name' => 'Administrator Sekolah',
                'password' => Hash::make('password'),
                'phone' => '081234567891',
                'is_active' => true,
            ]
        );
        $admin->syncRoles(['admin']);

        // 4. Akun Guru Pengajar
        $guru = User::firstOrCreate(
            ['email' => 'guru@oneschool.sch.id'],
            [
                'name' => 'Budi Santoso, S.Pd.',
                'password' => Hash::make('password'),
                'phone' => '081234567892',
                'is_active' => true,
            ]
        );
        $guru->syncRoles(['guru']);

        // 5. Akun Wali Kelas
        $walas = User::firstOrCreate(
            ['email' => 'walikelas@oneschool.sch.id'],
            [
                'name' => 'Siti Rahmawati, M.Pd.',
                'password' => Hash::make('password'),
                'phone' => '081234567893',
                'is_active' => true,
            ]
        );
        $walas->syncRoles(['guru', 'wali_kelas']);

        // 6. Akun Guru Pembimbing PKL
        $pembimbing = User::firstOrCreate(
            ['email' => 'pembimbing@oneschool.sch.id'],
            [
                'name' => 'Ahmad Fauzi, S.Kom.',
                'password' => Hash::make('password'),
                'phone' => '081234567894',
                'is_active' => true,
            ]
        );
        $pembimbing->syncRoles(['guru', 'guru_pembimbing_pkl']);

        // 7. Akun Siswa (login via Email / NISN / NIS)
        $siswa = User::firstOrCreate(
            ['email' => 'siswa@oneschool.sch.id'],
            [
                'name' => 'Aditya Pratama',
                'nis' => '20241001',
                'nisn' => '0071234567',
                'password' => Hash::make('password'),
                'phone' => '081234567895',
                'is_active' => true,
            ]
        );
        if (! $siswa->nis || ! $siswa->nisn) {
            $siswa->update([
                'nis' => '20241001',
                'nisn' => '0071234567',
            ]);
        }
        $siswa->syncRoles(['siswa']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Opsional: biarkan akun tetap tersimpan
    }
};
