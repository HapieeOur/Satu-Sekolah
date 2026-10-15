<?php

namespace App\Services;

use App\Contracts\Services\UserServiceInterface;
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
                'password' => Hash::make($data['password']),
                'is_active' => $data['is_active'] ?? true,
            ]);

            $user->syncRoles($roles);

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

            if (! empty($data['password'])) {
                $updateData['password'] = Hash::make($data['password']);
            }

            $user->update($updateData);
            $user->syncRoles($roles);

            return $user;
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
