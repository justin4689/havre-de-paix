<?php

namespace App\Mail\Transport;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\MessageConverter;

/**
 * Transport Symfony Mailer pour la Hostinger Mail API.
 *
 * L'expéditeur est déterminé par la boîte associée au token (le champ
 * "from" des Mailables ne sert qu'au nom d'affichage). Réponse attendue :
 * 204 sans corps ; toute erreur est levée en TransportException pour que
 * la file d'attente puisse rejouer l'envoi.
 *
 * @see https://api.mail.hostinger.com/
 */
class HostingerMailTransport extends AbstractTransport
{
    private const BASE_URL = 'https://api.mail.hostinger.com/api/v1';

    public function __construct(
        #[\SensitiveParameter] private readonly string $token,
        private readonly string $mailboxId,
        private readonly int $timeout = 10,
    ) {
        parent::__construct();
    }

    protected function doSend(SentMessage $message): void
    {
        $email = MessageConverter::toEmail($message->getOriginalMessage());

        try {
            Http::withToken($this->token)
                ->acceptJson()
                ->timeout($this->timeout)
                ->retry(2, 500, fn (\Throwable $e) => $this->shouldRetry($e))
                ->post(
                    self::BASE_URL . '/mailboxes/' . $this->mailboxId . '/send',
                    $this->payload($email),
                );
        } catch (ConnectionException $e) {
            throw new TransportException('Hostinger Mail API injoignable : ' . $e->getMessage(), 0, $e);
        } catch (RequestException $e) {
            throw new TransportException(
                sprintf(
                    'Hostinger Mail API a refusé l\'envoi (HTTP %d) : %s',
                    $e->response->status(),
                    $e->response->json('error', $e->response->body()),
                ),
                0,
                $e,
            );
        }
    }

    /** Ne rejouer que les pannes transitoires — jamais les erreurs de validation (4xx). */
    private function shouldRetry(\Throwable $e): bool
    {
        return $e instanceof ConnectionException
            || ($e instanceof RequestException && $e->response->serverError());
    }

    /** @return array<string, mixed> */
    private function payload(Email $email): array
    {
        $payload = array_filter([
            'to'          => $this->addresses($email->getTo()),
            'cc'          => $this->addresses($email->getCc()),
            'bcc'         => $this->addresses($email->getBcc()),
            'displayName' => $email->getFrom()[0]?->getName() ?: null,
            'subject'     => $email->getSubject(),
            'html'        => $email->getHtmlBody(),
            'text'        => $email->getTextBody(),
        ]);

        $attachments = array_map(fn ($part) => [
            'filename'    => $part->getFilename() ?? 'attachment',
            'content'     => base64_encode($part->getBody()),
            'contentType' => $part->getMediaType() . '/' . $part->getMediaSubtype(),
        ], $email->getAttachments());

        if ($attachments !== []) {
            $payload['attachments'] = $attachments;
        }

        return $payload;
    }

    /**
     * @param  \Symfony\Component\Mime\Address[]  $addresses
     * @return string[]
     */
    private function addresses(array $addresses): array
    {
        return array_map(fn ($address) => $address->getAddress(), $addresses);
    }

    public function __toString(): string
    {
        return 'hostinger';
    }
}
