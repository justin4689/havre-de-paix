<?php

namespace App\Services;

use App\Models\Reservation;
use App\Models\Room;
use App\Repositories\Contracts\ReservationRepositoryInterface;
use App\Repositories\Contracts\RoomRepositoryInterface;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ReservationService
{
    public function __construct(
        private readonly ReservationRepositoryInterface $reservations,
        private readonly RoomRepositoryInterface $rooms,
        private readonly AvailabilityService $availability,
        private readonly PricingService $pricing,
    ) {}

    /**
     * Contexte du checkout : voyageurs plafonnés à la capacité,
     * nombre de nuits et prix total (règles saisonnières incluses).
     */
    public function checkoutContext(Room $room, string $checkIn, string $checkOut, int $guests): array
    {
        return [
            'guests'     => min(max(1, $guests), $room->capacity_adults),
            'nights'     => $this->pricing->nightsBetween($checkIn, $checkOut),
            'totalPrice' => $this->pricing->priceForStay($room, $checkIn, $checkOut),
        ];
    }

    /**
     * Réservation publique : vérifie la disponibilité, crée la réservation
     * confirmée et envoie les emails client + hôtel.
     */
    public function book(array $data): Reservation
    {
        $room = $this->rooms->findOrFail((int) $data['room_id']);

        if (! $this->availability->isRoomAvailable($room, $data['check_in'], $data['check_out'])) {
            throw ValidationException::withMessages([
                'check_in' => 'Cette chambre n\'est plus disponible pour ces dates.',
            ]);
        }

        $reservation = $this->reservations->create([
            'ref'              => $this->nextRef(),
            'room_id'          => $room->id,
            'guest_name'       => $data['guest_name'],
            'guest_email'      => $data['guest_email'],
            'guest_phone'      => $data['guest_phone'],
            'check_in'         => $data['check_in'],
            'check_out'        => $data['check_out'],
            'nights'           => $this->pricing->nightsBetween($data['check_in'], $data['check_out']),
            'guests'           => $data['guests'],
            'total_price'      => $this->pricing->priceForStay($room, $data['check_in'], $data['check_out']),
            'special_requests' => $data['special_requests'] ?? null,
            'cancel_token'     => Str::random(40),
            'status'           => 'confirmed',
        ]);

        $this->sendSafely(fn () => Mail::to($reservation->guest_email)->send(new \App\Mail\ReservationConfirmation($reservation)));
        $this->sendSafely(fn () => Mail::to(config('mail.hotel_email', 'hotel@havredepaix-assinie.com'))->send(new \App\Mail\ReservationAlert($reservation)));

        return $reservation;
    }

    /**
     * Réservation manuelle (réception) : pas de contrôle de disponibilité
     * ni d'emails — la réception maîtrise son planning.
     */
    public function bookManual(array $data): Reservation
    {
        $room = $this->rooms->findOrFail((int) $data['room_id']);

        return $this->reservations->create([
            ...$data,
            'ref'          => $this->nextRef(),
            'nights'       => $this->pricing->nightsBetween($data['check_in'], $data['check_out']),
            'total_price'  => $this->pricing->priceForStay($room, $data['check_in'], $data['check_out']),
            'cancel_token' => Str::random(40),
            'status'       => 'confirmed',
        ]);
    }

    public function cancel(Reservation $reservation): Reservation
    {
        $reservation = $this->reservations->update($reservation, [
            'status'       => 'cancelled',
            'cancelled_at' => now(),
        ]);

        $this->sendSafely(fn () => Mail::to($reservation->guest_email)->send(new \App\Mail\ReservationCancelled($reservation)));
        $this->sendSafely(fn () => Mail::to(config('mail.hotel_email', 'hotel@havredepaix-assinie.com'))->send(new \App\Mail\ReservationCancelledAlert($reservation)));

        return $reservation;
    }

    public function findCancellableByToken(string $token): ?Reservation
    {
        return $this->reservations->findCancellableByToken($token);
    }

    public function findByRef(string $ref): ?Reservation
    {
        return $this->reservations->findByRef($ref);
    }

    public function lookup(string $ref, string $email): ?Reservation
    {
        return $this->reservations->findByRefAndEmail($ref, $email);
    }

    public function update(Reservation $reservation, array $attributes): Reservation
    {
        return $this->reservations->update($reservation, $attributes);
    }

    /** Liste back-office filtrée (statut, date d'arrivée, recherche libre). */
    public function paginateFiltered(array $filters, int $perPage = 20)
    {
        return $this->reservations->paginateFiltered($filters, $perPage);
    }

    private function nextRef(): string
    {
        $year = (int) date('Y');

        return 'HDP-' . $year . '-' . str_pad((string) ($this->reservations->countCreatedInYear($year) + 1), 4, '0', STR_PAD_LEFT);
    }

    /** La réservation ne doit jamais échouer à cause d'un email. */
    private function sendSafely(callable $send): void
    {
        try {
            $send();
        } catch (\Exception $e) {
            logger()->error('Mail error: ' . $e->getMessage());
        }
    }
}
