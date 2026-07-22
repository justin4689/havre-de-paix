<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;

class ContactService
{
    /** Le message est transmis à l'hôtel ; un échec d'email est loggé sans bloquer. */
    public function send(array $data): void
    {
        try {
            Mail::to(config('mail.hotel_email', 'hotel@residencehotelcascades.com'))
                ->send(new \App\Mail\ContactMessage($data));
        } catch (\Exception $e) {
            logger()->error('Contact mail error: ' . $e->getMessage());
        }
    }
}
