<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions list
        $permissions = [
            // Admin permissions
            'admin.dashboard',
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
            'roles.manage',
            'academic.manage',
            'schedules.manage',
            'internships.manage',
            'attendance.correct',
            'news.manage',
            'reports.view',

            // Guru permissions
            'guru.dashboard',
            'schedules.view_own',
            'news.view',

            // Wali Kelas permissions
            'wali_kelas.dashboard',
            'classroom.view_students',
            'classroom.view_attendance',

            // Guru Pembimbing PKL permissions
            'pembimbing_pkl.dashboard',
            'internship.view_mentees',
            'internship.review_journals',
            'internship.manage_tasks',
            'internship.review_leaves',

            // Siswa permissions
            'siswa.dashboard',
            'internship.attendance',
            'internship.journal',
            'internship.tasks',
            'internship.leaves',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Roles definition
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions(Permission::all());

        $guruRole = Role::firstOrCreate(['name' => 'guru', 'guard_name' => 'web']);
        $guruRole->syncPermissions([
            'guru.dashboard',
            'schedules.view_own',
            'news.view',
        ]);

        $waliKelasRole = Role::firstOrCreate(['name' => 'wali_kelas', 'guard_name' => 'web']);
        $waliKelasRole->syncPermissions([
            'guru.dashboard',
            'schedules.view_own',
            'news.view',
            'wali_kelas.dashboard',
            'classroom.view_students',
            'classroom.view_attendance',
        ]);

        $pembimbingRole = Role::firstOrCreate(['name' => 'guru_pembimbing_pkl', 'guard_name' => 'web']);
        $pembimbingRole->syncPermissions([
            'guru.dashboard',
            'schedules.view_own',
            'news.view',
            'pembimbing_pkl.dashboard',
            'internship.view_mentees',
            'internship.review_journals',
            'internship.manage_tasks',
            'internship.review_leaves',
        ]);

        $siswaRole = Role::firstOrCreate(['name' => 'siswa', 'guard_name' => 'web']);
        $siswaRole->syncPermissions([
            'siswa.dashboard',
            'internship.attendance',
            'internship.journal',
            'internship.tasks',
            'internship.leaves',
            'schedules.view_own',
            'news.view',
        ]);
    }
}
