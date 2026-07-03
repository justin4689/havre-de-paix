@extends('layouts.app')
@section('title', 'À Propos — Havre de Paix Assinie')
@section('description', 'Découvrez l\'histoire du Havre de Paix, résidence-hôtel à Assinie Km 18,75, entre mer et lagune en Côte d\'Ivoire.')
@section('content')
<div class="pt-20">
    <div class="py-20 text-center" style="background-color: var(--color-navy);">
        <h1 class="text-4xl sm:text-5xl font-bold text-white mb-4" style="font-family: var(--font-serif);">À Propos</h1>
        <p style="color: rgba(255,255,255,0.7);">Notre histoire et notre vision</p>
    </div>
    <div class="max-w-4xl mx-auto px-4 py-20 sm:px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-16">
            <div>
                <p class="text-sm font-semibold uppercase tracking-widest mb-3" style="color: var(--color-orange);">Notre histoire</p>
                <h2 class="section-title mb-4">Un refuge entre deux eaux</h2>
                <p class="leading-relaxed mb-4" style="color: var(--color-slate);">
                    Niché au cœur d'Assinie au Kilomètre 18,75, le Havre de Paix est né d'une vision simple : offrir un espace de sérénité authentique entre l'océan Atlantique et la lagune Aby.
                </p>
                <p class="leading-relaxed" style="color: var(--color-slate);">
                    À seulement 94 km d'Abidjan, notre résidence-hôtel accueille familles, couples et professionnels en quête d'un cadre naturel exceptionnel, loin de l'agitation de la ville.
                </p>
            </div>
            <div class="aspect-square rounded-2xl overflow-hidden shadow-xl">
                <img src="{{ asset('images/about.jpg') }}" alt="Havre de Paix" class="w-full h-full object-cover" loading="lazy">
            </div>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 mb-16">
            @foreach ([['5', 'Types de chambres'], ['94km', "D'Abidjan"], ['2', 'Accès direct plage & lagune'], ['24/7', 'Réservation en ligne']] as [$val, $label])
            <div class="text-center p-6 rounded-2xl" style="background-color: var(--color-snow);">
                <div class="text-3xl font-bold mb-2" style="color: var(--color-orange); font-family: var(--font-serif);">{{ $val }}</div>
                <div class="text-sm" style="color: var(--color-slate);">{{ $label }}</div>
            </div>
            @endforeach
        </div>
        <div class="text-center">
            <a href="{{ route('reservation.index') }}" class="btn-primary text-base px-10 py-4">Réserver votre séjour</a>
        </div>
    </div>
</div>
@endsection
