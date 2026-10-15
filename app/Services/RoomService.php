<?php

namespace App\Services;

use App\Contracts\Services\RoomServiceInterface;
use App\Models\Room;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class RoomService implements RoomServiceInterface
{
    public function getPaginated(int $perPage = 15, ?string $search = null): LengthAwarePaginator
    {
        $query = Room::latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        return $query->paginate($perPage);
    }

    public function getAll(): Collection
    {
        return Room::orderBy('name')->get();
    }

    public function create(array $data): Room
    {
        return Room::create([
            'code' => $data['code'],
            'name' => $data['name'],
            'capacity' => $data['capacity'] ?? 36,
            'description' => $data['description'] ?? null,
        ]);
    }

    public function update(Room $room, array $data): Room
    {
        $room->update([
            'code' => $data['code'],
            'name' => $data['name'],
            'capacity' => $data['capacity'] ?? 36,
            'description' => $data['description'] ?? null,
        ]);

        return $room;
    }

    public function delete(Room $room): bool
    {
        return (bool) $room->delete();
    }
}
