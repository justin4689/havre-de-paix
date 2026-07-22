@extends('layouts.app')

@section('title', 'Finaliser ma réservation — Résidence Hôtel Cascades')

@php
$basePrice  = $room->price_per_night * $nights;
$adjustment = $totalPrice - $basePrice;
@endphp

@section('content')
<div class="pt-24 pb-20 min-h-screen px-4 sm:px-6 lg:px-8" style="background-color: var(--color-snow);">
    <div class="max-w-6xl mx-auto">

        {{-- Progression : la chambre est déjà choisie --}}
        <div class="flex items-center justify-center gap-3 mb-10">
            <div class="flex items-center gap-2">
                <div class="step-dot done">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                </div>
                <span class="text-sm font-medium hidden sm:block" style="color: #16a34a;">Chambre choisie</span>
            </div>
            <div class="h-px w-8 sm:w-12" style="background-color: #16a34a;"></div>
            <div class="flex items-center gap-2">
                <div class="step-dot active">2</div>
                <span class="text-sm font-medium hidden sm:block" style="color: var(--color-orange);">Vos coordonnées</span>
            </div>
            <div class="h-px w-8 sm:w-12" style="background-color: var(--color-border);"></div>
            <div class="flex items-center gap-2">
                <div class="step-dot">3</div>
                <span class="text-sm font-medium hidden sm:block" style="color: var(--color-slate);">Confirmation</span>
            </div>
        </div>

        {{-- Erreurs --}}
        @if ($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200">
            <p class="text-sm font-medium text-red-800 mb-2">Veuillez corriger les erreurs suivantes :</p>
            <ul class="text-sm text-red-700 space-y-1">
                @foreach ($errors->all() as $error)
                <li class="flex items-center gap-2"><svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('reservation.store') }}" method="POST" id="booking-form" novalidate
              class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            @csrf

            {{-- Séjour verrouillé — modifiable uniquement via « Modifier » dans le récap --}}
            <input type="hidden" name="room_id"   value="{{ old('room_id', $room->id) }}">
            <input type="hidden" name="check_in"  value="{{ old('check_in', $checkIn) }}">
            <input type="hidden" name="check_out" value="{{ old('check_out', $checkOut) }}">
            <input type="hidden" name="guests"    value="{{ old('guests', $guests) }}">

            {{-- ===== COLONNE FORMULAIRE ===== --}}
            <div class="lg:col-span-2">

            {{-- ===== 1. COORDONNÉES ===== --}}
            <div class="bg-white rounded-2xl shadow-sm border p-6 mb-4" style="border-color: var(--color-border);">
                <h2 class="font-bold text-lg mb-5" style="color: var(--color-navy);">1. Vos coordonnées</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="guest_name" class="form-label">Nom complet <span class="text-red-500">*</span></label>
                        <input type="text" name="guest_name" id="guest_name"
                               value="{{ old('guest_name') }}"
                               placeholder="Ex : Kofi Atta"
                               class="form-input" autocomplete="name" required>
                        @error('guest_name')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="guest_phone" class="form-label">Téléphone <span class="text-red-500">*</span></label>
                        <input type="tel" name="guest_phone" id="guest_phone"
                               value="{{ old('guest_phone') }}"
                               placeholder="+225 00 00 00 00 00"
                               class="form-input" autocomplete="tel" required>
                        @error('guest_phone')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="guest_email" class="form-label">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="guest_email" id="guest_email"
                           value="{{ old('guest_email') }}"
                           placeholder="votre@email.com"
                           class="form-input" autocomplete="email" required>
                    <p class="text-xs mt-1" style="color: var(--color-slate);">La confirmation de réservation sera envoyée à cette adresse.</p>
                    @error('guest_email')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="special_requests" class="form-label">Demandes spéciales</label>
                    <textarea name="special_requests" id="special_requests" rows="3"
                              class="form-input resize-none"
                              placeholder="Lit bébé, arrivée tardive, vue préférée...">{{ old('special_requests') }}</textarea>
                </div>
            </div>

            {{-- ===== 2. CONFIRMATION ===== --}}
            <div class="bg-white rounded-2xl shadow-sm border p-6 mb-6" style="border-color: var(--color-border);">
                <h2 class="font-bold text-lg mb-5" style="color: var(--color-navy);">2. Confirmation</h2>

                {{-- Politique d'annulation --}}
                <div class="rounded-xl p-4 mb-5" style="background-color: var(--color-sky); color: #0c4a6e;">
                    <p class="font-semibold text-sm mb-1">Politique d'annulation</p>
                    <p class="text-sm">Annulation gratuite jusqu'à <strong>48h avant votre arrivée</strong>. Au-delà, une nuit de séjour vous sera facturée à l'arrivée.</p>
                    <p class="text-sm mt-2"><strong>Paiement à l'arrivée</strong> — aucun montant n'est prélevé en ligne.</p>
                </div>

                {{-- CGV --}}
                <label class="flex items-start gap-3 cursor-pointer group">
                    <input type="checkbox" name="accept_cgv" id="accept_cgv"
                           class="mt-0.5 w-4 h-4 rounded cursor-pointer"
                           style="accent-color: var(--color-orange);" required>
                    <span class="text-sm" style="color: var(--color-slate);">
                        J'ai lu et j'accepte les <a href="{{ route('legal') }}#cgv" target="_blank" class="underline transition-colors" style="color: var(--color-blue);">conditions générales de vente</a> et la <a href="{{ route('legal') }}#confidentialite" target="_blank" class="underline transition-colors" style="color: var(--color-blue);">politique de confidentialité</a> de la Résidence Hôtel Cascades. <span class="text-red-500">*</span>
                    </span>
                </label>
            </div>

            {{-- Bouton --}}
            <button type="submit" id="submit-btn"
                    class="btn-primary w-full text-base py-4"
                    onclick="this.disabled=true; this.innerHTML='Confirmation en cours...'; this.form.submit();">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Confirmer ma réservation
            </button>
            <p class="text-center text-xs mt-3" style="color: var(--color-slate);">
                Confirmation instantanée par email · Aucun prépaiement
            </p>
            </div>

            {{-- ===== COLONNE RÉCAP (sticky, verrouillée) ===== --}}
            <aside class="order-first lg:order-last lg:sticky lg:top-24 space-y-4">
                <div class="bg-white rounded-2xl shadow-sm border overflow-hidden" style="border-color: var(--color-border);">
                    <img src="{{ asset($room->first_image) }}" alt="{{ $room->name }}" class="w-full aspect-[16/9] object-cover">
                    <div class="p-5">
                        <div class="flex items-start justify-between gap-3 mb-1">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wide mb-1" style="color: var(--color-orange);">Votre séjour</p>
                                <h3 class="font-bold text-lg leading-tight" style="color: var(--color-navy);">{{ $room->name }}</h3>
                            </div>
                            <a href="{{ route('rooms.show', $room->slug) }}?check_in={{ $checkIn }}&check_out={{ $checkOut }}"
                               class="text-xs font-medium underline shrink-0 mt-1 transition-colors" style="color: var(--color-blue);">
                                Modifier
                            </a>
                        </div>
                        <p class="text-sm mb-4" style="color: var(--color-slate);">
                            {{ $guests }} voyageur{{ $guests > 1 ? 's' : '' }} &middot; Vue {{ mb_strtolower($room->view_label) }}
                        </p>

                        <div class="grid grid-cols-2 border-t border-b py-3 mb-4 text-sm" style="border-color: var(--color-border);">
                            <div>
                                <div class="text-[10px] font-bold uppercase tracking-wide" style="color: var(--color-slate);">Arrivée</div>
                                <div class="font-semibold" style="color: var(--color-navy);">{{ \Carbon\Carbon::parse($checkIn)->translatedFormat('D d M Y') }}</div>
                            </div>
                            <div class="border-l pl-4" style="border-color: var(--color-border);">
                                <div class="text-[10px] font-bold uppercase tracking-wide" style="color: var(--color-slate);">Départ</div>
                                <div class="font-semibold" style="color: var(--color-navy);">{{ \Carbon\Carbon::parse($checkOut)->translatedFormat('D d M Y') }}</div>
                            </div>
                        </div>

                        <div class="flex justify-between text-sm mb-2" style="color: var(--color-navy);">
                            <span class="underline">{{ number_format($room->price_per_night, 0, ',', ' ') }} FCFA × {{ $nights }} nuit{{ $nights > 1 ? 's' : '' }}</span>
                            <span>{{ number_format($basePrice, 0, ',', ' ') }} FCFA</span>
                        </div>
                        @if ($adjustment !== 0)
                        <div class="flex justify-between text-sm mb-2" style="color: {{ $adjustment > 0 ? 'var(--color-navy)' : '#16a34a' }};">
                            <span class="underline">{{ $adjustment > 0 ? 'Ajustement haute saison' : 'Réduction basse saison' }}</span>
                            <span>{{ $adjustment > 0 ? '+' : '−' }}{{ number_format(abs($adjustment), 0, ',', ' ') }} FCFA</span>
                        </div>
                        @endif
                        <div class="flex justify-between font-bold text-base border-t pt-3" style="border-color: var(--color-border); color: var(--color-navy);">
                            <span>Total</span>
                            <span>{{ number_format($totalPrice, 0, ',', ' ') }} FCFA</span>
                        </div>
                        <p class="text-xs mt-1.5" style="color: var(--color-slate);">Payé en intégralité à l'arrivée</p>
                    </div>
                </div>

                {{-- Réassurance --}}
                <div class="rounded-2xl p-5 space-y-2.5 text-sm" style="background-color: #f0fdf4; border: 1px solid #bbf7d0;">
                    @foreach ([
                        'Annulation gratuite jusqu\'à 48h avant l\'arrivée',
                        'Aucun prépaiement — paiement à l\'arrivée',
                        'Confirmation immédiate par email',
                    ] as $reassurance)
                    <div class="flex items-start gap-2 text-green-800">
                        <svg class="w-4 h-4 shrink-0 mt-0.5 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        {{ $reassurance }}
                    </div>
                    @endforeach
                </div>
            </aside>
        </form>
    </div>
</div>

@endsection
