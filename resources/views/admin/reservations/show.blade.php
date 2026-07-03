@extends('layouts.admin')
@section('page-title', 'Réservation ' . $reservation->ref)

@section('content')

<div class="mb-5">
    <a href="{{ route('admin.reservations.index') }}" class="text-sm flex items-center gap-1" style="color: var(--color-blue);">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Retour aux réservations
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Détails principaux --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- En-tête --}}
        <div class="bg-white rounded-xl border shadow-sm p-6" style="border-color: var(--color-border);">
            <div class="flex items-start justify-between flex-wrap gap-4">
                <div>
                    <p class="text-xs font-mono font-semibold mb-1" style="color: var(--color-orange);">{{ $reservation->ref }}</p>
                    <h2 class="text-xl font-bold" style="color: var(--color-navy); font-family: var(--font-serif);">{{ $reservation->guest_name }}</h2>
                    <p class="text-sm mt-1" style="color: var(--color-slate);">{{ $reservation->guest_email }}</p>
                    <p class="text-sm" style="color: var(--color-slate);">{{ $reservation->guest_phone }}</p>
                </div>
                <span class="px-3 py-1.5 rounded-full text-sm font-semibold
                    {{ $reservation->status === 'confirmed' ? 'bg-green-100 text-green-700' : ($reservation->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                    {{ $reservation->status_label }}
                </span>
            </div>
        </div>

        {{-- Séjour --}}
        <div class="bg-white rounded-xl border shadow-sm p-6" style="border-color: var(--color-border);">
            <h3 class="font-semibold mb-4" style="color: var(--color-navy);">Détails du séjour</h3>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide mb-1" style="color: var(--color-slate);">Chambre</p>
                    <p class="font-medium" style="color: var(--color-navy);">
                        <a href="{{ route('admin.rooms.edit', $reservation->room) }}" style="color: var(--color-blue);">{{ $reservation->room->name }}</a>
                    </p>
                </div>
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide mb-1" style="color: var(--color-slate);">Voyageurs</p>
                    <p class="font-medium" style="color: var(--color-navy);">{{ $reservation->guests }} personne(s)</p>
                </div>
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide mb-1" style="color: var(--color-slate);">Arrivée</p>
                    <p class="font-medium" style="color: var(--color-navy);">{{ $reservation->check_in->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide mb-1" style="color: var(--color-slate);">Départ</p>
                    <p class="font-medium" style="color: var(--color-navy);">{{ $reservation->check_out->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide mb-1" style="color: var(--color-slate);">Durée</p>
                    <p class="font-medium" style="color: var(--color-navy);">{{ $reservation->nights }} nuit(s)</p>
                </div>
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide mb-1" style="color: var(--color-slate);">Montant total</p>
                    <p class="font-bold text-base" style="color: var(--color-orange);">{{ number_format($reservation->total_price, 0, ',', ' ') }} FCFA</p>
                </div>
            </div>
            @if ($reservation->special_requests)
            <div class="mt-4 pt-4" style="border-top: 1px solid var(--color-border);">
                <p class="text-xs font-medium uppercase tracking-wide mb-1" style="color: var(--color-slate);">Demandes spéciales</p>
                <p class="text-sm" style="color: var(--color-navy);">{{ $reservation->special_requests }}</p>
            </div>
            @endif
        </div>

        {{-- Modifier le statut --}}
        @if (auth()->user()->isAdmin())
        <div class="bg-white rounded-xl border shadow-sm p-6" style="border-color: var(--color-border);">
            <h3 class="font-semibold mb-4" style="color: var(--color-navy);">Modifier la réservation</h3>
            <form action="{{ route('admin.reservations.update', $reservation) }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Statut</label>
                        <select name="status" class="form-input text-sm">
                            <option value="confirmed" {{ $reservation->status === 'confirmed' ? 'selected' : '' }}>Confirmée</option>
                            <option value="modified" {{ $reservation->status === 'modified' ? 'selected' : '' }}>Modifiée</option>
                            <option value="cancelled" {{ $reservation->status === 'cancelled' ? 'selected' : '' }}>Annulée</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Arrivée</label>
                        <input type="date" name="check_in" value="{{ $reservation->check_in->format('Y-m-d') }}" class="form-input text-sm">
                    </div>
                    <div>
                        <label class="form-label">Départ</label>
                        <input type="date" name="check_out" value="{{ $reservation->check_out->format('Y-m-d') }}" class="form-input text-sm">
                    </div>
                </div>
                <button type="submit" class="btn-primary text-sm">Enregistrer les modifications</button>
            </form>
        </div>
        @endif

    </div>

    {{-- Colonne droite --}}
    <div class="space-y-5">

        {{-- Infos techniques --}}
        <div class="bg-white rounded-xl border shadow-sm p-5" style="border-color: var(--color-border);">
            <h3 class="font-semibold mb-3 text-sm" style="color: var(--color-navy);">Informations système</h3>
            <div class="space-y-2 text-xs" style="color: var(--color-slate);">
                <div class="flex justify-between">
                    <span>Créée le</span>
                    <span class="font-medium" style="color: var(--color-navy);">{{ $reservation->created_at->format('d/m/Y à H:i') }}</span>
                </div>
                @if ($reservation->cancelled_at)
                <div class="flex justify-between">
                    <span>Annulée le</span>
                    <span class="font-medium text-red-600">{{ $reservation->cancelled_at->format('d/m/Y à H:i') }}</span>
                </div>
                @endif
            </div>
        </div>

        {{-- Chambre aperçu --}}
        <div class="bg-white rounded-xl border shadow-sm overflow-hidden" style="border-color: var(--color-border);">
            @if ($reservation->room->first_image)
            <img src="{{ asset($reservation->room->first_image) }}" alt="{{ $reservation->room->name }}" class="w-full h-36 object-cover">
            @else
            <div class="w-full h-36 flex items-center justify-center" style="background-color: var(--color-snow);">
                <svg class="w-10 h-10" style="color: var(--color-border);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            @endif
            <div class="p-4">
                <p class="font-semibold text-sm" style="color: var(--color-navy);">{{ $reservation->room->name }}</p>
                <p class="text-xs mt-0.5" style="color: var(--color-slate);">{{ $reservation->room->capacity_adults }} adultes · {{ $reservation->room->size_m2 }} m² · {{ $reservation->room->view_label }}</p>
                <p class="text-sm font-bold mt-2" style="color: var(--color-orange);">{{ number_format($reservation->room->price_per_night, 0, ',', ' ') }} FCFA / nuit</p>
            </div>
        </div>

    </div>

</div>

@endsection
