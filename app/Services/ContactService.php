<?php

namespace App\Services;

class ContactService
{
    public function __construct(
        private readonly EmailService $emails,
    ) {}

    /** Le message est transmis à l'hôtel ; un échec d'email est loggé sans bloquer. */
    public function send(array $data): void
    {
        $this->emails->sendContactMessage($data);
    }
}
