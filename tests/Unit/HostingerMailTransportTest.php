<?php

use App\Mail\Transport\HostingerMailTransport;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

uses(Tests\TestCase::class);

function makeEmail(): Email
{
    return (new Email())
        ->from(new Address('info@residencehotelcascades.com', 'Résidence Hôtel Cascades'))
        ->to('client@example.com')
        ->subject('Confirmation de réservation RHC-2026-0042')
        ->html('<p>Bonjour</p>')
        ->text('Bonjour');
}

it('envoie le message via la Hostinger Mail API', function () {
    Http::fake(['api.mail.hostinger.com/*' => Http::response(null, 204)]);

    $transport = new HostingerMailTransport(token: 'secret-token', mailboxId: 'MB123');
    $transport->send(makeEmail());

    Http::assertSent(function ($request) {
        return $request->url() === 'https://api.mail.hostinger.com/api/v1/mailboxes/MB123/send'
            && $request->hasHeader('Authorization', 'Bearer secret-token')
            && $request['to'] === ['client@example.com']
            && $request['subject'] === 'Confirmation de réservation RHC-2026-0042'
            && $request['displayName'] === 'Résidence Hôtel Cascades'
            && $request['html'] === '<p>Bonjour</p>';
    });
});

it('lève une TransportException sur une erreur de validation (422) sans réessayer', function () {
    Http::fake(['api.mail.hostinger.com/*' => Http::response(['error' => 'Invalid recipient', 'code' => 'invalid_recipient'], 422)]);

    $transport = new HostingerMailTransport(token: 'secret-token', mailboxId: 'MB123');

    expect(fn () => $transport->send(makeEmail()))
        ->toThrow(TransportException::class, 'Invalid recipient');

    Http::assertSentCount(1);
});

it('réessaie sur une erreur serveur (5xx) avant d\'échouer', function () {
    Http::fake(['api.mail.hostinger.com/*' => Http::response(['error' => 'Upstream error', 'code' => 'upstream'], 502)]);

    $transport = new HostingerMailTransport(token: 'secret-token', mailboxId: 'MB123');

    expect(fn () => $transport->send(makeEmail()))->toThrow(TransportException::class);

    Http::assertSentCount(2);
});
