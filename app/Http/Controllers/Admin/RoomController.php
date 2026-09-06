<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoomRequest;
use App\Models\Room;
use App\Services\RoomAdminService;

class RoomController extends Controller
{
    public function __construct(
        private readonly RoomAdminService $roomService,
    ) {}

    public function index()
    {
        $rooms = $this->roomService->all();

        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('admin.rooms.create');
    }

    public function store(RoomRequest $request)
    {
        $this->roomService->create($request->validated(), $request->file('new_images') ?? []);

        return redirect()->route('admin.rooms.index')->with('success', 'Chambre créée avec succès.');
    }

    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    public function update(RoomRequest $request, Room $room)
    {
        $this->roomService->update($room, $request->validated(), $request->file('new_images') ?? []);

        return redirect()->route('admin.rooms.index')->with('success', 'Chambre mise à jour.');
    }

    public function destroy(Room $room)
    {
        $this->roomService->deactivate($room);

        return redirect()->route('admin.rooms.index')->with('success', 'Chambre désactivée.');
    }
}
