<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AvailabilityRequest;
use App\Services\AvailabilityService;
use App\Services\PricingService;
use Illuminate\Http\JsonResponse;

class AvailabilityController extends Controller
{
    public function __construct(
        private readonly AvailabilityService $availability,
        private readonly PricingService $pricing,
    ) {}

    public function index(AvailabilityRequest $request): JsonResponse
    {
        $checkIn  = $request->validated('check_in');
        $checkOut = $request->validated('check_out');
        $guests   = (int) ($request->validated('guests') ?? 1);

        $rooms = $this->availability->availableActiveRooms($checkIn, $checkOut, $guests)
            ->map(fn ($room) => [
                'id'          => $room->id,
                'slug'        => $room->slug,
                'name'        => $room->name,
                'capacity'    => $room->capacity_adults,
                'view'        => $room->view_label,
                'first_image' => asset($room->first_image),
                'price_night' => $room->price_per_night,
                'price_total' => $this->pricing->priceForStay($room, $checkIn, $checkOut),
                'url'         => route('rooms.show', $room->slug),
            ])
            ->values();

        return response()->json(['data' => $rooms]);
    }
}
