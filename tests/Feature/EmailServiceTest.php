<?php

use App\Mail\ContactMessage;
use App\Mail\ReservationAlert;
use App\Mail\ReservationCancelled;
use App\Mail\ReservationCancelledAlert;
use App\Mail\ReservationConfirmation;
use App\Models\Reservation;
use App\Models\Room;
use App\Services\EmailService;
use Illuminate\Support\Facades\Mail;

function makeReservation(): Reservation
{
    $room = Room::create([
        'slug' => 'chambre-999', 'name' => 'Chambre 999',
        'description_short' => 'Test', 'capacity_adults' => 2, 'capacity_children' => 0,
        'size_m2' => 20, 'bed_type' => 'double', 'floor' => 1, 'category' => 'standard',
        'amenities' => [], 'images' => [], 'price_per_night' => 50000,
        'min_nights' => 1, 'status' => 'active',
    ]);

    return Reservation::create([
        'ref' => 'RHC-2026-9999', 'room_id' => $room->id,
        'guest_name' => 'Test Client', 'guest_email' => 'client@example.com',
        'guest_phone' => '+225 01 02 03 04 05',
        'check_in' => now()->addDays(3)->toDateString(),
        'check_out' => now()->addDays(5)->toDateString(),
        'nights' => 2, 'guests' => 2, 'total_price' => 100000,
        'status' => 'confirmed', 'cancel_token' => str_repeat('a', 40),
    ]);
}

it('met en file la confirmation client et l\'alerte hôtel à la création', function () {
    Mail::fake();

    app(EmailService::class)->sendReservationCreated(makeReservation());

    Mail::assertQueued(ReservationConfirmation::class, fn ($mail) => $mail->hasTo('client@example.com'));
    Mail::assertQueued(ReservationAlert::class, fn ($mail) => $mail->hasTo(config('mail.hotel_email')));
});

it('met en file les emails d\'annulation', function () {
    Mail::fake();

    app(EmailService::class)->sendReservationCancelled(makeReservation());

    Mail::assertQueued(ReservationCancelled::class, fn ($mail) => $mail->hasTo('client@example.com'));
    Mail::assertQueued(ReservationCancelledAlert::class, fn ($mail) => $mail->hasTo(config('mail.hotel_email')));
});

it('met en file le message de contact vers la réception', function () {
    Mail::fake();

    app(EmailService::class)->sendContactMessage([
        'name' => 'Test', 'email' => 'test@example.com',
        'subject' => 'Question', 'message' => 'Bonjour',
    ]);

    Mail::assertQueued(ContactMessage::class, fn ($mail) => $mail->hasTo(config('mail.hotel_email')));
});

it('ne propage jamais un échec de mise en file', function () {
    Mail::shouldReceive('to')->andThrow(new RuntimeException('queue down'));

    app(EmailService::class)->sendContactMessage([
        'name' => 'Test', 'email' => 'test@example.com',
        'subject' => 'Question', 'message' => 'Bonjour',
    ]);
})->throwsNoExceptions();

it('met en file les emails lors d\'une réservation de bout en bout', function () {
    Mail::fake();
    $room = makeReservation()->room; // crée aussi une chambre réutilisable

    $this->post(route('reservation.store'), [
        'room_id' => $room->id,
        'check_in' => now()->addDays(10)->toDateString(),
        'check_out' => now()->addDays(12)->toDateString(),
        'guests' => 2,
        'guest_name' => 'Aya Kone',
        'guest_email' => 'aya@example.com',
        'guest_phone' => '+225 07 08 09 10 11',
        'accept_cgv' => '1',
    ]);

    Mail::assertQueued(ReservationConfirmation::class, fn ($mail) => $mail->hasTo('aya@example.com'));
    Mail::assertQueued(ReservationAlert::class);
});
