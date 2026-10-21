<?php

namespace App\Http\Controllers\Api\Admin;

use App\Contracts\Services\RoomServiceInterface;
use App\Models\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminRoomController extends AdminBaseController
{
    public function __construct(
        protected RoomServiceInterface $roomService
    ) {}

    /**
     * Display a listing of rooms.
     */
    public function index(): JsonResponse
    {
        $this->authorizeAdmin();

        $rooms = Room::latest()->get()->map(function ($r) {
            return [
                'id' => $r->id,
                'code' => $r->code,
                'name' => $r->name,
                'capacity' => $r->capacity,
                'description' => $r->description ?? '-',
            ];
        });

        return $this->respondWithSuccess($rooms, 'Daftar ruangan berhasil diambil.');
    }

    /**
     * Store a newly created room.
     */
    public function store(Request $request): JsonResponse
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'code' => ['required', 'string', 'max:20', 'unique:rooms,code'],
            'name' => ['required', 'string', 'max:100'],
            'capacity' => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'string'],
        ]);

        $room = Room::create($validated);

        return $this->respondWithSuccess([
            'id' => $room->id,
            'code' => $room->code,
            'name' => $room->name,
            'capacity' => $room->capacity,
            'description' => $room->description,
        ], 'Ruangan berhasil ditambahkan.', 201);
    }

    /**
     * Delete room.
     */
    public function destroy(Room $room): JsonResponse
    {
        $this->authorizeAdmin();

        $name = $room->name;
        $room->delete();

        return $this->respondWithSuccess(null, "Ruangan {$name} berhasil dihapus.");
    }
}
