@extends('layouts.admin')
@section('page-title', 'Nouvelle réservation manuelle')

@section('content')

<div class="mb-5">
    <a href="{{ route('admin.reservations.index') }}" class="text-sm flex items-center gap-1" style="color: var(--color-blue);">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Retour
    </a>
</div>

<div class="max-w-2xl">
    <div class="bg-white rounded-xl border shadow-sm p-6" style="border-color: var(--color-border);">
        <h2 class="text-lg font-semibold mb-6" style="color: var(--color-navy);">Créer une réservation</h2>

        @if ($errors->any())
        <div class="mb-5 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
            <ul class="space-y-1 list-disc list-inside">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.reservations.store') }}" method="POST" class="space-y-5">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Chambre <span class="text-red-500">*</span></label>
                    <select name="room_id" class="form-input" required>
                        <option value="">Sélectionner une chambre</option>
                        @foreach ($rooms as $room)
                        <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                            {{ $room->name }} — {{ number_format($room->price_per_night, 0, ',', ' ') }} FCFA/nuit
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Nb de voyageurs <span class="text-red-500">*</span></label>
                    <input type="number" name="guests" value="{{ old('guests', 1) }}" min="1" max="10" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">Arrivée <span class="text-red-500">*</span></label>
                    <input type="date" name="check_in" value="{{ old('check_in') }}" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">Départ <span class="text-red-500">*</span></label>
                    <input type="date" name="check_out" value="{{ old('check_out') }}" class="form-input" required>
                </div>
            </div>

            <hr style="border-color: var(--color-border);">
            <h3 class="font-medium text-sm" style="color: var(--color-navy);">Informations client</h3>

            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="form-label">Nom complet <span class="text-red-500">*</span></label>
                    <input type="text" name="guest_name" value="{{ old('guest_name') }}" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="guest_email" value="{{ old('guest_email') }}" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">Téléphone <span class="text-red-500">*</span></label>
                    <input type="tel" name="guest_phone" value="{{ old('guest_phone') }}" class="form-input" required>
                </div>
                <div class="col-span-2">
                    <label class="form-label">Demandes spéciales</label>
                    <textarea name="special_requests" rows="3" class="form-input resize-none">{{ old('special_requests') }}</textarea>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">Créer la réservation</button>
                <a href="{{ route('admin.reservations.index') }}" class="btn-outline">Annuler</a>
            </div>
        </form>
    </div>
</div>

@endsection
