<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreReservationRequest;
use App\Http\Requests\Admin\UpdateReservationRequest;
use App\Models\Reservation;
use App\Services\ReservationService;
use App\Services\RoomAdminService;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function __construct(
        private readonly ReservationService $reservationService,
        private readonly RoomAdminService $roomService,
    ) {}

    public function index(Request $request)
    {
        $reservations = $this->reservationService->paginateFiltered(
            $request->only(['status', 'date', 'search'])
        );

        return view('admin.reservations.index', compact('reservations'));
    }

    public function show(Reservation $reservation)
    {
        $reservation->load('room');

        return view('admin.reservations.show', compact('reservation'));
    }

    public function create()
    {
        $rooms = $this->roomService->activeForSelect();

        return view('admin.reservations.create', compact('rooms'));
    }

    public function store(StoreReservationRequest $request)
    {
        $this->reservationService->bookManual($request->validated());

        return redirect()->route('admin.reservations.index')->with('success', 'Réservation manuelle créée.');
    }

    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        $this->reservationService->update($reservation, $request->validated());

        return back()->with('success', 'Réservation mise à jour.');
    }
}
