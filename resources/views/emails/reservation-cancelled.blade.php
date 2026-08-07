@extends('emails.layouts.main')

@section('title', 'Annulation confirmée — ' . $reservation->ref)
@section('logo', '1')
@section('heading', 'Annulation confirmée')
@section('subheading', 'Réservation ' . $reservation->ref)

@section('content')
    <p class="greeting">Bonjour {{ $reservation->guest_name }},</p>
    <p class="intro">
        Votre demande d'annulation a bien été prise en compte.
        Votre réservation est désormais annulée — aucun montant ne vous sera facturé.
    </p>

    <div class="summary">
        <p><strong>Chambre :</strong> {{ $reservation->room->name }}</p>
        <p><strong>Dates :</strong> {{ $reservation->check_in->format('d/m/Y') }} → {{ $reservation->check_out->format('d/m/Y') }}</p>
        <p><strong>Annulée le :</strong> {{ ($reservation->cancelled_at ?? now())->format('d/m/Y à H:i') }}</p>
    </div>

    <p class="intro">
        Nous espérons avoir l'occasion de vous accueillir prochainement à la
        Résidence Hôtel Cascades. N'hésitez pas à effectuer une nouvelle
        réservation sur notre site.
    </p>

    <a href="{{ route('rooms.index') }}" class="cta-btn">Découvrir nos chambres</a>
@endsection
