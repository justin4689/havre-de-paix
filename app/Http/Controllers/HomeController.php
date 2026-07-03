<?php

namespace App\Http\Controllers;

use App\Models\Room;

class HomeController extends Controller
{
    public function index()
    {
        $rooms = Room::where('status', 'active')
            ->orderBy('price_per_night')
            ->take(3)
            ->get();

        return view('home', compact('rooms'));
    }
}
