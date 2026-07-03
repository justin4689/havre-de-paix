<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::orderBy('price_per_night')->get();
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('admin.rooms.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateRoom($request);
        $validated['slug'] = Str::slug($validated['name']);
        $validated['images'] = $this->handleImages($request);

        Room::create($validated);

        return redirect()->route('admin.rooms.index')->with('success', 'Chambre créée avec succès.');
    }

    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $this->validateRoom($request);

        if ($request->hasFile('new_images')) {
            $validated['images'] = array_merge(
                $room->images ?? [],
                $this->handleImages($request)
            );
        }

        $room->update($validated);

        return redirect()->route('admin.rooms.index')->with('success', 'Chambre mise à jour.');
    }

    public function destroy(Room $room)
    {
        $room->update(['status' => 'inactive']);
        return redirect()->route('admin.rooms.index')->with('success', 'Chambre désactivée.');
    }

    private function validateRoom(Request $request): array
    {
        return $request->validate([
            'name'             => 'required|string|max:100',
            'description_short'=> 'required|string|max:255',
            'description_long' => 'nullable|string',
            'capacity_adults'  => 'required|integer|min:1|max:10',
            'capacity_children'=> 'nullable|integer|min:0|max:10',
            'size_m2'          => 'nullable|integer',
            'bed_type'         => 'required|in:single,double,twin,king',
            'floor'            => 'required|integer|min:0|max:10',
            'view'             => 'required|in:sea,lagoon,garden,pool',
            'amenities'        => 'nullable|array',
            'price_per_night'  => 'required|integer|min:1000',
            'min_nights'       => 'nullable|integer|min:1',
            'status'           => 'required|in:active,inactive,maintenance',
        ]);
    }

    private function handleImages(Request $request): array
    {
        $paths = [];
        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $file) {
                $path    = $file->store('rooms', 'public');
                $paths[] = 'storage/' . $path;
            }
        }
        return $paths;
    }
}
