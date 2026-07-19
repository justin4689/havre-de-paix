@extends('layouts.app')

@section('title', 'Retrouver ma réservation — Havre de Paix Assinie')
@section('description', 'Consultez ou annulez votre réservation au Havre de Paix avec votre référence (HDP-AAAA-XXXX) et votre email.')

@section('content')
<div class="pt-24 pb-20 min-h-screen px-4 sm:px-6" style="background-color: var(--color-snow);">
    <div class="max-w-md mx-auto">

        <div class="text-center mb-8">
            <div class="w-14 h-14 rounded-full mx-auto mb-4 flex items-center justify-center" style="background-color: var(--color-sand);">
                <svg class="w-7 h-7" style="color: #9A3412;" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <h1 class="text-3xl font-bold tracking-tight mb-2" style="color: var(--color-navy);">Retrouver ma réservation</h1>
            <p class="text-sm" style="color: var(--color-slate);">
                Saisissez la référence reçue dans votre email de confirmation et l'adresse email utilisée lors de la réservation.
            </p>
        </div>

        <form action="{{ route('reservation.lookup.submit') }}" method="POST"
              class="bg-white rounded-2xl shadow-sm border p-6" style="border-color: var(--color-border);">
            @csrf

            <div class="mb-4">
                <label for="ref" class="form-label">Référence de réservation <span class="text-red-500">*</span></label>
                <input type="text" name="ref" id="ref"
                       value="{{ old('ref') }}"
                       placeholder="HDP-{{ date('Y') }}-0001"
                       class="form-input uppercase"
                       autocomplete="off" required>
                @error('ref')<p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>@enderror
            </div>

            <div class="mb-6">
                <label for="email" class="form-label">Email de la réservation <span class="text-red-500">*</span></label>
                <input type="email" name="email" id="email"
                       value="{{ old('email') }}"
                       placeholder="votre@email.com"
                       class="form-input"
                       autocomplete="email" required>
                @error('email')<p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="btn-primary w-full py-3.5">
                Retrouver ma réservation
            </button>
        </form>

        <p class="text-center text-xs mt-5 leading-relaxed" style="color: var(--color-slate);">
            Référence introuvable ? Elle figure dans l'objet de votre email de confirmation (format HDP-AAAA-XXXX).<br>
            Besoin d'aide ? <a href="{{ route('contact') }}" class="underline" style="color: var(--color-blue);">Contactez la réception</a>.
        </p>
    </div>
</div>
@endsection
