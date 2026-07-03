@extends('layouts.app')
@section('title', 'Annulation refusée')
@section('content')
<div class="pt-24 pb-20 min-h-screen flex items-center justify-center px-4" style="background-color: var(--color-snow);">
    <div class="max-w-md w-full text-center">
        <div class="w-16 h-16 rounded-full mx-auto mb-4 flex items-center justify-center" style="background-color: #fef3c7;">
            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
        <h1 class="text-2xl font-bold mb-2" style="font-family: var(--font-serif); color: var(--color-navy);">Annulation non possible</h1>
        <p class="mb-2" style="color: var(--color-slate);">La réservation <strong>{{ $reservation->ref }}</strong> ne peut plus être annulée gratuitement.</p>
        <p class="text-sm mb-8" style="color: var(--color-slate);">L'annulation gratuite est possible jusqu'à 48h avant l'arrivée. Contactez-nous directement pour toute demande.</p>
        <a href="{{ route('contact') }}" class="btn-primary">Nous contacter</a>
    </div>
</div>
@endsection
