<?php

use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

function actingAsRoomAdmin(): User
{
    $admin = User::create([
        'name' => 'Admin Test',
        'email' => 'admin-rooms@example.com',
        'password' => bcrypt('secret-test'),
        'role' => 'admin',
    ]);

    test()->actingAs($admin);

    return $admin;
}

function makeRoom(array $attributes = []): Room
{
    return Room::create([
        'slug' => 'chambre-a-supprimer', 'name' => 'Chambre à supprimer',
        'description_short' => 'Test', 'capacity_adults' => 2, 'capacity_children' => 0,
        'size_m2' => 20, 'bed_type' => 'double', 'floor' => 1, 'category' => 'standard',
        'amenities' => [], 'images' => [], 'price_per_night' => 50000,
        'min_nights' => 1, 'status' => 'active',
        ...$attributes,
    ]);
}

it('supprime une chambre et ses photos uploadées, sans toucher au catalogue versionné', function () {
    Storage::fake('public');
    Storage::disk('public')->put('rooms/upload-test.jpg', 'fake');
    actingAsRoomAdmin();

    $room = makeRoom([
        'images' => ['storage/rooms/upload-test.jpg', 'images/rooms/standard-1-1.jpg'],
    ]);

    $this->delete(route('admin.rooms.destroy', $room))
        ->assertRedirect(route('admin.rooms.index'));

    $this->assertDatabaseMissing('rooms', ['slug' => 'chambre-a-supprimer']);
    Storage::disk('public')->assertMissing('rooms/upload-test.jpg');
    expect(file_exists(public_path('images/rooms/standard-1-1.jpg')))->toBeTrue();
});

it('refuse de supprimer une chambre qui a des réservations', function () {
    actingAsRoomAdmin();
    $room = makeRoom();

    Reservation::create([
        'ref' => 'HDP-2026-9998',
        'room_id' => $room->id,
        'guest_name' => 'Client Test',
        'guest_email' => 'client@example.com',
        'guest_phone' => '+225 01 02 03 04 05',
        'check_in' => now()->addDays(3)->toDateString(),
        'check_out' => now()->addDays(5)->toDateString(),
        'nights' => 2,
        'guests' => 2,
        'total_price' => 100000,
        'status' => 'confirmed',
        'cancel_token' => str_repeat('b', 40),
    ]);

    $this->from(route('admin.rooms.index'))
        ->delete(route('admin.rooms.destroy', $room))
        ->assertSessionHasErrors('room');

    $this->assertDatabaseHas('rooms', ['slug' => 'chambre-a-supprimer']);
});

it('bascule le statut actif/inactif depuis la liste', function () {
    actingAsRoomAdmin();
    $room = makeRoom();

    $this->patch(route('admin.rooms.toggle', $room))->assertRedirect(route('admin.rooms.index'));
    expect($room->refresh()->status)->toBe('inactive');

    $this->patch(route('admin.rooms.toggle', $room));
    expect($room->refresh()->status)->toBe('active');
});
