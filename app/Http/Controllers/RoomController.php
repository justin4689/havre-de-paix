<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::where('status', 'active');

        if ($request->filled('capacity')) {
            $query->where('capacity_adults', '>=', $request->capacity);
        }

        if ($request->filled('view')) {
            $query->where('view', $request->view);
        }

        if ($request->filled('price_max')) {
            $query->where('price_per_night', '<=', $request->price_max);
        }

        $checkIn  = $request->get('check_in');
        $checkOut = $request->get('check_out');

        $rooms = $query->orderBy('price_per_night')->get();

        // Filtrer par disponibilité si dates fournies
        if ($checkIn && $checkOut && $checkIn < $checkOut) {
            $rooms = $rooms->filter(fn ($r) => $r->isAvailable($checkIn, $checkOut));
        }

        return view('rooms.index', compact('rooms', 'checkIn', 'checkOut'));
    }

    public function show(string $slug)
    {
        $room    = Room::findBySlug($slug);
        $similar = Room::where('status', 'active')
            ->where('id', '!=', $room->id)
            ->where('view', $room->view)
            ->take(2)
            ->get();

        return view('rooms.show', compact('room', 'similar'));
    }
}
