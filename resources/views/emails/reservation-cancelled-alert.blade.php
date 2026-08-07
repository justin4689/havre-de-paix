@extends('emails.layouts.main')

@section('title', 'Annulation — ' . $reservation->ref)
@section('accent', '#DC2626')
@section('heading', 'Réservation annulée')
@section('subheading', 'Résidence Hôtel Cascades — Back-office')

@section('content')
    <div class="ref-badge danger">{{ $reservation->ref }}</div>

    <table class="kv-table" cellpadding="0" cellspacing="0">
        <tr><td class="k">Client</td><td class="v">{{ $reservation->guest_name }}</td></tr>
        <tr><td class="k">Email</td><td class="v">{{ $reservation->guest_email }}</td></tr>
        <tr><td class="k">Chambre</td><td class="v">{{ $reservation->room->name }}</td></tr>
        <tr><td class="k">Dates</td><td class="v">{{ $reservation->check_in->format('d/m/Y') }} → {{ $reservation->check_out->format('d/m/Y') }}</td></tr>
        <tr><td class="k">Annulée le</td><td class="v">{{ ($reservation->cancelled_at ?? now())->format('d/m/Y à H:i') }}</td></tr>
    </table>
@endsection

@section('footer')
    <p>Alerte automatique — La chambre est désormais disponible pour ces dates.</p>
@endsection
