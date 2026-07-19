<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::where('status', 'active');

        if ($request->filled('capacity')) {
            $query->where('capacity_adults', '>=', $request->capacity);
        }

        if ($request->filled('view')) {
            $query->whereIn('view', (array) $request->view);
        }

        if ($request->filled('price_max')) {
            $query->where('price_per_night', '<=', $request->price_max);
        }

        // Compteurs et bornes de prix du panneau de filtres (catalogue actif complet)
        $allActive   = Room::where('status', 'active')->get(['view', 'price_per_night']);
        $viewCounts  = $allActive->countBy('view');
        $priceBounds = $allActive->isEmpty()
            ? ['min' => 0, 'max' => 200000]
            : [
                'min' => (int) floor($allActive->min('price_per_night') / 5000) * 5000,
                'max' => (int) ceil($allActive->max('price_per_night') / 5000) * 5000,
            ];

        $checkIn  = $request->get('check_in');
        $checkOut = $request->get('check_out');

        match ($request->get('sort', 'price_asc')) {
            'price_desc' => $query->orderByDesc('price_per_night'),
            'capacity'   => $query->orderByDesc('capacity_adults'),
            default      => $query->orderBy('price_per_night'),
        };

        $rooms = $query->get();

        // Filtrer par disponibilité si dates fournies
        if ($checkIn && $checkOut && $checkIn < $checkOut) {
            $rooms = $rooms->filter(fn ($r) => $r->isAvailable($checkIn, $checkOut))->values();
        }

        // Pagination sur la collection (le filtre de disponibilité est en PHP,
        // une pagination SQL fausserait les comptes par page).
        $perPage = 8;
        $page    = max(1, (int) $request->get('page', 1));
        $rooms   = new LengthAwarePaginator(
            $rooms->forPage($page, $perPage)->values(),
            $rooms->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => Arr::except($request->query(), 'page')]
        );

        return view('rooms.index', compact('rooms', 'checkIn', 'checkOut', 'viewCounts', 'priceBounds'));
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
