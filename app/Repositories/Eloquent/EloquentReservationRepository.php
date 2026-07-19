<?php

namespace App\Repositories\Eloquent;

use App\Models\Reservation;
use App\Repositories\Contracts\ReservationRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class EloquentReservationRepository implements ReservationRepositoryInterface
{
    public function create(array $attributes): Reservation
    {
        return Reservation::create($attributes);
    }

    public function update(Reservation $reservation, array $attributes): Reservation
    {
        $reservation->update($attributes);

        return $reservation;
    }

    public function findByRef(string $ref): ?Reservation
    {
        return Reservation::where('ref', $ref)->with('room')->first();
    }

    public function findByRefAndEmail(string $ref, string $email): ?Reservation
    {
        return Reservation::whereRaw('UPPER(ref) = ?', [mb_strtoupper(trim($ref))])
            ->whereRaw('LOWER(guest_email) = ?', [mb_strtolower(trim($email))])
            ->with('room')
            ->first();
    }

    public function findCancellableByToken(string $token): ?Reservation
    {
        return Reservation::where('cancel_token', $token)
            ->where('status', 'confirmed')
            ->first();
    }

    public function paginateFiltered(array $filters, int $perPage = 20): LengthAwarePaginator
    {
        return Reservation::with('room')
            ->latest()
            ->when($filters['status'] ?? null, fn ($q, $status) => $q->where('status', $status))
            ->when($filters['date'] ?? null, fn ($q, $date) => $q->where('check_in', $date))
            ->when($filters['search'] ?? null, fn ($q, $search) => $q->where(
                fn ($sub) => $sub->where('guest_name', 'like', "%{$search}%")
                    ->orWhere('ref', 'like', "%{$search}%")
                    ->orWhere('guest_email', 'like', "%{$search}%")
            ))
            ->paginate($perPage)
            ->withQueryString();
    }

    public function roomHasOverlap(int $roomId, string $checkIn, string $checkOut): bool
    {
        return Reservation::where('room_id', $roomId)
            ->where('status', 'confirmed')
            ->where('check_in', '<', $checkOut)
            ->where('check_out', '>', $checkIn)
            ->exists();
    }

    public function countCreatedInYear(int $year): int
    {
        return Reservation::whereYear('created_at', $year)->count();
    }

    public function arrivalsOn(string $date): Collection
    {
        return Reservation::with('room')
            ->where('check_in', $date)
            ->where('status', 'confirmed')
            ->get();
    }

    public function departuresOn(string $date): Collection
    {
        return Reservation::with('room')
            ->where('check_out', $date)
            ->where('status', 'confirmed')
            ->get();
    }

    public function occupiedCountOn(string $date): int
    {
        return Reservation::where('check_in', '<=', $date)
            ->where('check_out', '>', $date)
            ->where('status', 'confirmed')
            ->count();
    }

    public function revenueForMonth(int $month, int $year): int
    {
        return (int) Reservation::where('status', 'confirmed')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->sum('total_price');
    }

    public function upcomingConfirmedCount(string $fromDate): int
    {
        return Reservation::where('status', 'confirmed')
            ->where('check_in', '>', $fromDate)
            ->count();
    }

    public function latest(int $limit): Collection
    {
        return Reservation::with('room')->latest()->take($limit)->get();
    }
}
