<?php

namespace App\Services;

use App\Mail\ContactMessage;
use App\Mail\ReservationAlert;
use App\Mail\ReservationCancelled;
use App\Mail\ReservationCancelledAlert;
use App\Mail\ReservationConfirmation;
use App\Models\Reservation;
use Illuminate\Contracts\Mail\Factory as MailFactory;
use Illuminate\Mail\Mailable;
use Psr\Log\LoggerInterface;

/**
 * Point d'entrée unique des emails transactionnels.
 *
 * Les Mailables sont mis en file d'attente (ShouldQueue) : l'appel ne fait
 * que déposer le job, le worker se charge de l'appel API. Un échec de mise
 * en file est logué mais ne bloque jamais l'action métier (réservation,
 * annulation, contact).
 */
class EmailService
{
    public function __construct(
        private readonly MailFactory $mailer,
        private readonly LoggerInterface $logger,
    ) {}

    /** Confirmation au client + alerte à l'hôtel. */
    public function sendReservationCreated(Reservation $reservation): void
    {
        $this->sendSafely($reservation->guest_email, new ReservationConfirmation($reservation));
        $this->sendSafely($this->hotelEmail(), new ReservationAlert($reservation));
    }

    /** Annulation confirmée au client + alerte à l'hôtel. */
    public function sendReservationCancelled(Reservation $reservation): void
    {
        $this->sendSafely($reservation->guest_email, new ReservationCancelled($reservation));
        $this->sendSafely($this->hotelEmail(), new ReservationCancelledAlert($reservation));
    }

    /** Message du formulaire de contact, transmis à la réception. */
    public function sendContactMessage(array $data): void
    {
        $this->sendSafely($this->hotelEmail(), new ContactMessage($data));
    }

    /** L'email ne doit jamais faire échouer l'action qui le déclenche. */
    private function sendSafely(string $to, Mailable $mailable): void
    {
        try {
            $this->mailer->to($to)->send($mailable);
        } catch (\Throwable $e) {
            $this->logger->error('Mail error [' . $mailable::class . ']: ' . $e->getMessage(), [
                'to' => $to,
            ]);
        }
    }

    private function hotelEmail(): string
    {
        return config('mail.hotel_email', 'info@residencehotelcascades.com');
    }
}
