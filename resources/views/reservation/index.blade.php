@extends('layouts.app')

@section('title', 'Réserver — Havre de Paix Assinie')

@section('content')
<div class="pt-24 pb-20 min-h-screen px-4 sm:px-6 lg:px-8" style="background-color: var(--color-snow);">
    <div class="max-w-2xl mx-auto">

        {{-- Étapes --}}
        <div class="flex items-center justify-center gap-4 mb-10" x-data="{ step: 1 }" id="steps-indicator">
            @foreach ([1 => 'Récapitulatif', 2 => 'Coordonnées', 3 => 'Confirmation'] as $n => $label)
            <div class="flex items-center gap-2">
                <div class="step-dot {{ $n === 1 ? 'active' : '' }}" id="step-dot-{{ $n }}">{{ $n }}</div>
                <span class="text-sm font-medium hidden sm:block" id="step-label-{{ $n }}"
                      style="{{ $n === 1 ? 'color: var(--color-orange);' : 'color: var(--color-slate);' }}">
                    {{ $label }}
                </span>
            </div>
            @if ($n < 3)
            <div class="flex-1 h-px max-w-12" id="step-line-{{ $n }}" style="background-color: var(--color-border);"></div>
            @endif
            @endforeach
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

        <form action="{{ route('reservation.store') }}" method="POST" id="booking-form"
              x-data="reservationForm()" novalidate>
            @csrf

            {{-- ===== ÉTAPE 1 : RÉCAPITULATIF ===== --}}
            <div id="step-1" class="bg-white rounded-2xl shadow-sm border p-6 mb-4" style="border-color: var(--color-border);">
                <h2 class="font-semibold text-lg mb-5" style="color: var(--color-navy); font-family: var(--font-serif);">
                    1. Votre séjour
                </h2>

                {{-- Chambre --}}
                <div class="mb-5">
                    <label for="room_id" class="form-label">Chambre <span class="text-red-500">*</span></label>
                    <select name="room_id" id="room_id" class="form-input" x-model="roomId" @change="updatePrice()" required>
                        <option value="">Sélectionner une chambre...</option>
                        @foreach (\App\Models\Room::where('status', 'active')->orderBy('price_per_night')->get() as $r)
                        <option value="{{ $r->id }}"
                                data-price="{{ $r->price_per_night }}"
                                {{ (old('room_id', $room?->id) == $r->id) ? 'selected' : '' }}>
                            {{ $r->name }} — {{ number_format($r->price_per_night, 0, ',', ' ') }} FCFA/nuit
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Dates --}}
                <div class="grid grid-cols-2 gap-3 mb-5">
                    <div>
                        <label for="check_in" class="form-label">Arrivée <span class="text-red-500">*</span></label>
                        <input type="date" name="check_in" id="check_in"
                               x-model="checkIn" @change="updatePrice()"
                               min="{{ date('Y-m-d') }}"
                               value="{{ old('check_in', $checkIn) }}"
                               class="form-input" required>
                        @error('check_in')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="check_out" class="form-label">Départ <span class="text-red-500">*</span></label>
                        <input type="date" name="check_out" id="check_out"
                               x-model="checkOut" @change="updatePrice()"
                               :min="minCheckOut"
                               value="{{ old('check_out', $checkOut) }}"
                               class="form-input" required>
                    </div>
                </div>

                <div class="mb-5">
                    <label for="guests" class="form-label">Nombre de personnes <span class="text-red-500">*</span></label>
                    <select name="guests" id="guests" class="form-input" required>
                        @for ($i = 1; $i <= 8; $i++)
                        <option value="{{ $i }}" {{ old('guests', $guests) == $i ? 'selected' : '' }}>{{ $i }} {{ $i > 1 ? 'personnes' : 'personne' }}</option>
                        @endfor
                    </select>
                </div>

                {{-- Total prix --}}
                <div x-show="nights > 0" class="rounded-xl p-4" style="background-color: var(--color-snow);">
                    <div class="flex justify-between text-sm mb-2" style="color: var(--color-slate);">
                        <span x-text="pricePerNight.toLocaleString('fr-FR') + ' FCFA × ' + nights + ' nuit(s)'"></span>
                        <span x-text="total.toLocaleString('fr-FR') + ' FCFA'"></span>
                    </div>
                    <div class="flex justify-between font-semibold text-base border-t pt-2" style="border-color: var(--color-border); color: var(--color-navy);">
                        <span>Total séjour</span>
                        <span x-text="total.toLocaleString('fr-FR') + ' FCFA'" style="color: var(--color-orange);"></span>
                    </div>
                </div>
            </div>

            {{-- ===== ÉTAPE 2 : COORDONNÉES ===== --}}
            <div id="step-2" class="bg-white rounded-2xl shadow-sm border p-6 mb-4" style="border-color: var(--color-border);">
                <h2 class="font-semibold text-lg mb-5" style="color: var(--color-navy); font-family: var(--font-serif);">
                    2. Vos coordonnées
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="guest_name" class="form-label">Nom complet <span class="text-red-500">*</span></label>
                        <input type="text" name="guest_name" id="guest_name"
                               value="{{ old('guest_name') }}"
                               placeholder="Ex : Kofi Atta"
                               class="form-input" autocomplete="name" required>
                    </div>
                    <div>
                        <label for="guest_phone" class="form-label">Téléphone <span class="text-red-500">*</span></label>
                        <input type="tel" name="guest_phone" id="guest_phone"
                               value="{{ old('guest_phone') }}"
                               placeholder="+225 00 00 00 00 00"
                               class="form-input" autocomplete="tel" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="guest_email" class="form-label">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="guest_email" id="guest_email"
                           value="{{ old('guest_email') }}"
                           placeholder="votre@email.com"
                           class="form-input" autocomplete="email" required>
                    <p class="text-xs mt-1" style="color: var(--color-slate);">La confirmation de réservation sera envoyée à cette adresse.</p>
                </div>

                <div>
                    <label for="special_requests" class="form-label">Demandes spéciales</label>
                    <textarea name="special_requests" id="special_requests" rows="3"
                              class="form-input resize-none"
                              placeholder="Lit bébé, arrivée tardive, vue préférée...">{{ old('special_requests') }}</textarea>
                </div>
            </div>

            {{-- ===== ÉTAPE 3 : CONFIRMATION ===== --}}
            <div id="step-3" class="bg-white rounded-2xl shadow-sm border p-6 mb-6" style="border-color: var(--color-border);">
                <h2 class="font-semibold text-lg mb-5" style="color: var(--color-navy); font-family: var(--font-serif);">
                    3. Confirmation
                </h2>

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
                        J'ai lu et j'accepte les <a href="{{ route('legal') }}" target="_blank" class="underline transition-colors" style="color: var(--color-blue);">conditions générales de vente</a> et la politique de confidentialité du Havre de Paix. <span class="text-red-500">*</span>
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
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function reservationForm() {
    return {
        roomId:       '{{ old("room_id", $room?->id) }}',
        checkIn:      '{{ old("check_in", $checkIn) }}',
        checkOut:     '{{ old("check_out", $checkOut) }}',
        pricePerNight: {{ $room?->price_per_night ?? 0 }},
        nights:       0,
        total:        0,
        get minCheckOut() {
            if (!this.checkIn) return '';
            const d = new Date(this.checkIn);
            d.setDate(d.getDate() + 1);
            return d.toISOString().split('T')[0];
        },
        updatePrice() {
            if (!this.checkIn || !this.checkOut) { this.nights = 0; return; }
            const ms = new Date(this.checkOut) - new Date(this.checkIn);
            this.nights = ms > 0 ? Math.round(ms / 86400000) : 0;

            // Récupérer prix depuis le select
            const sel = document.getElementById('room_id');
            if (sel && sel.selectedOptions[0]) {
                this.pricePerNight = parseInt(sel.selectedOptions[0].dataset.price || 0);
            }
            this.total = this.nights * this.pricePerNight;
        },
        init() { this.updatePrice(); }
    };
}
</script>
@endpush
