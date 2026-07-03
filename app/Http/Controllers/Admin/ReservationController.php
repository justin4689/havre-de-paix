<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservation::with('room')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->where('check_in', $request->date);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn ($q) =>
                $q->where('guest_name', 'like', "%$s%")
                  ->orWhere('ref', 'like', "%$s%")
                  ->orWhere('guest_email', 'like', "%$s%")
            );
        }

        $reservations = $query->paginate(20);
        return view('admin.reservations.index', compact('reservations'));
    }

    public function show(Reservation $reservation)
    {
        $reservation->load('room');
        return view('admin.reservations.show', compact('reservation'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'status'  => 'sometimes|in:confirmed,cancelled,modified',
            'check_in'  => 'sometimes|date',
            'check_out' => 'sometimes|date|after:check_in',
        ]);

        $reservation->update($validated);

        return back()->with('success', 'Réservation mise à jour.');
    }

    public function create()
    {
        $rooms = \App\Models\Room::where('status', 'active')->orderBy('name')->get();
        return view('admin.reservations.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id'          => 'required|exists:rooms,id',
            'check_in'         => 'required|date',
            'check_out'        => 'required|date|after:check_in',
            'guests'           => 'required|integer|min:1',
            'guest_name'       => 'required|string|max:100',
            'guest_email'      => 'required|email',
            'guest_phone'      => 'required|string|max:30',
            'special_requests' => 'nullable|string|max:500',
        ]);

        $room    = \App\Models\Room::findOrFail($validated['room_id']);
        $nights  = (int) (new \DateTime($validated['check_out']))->diff(new \DateTime($validated['check_in']))->days;

        Reservation::create([
            ...$validated,
            'ref'          => Reservation::generateRef(),
            'nights'       => $nights,
            'total_price'  => $room->priceForStay($validated['check_in'], $validated['check_out']),
            'cancel_token' => \Illuminate\Support\Str::random(40),
            'status'       => 'confirmed',
        ]);

        return redirect()->route('admin.reservations.index')->with('success', 'Réservation manuelle créée.');
    }
}
