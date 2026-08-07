<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationAlert extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /** Rejoué 3 fois (10 s puis 60 s) avant d'atterrir dans failed_jobs. */
    public int $tries = 3;

    /** @var array<int, int> */
    public array $backoff = [10, 60];

    public function __construct(public Reservation $reservation) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouvelle réservation — ' . $this->reservation->guest_name . ' — ' . $this->reservation->ref,
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.reservation-alert');
    }
}
