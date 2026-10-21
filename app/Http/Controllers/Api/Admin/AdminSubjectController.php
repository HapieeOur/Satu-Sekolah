<?php

namespace App\Http\Controllers\Api\Admin;

use App\Contracts\Services\SubjectServiceInterface;
use App\Models\Subject;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminSubjectController extends AdminBaseController
{
    public function __construct(
        protected SubjectServiceInterface $subjectService
    ) {}

    /**
     * Display a listing of subjects.
     */
    public function index(): JsonResponse
    {
        $this->authorizeAdmin();

        $subjects = Subject::with('teachers.user')->latest()->get()->map(function ($s) {
            return [
                'id' => $s->id,
                'code' => $s->code,
                'name' => $s->name,
                'description' => $s->description ?? '-',
                'teachers' => $s->teachers->map(fn ($t) => [
                    'id' => $t->id,
                    'name' => $t->user?->name ?? 'Guru',
                ]),
            ];
        });

        return $this->respondWithSuccess($subjects, 'Daftar mata pelajaran berhasil diambil.');
    }

    /**
     * Store a newly created subject.
     */
    public function store(Request $request): JsonResponse
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'code' => ['required', 'string', 'max:20', 'unique:subjects,code'],
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'teacher_ids' => ['nullable', 'array'],
            'teacher_ids.*' => ['exists:teachers,id'],
        ]);

        return DB::transaction(function () use ($validated) {
            $subject = Subject::create([
                'code' => $validated['code'],
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
            ]);

            if (! empty($validated['teacher_ids'])) {
                $subject->teachers()->sync($validated['teacher_ids']);
            }

            return $this->respondWithSuccess([
                'id' => $subject->id,
                'code' => $subject->code,
                'name' => $subject->name,
                'description' => $subject->description,
            ], 'Mata pelajaran berhasil ditambahkan.', 201);
        });
    }

    /**
     * Update subject.
     */
    public function update(Request $request, Subject $subject): JsonResponse
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'code' => ['required', 'string', 'max:20', 'unique:subjects,code,' . $subject->id],
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'teacher_ids' => ['nullable', 'array'],
            'teacher_ids.*' => ['exists:teachers,id'],
        ]);

        return DB::transaction(function () use ($validated, $subject) {
            $subject->update([
                'code' => $validated['code'],
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
            ]);

            if (isset($validated['teacher_ids'])) {
                $subject->teachers()->sync($validated['teacher_ids']);
            }

            return $this->respondWithSuccess([
                'id' => $subject->id,
                'code' => $subject->code,
                'name' => $subject->name,
                'description' => $subject->description,
            ], 'Mata pelajaran berhasil diperbarui.');
        });
    }

    /**
     * Delete subject.
     */
    public function destroy(Subject $subject): JsonResponse
    {
        $this->authorizeAdmin();

        $name = $subject->name;
        $subject->teachers()->detach();
        $subject->delete();

        return $this->respondWithSuccess(null, "Mata pelajaran {$name} berhasil dihapus.");
    }
}
