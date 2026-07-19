<?php

namespace App\Http\Controllers;

use App\Services\RoomCatalogService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class RoomController extends Controller
{
    public function __construct(
        private readonly RoomCatalogService $catalog,
    ) {}

    public function index(Request $request)
    {
        $data = $this->catalog->catalog(
            $request->only(['capacity', 'view', 'price_max', 'sort', 'check_in', 'check_out']),
            max(1, (int) $request->get('page', 1)),
            $request->url(),
            Arr::except($request->query(), 'page'),
        );

        return view('rooms.index', [
            'rooms'       => $data['rooms'],
            'viewCounts'  => $data['viewCounts'],
            'priceBounds' => $data['priceBounds'],
            'checkIn'     => $request->get('check_in'),
            'checkOut'    => $request->get('check_out'),
        ]);
    }

    public function show(string $slug)
    {
        $room    = $this->catalog->findBySlug($slug);
        $similar = $this->catalog->similarTo($room);

        return view('rooms.show', compact('room', 'similar'));
    }
}
