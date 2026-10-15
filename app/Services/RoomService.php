<?php

namespace App\Services;

use App\Contracts\Repositories\RoomRepositoryInterface;
use App\Contracts\Services\RoomServiceInterface;
use App\Models\Room;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class RoomService implements RoomServiceInterface
{
    public function __construct(
        protected RoomRepositoryInterface $roomRepository
    ) {}

    public function getPaginated(int $perPage = 15, ?string $search = null): LengthAwarePaginator
    {
        return $this->roomRepository->getPaginated($perPage, $search);
    }

    public function getAll(): Collection
    {
        return $this->roomRepository->getAll();
    }

    public function create(array $data): Room
    {
        return $this->roomRepository->create([
            'code' => $data['code'],
            'name' => $data['name'],
            'capacity' => $data['capacity'] ?? 36,
            'description' => $data['description'] ?? null,
        ]);
    }

    public function update(Room $room, array $data): Room
    {
        return $this->roomRepository->update($room, [
            'code' => $data['code'],
            'name' => $data['name'],
            'capacity' => $data['capacity'] ?? 36,
            'description' => $data['description'] ?? null,
        ]);
    }

    public function delete(Room $room): bool
    {
        return $this->roomRepository->delete($room);
    }
}
