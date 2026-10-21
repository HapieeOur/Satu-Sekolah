<?php

namespace App\Http\Controllers\Api\Admin;

use App\Contracts\Services\UserServiceInterface;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;
use Spatie\Permission\Models\Role;

class AdminUserController extends AdminBaseController
{
    public function __construct(
        protected UserServiceInterface $userService
    ) {}

    /**
     * Display a listing of users.
     */
    public function index(Request $request): JsonResponse
    {
        $this->authorizeAdmin();

        $query = User::with('roles')->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%")
                    ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $role = $request->input('role');
            $query->whereHas('roles', function ($q) use ($role) {
                $q->where('name', $role);
            });
        }

        if ($request->filled('status')) {
            $status = $request->input('status') === 'active' || $request->input('status') === '1';
            $query->where('is_active', $status);
        }

        $perPage = (int) $request->input('per_page', 50);
        $users = $query->paginate($perPage);

        $formatted = $users->getCollection()->map(function ($u) {
            return [
                'id' => $u->id,
                'name' => $u->name,
                'email' => $u->email,
                'phone' => $u->phone,
                'nis' => $u->nis,
                'nisn' => $u->nisn,
                'is_active' => (bool) $u->is_active,
                'roles' => $u->roles->pluck('name'),
                'created_at' => $u->created_at?->format('Y-m-d H:i:s'),
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Daftar pengguna berhasil diambil.',
            'data' => $formatted,
            'meta' => [
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
                'per_page' => $users->perPage(),
                'total' => $users->total(),
            ],
        ]);
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request): JsonResponse
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:25'],
            'nis' => ['nullable', 'string', 'max:30', 'unique:users,nis'],
            'nisn' => ['nullable', 'string', 'max:30', 'unique:users,nisn'],
            'password' => ['required', 'string', 'min:6'],
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $roles = $validated['roles'];
        unset($validated['roles']);

        $user = $this->userService->createUser($validated, $roles);
        $user->load('roles');

        return $this->respondWithSuccess([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'nis' => $user->nis,
            'nisn' => $user->nisn,
            'is_active' => (bool) $user->is_active,
            'roles' => $user->roles->pluck('name'),
            'created_at' => $user->created_at?->format('Y-m-d H:i:s'),
        ], 'Pengguna berhasil ditambahkan.', 201);
    }

    /**
     * Update user.
     */
    public function update(Request $request, User $user): JsonResponse
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'phone' => ['nullable', 'string', 'max:25'],
            'nis' => ['nullable', 'string', 'max:30', 'unique:users,nis,'.$user->id],
            'nisn' => ['nullable', 'string', 'max:30', 'unique:users,nisn,'.$user->id],
            'password' => ['nullable', 'string', 'min:6'],
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $roles = $validated['roles'];
        unset($validated['roles']);

        // Prevent self disabling
        $currentUserId = Auth::id() ?? $this->currentUser()?->id;
        if ($user->id === $currentUserId && isset($validated['is_active']) && ! $validated['is_active']) {
            return $this->respondWithError('Anda tidak dapat menonaktifkan akun Anda sendiri.', 422);
        }

        $user = $this->userService->updateUser($user, $validated, $roles);
        $user->load('roles');

        return $this->respondWithSuccess([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'nis' => $user->nis,
            'nisn' => $user->nisn,
            'is_active' => (bool) $user->is_active,
            'roles' => $user->roles->pluck('name'),
        ], 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Remove user.
     */
    public function destroy(User $user): JsonResponse
    {
        $this->authorizeAdmin();

        $currentUserId = Auth::id() ?? $this->currentUser()?->id;
        if ($user->id === $currentUserId) {
            return $this->respondWithError('Anda tidak dapat menghapus akun Anda sendiri.', 422);
        }

        try {
            $name = $user->name;
            $this->userService->deleteUser($user, (int) $currentUserId);

            return $this->respondWithSuccess(null, "Pengguna {$name} berhasil dihapus.");
        } catch (InvalidArgumentException $e) {
            return $this->respondWithError($e->getMessage(), 422);
        }
    }

    /**
     * List all available roles in the system.
     */
    public function roles(): JsonResponse
    {
        $this->authorizeAdmin();

        $roles = Role::pluck('name');

        return $this->respondWithSuccess($roles, 'Daftar peran berhasil diambil.');
    }
}
