<?php

namespace App\Repositories\Contracts;

use App\Models\Room;
use Illuminate\Support\Collection;

interface RoomRepositoryInterface
{
    public function allActive(): Collection;

    public function featured(int $limit = 3): Collection;

    /** @param array{capacity?: int|string, view?: array|string, price_max?: int|string} $filters */
    public function activeFiltered(array $filters, string $sort = 'price_asc'): Collection;

    public function allOrderedByPrice(): Collection;

    public function activeOrderedByName(): Collection;

    public function findOrFail(int $id): Room;

    public function findBySlugOrFail(string $slug): Room;

    public function similarTo(Room $room, int $limit = 2): Collection;

    public function activeCount(): int;

    public function create(array $attributes): Room;

    public function update(Room $room, array $attributes): Room;

    public function roomHasBlockedOverlap(int $roomId, string $checkIn, string $checkOut): bool;
}
