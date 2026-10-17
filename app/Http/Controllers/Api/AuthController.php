<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserResource;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends ApiController
{
    /**
     * Authenticate user from mobile app (supports Email, NIS, NIP, or Phone).
     */
    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
            'device_name' => ['nullable', 'string', 'max:100'],
        ]);

        $loginInput = trim($validated['login']);

        // 1. Try finding by email
        $user = User::where('email', $loginInput)->first();

        // 2. Try finding by Student NIS / NISN
        if (! $user) {
            $student = Student::where('nis', $loginInput)
                ->orWhere('nisn', $loginInput)
                ->first();

            if ($student && $student->user) {
                $user = $student->user;
            }
        }

        // 3. Try finding by Teacher NIP
        if (! $user) {
            $teacher = Teacher::where('nip', $loginInput)->first();
            if ($teacher && $teacher->user) {
                $user = $teacher->user;
            }
        }

        // 4. Try finding by Phone
        if (! $user) {
            $user = User::where('phone', $loginInput)->first();
        }

        // Check user existence and password
        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            return $this->respondWithError('Email, NIS, atau kata sandi yang Anda masukkan salah.', 422, [
                'login' => ['Kredensial tidak cocok dengan data kami.'],
            ]);
        }

        // Check account activation
        if (! $user->is_active) {
            return $this->respondWithError('Akun Anda dinonaktifkan. Silakan hubungi administrator sekolah.', 403);
        }

        $deviceName = $validated['device_name'] ?? 'Mobile Device';
        $token = $user->createToken($deviceName)->plainTextToken;

        $user->load(['roles', 'student.classroom', 'teacher']);

        return $this->respondWithSuccess([
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => new UserResource($user),
        ], 'Login berhasil.');
    }

    /**
     * Get authenticated user profile.
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user();
        $user->load(['roles', 'student.classroom', 'teacher']);

        return $this->respondWithSuccess(new UserResource($user), 'Profil pengguna berhasil diambil.');
    }

    /**
     * Revoke current access token.
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->respondWithSuccess(null, 'Berhasil keluar (logout).');
    }
}
