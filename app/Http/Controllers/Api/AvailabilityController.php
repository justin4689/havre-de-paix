<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'check_in'  => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'guests'    => 'nullable|integer|min:1',
        ]);

        $checkIn  = $request->check_in;
        $checkOut = $request->check_out;
        $guests   = (int) $request->get('guests', 1);

        $rooms = Room::where('status', 'active')
            ->when($guests > 0, fn ($q) => $q->where('capacity_adults', '>=', $guests))
            ->get()
            ->filter(fn ($room) => $room->isAvailable($checkIn, $checkOut))
            ->map(fn ($room) => [
                'id'          => $room->id,
                'slug'        => $room->slug,
                'name'        => $room->name,
                'capacity'    => $room->capacity_adults,
                'view'        => $room->view_label,
                'first_image' => asset($room->first_image),
                'price_night' => $room->price_per_night,
                'price_total' => $room->priceForStay($checkIn, $checkOut),
                'url'         => route('rooms.show', $room->slug),
            ])
            ->values();

        return response()->json(['data' => $rooms]);
    }
}
