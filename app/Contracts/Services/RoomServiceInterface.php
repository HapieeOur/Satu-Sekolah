<?php

namespace App\Contracts\Services;

use App\Models\Room;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface RoomServiceInterface
{
    public function getPaginated(int $perPage = 15, ?string $search = null): LengthAwarePaginator;

    public function getAll(): Collection;

    public function create(array $data): Room;

    public function update(Room $room, array $data): Room;

    public function delete(Room $room): bool;
}
