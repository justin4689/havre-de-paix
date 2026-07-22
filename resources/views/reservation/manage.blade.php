@extends('layouts.app')

@section('title', 'Ma réservation ' . $reservation->ref . ' — Résidence Hôtel Cascades')

@php
$badgeStyles = [
    'green'  => 'background-color: #dcfce7; color: #166534;',
    'red'    => 'background-color: #fee2e2; color: #991b1b;',
    'yellow' => 'background-color: #fef9c3; color: #854d0e;',
    'gray'   => 'background-color: #e2e8f0; color: #334155;',
][$reservation->status_color] ?? 'background-color: #e2e8f0; color: #334155;';
@endphp

@section('content')
<div class="pt-24 pb-20 min-h-screen px-4 sm:px-6" style="background-color: var(--color-snow);">
    <div class="max-w-5xl mx-auto">

        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold tracking-tight mb-2" style="color: var(--color-navy);">Votre réservation</h1>
            <p class="text-sm" style="color: var(--color-slate);">Réservée au nom de <strong>{{ $reservation->guest_name }}</strong></p>
        </div>

        {{-- Statut annulée --}}
        @if ($reservation->status === 'cancelled')
        <div class="rounded-xl p-4 mb-4 text-sm flex gap-3" style="background-color: #fee2e2; color: #991b1b;">
            <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <p class="font-semibold">Réservation annulée</p>
                @if ($reservation->cancelled_at)
                <p class="mt-0.5">Annulée le {{ $reservation->cancelled_at->translatedFormat('d F Y à H\hi') }}. La chambre a été libérée.</p>
                @endif
            </div>
        </div>
        @endif

        {{-- Récapitulatif --}}
        <div class="bg-white rounded-2xl shadow-sm border overflow-hidden mb-4 md:flex" style="border-color: var(--color-border);">
            <img src="{{ asset($reservation->room->first_image) }}" alt="{{ $reservation->room->name }}"
                 class="w-full aspect-[16/7] md:aspect-auto md:w-2/5 object-cover" loading="lazy">
            <div class="p-6 flex-1">
                <div class="flex items-center justify-between mb-5 pb-4 border-b" style="border-color: var(--color-border);">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wide mb-1" style="color: var(--color-orange);">Référence</p>
                        <p class="text-2xl font-bold tracking-tight" style="color: var(--color-navy);">{{ $reservation->ref }}</p>
                    </div>
                    <div class="px-3 py-1 rounded-full text-sm font-semibold" style="{{ $badgeStyles }}">
                        {{ $reservation->status_label }}
                    </div>
                </div>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span style="color: var(--color-slate);">Chambre</span>
                        <span class="font-medium" style="color: var(--color-navy);">{{ $reservation->room->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span style="color: var(--color-slate);">Arrivée</span>
                        <span class="font-medium" style="color: var(--color-navy);">{{ $reservation->check_in->translatedFormat('D d F Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span style="color: var(--color-slate);">Départ</span>
                        <span class="font-medium" style="color: var(--color-navy);">{{ $reservation->check_out->translatedFormat('D d F Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span style="color: var(--color-slate);">Durée</span>
                        <span class="font-medium" style="color: var(--color-navy);">{{ $reservation->nights }} nuit{{ $reservation->nights > 1 ? 's' : '' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span style="color: var(--color-slate);">Voyageurs</span>
                        <span class="font-medium" style="color: var(--color-navy);">{{ $reservation->guests }}</span>
                    </div>
                    @if ($reservation->special_requests)
                    <div class="flex justify-between">
                        <span style="color: var(--color-slate);">Demandes</span>
                        <span class="font-medium text-right max-w-xs" style="color: var(--color-navy);">{{ $reservation->special_requests }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between pt-3 border-t font-bold text-base" style="border-color: var(--color-border); color: var(--color-navy);">
                        <span>Total {{ $reservation->status === 'cancelled' ? '' : 'à régler à l\'arrivée' }}</span>
                        <span>{{ number_format($reservation->total_price, 0, ',', ' ') }} FCFA</span>
                    </div>
                </div>
            </div>
        </div>

        @if ($reservation->status === 'confirmed')
            @if ($reservation->isCancellable())
            {{-- Annulation possible --}}
            <div class="rounded-xl p-4 mb-4 text-sm flex gap-3" style="background-color: #f0fdf4; border: 1px solid #bbf7d0;">
                <svg class="w-5 h-5 shrink-0 mt-0.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-green-800">Vous pouvez encore <strong>annuler gratuitement</strong> (plus de 48h avant votre arrivée).</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('home') }}" class="btn-navy flex-1 text-center">Retour à l'accueil</a>
                <a href="{{ route('reservation.cancel', $reservation->cancel_token) }}"
                   class="flex-1 text-center px-4 py-2.5 rounded-lg text-sm font-medium border-2 transition-colors cursor-pointer"
                   style="border-color: var(--color-border); color: var(--color-slate);"
                   onclick="return confirm('Êtes-vous sûr de vouloir annuler votre réservation ?')">
                    Annuler la réservation
                </a>
            </div>
            @else
            {{-- Annulation en ligne fermée --}}
            <div class="rounded-xl p-4 mb-4 text-sm flex gap-3" style="background-color: var(--color-sky); color: #0c4a6e;">
                <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p>
                    Votre arrivée est dans moins de 48h : l'annulation en ligne n'est plus disponible.
                    Conformément aux <a href="{{ route('legal') }}#cgv" class="underline font-medium">CGV</a>, une nuit serait facturée.
                    Pour toute demande, <a href="{{ route('contact') }}" class="underline font-medium">contactez la réception</a>.
                </p>
            </div>
            <a href="{{ route('home') }}" class="btn-navy w-full text-center">Retour à l'accueil</a>
            @endif
        @else
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('rooms.index') }}" class="btn-primary flex-1 text-center">Réserver un nouveau séjour</a>
            <a href="{{ route('home') }}" class="btn-navy flex-1 text-center">Retour à l'accueil</a>
        </div>
        @endif

        <p class="text-center text-xs mt-5" style="color: var(--color-slate);">
            <a href="{{ route('reservation.lookup') }}" class="underline">Rechercher une autre réservation</a>
        </p>
    </div>
</div>
@endsection
