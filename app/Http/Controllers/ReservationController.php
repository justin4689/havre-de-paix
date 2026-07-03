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
        $room     = null;
        $checkIn  = $request->get('check_in');
        $checkOut = $request->get('check_out');
        $guests   = $request->get('guests', 1);

        if ($request->filled('room_id')) {
            $room = Room::findOrFail($request->room_id);
        }

        return view('reservation.index', compact('room', 'checkIn', 'checkOut', 'guests'));
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
