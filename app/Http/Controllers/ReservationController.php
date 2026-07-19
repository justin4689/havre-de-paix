<?php

namespace App\Http\Controllers;

use App\Http\Requests\LookupReservationRequest;
use App\Http\Requests\StoreReservationRequest;
use App\Services\ReservationService;
use App\Services\RoomCatalogService;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function __construct(
        private readonly ReservationService $reservationService,
        private readonly RoomCatalogService $roomCatalog,
    ) {}

    public function index(Request $request)
    {
        // Le checkout exige un séjour déjà choisi (chambre + dates),
        // comme chez Airbnb/Booking.
        if (! $request->filled('room_id')) {
            return redirect()->route('rooms.index')
                ->with('info', 'Choisissez d\'abord votre chambre pour réserver.');
        }

        $room     = $this->roomCatalog->findById((int) $request->room_id);
        $checkIn  = $request->get('check_in');
        $checkOut = $request->get('check_out');

        if (! $checkIn || ! $checkOut || $checkOut <= $checkIn) {
            return redirect()->route('rooms.show', $room->slug)
                ->with('info', 'Sélectionnez vos dates de séjour pour continuer.');
        }

        $context = $this->reservationService->checkoutContext(
            $room, $checkIn, $checkOut, (int) $request->get('guests', 1)
        );

        return view('reservation.index', [
            'room'       => $room,
            'checkIn'    => $checkIn,
            'checkOut'   => $checkOut,
            'guests'     => $context['guests'],
            'nights'     => $context['nights'],
            'totalPrice' => $context['totalPrice'],
        ]);
    }

    public function store(StoreReservationRequest $request)
    {
        $reservation = $this->reservationService->book($request->validated());

        return redirect()->route('reservation.confirmation', $reservation->ref);
    }

    public function confirmation(string $ref)
    {
        $reservation = $this->reservationService->findByRef($ref);
        abort_if(! $reservation, 404);

        return view('reservation.confirmation', compact('reservation'));
    }

    public function cancel(string $token)
    {
        $reservation = $this->reservationService->findCancellableByToken($token);
        abort_if(! $reservation, 404);

        if (! $reservation->isCancellable()) {
            return view('reservation.cancel-denied', compact('reservation'));
        }

        $this->reservationService->cancel($reservation);

        return view('reservation.cancelled', compact('reservation'));
    }

    public function lookupForm()
    {
        return view('reservation.lookup');
    }

    public function lookup(LookupReservationRequest $request)
    {
        $reservation = $this->reservationService->lookup(
            $request->validated('ref'),
            $request->validated('email'),
        );

        if (! $reservation) {
            return back()
                ->withErrors(['ref' => 'Aucune réservation trouvée avec cette référence et cet email. Vérifiez l\'email de confirmation reçu.'])
                ->withInput();
        }

        return view('reservation.manage', compact('reservation'));
    }
}
