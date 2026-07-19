<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        // Le checkout exige un séjour déjà choisi (chambre + dates) :
        // pas de sélection de chambre ici, comme chez Airbnb/Booking.
        if (! $request->filled('room_id')) {
            return redirect()->route('rooms.index')
                ->with('info', 'Choisissez d\'abord votre chambre pour réserver.');
        }

        $room     = Room::findOrFail($request->room_id);
        $checkIn  = $request->get('check_in');
        $checkOut = $request->get('check_out');

        if (! $checkIn || ! $checkOut || $checkOut <= $checkIn) {
            return redirect()->route('rooms.show', $room->slug)
                ->with('info', 'Sélectionnez vos dates de séjour pour continuer.');
        }

        $guests     = min(max(1, (int) $request->get('guests', 1)), $room->capacity_adults);
        $nights     = (int) (new \DateTime($checkOut))->diff(new \DateTime($checkIn))->days;
        $totalPrice = $room->priceForStay($checkIn, $checkOut);

        return view('reservation.index', compact('room', 'checkIn', 'checkOut', 'guests', 'nights', 'totalPrice'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id'          => 'required|exists:rooms,id',
            'check_in'         => 'required|date|after_or_equal:today',
            'check_out'        => 'required|date|after:check_in',
            'guests'           => 'required|integer|min:1|max:10',
            'guest_name'       => 'required|string|max:100',
            'guest_email'      => 'required|email|max:150',
            'guest_phone'      => 'required|string|max:30',
            'special_requests' => 'nullable|string|max:500',
            'accept_cgv'       => 'required|accepted',
        ]);

        $room = Room::findOrFail($validated['room_id']);

        // Vérification disponibilité
        if (! $room->isAvailable($validated['check_in'], $validated['check_out'])) {
            return back()->withErrors(['check_in' => 'Cette chambre n\'est plus disponible pour ces dates.'])->withInput();
        }

        $nights     = (int) (new \DateTime($validated['check_out']))->diff(new \DateTime($validated['check_in']))->days;
        $totalPrice = $room->priceForStay($validated['check_in'], $validated['check_out']);

        $reservation = Reservation::create([
            'ref'              => Reservation::generateRef(),
            'room_id'          => $room->id,
            'guest_name'       => $validated['guest_name'],
            'guest_email'      => $validated['guest_email'],
            'guest_phone'      => $validated['guest_phone'],
            'check_in'         => $validated['check_in'],
            'check_out'        => $validated['check_out'],
            'nights'           => $nights,
            'guests'           => $validated['guests'],
            'total_price'      => $totalPrice,
            'special_requests' => $validated['special_requests'] ?? null,
            'cancel_token'     => Str::random(40),
            'status'           => 'confirmed',
        ]);

        // Emails via queue
        try {
            Mail::to($reservation->guest_email)->send(new \App\Mail\ReservationConfirmation($reservation));
            Mail::to(config('mail.hotel_email', 'hotel@havredepaix-assinie.com'))
                ->send(new \App\Mail\ReservationAlert($reservation));
        } catch (\Exception $e) {
            // Log silencieux — la réservation est créée même si l'email échoue
            logger()->error('Mail error: ' . $e->getMessage());
        }

        return redirect()->route('reservation.confirmation', $reservation->ref);
    }

    public function confirmation(string $ref)
    {
        $reservation = Reservation::where('ref', $ref)->with('room')->firstOrFail();
        return view('reservation.confirmation', compact('reservation'));
    }

    public function lookupForm()
    {
        return view('reservation.lookup');
    }

    public function lookup(Request $request)
    {
        $validated = $request->validate([
            'ref'   => 'required|string|max:20',
            'email' => 'required|email|max:150',
        ], [], ['ref' => 'référence', 'email' => 'email']);

        // Couple référence + email : évite qu'une référence seule (séquentielle,
        // donc devinable) suffise à consulter la réservation d'un tiers.
        $reservation = Reservation::whereRaw('UPPER(ref) = ?', [mb_strtoupper(trim($validated['ref']))])
            ->whereRaw('LOWER(guest_email) = ?', [mb_strtolower(trim($validated['email']))])
            ->with('room')
            ->first();

        if (! $reservation) {
            return back()
                ->withErrors(['ref' => 'Aucune réservation trouvée avec cette référence et cet email. Vérifiez l\'email de confirmation reçu.'])
                ->withInput();
        }

        return view('reservation.manage', compact('reservation'));
    }

    public function cancel(string $token)
    {
        $reservation = Reservation::where('cancel_token', $token)
            ->where('status', 'confirmed')
            ->firstOrFail();

        if (! $reservation->isCancellable()) {
            return view('reservation.cancel-denied', compact('reservation'));
        }

        $reservation->update([
            'status'       => 'cancelled',
            'cancelled_at' => now(),
        ]);

        try {
            Mail::to($reservation->guest_email)->send(new \App\Mail\ReservationCancelled($reservation));
            Mail::to(config('mail.hotel_email', 'hotel@havredepaix-assinie.com'))
                ->send(new \App\Mail\ReservationCancelledAlert($reservation));
        } catch (\Exception $e) {
            logger()->error('Mail error: ' . $e->getMessage());
        }

        return view('reservation.cancelled', compact('reservation'));
    }
}
