@extends('layouts.app')
@section('title', 'Réservation annulée — ' . $reservation->ref)
@section('content')
<div class="pt-24 pb-20 min-h-screen flex items-center justify-center px-4" style="background-color: var(--color-snow);">
    <div class="max-w-md w-full text-center">
        <div class="w-16 h-16 rounded-full mx-auto mb-4 flex items-center justify-center" style="background-color: #fee2e2;">
            <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </div>
        <h1 class="text-2xl font-bold mb-2" style="font-family: var(--font-serif); color: var(--color-navy);">Réservation annulée</h1>
        <p class="mb-2" style="color: var(--color-slate);">La réservation <strong>{{ $reservation->ref }}</strong> a bien été annulée.</p>
        <p class="text-sm mb-8" style="color: var(--color-slate);">Un email de confirmation vous a été envoyé.</p>
        <a href="{{ route('rooms.index') }}" class="btn-primary">Réserver à nouveau</a>
    </div>
</div>
@endsection
