@extends('layouts.app')
@section('title', 'Galerie — Havre de Paix Assinie')
@section('content')
<div class="pt-20">
    <div class="py-16 text-center" style="background-color: var(--color-navy);">
        <h1 class="text-4xl sm:text-5xl font-bold text-white mb-3" style="font-family: var(--font-serif);">Galerie</h1>
        <p style="color: rgba(255,255,255,0.7);">Découvrez notre cadre tropical en images</p>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-16">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
            @foreach ([
                ['images/gallery/pool.jpg', 'Piscine'],
                ['images/gallery/beach.jpg', 'Plage privée'],
                ['images/gallery/room1.jpg', 'Chambre Standard'],
                ['images/gallery/lagoon.jpg', 'Lagune'],
                ['images/gallery/suite.jpg', 'Suite Junior'],
                ['images/gallery/restaurant.jpg', 'Restaurant'],
                ['images/gallery/sunset.jpg', 'Coucher de soleil'],
                ['images/gallery/exterior.jpg', 'Vue extérieure'],
            ] as [$img, $alt])
            <div class="aspect-square rounded-xl overflow-hidden group cursor-pointer">
                <img src="{{ asset($img) }}" alt="{{ $alt }}"
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                     loading="lazy">
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
