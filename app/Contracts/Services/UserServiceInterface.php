<?php

namespace App\Contracts\Services;

use App\Models\User;

interface UserServiceInterface
{
    /**
     * Create a new user with assigned roles.
     *
     * @param  array<string, mixed>  $data
     * @param  array<string>  $roles
     */
    public function createUser(array $data, array $roles): User;

    /**
     * Update an existing user and their roles.
     *
     * @param  array<string, mixed>  $data
     * @param  array<string>  $roles
     */
    public function updateUser(User $user, array $data, array $roles): User;

    /**
     * Delete a user with safeguard against deleting oneself.
     */
    public function deleteUser(User $user, int $currentUserId): bool;

    /**
     * Toggle the active status of a user.
     */
    public function toggleUserStatus(User $user, int $currentUserId): bool;
}
