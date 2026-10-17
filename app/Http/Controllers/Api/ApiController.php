<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

abstract class ApiController extends Controller
{
    /**
     * Return a standardized success JSON response.
     */
    protected function respondWithSuccess(mixed $data = null, string $message = 'Success', int $statusCode = 200): JsonResponse
    {
        $payload = [
            'success' => true,
            'message' => $message,
        ];

        if ($data !== null) {
            $payload['data'] = $data;
        }

        return response()->json($payload, $statusCode);
    }

    /**
     * Return a standardized error JSON response.
     */
    protected function respondWithError(string $message = 'Error', int $statusCode = 400, mixed $errors = null): JsonResponse
    {
        $payload = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors !== null) {
            $payload['errors'] = $errors;
        }

        return response()->json($payload, $statusCode);
    }

    /**
     * Return a standardized paginated JSON response.
     */
    protected function respondWithPagination(LengthAwarePaginator $paginator, ?string $resourceClass = null, string $message = 'Success'): JsonResponse
    {
        $items = $resourceClass ? $resourceClass::collection($paginator->items()) : $paginator->items();

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $items,
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'has_more_pages' => $paginator->hasMorePages(),
            ],
        ], 200);
    }

    /**
     * Get the authenticated user.
     */
    protected function currentUser(): ?User
    {
        return Auth::guard('sanctum')->user() ?? Auth::user();
    }

    /**
     * Get the authenticated student profile.
     */
    protected function currentStudent(): ?Student
    {
        $user = $this->currentUser();
        return $user?->student;
    }

    /**
     * Get the authenticated teacher profile.
     */
    protected function currentTeacher(): ?Teacher
    {
        $user = $this->currentUser();
        return $user?->teacher;
    }
}
