@extends('layouts.app')

@section('title', 'Résidence Hôtel Cascades — Résidence-Hôtel au cœur de Cocody')
@section('description', 'Réservez votre séjour à la Résidence Hôtel Cascades, résidence-hôtel à Cocody, Abidjan, Côte d\'Ivoire. Chambres et suites tout confort dans un cadre calme et verdoyant. Paiement à l\'arrivée.')
@section('hero_nav', '1')

@section('content')

{{-- ===== HERO ===== --}}
<section class="relative min-h-[85vh] flex items-center justify-center overflow-hidden">
    {{-- Background image --}}
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/hero2.webp') }}"
             alt="La Résidence Hôtel Cascades illuminée de nuit — Cocody, Abidjan"
             class="w-full h-full object-cover"
             loading="eager">
        <div class="absolute inset-0 hero-overlay"></div>
    </div>

    <div class="relative z-10 text-center text-white px-4 sm:px-6 max-w-5xl mx-auto pt-24">
        <div class="badge-orange mb-6 inline-flex">
            <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            Abidjan · Cocody · Côte d'Ivoire
        </div>

        <h1 class="text-5xl sm:text-6xl lg:text-7xl font-bold mb-6 leading-tight" style="font-family: var(--font-serif);">
            Résidence Hôtel<br>
            <span style="color: var(--color-orange);">Cascades</span>
        </h1>

        <p class="text-lg sm:text-xl mb-10 leading-relaxed max-w-2xl mx-auto" style="color: rgba(255,255,255,0.85);">
            Au cœur de Cocody, à Abidjan. Chambres et suites dans un cadre calme et verdoyant.
            <strong style="color: white;">Paiement à l'arrivée — aucun prépaiement requis.</strong>
        </p>

        {{-- Barre de recherche « pill » segmentée --}}
        <div class="max-w-3xl mx-auto animate-fade-up">
            <form action="{{ route('rooms.index') }}" method="GET"
                  class="bg-white rounded-2xl sm:rounded-full shadow-2xl p-2 flex flex-col sm:flex-row sm:items-center text-left"
                  style="color: var(--color-navy);">

                <div class="flex-1 min-w-0 px-5 py-2.5 rounded-2xl sm:rounded-full transition-colors hover:bg-slate-50">
                    <label for="check_in" class="block text-xs font-bold uppercase tracking-wide mb-0.5">Arrivée</label>
                    <input type="date" id="check_in" name="check_in"
                           min="{{ date('Y-m-d') }}"
                           value="{{ request('check_in') }}"
                           class="w-full bg-transparent text-sm font-medium outline-none border-0 p-0 cursor-pointer"
                           required>
                </div>

                <div class="hidden sm:block w-px self-stretch my-3" style="background-color: var(--color-border);"></div>
                <div class="sm:hidden h-px mx-5" style="background-color: var(--color-border);"></div>

                <div class="flex-1 min-w-0 px-5 py-2.5 rounded-2xl sm:rounded-full transition-colors hover:bg-slate-50">
                    <label for="check_out" class="block text-xs font-bold uppercase tracking-wide mb-0.5">Départ</label>
                    <input type="date" id="check_out" name="check_out"
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                           value="{{ request('check_out') }}"
                           class="w-full bg-transparent text-sm font-medium outline-none border-0 p-0 cursor-pointer"
                           required>
                </div>

                <div class="hidden sm:block w-px self-stretch my-3" style="background-color: var(--color-border);"></div>
                <div class="sm:hidden h-px mx-5" style="background-color: var(--color-border);"></div>

                <div class="flex-1 min-w-0 px-5 py-2.5 rounded-2xl sm:rounded-full transition-colors hover:bg-slate-50">
                    <label for="guests" class="block text-xs font-bold uppercase tracking-wide mb-0.5">Hôtes</label>
                    <select id="guests" name="capacity" class="w-full bg-transparent text-sm font-medium outline-none border-0 p-0 cursor-pointer">
                        @for ($i = 1; $i <= 8; $i++)
                        <option value="{{ $i }}" {{ request('capacity') == $i ? 'selected' : '' }}>{{ $i }} hôte{{ $i > 1 ? 's' : '' }}</option>
                        @endfor
                    </select>
                </div>

                <button type="submit" class="btn-search h-12 sm:w-12 w-auto px-6 sm:px-0 m-1 sm:m-0 sm:ml-2" aria-label="Rechercher les disponibilités">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <span class="sm:hidden">Rechercher</span>
                </button>
            </form>

            <p class="mt-5 text-sm font-medium" style="color: rgba(255,255,255,0.85);">
                Annulation gratuite jusqu'à 48h &middot; Paiement à l'arrivée &middot; Confirmation immédiate
            </p>
        </div>
    </div>

    {{-- Scroll indicator --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10 animate-bounce">
        <svg class="w-6 h-6 text-white opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
    </div>
</section>

{{-- ===== POURQUOI NOUS CHOISIR ===== --}}
<section class="py-20 px-4 sm:px-6 lg:px-8" style="background-color: white;">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-14">
            <p class="text-sm font-semibold uppercase tracking-widest mb-3" style="color: var(--color-orange);">Notre différence</p>
            <h2 class="section-title">Pourquoi choisir la Résidence Hôtel Cascades ?</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach ([
                ['icon' => 'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z', 'title' => 'Piscine & jardins', 'desc' => 'Détendez-vous au bord de la piscine, dans un cadre verdoyant et paisible.'],
                ['icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Emplacement idéal', 'desc' => 'Au cœur de Cocody, à quelques minutes des commerces, ambassades et du Plateau.'],
                ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'title' => 'Paiement à l\'arrivée', 'desc' => 'Réservez sans risque. Vous payez uniquement à votre arrivée.'],
                ['icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'title' => 'Confirmation immédiate', 'desc' => 'Votre réservation est confirmée en ligne en moins de 5 minutes.'],
            ] as $feat)
            <div class="text-center p-6 rounded-2xl transition-all duration-300 hover:-translate-y-1" style="background-color: var(--color-snow);">
                <div class="w-12 h-12 mx-auto mb-4 rounded-full flex items-center justify-center" style="background-color: var(--color-sand);">
                    <svg class="w-6 h-6" style="color: #9A3412;" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $feat['icon'] }}"/></svg>
                </div>
                <h3 class="font-semibold text-base mb-2" style="color: var(--color-navy);">{{ $feat['title'] }}</h3>
                <p class="text-sm leading-relaxed" style="color: var(--color-slate);">{{ $feat['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== CHAMBRES VEDETTES ===== --}}
<section class="py-20 px-4 sm:px-6 lg:px-8" style="background-color: var(--color-snow);">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-end justify-between mb-12">
            <div>
                <p class="text-sm font-semibold uppercase tracking-widest mb-2" style="color: var(--color-orange);">Notre catalogue</p>
                <h2 class="section-title">Nos Chambres & Suites</h2>
                <p class="section-subtitle max-w-md">De la Chambre Standard à la Mini Suite, trouvez l'hébergement qui vous correspond.</p>
            </div>
            <a href="{{ route('rooms.index') }}" class="btn-outline hidden sm:inline-flex">
                Voir toutes les chambres
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        @if ($roomsByCategory->isNotEmpty())
        <div x-data="{ tab: '{{ $roomsByCategory->keys()->first() }}' }">

            {{-- Onglets par catégorie --}}
            <div class="flex flex-wrap gap-2 mb-8" role="tablist" aria-label="Catégories de chambres">
                @foreach ($roomsByCategory as $categoryKey => $room)
                <button @click="tab = '{{ $categoryKey }}'" role="tab"
                        :aria-selected="tab === '{{ $categoryKey }}' ? 'true' : 'false'"
                        :class="tab === '{{ $categoryKey }}' ? 'text-white shadow-md' : 'bg-white hover:border-slate-300'"
                        :style="tab === '{{ $categoryKey }}' ? 'background-color: var(--color-orange); border-color: var(--color-orange);' : 'color: var(--color-navy); border-color: var(--color-border);'"
                        class="px-5 py-2.5 rounded-full text-sm font-semibold border transition-all cursor-pointer">
                    {{ \App\Models\Room::CATEGORIES[$categoryKey] }}
                </button>
                @endforeach
            </div>

            {{-- Panneau de la catégorie active --}}
            @foreach ($roomsByCategory as $categoryKey => $room)
            <div x-show="tab === '{{ $categoryKey }}'" x-transition.opacity.duration.300ms role="tabpanel"
                 {{ $loop->first ? '' : 'x-cloak' }}>
                <div class="bg-white rounded-3xl border shadow-sm overflow-hidden grid grid-cols-1 lg:grid-cols-2" style="border-color: var(--color-border);">
                    <div class="relative overflow-hidden min-h-[280px] lg:min-h-[440px]">
                        <img src="{{ asset($room->first_image) }}" alt="{{ $room->name }}"
                             class="absolute inset-0 w-full h-full object-cover" loading="lazy">
                        <div class="absolute top-4 left-4">
                            <span class="badge">{{ $room->category_label }}</span>
                        </div>
                    </div>
                    <div class="p-8 lg:p-12 flex flex-col justify-center">
                        <h3 class="text-2xl font-bold mb-3" style="color: var(--color-navy); font-family: var(--font-serif);">{{ $room->name }}</h3>
                        <p class="leading-relaxed mb-6" style="color: var(--color-slate);">{{ $room->description_short }}</p>

                        {{-- Caractéristiques --}}
                        <div class="grid grid-cols-2 gap-x-6 gap-y-3 mb-6 text-sm" style="color: var(--color-navy);">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4 shrink-0" style="color: var(--color-orange);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ $room->capacity_adults }} hôte{{ $room->capacity_adults > 1 ? 's' : '' }}
                            </span>
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4 shrink-0" style="color: var(--color-orange);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                                {{ $room->bed_type_label }}
                            </span>
                            @if ($room->size_m2)
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4 shrink-0" style="color: var(--color-orange);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V6a2 2 0 012-2h2M4 16v2a2 2 0 002 2h2m8-16h2a2 2 0 012 2v2m-4 12h2a2 2 0 002-2v-2"/></svg>
                                {{ $room->size_m2 }} m²
                            </span>
                            @endif
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4 shrink-0" style="color: var(--color-orange);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                Étage {{ $room->floor }}
                            </span>
                        </div>

                        {{-- Équipements --}}
                        <div class="flex gap-x-4 gap-y-2 mb-8 flex-wrap">
                            @foreach (array_slice($room->amenities ?? [], 0, 4) as $amenity)
                            <span class="text-xs flex items-center gap-1.5" style="color: var(--color-slate);">
                                <x-amenity-icon :name="$amenity" class="w-3.5 h-3.5 shrink-0" style="color: var(--color-orange);" />
                                {{ $amenity }}
                            </span>
                            @endforeach
                        </div>

                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('rooms.show', $room->slug) }}" class="btn-primary">Voir & Réserver</a>
                            <a href="{{ route('rooms.index', ['category' => [$categoryKey]]) }}" class="btn-outline">
                                Toute la catégorie {{ \App\Models\Room::CATEGORIES[$categoryKey] }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12" style="color: var(--color-slate);">
            <p>Les chambres seront bientôt disponibles.</p>
        </div>
        @endif

        <div class="text-center mt-8 sm:hidden">
            <a href="{{ route('rooms.index') }}" class="btn-outline">Voir toutes les chambres</a>
        </div>
    </div>
</section>

{{-- ===== L'HÔTEL EN VIDÉO ===== --}}
<section class="py-20 px-4 sm:px-6 lg:px-8 overflow-hidden" style="background-color: var(--color-ink);">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

            <div class="text-center lg:text-left">
                <p class="text-sm font-semibold uppercase tracking-widest mb-3" style="color: var(--color-primary);">Immersion</p>
                <h2 class="text-4xl font-bold text-white tracking-tight mb-4">Visitez avant de réserver</h2>
                <p class="leading-relaxed mb-8 max-w-md mx-auto lg:mx-0" style="color: rgba(255,255,255,0.65);">
                    Deux minutes suffisent pour ressentir l'atmosphère des Cascades :
                    les jardins, les chambres, le restaurant — comme si vous y étiez.
                    Activez le son d'un simple clic.
                </p>
                <a href="{{ route('rooms.index') }}" class="btn-primary">
                    Réserver mon séjour
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="flex justify-center gap-5 sm:gap-8">
                @foreach (['video-1.mp4' => 'Visite de la résidence', 'video-2.mp4' => 'L\'expérience Cascades'] as $file => $label)
                <div x-data="{ muted: true }" class="relative w-[44vw] max-w-[320px] shrink-0 {{ $loop->last ? 'mt-12' : '' }}">
                    <div class="rounded-[1.75rem] overflow-hidden shadow-2xl border-4" style="border-color: rgba(255,255,255,0.12); aspect-ratio: 9/16; background-color: #000;">
                        <video src="{{ asset('videos/' . $file) }}"
                               class="w-full h-full object-cover js-hotel-video"
                               x-ref="player" loop muted playsinline preload="metadata"
                               aria-label="{{ $label }}"></video>
                    </div>
                    {{-- Bouton son --}}
                    <button @click="muted = ! muted; $refs.player.muted = muted; $refs.player.play()"
                            class="absolute bottom-3 right-3 w-10 h-10 rounded-full flex items-center justify-center text-white cursor-pointer transition-colors hover:bg-white/30"
                            style="background-color: rgba(255,255,255,0.18); backdrop-filter: blur(4px);"
                            :aria-label="muted ? 'Activer le son' : 'Couper le son'">
                        <svg x-show="muted" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z M17 14l4-4m0 4l-4-4"/></svg>
                        <svg x-show="!muted" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072M18.364 5.636a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/></svg>
                    </button>
                    <p class="text-center text-xs mt-3 font-medium" style="color: rgba(255,255,255,0.55);">{{ $label }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ===== LE LIEU & SAVEURS (galerie avec lightbox) ===== --}}
<div x-data="homeGallery()"
     @keydown.escape.window="close()"
     @keydown.arrow-right.window="opened && next()"
     @keydown.arrow-left.window="opened && prev()">

{{-- ===== LE LIEU EN IMAGES ===== --}}
<section class="py-20 px-4 sm:px-6 lg:px-8" style="background-color: white;">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12">
            <p class="text-sm font-semibold uppercase tracking-widest mb-2" style="color: var(--color-orange);">Le lieu</p>
            <h2 class="section-title">Le décor de votre séjour</h2>
            <p class="section-subtitle max-w-md mx-auto">Lobby, salons, jardins et terrasses — un havre de calme en plein Abidjan. Cliquez sur une photo pour l'agrandir.</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 md:grid-rows-3 gap-3 md:h-[760px]">
            @foreach ([
                ['img' => 'decor4.jpg', 'label' => 'Le lobby',            'alt' => 'Le lobby de la Résidence Hôtel Cascades et son plafond lumineux', 'class' => 'col-span-2 md:row-span-2 aspect-[4/3] md:aspect-auto'],
                ['img' => 'decor1.jpg', 'label' => 'L\'entrée végétale',  'alt' => 'L\'entrée et son mur végétal orné de sculptures',                'class' => 'aspect-square md:aspect-auto'],
                ['img' => 'decor7.jpg', 'label' => 'La réception',        'alt' => 'La réception en marbre et bois',                                  'class' => 'aspect-square md:aspect-auto'],
                ['img' => 'decor6.jpg', 'label' => 'L\'escalier',         'alt' => 'L\'escalier design et ses motifs géométriques',                  'class' => 'aspect-square md:aspect-auto'],
                ['img' => 'decor3.jpg', 'label' => 'Le hall',             'alt' => 'Le hall et ses assises traditionnelles en bois',                  'class' => 'aspect-square md:aspect-auto'],
                ['img' => 'decor5.jpg', 'label' => 'L\'entrée',           'alt' => 'L\'escalier d\'entrée bordé de verdure',                         'class' => 'aspect-square md:aspect-auto'],
                ['img' => 'decor8.jpg', 'label' => 'Le salon',            'alt' => 'Le salon lounge et ses plantes',                                  'class' => 'aspect-square md:aspect-auto'],
                ['img' => 'decor2.jpg', 'label' => 'Le couloir d\'accueil', 'alt' => 'Le couloir d\'accueil vers la réception',                      'class' => 'col-span-2 aspect-[16/9] md:aspect-auto'],
            ] as $tile)
            <div class="relative rounded-2xl overflow-hidden group cursor-zoom-in {{ $tile['class'] }}"
                 data-gallery="decor" role="button" tabindex="0"
                 @click="show($event.currentTarget)" @keydown.enter="show($event.currentTarget)">
                <img src="{{ asset('images/' . $tile['img']) }}" alt="{{ $tile['alt'] }}"
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                <div class="absolute inset-0 flex items-end justify-between p-4 opacity-0 group-hover:opacity-100 focus:opacity-100 transition-opacity duration-300"
                     style="background: linear-gradient(to top, rgba(11,18,21,0.72), transparent 55%);">
                    <span class="text-white text-sm font-semibold">{{ $tile['label'] }}</span>
                    <span class="w-8 h-8 rounded-full flex items-center justify-center shrink-0" style="background-color: rgba(255,255,255,0.2); backdrop-filter: blur(4px);">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V6a2 2 0 012-2h2M4 16v2a2 2 0 002 2h2m8-16h2a2 2 0 012 2v2m-4 12h2a2 2 0 002-2v-2"/></svg>
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== BAR & RESTAURANT ===== --}}
<section class="py-20 px-4 sm:px-6 lg:px-8" style="background-color: var(--color-snow);">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12">
            <p class="text-sm font-semibold uppercase tracking-widest mb-2" style="color: var(--color-orange);">Saveurs</p>
            <h2 class="section-title">Bar & Restaurant</h2>
            <p class="section-subtitle max-w-md mx-auto">Du petit-déjeuner au dernier verre — nos espaces gourmands vous accueillent toute la journée.</p>
        </div>

        {{-- Deux espaces --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="card group">
                <div class="relative aspect-[16/10] overflow-hidden cursor-zoom-in"
                     data-gallery="saveurs" role="button" tabindex="0"
                     @click="show($event.currentTarget)" @keydown.enter="show($event.currentTarget)">
                    <img src="{{ asset('images/resto2.jpg') }}" alt="La salle du restaurant de la Résidence Hôtel Cascades"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                    <span class="absolute top-4 left-4 px-3 py-1.5 rounded-full text-xs font-bold text-white" style="background-color: rgba(11,18,21,0.55); backdrop-filter: blur(6px);">Le Restaurant</span>
                    <span class="absolute bottom-4 right-4 w-8 h-8 rounded-full items-center justify-center hidden group-hover:flex" style="background-color: rgba(255,255,255,0.2); backdrop-filter: blur(4px);">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V6a2 2 0 012-2h2M4 16v2a2 2 0 002 2h2m8-16h2a2 2 0 012 2v2m-4 12h2a2 2 0 002-2v-2"/></svg>
                    </span>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-lg mb-2" style="color: var(--color-navy);">Une table généreuse</h3>
                    <p class="text-sm leading-relaxed mb-4" style="color: var(--color-slate);">
                        Cuisine ivoirienne et internationale préparée avec des produits frais, servie dans une salle
                        chaleureuse — et de grandes tablées dans le jardin pour vos événements.
                    </p>
                    <div class="flex flex-wrap gap-x-5 gap-y-2 pt-4 border-t text-xs font-medium" style="border-color: var(--color-border); color: var(--color-slate);">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" style="color: var(--color-orange);" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Petit-déjeuner · Déjeuner · Dîner
                        </span>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" style="color: var(--color-orange);" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            Tablées événements au jardin
                        </span>
                    </div>
                </div>
            </div>

            <div class="card group">
                <div class="relative aspect-[16/10] overflow-hidden cursor-zoom-in"
                     data-gallery="saveurs" role="button" tabindex="0"
                     @click="show($event.currentTarget)" @keydown.enter="show($event.currentTarget)">
                    <img src="{{ asset('images/bar1.jpg') }}" alt="Le comptoir du bar de la Résidence Hôtel Cascades"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                    <span class="absolute top-4 left-4 px-3 py-1.5 rounded-full text-xs font-bold text-white" style="background-color: rgba(11,18,21,0.55); backdrop-filter: blur(6px);">Le Bar</span>
                    <span class="absolute bottom-4 right-4 w-8 h-8 rounded-full items-center justify-center hidden group-hover:flex" style="background-color: rgba(255,255,255,0.2); backdrop-filter: blur(4px);">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V6a2 2 0 012-2h2M4 16v2a2 2 0 002 2h2m8-16h2a2 2 0 012 2v2m-4 12h2a2 2 0 002-2v-2"/></svg>
                    </span>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-lg mb-2" style="color: var(--color-navy);">L'heure du cocktail</h3>
                    <p class="text-sm leading-relaxed mb-4" style="color: var(--color-slate);">
                        Cocktails, jus frais et belle sélection de spiritueux au comptoir, dans une ambiance
                        feutrée qui s'anime en soirée — pour nos hôtes comme pour leurs invités.
                    </p>
                    <div class="flex flex-wrap gap-x-5 gap-y-2 pt-4 border-t text-xs font-medium" style="border-color: var(--color-border); color: var(--color-slate);">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" style="color: var(--color-orange);" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M8 22h8M12 11v11M19 3l-7 8-7-8h14z"/></svg>
                            Cocktails & jus frais
                        </span>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" style="color: var(--color-orange);" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 01-.99-3.467l2.31-.66A2.25 2.25 0 009 15.553z"/></svg>
                            Ambiance lounge en soirée
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Ambiances --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            @foreach ([
                ['img' => 'resto3.jpg', 'label' => 'Le soir venu',      'alt' => 'Le restaurant en ambiance du soir'],
                ['img' => 'resto1.jpg', 'label' => 'Banquets au jardin','alt' => 'Grande tablée dressée dans le jardin pour un événement'],
                ['img' => 'bar3.jpg',   'label' => 'Le bar en soirée',  'alt' => 'Le bar en soirée'],
                ['img' => 'bar2.jpg',   'label' => 'Côté salon',        'alt' => 'Le bar vu depuis le salon'],
            ] as $tile)
            <div class="relative rounded-2xl overflow-hidden group cursor-zoom-in aspect-square"
                 data-gallery="saveurs" role="button" tabindex="0"
                 @click="show($event.currentTarget)" @keydown.enter="show($event.currentTarget)">
                <img src="{{ asset('images/' . $tile['img']) }}" alt="{{ $tile['alt'] }}"
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                <div class="absolute inset-0 flex items-end justify-between p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                     style="background: linear-gradient(to top, rgba(11,18,21,0.72), transparent 55%);">
                    <span class="text-white text-sm font-semibold">{{ $tile['label'] }}</span>
                    <span class="w-8 h-8 rounded-full flex items-center justify-center shrink-0" style="background-color: rgba(255,255,255,0.2); backdrop-filter: blur(4px);">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V6a2 2 0 012-2h2M4 16v2a2 2 0 002 2h2m8-16h2a2 2 0 012 2v2m-4 12h2a2 2 0 002-2v-2"/></svg>
                    </span>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('table') }}" class="btn-primary">
                Découvrir Notre Table
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- ===== LIGHTBOX ===== --}}
<div x-show="opened" x-transition.opacity.duration.200ms style="display: none;"
     class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-8"
     role="dialog" aria-modal="true" aria-label="Visionneuse de photos">
    <div class="absolute inset-0" style="background-color: rgba(11,18,21,0.93); backdrop-filter: blur(8px);" @click="close()"></div>

    <div class="relative z-10 max-w-5xl w-full">
        <img :src="current.src" :alt="current.alt"
             class="w-full max-h-[78vh] object-contain rounded-2xl shadow-2xl select-none">
        <p class="text-center text-sm mt-4 font-medium" style="color: rgba(255,255,255,0.85);" x-text="current.alt"></p>
    </div>

    {{-- Compteur --}}
    <div class="absolute top-5 left-5 z-20 px-3 py-1.5 rounded-full text-xs font-bold text-white" style="background-color: rgba(255,255,255,0.15);">
        <span x-text="(index + 1) + ' / ' + items.length"></span>
    </div>

    {{-- Fermer --}}
    <button @click="close()" aria-label="Fermer"
            class="absolute top-5 right-5 z-20 w-10 h-10 rounded-full flex items-center justify-center text-white cursor-pointer transition-colors hover:bg-white/20"
            style="background-color: rgba(255,255,255,0.15);">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
    </button>

    {{-- Navigation --}}
    <button @click="prev()" aria-label="Photo précédente"
            class="absolute left-3 sm:left-6 top-1/2 -translate-y-1/2 z-20 w-11 h-11 rounded-full flex items-center justify-center text-white cursor-pointer transition-colors hover:bg-white/20"
            style="background-color: rgba(255,255,255,0.15);">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </button>
    <button @click="next()" aria-label="Photo suivante"
            class="absolute right-3 sm:right-6 top-1/2 -translate-y-1/2 z-20 w-11 h-11 rounded-full flex items-center justify-center text-white cursor-pointer transition-colors hover:bg-white/20"
            style="background-color: rgba(255,255,255,0.15);">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    </button>
</div>

</div>

{{-- ===== TÉMOIGNAGES (défilement continu) ===== --}}
<section class="py-20 overflow-hidden" style="background-color: var(--color-navy);">
    <div class="max-w-5xl mx-auto text-center px-4 sm:px-6 lg:px-8 mb-12">
        <p class="text-sm font-semibold uppercase tracking-widest mb-3" style="color: var(--color-orange);">Avis clients</p>
        <h2 class="text-4xl font-bold text-white tracking-tight">Ce que disent nos hôtes</h2>
    </div>

    @php
    $reviews = [
        ['name' => 'Kofi A.',        'note' => 5, 'context' => 'Séjour en famille · Avril 2026',      'text' => 'Un séjour parfait en famille. La piscine est superbe et le service impeccable.'],
        ['name' => 'Aminata D.',     'note' => 5, 'context' => 'Voyage d\'affaires · Mars 2026',      'text' => 'Idéalement situé, calme absolu à deux pas de mes rendez-vous à Cocody. Personnel aux petits soins.'],
        ['name' => 'Sophie M.',      'note' => 5, 'context' => 'Séjour en couple · Février 2026',     'text' => 'Cadre verdoyant et reposant en pleine ville. Les chambres sont propres et très bien équipées.'],
        ['name' => 'Yao K.',         'note' => 5, 'context' => 'Anniversaire · Mai 2026',             'text' => 'Réservation en ligne simple, paiement à l\'arrivée rassurant. La Suite Prestige vaut chaque franc.'],
        ['name' => 'Jean-Paul K.',   'note' => 4, 'context' => 'Séminaire d\'entreprise · Janv. 2026','text' => 'Idéal pour un séminaire résidentiel. Personnel accueillant et cuisine délicieuse.'],
        ['name' => 'Mariam T.',      'note' => 4, 'context' => 'Week-end entre amies · Juin 2026',    'text' => 'Cadre superbe et calme rare à Abidjan. Le restaurant mérite le détour, poissons grillés excellents.'],
        ['name' => 'Franck B.',      'note' => 5, 'context' => 'Séjour en famille · Déc. 2025',       'text' => 'En plein Cocody et pourtant la déconnexion totale. Piscine impeccable, les enfants étaient ravis.'],
        ['name' => 'Awa S.',         'note' => 5, 'context' => 'Voyage solo · Mai 2026',              'text' => 'L\'annulation gratuite m\'a décidée, l\'accueil m\'a conquise. Chambre parfaite, quartier sûr.'],
    ];
    @endphp

    <div class="relative marquee">
        {{-- Fondus latéraux --}}
        <div class="absolute inset-y-0 left-0 w-16 sm:w-32 z-10 pointer-events-none" style="background: linear-gradient(to right, var(--color-navy), transparent);"></div>
        <div class="absolute inset-y-0 right-0 w-16 sm:w-32 z-10 pointer-events-none" style="background: linear-gradient(to left, var(--color-navy), transparent);"></div>

        <div class="marquee-track flex w-max gap-5">
            @foreach (array_merge($reviews, $reviews) as $t)
            <div class="w-80 shrink-0 rounded-2xl p-6 text-left" style="background-color: rgba(255,255,255,0.08);">
                <div class="flex items-center gap-1 mb-3" role="img" aria-label="Note : {{ $t['note'] }} sur 5">
                    @for ($i = 1; $i <= 5; $i++)
                    <svg class="w-4 h-4" style="color: {{ $i <= $t['note'] ? 'var(--color-orange)' : 'rgba(255,255,255,0.2)' }};" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <p class="text-sm leading-relaxed mb-4" style="color: rgba(255,255,255,0.8);">"{{ $t['text'] }}"</p>
                <p class="text-sm font-semibold text-white">{{ $t['name'] }}</p>
                <p class="text-xs mt-0.5" style="color: rgba(255,255,255,0.5);">{{ $t['context'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== CTA FINAL ===== --}}
<section class="py-20 px-4 sm:px-6 lg:px-8 text-center" style="background-color: white;">
    <div class="max-w-2xl mx-auto">
        <h2 class="section-title mb-4">Prêt pour votre escapade&nbsp;?</h2>
        <p class="section-subtitle mb-8">Réservez votre chambre en ligne en moins de 5 minutes. Confirmation instantanée. Paiement à l'arrivée.</p>
        <a href="{{ route('rooms.index') }}" class="btn-primary text-base px-10 py-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Réserver maintenant
        </a>
        <p class="mt-4 text-sm" style="color: var(--color-slate);">Annulation gratuite jusqu'à 48h avant l'arrivée</p>
    </div>
</section>

@endsection

@push('scripts')
<script>

// Galerie lightbox des sections Décor et Bar & Restaurant
function homeGallery() {
    return {
        opened: false,
        items: [],
        index: 0,
        get current() {
            return this.items[this.index] ?? { src: '', alt: '' };
        },
        show(tile) {
            const group = tile.dataset.gallery;
            const tiles = Array.from(document.querySelectorAll(`[data-gallery="${group}"]`));
            this.items = tiles.map(t => {
                const img = t.querySelector('img');
                return { src: img.src, alt: img.alt };
            });
            this.index = tiles.indexOf(tile);
            this.opened = true;
            document.body.style.overflow = 'hidden';
        },
        close() {
            this.opened = false;
            document.body.style.overflow = '';
        },
        next() { this.index = (this.index + 1) % this.items.length; },
        prev() { this.index = (this.index - 1 + this.items.length) % this.items.length; },
    };
}
// Date minimum check_in → check_out
const checkIn  = document.getElementById('check_in');
const checkOut = document.getElementById('check_out');
if (checkIn && checkOut) {
    checkIn.addEventListener('change', () => {
        const min = new Date(checkIn.value);
        min.setDate(min.getDate() + 1);
        checkOut.min = min.toISOString().split('T')[0];
        if (checkOut.value && checkOut.value <= checkIn.value) {
            checkOut.value = min.toISOString().split('T')[0];
        }
    });
}

// Vidéos de présentation : lecture uniquement quand elles sont à l'écran
const hotelVideos = document.querySelectorAll('.js-hotel-video');
if (hotelVideos.length && 'IntersectionObserver' in window) {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.play().catch(() => {});
            } else {
                entry.target.pause();
            }
        });
    }, { threshold: 0.35 });
    hotelVideos.forEach((video) => observer.observe(video));
}
</script>
@endpush
