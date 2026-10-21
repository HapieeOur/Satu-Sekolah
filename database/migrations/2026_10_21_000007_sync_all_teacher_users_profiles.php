<?php

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        try {
            User::whereHas('roles', function ($q) {
                $q->whereIn('name', ['guru', 'wali_kelas', 'guru_pembimbing_pkl']);
            })
            ->whereDoesntHave('teacher')
            ->each(function ($user) {
                Teacher::firstOrCreate(
                    ['user_id' => $user->id],
                    [
                        'phone' => $user->phone,
                        'gender' => 'L',
                    ]
                );
            });
        } catch (\Throwable $e) {
            // Keep going if database tables are in transient state
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
