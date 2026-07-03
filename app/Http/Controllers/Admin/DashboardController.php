<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Room;

class DashboardController extends Controller
{
    public function index()
    {
        $today     = now()->toDateString();
        $arrivals  = Reservation::with('room')->where('check_in', $today)->where('status', 'confirmed')->get();
        $departures = Reservation::with('room')->where('check_out', $today)->where('status', 'confirmed')->get();

        $occupied  = Reservation::where('check_in', '<=', $today)
            ->where('check_out', '>', $today)
            ->where('status', 'confirmed')
            ->count();

        $totalRooms = Room::where('status', 'active')->count();
        $occupancy  = $totalRooms > 0 ? round($occupied / $totalRooms * 100) : 0;

        $monthRevenue = Reservation::where('status', 'confirmed')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_price');

        $pending = Reservation::where('status', 'confirmed')
            ->where('check_in', '>', $today)
            ->count();

        $recent = Reservation::with('room')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'arrivals', 'departures', 'occupied', 'totalRooms',
            'occupancy', 'monthRevenue', 'pending', 'recent'
        ));
    }
}
