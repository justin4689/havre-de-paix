@extends('emails.layouts.main')

@section('title', 'Nouvelle réservation — ' . $reservation->ref)
@section('accent', '#42B6DA')
@section('heading', 'Nouvelle réservation reçue')
@section('subheading', 'Résidence Hôtel Cascades — Back-office')

@section('content')
    <div class="ref-badge">{{ $reservation->ref }}</div>

    <table class="kv-table" cellpadding="0" cellspacing="0">
        <tr><td class="k">Client</td><td class="v">{{ $reservation->guest_name }}</td></tr>
        <tr><td class="k">Email</td><td class="v">{{ $reservation->guest_email }}</td></tr>
        <tr><td class="k">Téléphone</td><td class="v">{{ $reservation->guest_phone }}</td></tr>
        <tr><td class="k">Chambre</td><td class="v">{{ $reservation->room->name }}</td></tr>
        <tr><td class="k">Arrivée</td><td class="v">{{ $reservation->check_in->format('d/m/Y') }}</td></tr>
        <tr><td class="k">Départ</td><td class="v">{{ $reservation->check_out->format('d/m/Y') }}</td></tr>
        <tr><td class="k">Nuits</td><td class="v">{{ $reservation->nights }}</td></tr>
        <tr><td class="k">Hôtes</td><td class="v">{{ $reservation->guests }}</td></tr>
        <tr><td class="k">Montant total</td><td class="v" style="color:#42B6DA;">{{ number_format($reservation->total_price, 0, ',', ' ') }} FCFA</td></tr>
        @if ($reservation->special_requests)
        <tr><td class="k">Demandes spéciales</td><td class="v">{{ $reservation->special_requests }}</td></tr>
        @endif
    </table>
@endsection

@section('footer')
    <p>Alerte automatique envoyée depuis le moteur de réservation.</p>
@endsection
