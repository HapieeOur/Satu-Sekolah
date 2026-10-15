<?php

namespace App\Contracts\Repositories;

use App\Models\Room;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface RoomRepositoryInterface
{
    public function getPaginated(int $perPage = 15, ?string $search = null): LengthAwarePaginator;

    public function getAll(): Collection;

    public function findById(int $id): ?Room;

    public function findByCode(string $code): ?Room;

    public function create(array $data): Room;

    public function update(Room $room, array $data): Room;

    public function delete(Room $room): bool;
}
