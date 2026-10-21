<?php

namespace App\Http\Controllers\Api\Admin;

use App\Contracts\Services\SubjectServiceInterface;
use App\Contracts\Services\TeacherServiceInterface;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminTeacherController extends AdminBaseController
{
    public function __construct(
        protected TeacherServiceInterface $teacherService,
        protected SubjectServiceInterface $subjectService
    ) {}

    /**
     * Display a listing of teachers.
     */
    public function index(Request $request): JsonResponse
    {
        $this->authorizeAdmin();

        $query = Teacher::with(['user.roles', 'subjects'])->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nip', 'like', "%{$search}%")
                    ->orWhere('nuptk', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $perPage = (int) $request->input('per_page', 50);
        $teachers = $query->paginate($perPage);

        $formatted = $teachers->getCollection()->map(function ($t) {
            $roles = $t->user?->roles->pluck('name') ?? collect();

            return [
                'id' => $t->id,
                'user_id' => $t->user_id,
                'name' => $t->user?->name ?? 'Tanpa Nama',
                'email' => $t->user?->email ?? '-',
                'nip' => $t->nip ?? '-',
                'nuptk' => $t->nuptk ?? '-',
                'gender' => $t->gender ?? 'L',
                'phone' => $t->phone ?? $t->user?->phone ?? '-',
                'address' => $t->address ?? '-',
                'roles' => $roles,
                'is_walas' => $roles->contains('wali_kelas'),
                'is_mentor' => $roles->contains('guru_pembimbing_pkl'),
                'subjects' => $t->subjects->map(fn ($s) => [
                    'id' => $s->id,
                    'code' => $s->code,
                    'name' => $s->name,
                ]),
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Daftar guru berhasil diambil.',
            'data' => $formatted,
            'meta' => [
                'current_page' => $teachers->currentPage(),
                'last_page' => $teachers->lastPage(),
                'per_page' => $teachers->perPage(),
                'total' => $teachers->total(),
            ],
        ]);
    }

    /**
     * Store a newly created teacher.
     */
    public function store(Request $request): JsonResponse
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'user_id' => ['nullable', 'exists:users,id'],
            'name' => ['required_without:user_id', 'nullable', 'string', 'max:255'],
            'email' => ['required_without:user_id', 'nullable', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['nullable', 'string', 'min:6'],
            'nip' => ['nullable', 'string', 'max:30', 'unique:teachers,nip'],
            'nuptk' => ['nullable', 'string', 'max:30'],
            'gender' => ['nullable', 'in:L,P'],
            'phone' => ['nullable', 'string', 'max:25'],
            'address' => ['nullable', 'string'],
            'subject_ids' => ['nullable', 'array'],
            'subject_ids.*' => ['exists:subjects,id'],
            'is_walas' => ['nullable', 'boolean'],
            'is_mentor' => ['nullable', 'boolean'],
        ]);

        return DB::transaction(function () use ($validated) {
            $userId = $validated['user_id'] ?? null;

            if (! $userId) {
                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'phone' => $validated['phone'] ?? null,
                    'password' => Hash::make($validated['password'] ?? 'guru12345'),
                    'is_active' => true,
                ]);

                $roles = ['guru'];
                if (! empty($validated['is_walas'])) {
                    $roles[] = 'wali_kelas';
                }
                if (! empty($validated['is_mentor'])) {
                    $roles[] = 'guru_pembimbing_pkl';
                }
                $user->syncRoles($roles);

                $userId = $user->id;
            } else {
                $user = User::find($userId);
                if ($user) {
                    if (! empty($validated['is_walas']) && ! $user->hasRole('wali_kelas')) {
                        $user->assignRole('wali_kelas');
                    }
                    if (! empty($validated['is_mentor']) && ! $user->hasRole('guru_pembimbing_pkl')) {
                        $user->assignRole('guru_pembimbing_pkl');
                    }
                }
            }

            $teacher = Teacher::create([
                'user_id' => $userId,
                'nip' => $validated['nip'] ?? null,
                'nuptk' => $validated['nuptk'] ?? null,
                'gender' => $validated['gender'] ?? 'L',
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
            ]);

            if (! empty($validated['subject_ids'])) {
                $teacher->subjects()->sync($validated['subject_ids']);
            }

            $teacher->load(['user.roles', 'subjects']);

            return $this->respondWithSuccess([
                'id' => $teacher->id,
                'name' => $teacher->user?->name,
                'nip' => $teacher->nip,
                'phone' => $teacher->phone,
            ], 'Data guru berhasil ditambahkan.', 201);
        });
    }

    /**
     * Delete teacher.
     */
    public function destroy(Teacher $teacher): JsonResponse
    {
        $this->authorizeAdmin();

        $name = $teacher->user?->name ?? 'Guru';
        $teacher->subjects()->detach();
        $teacher->delete();

        return $this->respondWithSuccess(null, "Data guru {$name} berhasil dihapus.");
    }

    /**
     * Get list of users available for teacher assignment.
     */
    public function availableUsers(): JsonResponse
    {
        $this->authorizeAdmin();

        $users = User::role('guru')
            ->whereDoesntHave('teacher')
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        return $this->respondWithSuccess($users, 'Daftar user guru tersedia berhasil diambil.');
    }
}
