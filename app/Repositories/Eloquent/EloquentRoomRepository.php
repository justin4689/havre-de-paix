<?php

namespace App\Repositories\Eloquent;

use App\Models\Room;
use App\Repositories\Contracts\RoomRepositoryInterface;
use Illuminate\Support\Collection;

class EloquentRoomRepository implements RoomRepositoryInterface
{
    public function allActive(): Collection
    {
        return Room::where('status', 'active')->get();
    }

    public function featured(int $limit = 3): Collection
    {
        return Room::where('status', 'active')
            ->orderBy('price_per_night')
            ->take($limit)
            ->get();
    }

    public function activeFiltered(array $filters, string $sort = 'price_asc'): Collection
    {
        return Room::where('status', 'active')
            ->when($filters['capacity'] ?? null, fn ($q, $capacity) => $q->where('capacity_adults', '>=', $capacity))
            ->when($filters['view'] ?? null, fn ($q, $view) => $q->whereIn('view', (array) $view))
            ->when($filters['price_max'] ?? null, fn ($q, $priceMax) => $q->where('price_per_night', '<=', $priceMax))
            ->tap(fn ($q) => match ($sort) {
                'price_desc' => $q->orderByDesc('price_per_night'),
                'capacity'   => $q->orderByDesc('capacity_adults'),
                default      => $q->orderBy('price_per_night'),
            })
            ->get();
    }

    public function allOrderedByPrice(): Collection
    {
        return Room::orderBy('price_per_night')->get();
    }

    public function activeOrderedByName(): Collection
    {
        return Room::where('status', 'active')->orderBy('name')->get();
    }

    public function findOrFail(int $id): Room
    {
        return Room::findOrFail($id);
    }

    public function findBySlugOrFail(string $slug): Room
    {
        return Room::findBySlug($slug);
    }

    public function similarTo(Room $room, int $limit = 2): Collection
    {
        return Room::where('status', 'active')
            ->where('id', '!=', $room->id)
            ->where('view', $room->view)
            ->take($limit)
            ->get();
    }

    public function activeCount(): int
    {
        return Room::where('status', 'active')->count();
    }

    public function create(array $attributes): Room
    {
        return Room::create($attributes);
    }

    public function update(Room $room, array $attributes): Room
    {
        $room->update($attributes);

        return $room;
    }

    public function roomHasBlockedOverlap(int $roomId, string $checkIn, string $checkOut): bool
    {
        return Room::findOrFail($roomId)
            ->blockedDates()
            ->where('start_date', '<', $checkOut)
            ->where('end_date', '>', $checkIn)
            ->exists();
    }
}
