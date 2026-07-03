@extends('layouts.app')
@section('title', 'Réservation confirmée — ' . $reservation->ref)

@section('content')
<div class="pt-24 pb-20 min-h-screen px-4 sm:px-6" style="background-color: var(--color-snow);">
    <div class="max-w-xl mx-auto">

        {{-- Icône succès --}}
        <div class="text-center mb-8 animate-fade-up">
            <div class="w-20 h-20 rounded-full mx-auto mb-4 flex items-center justify-center" style="background-color: #dcfce7;">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold mb-2" style="font-family: var(--font-serif); color: var(--color-navy);">
                Réservation confirmée !
            </h1>
            <p style="color: var(--color-slate);">Un email de confirmation a été envoyé à <strong>{{ $reservation->guest_email }}</strong></p>
        </div>

        {{-- Récapitulatif --}}
        <div class="bg-white rounded-2xl shadow-sm border p-6 mb-4" style="border-color: var(--color-border);">
            <div class="flex items-center justify-between mb-5 pb-4 border-b" style="border-color: var(--color-border);">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider mb-1" style="color: var(--color-orange);">Référence</p>
                    <p class="text-2xl font-bold" style="color: var(--color-navy); font-family: var(--font-serif);">{{ $reservation->ref }}</p>
                </div>
                <div class="px-3 py-1 rounded-full text-sm font-semibold" style="background-color: #dcfce7; color: #166534;">
                    Confirmée
                </div>
            </div>

            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span style="color: var(--color-slate);">Chambre</span>
                    <span class="font-medium" style="color: var(--color-navy);">{{ $reservation->room->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span style="color: var(--color-slate);">Arrivée</span>
                    <span class="font-medium" style="color: var(--color-navy);">{{ $reservation->check_in->format('d/m/Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span style="color: var(--color-slate);">Départ</span>
                    <span class="font-medium" style="color: var(--color-navy);">{{ $reservation->check_out->format('d/m/Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span style="color: var(--color-slate);">Durée</span>
                    <span class="font-medium" style="color: var(--color-navy);">{{ $reservation->nights }} nuit(s)</span>
                </div>
                <div class="flex justify-between">
                    <span style="color: var(--color-slate);">Personnes</span>
                    <span class="font-medium" style="color: var(--color-navy);">{{ $reservation->guests }}</span>
                </div>
                @if ($reservation->special_requests)
                <div class="flex justify-between">
                    <span style="color: var(--color-slate);">Demandes</span>
                    <span class="font-medium text-right max-w-xs" style="color: var(--color-navy);">{{ $reservation->special_requests }}</span>
                </div>
                @endif
                <div class="flex justify-between pt-3 border-t font-semibold text-base" style="border-color: var(--color-border);">
                    <span style="color: var(--color-navy);">Total à régler</span>
                    <span style="color: var(--color-orange);">{{ number_format($reservation->total_price, 0, ',', ' ') }} FCFA</span>
                </div>
            </div>
        </div>

        {{-- Infos paiement --}}
        <div class="rounded-xl p-4 mb-4 text-sm flex gap-3" style="background-color: var(--color-sky); color: #0c4a6e;">
            <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <p class="font-semibold mb-1">Paiement à l'arrivée</p>
                <p>Le règlement de <strong>{{ number_format($reservation->total_price, 0, ',', ' ') }} FCFA</strong> s'effectue directement à l'hôtel à votre arrivée. Aucun montant n'a été prélevé en ligne.</p>
            </div>
        </div>

        {{-- Accès --}}
        <div class="bg-white rounded-2xl border p-5 mb-6" style="border-color: var(--color-border);">
            <h2 class="font-semibold mb-3" style="color: var(--color-navy); font-family: var(--font-serif);">
                Comment nous trouver ?
            </h2>
            <p class="text-sm mb-2" style="color: var(--color-slate);">
                <strong>Havre de Paix — Assinie Km 18,75</strong>, Côte d'Ivoire<br>
                À 94 km d'Abidjan par l'autoroute de Bassam, puis Assinie.
            </p>
            <a href="https://maps.google.com/?q=Assinie+Km+18,75+Cote+d+Ivoire" target="_blank" rel="noopener"
               class="text-sm font-medium flex items-center gap-1.5 mt-3 transition-colors" style="color: var(--color-blue);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Ouvrir dans Google Maps
            </a>
        </div>

        {{-- Actions --}}
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('home') }}" class="btn-navy flex-1 text-center">
                Retour à l'accueil
            </a>
            <a href="{{ route('reservation.cancel', $reservation->cancel_token) }}"
               class="flex-1 text-center px-4 py-2.5 rounded-lg text-sm font-medium border-2 transition-colors"
               style="border-color: var(--color-border); color: var(--color-slate);"
               onclick="return confirm('Êtes-vous sûr de vouloir annuler votre réservation ?')">
                Annuler la réservation
            </a>
        </div>
        <p class="text-center text-xs mt-3" style="color: var(--color-slate);">
            Le lien d'annulation est également disponible dans votre email de confirmation.
        </p>
    </div>
</div>
@endsection
