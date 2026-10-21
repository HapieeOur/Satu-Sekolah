<?php

namespace App\Http\Controllers\Api\Admin;

use App\Contracts\Services\ClassroomServiceInterface;
use App\Contracts\Services\StudentServiceInterface;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminStudentController extends AdminBaseController
{
    public function __construct(
        protected StudentServiceInterface $studentService,
        protected ClassroomServiceInterface $classroomService
    ) {}

    /**
     * Display a listing of students.
     */
    public function index(Request $request): JsonResponse
    {
        $this->authorizeAdmin();

        $query = Student::with(['classroom', 'user'])->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%")
                    ->orWhere('nisn', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('classroom_id')) {
            $query->where('classroom_id', $request->input('classroom_id'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $perPage = (int) $request->input('per_page', 50);
        $students = $query->paginate($perPage);

        $formatted = $students->getCollection()->map(function ($s) {
            return [
                'id' => $s->id,
                'user_id' => $s->user_id,
                'name' => $s->name,
                'nis' => $s->nis,
                'nisn' => $s->nisn,
                'gender' => $s->gender,
                'classroom_id' => $s->classroom_id,
                'classroom_name' => $s->classroom?->name ?? 'Belum Ada Kelas',
                'phone' => $s->phone ?? '-',
                'address' => $s->address ?? '-',
                'parent_name' => $s->parent_name ?? '-',
                'parent_phone' => $s->parent_phone ?? '-',
                'status' => $s->status ?? 'aktif',
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Daftar siswa berhasil diambil.',
            'data' => $formatted,
            'meta' => [
                'current_page' => $students->currentPage(),
                'last_page' => $students->lastPage(),
                'per_page' => $students->perPage(),
                'total' => $students->total(),
            ],
        ]);
    }

    /**
     * Store a newly created student.
     */
    public function store(Request $request): JsonResponse
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nis' => ['required', 'string', 'max:30', 'unique:students,nis'],
            'nisn' => ['nullable', 'string', 'max:30', 'unique:students,nisn'],
            'gender' => ['required', 'in:L,P'],
            'classroom_id' => ['nullable', 'exists:classrooms,id'],
            'phone' => ['nullable', 'string', 'max:25'],
            'address' => ['nullable', 'string'],
            'parent_name' => ['nullable', 'string', 'max:255'],
            'parent_phone' => ['nullable', 'string', 'max:25'],
            'status' => ['nullable', 'string', 'in:aktif,nonaktif,lulus,pindah'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        return DB::transaction(function () use ($validated) {
            // Generate email if omitted
            $email = ! empty($validated['email'])
                ? $validated['email']
                : 'siswa.'.strtolower($validated['nis']).'@student.sch.id';

            // Ensure unique email
            $existingUser = User::where('email', $email)->first();
            if ($existingUser) {
                $email = 'siswa.'.strtolower($validated['nis']).'.'.Str::random(4).'@student.sch.id';
            }

            $user = User::create([
                'name' => $validated['name'],
                'email' => $email,
                'phone' => $validated['phone'] ?? null,
                'nis' => $validated['nis'],
                'nisn' => $validated['nisn'] ?? null,
                'password' => Hash::make($validated['password'] ?? 'siswa12345'),
                'is_active' => true,
            ]);
            $user->syncRoles(['siswa']);

            $student = Student::create([
                'user_id' => $user->id,
                'name' => $validated['name'],
                'nis' => $validated['nis'],
                'nisn' => $validated['nisn'] ?? null,
                'gender' => $validated['gender'],
                'classroom_id' => $validated['classroom_id'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'parent_name' => $validated['parent_name'] ?? null,
                'parent_phone' => $validated['parent_phone'] ?? null,
                'status' => $validated['status'] ?? 'aktif',
            ]);

            return $this->respondWithSuccess([
                'id' => $student->id,
                'name' => $student->name,
                'nis' => $student->nis,
                'email' => $user->email,
            ], 'Data siswa berhasil ditambahkan.', 201);
        });
    }

    /**
     * Delete student.
     */
    public function destroy(Student $student): JsonResponse
    {
        $this->authorizeAdmin();

        $name = $student->name;
        $student->delete();

        return $this->respondWithSuccess(null, "Data siswa {$name} berhasil dihapus.");
    }
}
