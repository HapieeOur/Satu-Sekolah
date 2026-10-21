<?php

namespace App\Services;

use App\Contracts\Services\UserServiceInterface;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use InvalidArgumentException;

class UserService implements UserServiceInterface
{
    /**
     * Create a new user with assigned roles.
     *
     * @param  array<string, mixed>  $data
     * @param  array<string>  $roles
     */
    public function createUser(array $data, array $roles): User
    {
        return DB::transaction(function () use ($data, $roles) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'nis' => ! empty($data['nis']) ? $data['nis'] : null,
                'nisn' => ! empty($data['nisn']) ? $data['nisn'] : null,
                'password' => Hash::make($data['password']),
                'is_active' => $data['is_active'] ?? true,
            ]);

            $user->syncRoles($roles);

            $this->syncStudentProfile($user, $data, $roles);
            $this->syncTeacherProfile($user, $data, $roles);

            return $user;
        });
    }

    /**
     * Update an existing user and their roles.
     *
     * @param  array<string, mixed>  $data
     * @param  array<string>  $roles
     */
    public function updateUser(User $user, array $data, array $roles): User
    {
        return DB::transaction(function () use ($user, $data, $roles) {
            $updateData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'is_active' => $data['is_active'] ?? true,
            ];

            if (array_key_exists('nis', $data)) {
                $updateData['nis'] = ! empty($data['nis']) ? $data['nis'] : null;
            }

            if (array_key_exists('nisn', $data)) {
                $updateData['nisn'] = ! empty($data['nisn']) ? $data['nisn'] : null;
            }

            if (! empty($data['password'])) {
                $updateData['password'] = Hash::make($data['password']);
            }

            $user->update($updateData);
            $user->syncRoles($roles);

            $this->syncStudentProfile($user, $data, $roles);
            $this->syncTeacherProfile($user, $data, $roles);

            return $user;
        });
    }

    /**
     * Synchronize linked Student record if user is a student or has NIS/NISN.
     *
     * @param  array<string, mixed>  $data
     * @param  array<string>  $roles
     */
    protected function syncStudentProfile(User $user, array $data, array $roles): void
    {
        $isStudent = in_array('siswa', $roles) || ! empty($data['nis']) || ! empty($data['nisn']);
        if (! $isStudent) {
            return;
        }

        $student = Student::where('user_id', $user->id)
            ->orWhere(function ($q) use ($data) {
                if (! empty($data['nis'])) {
                    $q->orWhere('nis', $data['nis']);
                }
                if (! empty($data['nisn'])) {
                    $q->orWhere('nisn', $data['nisn']);
                }
            })
            ->first();

        if ($student) {
            $studentUpdate = ['user_id' => $user->id];
            if (! empty($data['nis'])) {
                $studentUpdate['nis'] = $data['nis'];
            }
            if (! empty($data['nisn'])) {
                $studentUpdate['nisn'] = $data['nisn'];
            }
            if (! empty($data['name'])) {
                $studentUpdate['name'] = $data['name'];
            }
            if (! empty($data['phone'])) {
                $studentUpdate['phone'] = $data['phone'];
            }
            $student->update($studentUpdate);
        } elseif (! empty($data['nis'])) {
            Student::create([
                'user_id' => $user->id,
                'nis' => $data['nis'],
                'nisn' => ! empty($data['nisn']) ? $data['nisn'] : null,
                'name' => $user->name,
                'phone' => $user->phone ?? null,
                'gender' => 'L',
                'status' => 'aktif',
            ]);
        }
    }

    /**
     * Automatically ensure a teacher profile exists when user has a teaching role.
     */
    protected function syncTeacherProfile(User $user, array $data, array $roles): void
    {
        $isTeacherRole = in_array('guru', $roles, true)
            || in_array('guru_pembimbing_pkl', $roles, true)
            || in_array('wali_kelas', $roles, true);

        if ($isTeacherRole) {
            $teacher = Teacher::where('user_id', $user->id)->first();
            if ($teacher) {
                if (! empty($data['phone'])) {
                    $teacher->update(['phone' => $data['phone']]);
                }
            } else {
                Teacher::create([
                    'user_id' => $user->id,
                    'phone' => $user->phone ?? ($data['phone'] ?? null),
                    'gender' => 'L',
                ]);
            }
        }
    }

    /**
     * Self-healing: ensure all existing users with teacher roles have a teacher profile record.
     */
    public static function ensureTeacherProfilesExist(): void
    {
        User::role(['guru', 'guru_pembimbing_pkl', 'wali_kelas'])
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
    }

    /**
     * Delete a user with safeguard against deleting oneself.
     */
    public function deleteUser(User $user, int $currentUserId): bool
    {
        if ($user->id === $currentUserId) {
            throw new InvalidArgumentException('Anda tidak dapat menghapus akun Anda sendiri.');
        }

        return DB::transaction(function () use ($user) {
            $user->roles()->detach();

            return (bool) $user->delete();
        });
    }

    /**
     * Toggle the active status of a user.
     */
    public function toggleUserStatus(User $user, int $currentUserId): bool
    {
        if ($user->id === $currentUserId) {
            throw new InvalidArgumentException('Anda tidak dapat mengubah status akun Anda sendiri.');
        }

        return $user->update([
            'is_active' => ! $user->is_active,
        ]);
    }
}
