@extends('layouts.app')

@section('title', 'Nos Chambres & Suites — Havre de Paix Assinie')
@section('description', 'Découvrez nos chambres et suites avec vue mer, lagune ou jardin à Assinie. Réservez en ligne avec confirmation instantanée.')

@section('content')

<div class="pt-20" style="background-color: var(--color-snow);">

    {{-- Header --}}
    <div class="py-14 px-4 sm:px-6 lg:px-8 text-center" style="background-color: var(--color-navy);">
        <p class="text-sm font-semibold uppercase tracking-widest mb-3" style="color: var(--color-orange);">Hébergement</p>
        <h1 class="text-4xl sm:text-5xl font-bold text-white mb-4" style="font-family: var(--font-serif);">Nos Chambres & Suites</h1>
        <p class="max-w-xl mx-auto" style="color: rgba(255,255,255,0.7);">
            Du confort standard à la suite présidentielle — chaque hébergement offre un cadre tropical unique entre mer et lagune.
        </p>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Filtres + dates --}}
        <div class="bg-white rounded-2xl shadow-sm border p-5 mb-8" style="border-color: var(--color-border);">
            <form action="{{ route('rooms.index') }}" method="GET" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
                <div>
                    <label class="form-label text-xs">Arrivée</label>
                    <input type="date" name="check_in" value="{{ $checkIn }}" min="{{ date('Y-m-d') }}" class="form-input text-sm">
                </div>
                <div>
                    <label class="form-label text-xs">Départ</label>
                    <input type="date" name="check_out" value="{{ $checkOut }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="form-input text-sm">
                </div>
                <div>
                    <label class="form-label text-xs">Personnes</label>
                    <select name="capacity" class="form-input text-sm">
                        <option value="">Toutes</option>
                        @for ($i = 1; $i <= 6; $i++)
                        <option value="{{ $i }}" {{ request('capacity') == $i ? 'selected' : '' }}>{{ $i }} pers.</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="form-label text-xs">Vue</label>
                    <select name="view" class="form-input text-sm">
                        <option value="">Toutes</option>
                        <option value="sea" {{ request('view') === 'sea' ? 'selected' : '' }}>Mer</option>
                        <option value="lagoon" {{ request('view') === 'lagoon' ? 'selected' : '' }}>Lagune</option>
                        <option value="pool" {{ request('view') === 'pool' ? 'selected' : '' }}>Piscine</option>
                        <option value="garden" {{ request('view') === 'garden' ? 'selected' : '' }}>Jardin</option>
                    </select>
                </div>
                <div>
                    <label class="form-label text-xs">Prix max / nuit</label>
                    <select name="price_max" class="form-input text-sm">
                        <option value="">Tous</option>
                        <option value="50000" {{ request('price_max') == 50000 ? 'selected' : '' }}>50 000 FCFA</option>
                        <option value="100000" {{ request('price_max') == 100000 ? 'selected' : '' }}>100 000 FCFA</option>
                        <option value="200000" {{ request('price_max') == 200000 ? 'selected' : '' }}>200 000 FCFA</option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="btn-primary flex-1 text-sm py-2.5">Filtrer</button>
                    <a href="{{ route('rooms.index') }}" class="btn-outline text-sm py-2.5 px-3">✕</a>
                </div>
            </form>
        </div>

        {{-- Résultats --}}
        @if ($checkIn && $checkOut)
        <div class="mb-6 flex items-center gap-2 text-sm" style="color: var(--color-slate);">
            <svg class="w-4 h-4" style="color: var(--color-orange);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span><strong>{{ $rooms->count() }}</strong> chambre(s) disponible(s) du {{ \Carbon\Carbon::parse($checkIn)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($checkOut)->format('d/m/Y') }}</span>
        </div>
        @endif

        {{-- Grille chambres --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($rooms as $room)
            <article class="card group">
                <div class="relative aspect-[4/3] overflow-hidden">
                    <img src="{{ asset($room->first_image) }}"
                         alt="{{ $room->name }}"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                         loading="lazy" width="400" height="300">
                    <div class="absolute top-3 left-3 flex gap-2">
                        <span class="badge">{{ $room->view_label }}</span>
                        @if ($rooms->count() <= 2 && $checkIn)
                        <span class="badge-orange">Dernières dispo.</span>
                        @endif
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-black/50 to-transparent"></div>
                </div>

                <div class="p-5">
                    <div class="flex items-start justify-between gap-2 mb-2">
                        <h2 class="font-semibold text-lg leading-tight" style="color: var(--color-navy); font-family: var(--font-serif);">{{ $room->name }}</h2>
                        <span class="text-xs px-2 py-1 rounded-full shrink-0" style="background-color: var(--color-sky); color: #075985;">
                            {{ $room->capacity_adults }} pers.
                        </span>
                    </div>

                    <p class="text-sm mb-4 line-clamp-2" style="color: var(--color-slate);">{{ $room->description_short }}</p>

                    {{-- Détails --}}
                    <div class="grid grid-cols-2 gap-2 mb-4 text-xs" style="color: var(--color-slate);">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 shrink-0" style="color: var(--color-orange);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/></svg>
                            {{ $room->bed_type_label }}
                        </div>
                        @if ($room->size_m2)
                        <div class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 shrink-0" style="color: var(--color-orange);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                            {{ $room->size_m2 }} m²
                        </div>
                        @endif
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t" style="border-color: var(--color-border);">
                        <div>
                            <div class="price-tag">{{ number_format($room->price_per_night, 0, ',', ' ') }}</div>
                            <div class="text-xs" style="color: var(--color-slate);">FCFA / nuit</div>
                        </div>
                        <a href="{{ route('rooms.show', $room->slug) }}{{ $checkIn ? '?check_in='.$checkIn.'&check_out='.$checkOut : '' }}"
                           class="btn-primary text-sm py-2 px-4">
                            Voir & Réserver
                        </a>
                    </div>
                </div>
            </article>
            @empty
            <div class="col-span-3 text-center py-20">
                <svg class="w-16 h-16 mx-auto mb-4" style="color: var(--color-border);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <h3 class="text-xl font-semibold mb-2" style="color: var(--color-navy);">Aucune chambre disponible</h3>
                <p class="mb-6" style="color: var(--color-slate);">Essayez d'autres dates ou critères.</p>
                <a href="{{ route('rooms.index') }}" class="btn-primary">Voir toutes les chambres</a>
            </div>
            @endforelse
        </div>
    </div>
</div>

@endsection
