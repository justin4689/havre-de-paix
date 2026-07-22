@extends('layouts.app')

@section('title', 'Nos Chambres & Suites — Résidence Hôtel Cascades')
@section('description', 'Découvrez nos chambres et suites avec vue mer, lagune ou jardin à Abidjan. Réservez en ligne avec confirmation instantanée.')
@section('hero_nav', '1')

@section('content')

<div style="background-color: var(--color-snow);">

    {{-- Header --}}
    <div class="relative flex items-center justify-center text-center h-[60vh] min-h-[420px] px-4 sm:px-6 lg:px-8 overflow-hidden">
        <img src="{{ asset('images/rooms-hero.jpg') }}" alt="Chambre de la Résidence Hôtel Cascades"
             class="absolute inset-0 w-full h-full object-cover" loading="eager">
        <div class="absolute inset-0 hero-overlay"></div>
        <div class="relative z-10 pt-16">
            <p class="text-sm font-semibold uppercase tracking-widest mb-3" style="color: var(--color-orange);">Hébergement</p>
            <h1 class="text-4xl sm:text-5xl font-bold text-white mb-4" style="font-family: var(--font-serif);">Nos Chambres & Suites</h1>
            <p class="max-w-xl mx-auto" style="color: rgba(255,255,255,0.85);">
                Du confort standard à la suite présidentielle — chaque hébergement offre un cadre tropical unique au cœur de Cocody.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        @if (session('info'))
        <div class="mb-6 p-4 rounded-xl text-sm flex items-center gap-3" style="background-color: var(--color-sky); color: #0c4a6e;">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('info') }}
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">

            {{-- ===== FILTRES (colonne gauche) ===== --}}
            <aside class="lg:sticky lg:top-24">
                <form action="{{ route('rooms.index') }}" method="GET" class="space-y-4">
                    <input type="hidden" name="sort" value="{{ request('sort', 'price_asc') }}">

                    {{-- Votre séjour --}}
                    <div class="rounded-2xl shadow-sm overflow-hidden border" style="border-color: var(--color-border);">
                        <div class="px-5 py-3" style="background-color: var(--color-navy);">
                            <h2 class="text-sm font-bold text-white flex items-center gap-2">
                                <svg class="w-4 h-4" style="color: var(--color-orange);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Votre séjour
                            </h2>
                        </div>
                        <div class="bg-white p-4 space-y-3">
                            <div>
                                <label class="form-label text-xs">Arrivée</label>
                                <input type="date" name="check_in" value="{{ $checkIn }}" min="{{ date('Y-m-d') }}" class="form-input text-sm">
                            </div>
                            <div>
                                <label class="form-label text-xs">Départ</label>
                                <input type="date" name="check_out" value="{{ $checkOut }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="form-input text-sm">
                            </div>
                            <div>
                                <label class="form-label text-xs">Voyageurs</label>
                                <select name="capacity" class="form-input text-sm">
                                    <option value="">Tous</option>
                                    @for ($i = 1; $i <= 6; $i++)
                                    <option value="{{ $i }}" {{ request('capacity') == $i ? 'selected' : '' }}>{{ $i }} voyageur{{ $i > 1 ? 's' : '' }}</option>
                                    @endfor
                                </select>
                            </div>
                            <button type="submit" class="btn-primary w-full text-sm py-2.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                Rechercher
                            </button>
                        </div>
                    </div>

                    {{-- Filtrer par --}}
                    <div class="bg-white rounded-2xl shadow-sm border p-5" style="border-color: var(--color-border);">
                        <div class="flex items-center justify-between mb-3">
                            <h2 class="text-xs font-bold uppercase tracking-wide" style="color: var(--color-navy);">Filtrer par</h2>
                            @if (request()->hasAny(['view', 'price_max', 'capacity']))
                            <a href="{{ route('rooms.index', array_filter(['check_in' => $checkIn, 'check_out' => $checkOut, 'sort' => request('sort')])) }}"
                               class="text-xs font-medium underline transition-colors" style="color: var(--color-blue);">
                                Tout effacer
                            </a>
                            @endif
                        </div>

                        {{-- Vue --}}
                        <p class="text-sm font-semibold mb-1" style="color: var(--color-navy);">Vue</p>
                        @foreach (['sea' => 'Mer', 'lagoon' => 'Lagune', 'pool' => 'Piscine', 'garden' => 'Jardin'] as $value => $label)
                        <label class="flex items-center justify-between py-1.5 cursor-pointer rounded-lg -mx-2 px-2 transition-colors hover:bg-slate-50">
                            <span class="flex items-center gap-2.5 text-sm" style="color: var(--color-navy);">
                                <input type="checkbox" name="view[]" value="{{ $value }}"
                                       onchange="this.form.submit()"
                                       {{ in_array($value, (array) request('view', [])) ? 'checked' : '' }}
                                       class="w-4 h-4 rounded cursor-pointer" style="accent-color: var(--color-orange);">
                                {{ $label }}
                            </span>
                            <span class="text-xs" style="color: var(--color-slate);">{{ $viewCounts[$value] ?? 0 }}</span>
                        </label>
                        @endforeach

                        {{-- Prix (curseur) --}}
                        <div class="flex items-center justify-between mb-2 mt-4 pt-4 border-t" style="border-color: var(--color-border);">
                            <p class="text-sm font-semibold" style="color: var(--color-navy);">Prix par nuit</p>
                            <span id="price-max-label" class="text-xs font-medium" style="color: var(--color-orange);">
                                {{ request('price_max') ? 'Jusqu\'à ' . number_format((int) request('price_max'), 0, ',', ' ') . ' FCFA' : 'Tous les prix' }}
                            </span>
                        </div>
                        <input type="range" name="price_max"
                               min="{{ $priceBounds['min'] }}" max="{{ $priceBounds['max'] }}" step="5000"
                               value="{{ request('price_max', $priceBounds['max']) }}"
                               oninput="document.getElementById('price-max-label').textContent = this.value == this.max ? 'Tous les prix' : 'Jusqu\'à ' + Number(this.value).toLocaleString('fr-FR') + ' FCFA'"
                               onchange="if (this.value == this.max) this.disabled = true; this.form.submit();"
                               class="w-full cursor-pointer" style="accent-color: var(--color-orange);"
                               aria-label="Prix maximum par nuit">
                        <div class="flex justify-between text-xs mt-1" style="color: var(--color-slate);">
                            <span>{{ number_format($priceBounds['min'], 0, ',', ' ') }}</span>
                            <span>{{ number_format($priceBounds['max'], 0, ',', ' ') }} FCFA</span>
                        </div>
                    </div>
                </form>
            </aside>

            {{-- ===== RÉSULTATS (colonne droite) ===== --}}
            <div class="lg:col-span-3">

                {{-- Compteur + tri --}}
                @php $sortUrl = fn ($s) => route('rooms.index', array_merge(request()->query(), ['sort' => $s])); @endphp
                <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                    <div class="text-sm" style="color: var(--color-slate);">
                        @if ($checkIn && $checkOut)
                        <strong style="color: var(--color-navy);">{{ $rooms->total() }}</strong> chambre{{ $rooms->total() > 1 ? 's' : '' }} disponible{{ $rooms->total() > 1 ? 's' : '' }}
                        du {{ \Carbon\Carbon::parse($checkIn)->translatedFormat('d M') }} au {{ \Carbon\Carbon::parse($checkOut)->translatedFormat('d M Y') }}
                        @else
                        <strong style="color: var(--color-navy);">{{ $rooms->total() }}</strong> hébergement{{ $rooms->total() > 1 ? 's' : '' }}
                        @endif
                    </div>
                    <label class="flex items-center gap-2 text-sm" style="color: var(--color-slate);">
                        Trier :
                        <select onchange="window.location=this.value" class="form-input text-sm w-auto py-2 cursor-pointer" aria-label="Trier les chambres">
                            <option value="{{ $sortUrl('price_asc') }}" {{ request('sort', 'price_asc') === 'price_asc' ? 'selected' : '' }}>Prix croissant</option>
                            <option value="{{ $sortUrl('price_desc') }}" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
                            <option value="{{ $sortUrl('capacity') }}" {{ request('sort') === 'capacity' ? 'selected' : '' }}>Capacité</option>
                        </select>
                    </label>
                </div>

                {{-- Grille chambres --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($rooms as $room)
                    <article class="card group">
                        <div class="relative aspect-[4/3] overflow-hidden">
                            <img src="{{ asset($room->first_image) }}"
                                 alt="{{ $room->name }}"
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                 loading="lazy" width="400" height="300">
                            <div class="absolute top-3 left-3 flex gap-2">
                                <span class="badge">{{ $room->view_label }}</span>
                                @if ($rooms->total() <= 2 && $checkIn)
                                <span class="badge-orange">Dernières dispo.</span>
                                @endif
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-black/50 to-transparent"></div>
                        </div>

                        <div class="p-4">
                            <div class="flex items-start justify-between gap-2 mb-2">
                                <h2 class="font-semibold text-base leading-tight" style="color: var(--color-navy);">{{ $room->name }}</h2>
                                <span class="text-xs px-2 py-1 rounded-full shrink-0" style="background-color: var(--color-sky); color: #075985;">
                                    {{ $room->capacity_adults }} pers.
                                </span>
                            </div>

                            <p class="text-sm mb-3 line-clamp-2" style="color: var(--color-slate);">{{ $room->description_short }}</p>

                            {{-- Détails --}}
                            <div class="flex flex-wrap gap-x-3 gap-y-1 mb-3 text-xs" style="color: var(--color-slate);">
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 shrink-0" style="color: var(--color-orange);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/></svg>
                                    {{ $room->bed_type_label }}
                                </span>
                                @if ($room->size_m2)
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 shrink-0" style="color: var(--color-orange);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                                    {{ $room->size_m2 }} m²
                                </span>
                                @endif
                            </div>

                            {{-- Réassurance façon Booking --}}
                            <div class="space-y-1 mb-3 text-xs font-semibold text-green-700">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    Annulation gratuite
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    Aucun prépaiement
                                </div>
                            </div>

                            <div class="pt-3 border-t space-y-3" style="border-color: var(--color-border);">
                                <div>
                                    @if ($checkIn && $checkOut)
                                    @php $nights = max(1, (int) \Carbon\Carbon::parse($checkIn)->diffInDays(\Carbon\Carbon::parse($checkOut))); @endphp
                                    <span class="price-tag text-xl">{{ number_format($room->price_per_night * $nights, 0, ',', ' ') }}</span>
                                    <span class="text-xs ml-1" style="color: var(--color-slate);">FCFA · {{ $nights }} nuit{{ $nights > 1 ? 's' : '' }}</span>
                                    @else
                                    <span class="price-tag text-xl">{{ number_format($room->price_per_night, 0, ',', ' ') }}</span>
                                    <span class="text-xs ml-1" style="color: var(--color-slate);">FCFA / nuit</span>
                                    @endif
                                </div>
                                <a href="{{ route('rooms.show', $room->slug) }}{{ $checkIn ? '?check_in='.$checkIn.'&check_out='.$checkOut : '' }}"
                                   class="btn-primary w-full text-sm py-2.5">
                                    Voir & Réserver
                                </a>
                            </div>
                        </div>
                    </article>
                    @empty
                    <div class="sm:col-span-2 text-center py-20">
                        <svg class="w-16 h-16 mx-auto mb-4" style="color: var(--color-border);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <h3 class="text-xl font-semibold mb-2" style="color: var(--color-navy);">Aucune chambre disponible</h3>
                        <p class="mb-6" style="color: var(--color-slate);">Essayez d'autres dates ou critères.</p>
                        <a href="{{ route('rooms.index') }}" class="btn-primary">Voir toutes les chambres</a>
                    </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                <div class="mt-8">
                    {{ $rooms->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
