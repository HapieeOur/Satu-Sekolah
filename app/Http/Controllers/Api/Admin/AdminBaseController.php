<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class AdminBaseController extends ApiController
{
    /**
     * Ensure the authenticated user has administrative privileges.
     */
    protected function authorizeAdmin(): void
    {
        $user = $this->currentUser();
        if (! $user) {
            throw new HttpResponseException(
                $this->respondWithError('Unauthenticated. Silakan login kembali.', 401)
            );
        }

        // Check if user has 'admin' in their assigned roles
        $userRoles = $user->roles ? $user->roles->pluck('name')->toArray() : [];
        $isAdmin = in_array('admin', $userRoles, true) || $user->hasRole('admin');

        if (! $isAdmin) {
            throw new HttpResponseException(
                $this->respondWithError('Akses ditolak: Hanya administrator yang memiliki izin.', 403)
            );
        }
    }
}
