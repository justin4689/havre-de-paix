<?php

namespace App\Services;

use App\Repositories\Contracts\ReservationRepositoryInterface;
use App\Repositories\Contracts\RoomRepositoryInterface;

class DashboardService
{
    public function __construct(
        private readonly ReservationRepositoryInterface $reservations,
        private readonly RoomRepositoryInterface $rooms,
    ) {}

    /** Indicateurs du tableau de bord réception. */
    public function stats(): array
    {
        $today      = now()->toDateString();
        $occupied   = $this->reservations->occupiedCountOn($today);
        $totalRooms = $this->rooms->activeCount();

        return [
            'arrivals'     => $this->reservations->arrivalsOn($today),
            'departures'   => $this->reservations->departuresOn($today),
            'occupied'     => $occupied,
            'totalRooms'   => $totalRooms,
            'occupancy'    => $totalRooms > 0 ? round($occupied / $totalRooms * 100) : 0,
            'monthRevenue' => $this->reservations->revenueForMonth(now()->month, now()->year),
            'pending'      => $this->reservations->upcomingConfirmedCount($today),
            'recent'       => $this->reservations->latest(5),
        ];
    }
}
