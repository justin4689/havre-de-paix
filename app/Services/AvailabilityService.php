<?php

namespace App\Services;

use App\Models\Room;
use App\Repositories\Contracts\ReservationRepositoryInterface;
use App\Repositories\Contracts\RoomRepositoryInterface;
use Illuminate\Support\Collection;

class AvailabilityService
{
    public function __construct(
        private readonly ReservationRepositoryInterface $reservations,
        private readonly RoomRepositoryInterface $rooms,
    ) {}

    public function isRoomAvailable(Room $room, string $checkIn, string $checkOut): bool
    {
        return ! $this->reservations->roomHasOverlap($room->id, $checkIn, $checkOut)
            && ! $this->rooms->roomHasBlockedOverlap($room->id, $checkIn, $checkOut);
    }

    public function availableActiveRooms(string $checkIn, string $checkOut, int $guests = 1): Collection
    {
        return $this->rooms->allActive()
            ->when($guests > 0, fn ($rooms) => $rooms->where('capacity_adults', '>=', $guests))
            ->filter(fn (Room $room) => $this->isRoomAvailable($room, $checkIn, $checkOut))
            ->values();
    }
}
