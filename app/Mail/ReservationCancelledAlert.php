<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationCancelledAlert extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Reservation $reservation) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Annulation reçue — ' . $this->reservation->guest_name . ' — ' . $this->reservation->ref,
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.reservation-cancelled-alert');
    }
}
