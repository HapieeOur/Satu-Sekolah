<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;

abstract class AdminBaseController extends ApiController
{
    /**
     * Ensure the authenticated user has administrative privileges.
     */
    protected function authorizeAdmin(): void
    {
        $user = $this->currentUser();
        if (! $user) {
            abort(response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401));
        }

        // Allow users with admin role or admin permissions
        if (! $user->hasRole('admin') && ! $user->can('admin.dashboard')) {
            abort(response()->json([
                'success' => false,
                'message' => 'Akses ditolak: Hanya administrator yang memiliki izin.',
            ], 403));
        }
    }
}
