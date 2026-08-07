@extends('emails.layouts.main')

@section('title', 'Confirmation de réservation — Résidence Hôtel Cascades')
@section('logo', '1')
@section('heading', 'Résidence Hôtel Cascades')
@section('subheading', 'Résidence-Hôtel · Cocody, Abidjan')

@section('content')
    <div class="ref-badge">Réservation {{ $reservation->ref }}</div>

    <p class="greeting">Bonjour {{ $reservation->guest_name }},</p>
    <p class="intro">
        Votre réservation à la Résidence Hôtel Cascades a bien été enregistrée.
        Nous avons hâte de vous accueillir dans notre havre de calme et de verdure,
        au cœur de Cocody à Abidjan.
    </p>

    <div class="details-card">
        <h2>Détails du séjour</h2>
        <table class="kv-table" cellpadding="0" cellspacing="0">
            <tr><td class="k">Chambre</td><td class="v">{{ $reservation->room->name }}</td></tr>
            <tr><td class="k">Arrivée</td><td class="v">{{ $reservation->check_in->format('d/m/Y') }} — à partir de 14h00</td></tr>
            <tr><td class="k">Départ</td><td class="v">{{ $reservation->check_out->format('d/m/Y') }} — avant 12h00</td></tr>
            <tr><td class="k">Durée</td><td class="v">{{ $reservation->nights }} nuit{{ $reservation->nights > 1 ? 's' : '' }}</td></tr>
            <tr><td class="k">Hôtes</td><td class="v">{{ $reservation->guests }} personne{{ $reservation->guests > 1 ? 's' : '' }}</td></tr>
        </table>
    </div>

    <table class="total-table" cellpadding="0" cellspacing="0">
        <tr>
            <td class="label">Montant total à régler</td>
            <td class="value">{{ number_format($reservation->total_price, 0, ',', ' ') }} FCFA</td>
        </tr>
    </table>

    <div class="notice">
        <strong>Paiement à l'arrivée</strong>
        Le règlement s'effectue intégralement à la réception lors de votre arrivée.
        Aucune transaction en ligne n'est requise. Veuillez présenter cet email ou
        votre référence de réservation.
    </div>

    <a href="{{ route('reservation.confirmation', $reservation->ref) }}" class="cta-btn">Consulter ma réservation</a>
    <a href="{{ route('reservation.cancel', $reservation->cancel_token) }}" class="cancel-link">Annuler ma réservation (gratuit jusqu'à 48h avant l'arrivée)</a>
@endsection

@section('footer')
    <p>
        Résidence Hôtel Cascades · Cocody Riviera — M'Badon, Abidjan, Côte d'Ivoire<br>
        <a href="mailto:{{ config('mail.hotel_email') }}">{{ config('mail.hotel_email') }}</a> · +225 05 06 50 55 92<br><br>
        Vous recevez cet email car vous avez effectué une réservation sur notre site.
    </p>
@endsection
