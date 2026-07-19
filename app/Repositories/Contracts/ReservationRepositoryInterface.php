<?php

namespace App\Repositories\Contracts;

use App\Models\Reservation;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ReservationRepositoryInterface
{
    public function create(array $attributes): Reservation;

    public function update(Reservation $reservation, array $attributes): Reservation;

    public function findByRef(string $ref): ?Reservation;

    public function findByRefAndEmail(string $ref, string $email): ?Reservation;

    public function findCancellableByToken(string $token): ?Reservation;

    /** @param array{status?: string, date?: string, search?: string} $filters */
    public function paginateFiltered(array $filters, int $perPage = 20): LengthAwarePaginator;

    public function roomHasOverlap(int $roomId, string $checkIn, string $checkOut): bool;

    public function countCreatedInYear(int $year): int;

    public function arrivalsOn(string $date): Collection;

    public function departuresOn(string $date): Collection;

    public function occupiedCountOn(string $date): int;

    public function revenueForMonth(int $month, int $year): int;

    public function upcomingConfirmedCount(string $fromDate): int;

    public function latest(int $limit): Collection;
}
