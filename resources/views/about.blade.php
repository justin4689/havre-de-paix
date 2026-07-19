@extends('layouts.app')
@section('title', 'Havre de Paix Assinie — Résidence-Hôtel entre mer et lagune')
@section('description', 'Découvrez le Havre de Paix : résidence-hôtel à Assinie Km 18,75, Côte d\'Ivoire. 5 chambres & suites, accès mer et lagune, 94 km d\'Abidjan. Tout ce qu\'il faut savoir avant votre séjour.')

@section('hero_nav', '1')

@section('content')
<div>

{{-- ═══════════════════════════════════════════
     1. HERO
═══════════════════════════════════════════ --}}
<section class="relative h-[60vh] min-h-[420px] flex items-center overflow-hidden">
    <img src="{{ asset('images/about-hero.jpg') }}"
         alt="Bungalows sur pilotis entre mer et lagune"
         class="absolute inset-0 w-full h-full object-cover">
    <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(30,41,59,0.92) 0%, rgba(30,41,59,0.4) 55%, rgba(30,41,59,0.1) 100%);"></div>

    <div class="relative z-10 w-full max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center pt-16">
        <span class="inline-flex items-center gap-2 text-xs font-semibold tracking-widest uppercase text-white/70 mb-4">
            <svg class="w-3 h-3" style="color: var(--color-orange);" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
            Assinie · Km 18,75 · Côte d'Ivoire
        </span>
        <h1 class="text-5xl sm:text-6xl lg:text-7xl font-bold text-white mb-4 leading-tight" style="font-family: var(--font-serif);">
            Havre de Paix
        </h1>
        <p class="text-lg text-white/80 mb-8 max-w-xl mx-auto">
            Résidence-hôtel entre l'océan Atlantique et la lagune Aby. Un refuge tropical à seulement 94 km d'Abidjan.
        </p>
        <div class="flex flex-wrap justify-center gap-3 mb-8">
            @foreach (['Entre mer & lagune', '5 chambres & suites', '94 km d\'Abidjan', 'Paiement à l\'arrivée'] as $badge)
            <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-semibold text-white border border-white/30 backdrop-blur-sm" style="background: rgba(255,255,255,0.12);">
                <svg class="w-3 h-3" style="color: var(--color-orange);" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                {{ $badge }}
            </span>
            @endforeach
        </div>
        <div class="flex flex-wrap justify-center gap-3">
            <a href="{{ route('rooms.index') }}" class="btn-primary text-sm px-7 py-3.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Réserver maintenant
            </a>
            <a href="#galerie" class="btn-outline text-sm px-7 py-3.5 text-white border-white/50 hover:bg-white hover:text-navy">
                Voir la galerie
            </a>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     2. NAVIGATION PAR ANCRE (sticky)
═══════════════════════════════════════════ --}}
<nav class="sticky top-16 z-40 bg-white border-b shadow-sm" style="border-color: var(--color-border);"
     x-data="{ active: 'presentation' }"
     @scroll.window="
        ['presentation','equipements','galerie','chambres','situation','politique'].forEach(id => {
            const el = document.getElementById(id);
            if (el && el.getBoundingClientRect().top <= 120) active = id;
        })
     ">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center lg:justify-center gap-1 overflow-x-auto hide-scrollbar py-1">
            @foreach ([
                ['id' => 'presentation', 'label' => 'Présentation'],
                ['id' => 'equipements',  'label' => 'Équipements'],
                ['id' => 'galerie',      'label' => 'Galerie'],
                ['id' => 'chambres',     'label' => 'Chambres'],
                ['id' => 'situation',    'label' => 'Situation'],
                ['id' => 'politique',    'label' => 'Politique'],
            ] as $anchor)
            <a href="#{{ $anchor['id'] }}"
               class="shrink-0 px-4 py-3 text-sm font-medium transition-colors border-b-2 whitespace-nowrap"
               :class="active === '{{ $anchor['id'] }}' ? 'border-orange-500 text-orange-500' : 'border-transparent hover:text-orange-500'"
               style="color: {{ 'var(--color-slate)' }}">
                {{ $anchor['label'] }}
            </a>
            @endforeach
        </div>
    </div>
</nav>

{{-- ═══════════════════════════════════════════
     3. CHECK-IN/OUT RAPIDE
═══════════════════════════════════════════ --}}
<div class="bg-white border-b" style="border-color: var(--color-border);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex flex-wrap items-center justify-center gap-6 sm:gap-10 text-sm">
            @foreach ([
                ['icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'label' => 'Arrivée',    'value' => 'À partir de 14h00'],
                ['icon' => 'M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1', 'label' => 'Départ',     'value' => 'Avant 12h00'],
                ['icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Paiement',   'value' => 'À l\'arrivée uniquement'],
                ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Annulation', 'value' => 'Gratuite 48h avant'],
            ] as $item)
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-full flex items-center justify-center shrink-0" style="background-color: var(--color-sand);">
                    <svg class="w-4 h-4" style="color: var(--color-orange);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium" style="color: var(--color-slate);">{{ $item['label'] }}</p>
                    <p class="font-semibold text-sm" style="color: var(--color-navy);">{{ $item['value'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════
     4. PRÉSENTATION
═══════════════════════════════════════════ --}}
<section id="presentation" class="scroll-mt-32 py-20" style="background-color: var(--color-snow);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center mb-20">
            <div>
                <p class="text-xs font-bold uppercase tracking-widest mb-3" style="color: var(--color-orange);">Notre histoire</p>
                <h2 class="section-title mb-6">Un refuge entre deux eaux</h2>
                <div class="space-y-4 text-base leading-relaxed" style="color: var(--color-slate);">
                    <p>
                        Niché au cœur d'Assinie au Kilomètre 18,75, le <strong style="color: var(--color-navy);">Havre de Paix</strong> est né d'une vision simple : offrir un espace de sérénité authentique entre l'océan Atlantique et la lagune Aby.
                    </p>
                    <p>
                        Chaque détail de notre résidence-hôtel a été pensé pour s'intégrer harmonieusement au cadre naturel exceptionnel qui nous entoure. Des bungalows sur pilotis aux suites panoramiques, nous avons conçu des espaces qui invitent à la contemplation et au repos.
                    </p>
                    <p>
                        À seulement <strong style="color: var(--color-navy);">94 km d'Abidjan</strong>, notre adresse est accessible en 2h de route, idéale pour un week-end ressourçant ou un séjour prolongé.
                    </p>
                </div>
                <div class="mt-8 flex gap-4">
                    <a href="{{ route('rooms.index') }}" class="btn-primary text-sm">Voir nos chambres</a>
                    <a href="{{ route('contact') }}" class="btn-outline text-sm">Nous contacter</a>
                </div>
            </div>
            <div class="relative">
                <div class="aspect-[4/5] rounded-2xl overflow-hidden shadow-2xl">
                    <img src="{{ asset('images/rooms/bungalow-lagune-1.jpg') }}"
                         alt="Bungalows Havre de Paix"
                         class="w-full h-full object-cover">
                </div>
                {{-- Encart flottant --}}
                <div class="absolute -bottom-6 -left-6 bg-white rounded-2xl p-5 shadow-xl border" style="border-color: var(--color-border);">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background-color: var(--color-sand);">
                            <svg class="w-6 h-6" style="color: var(--color-orange);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-sm" style="color: var(--color-navy);">Cadre exceptionnel</p>
                            <p class="text-xs" style="color: var(--color-slate);">Mer & lagune en même temps</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Chiffres clés --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            @foreach ([
                ['value' => '5',      'label' => 'Types de chambres & suites', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                ['value' => '94 km',  'label' => 'D\'Abidjan seulement',       'icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z'],
                ['value' => '2',      'label' => 'Accès directs mer & lagune', 'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064'],
                ['value' => '24/7',   'label' => 'Réservation & réception',    'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
            ] as $stat)
            <div class="text-center p-6 rounded-2xl bg-white border shadow-sm" style="border-color: var(--color-border);">
                <div class="w-10 h-10 rounded-full mx-auto mb-3 flex items-center justify-center" style="background-color: var(--color-sand);">
                    <svg class="w-5 h-5" style="color: var(--color-orange);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/>
                    </svg>
                </div>
                <div class="text-3xl font-bold mb-1" style="color: var(--color-orange); font-family: var(--font-serif);">{{ $stat['value'] }}</div>
                <div class="text-xs leading-snug" style="color: var(--color-slate);">{{ $stat['label'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     5. ÉQUIPEMENTS
═══════════════════════════════════════════ --}}
<section id="equipements" class="scroll-mt-32 py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <p class="text-xs font-bold uppercase tracking-widest mb-2" style="color: var(--color-orange);">Ce que nous offrons</p>
            <h2 class="section-title">Équipements & services</h2>
            <p class="section-subtitle max-w-2xl mx-auto">Tout le confort pour un séjour inoubliable entre mer et lagune.</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 mb-14">
            @foreach ([
                ['icon' => 'M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0', 'label' => 'WiFi haut débit', 'desc' => 'Dans tout l\'établissement'],
                ['icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064', 'label' => 'Accès plage & mer', 'desc' => 'Direct depuis l\'hôtel'],
                ['icon' => 'M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z', 'label' => 'Climatisation', 'desc' => 'Inverter dans chaque chambre'],
                ['icon' => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z', 'label' => 'Vue lagune & mer', 'desc' => 'Panorama exceptionnel'],
                ['icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'label' => 'Bar & boissons', 'desc' => 'Cocktails & rafraîchissements'],
                ['icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', 'label' => 'Terrasses privées', 'desc' => 'Chaque chambre'],
                ['icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Réception 24h/24', 'desc' => 'Accueil personnalisé'],
                ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'label' => 'Coffre-fort', 'desc' => 'Dans chaque chambre'],
                ['icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z', 'label' => 'Minibar', 'desc' => 'Chambres supérieures'],
                ['icon' => 'M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z', 'label' => 'Télévision satellite', 'desc' => 'Toutes les chambres'],
                ['icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z', 'label' => 'Parking sécurisé', 'desc' => 'Sur l\'enceinte de l\'hôtel'],
                ['icon' => 'M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129', 'label' => 'Langues parlées', 'desc' => 'Français & Anglais'],
            ] as $equip)
            <div class="flex items-start gap-3 p-4 rounded-xl border transition-shadow hover:shadow-md" style="border-color: var(--color-border);">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0" style="background-color: var(--color-sand);">
                    <svg class="w-5 h-5" style="color: var(--color-orange);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $equip['icon'] }}"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-sm" style="color: var(--color-navy);">{{ $equip['label'] }}</p>
                    <p class="text-xs mt-0.5" style="color: var(--color-slate);">{{ $equip['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Bloc spécial piscine + plage --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="relative rounded-2xl overflow-hidden h-56 group">
                <img src="{{ asset('images/pool.jpg') }}" alt="Piscine" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(30,41,59,0.8) 0%, transparent 60%);"></div>
                <div class="absolute bottom-4 left-4">
                    <p class="text-white font-bold text-lg" style="font-family: var(--font-serif);">Piscine extérieure</p>
                    <p class="text-white/70 text-sm">Ouverte de 7h à 21h</p>
                </div>
            </div>
            <div class="relative rounded-2xl overflow-hidden h-56 group">
                <img src="{{ asset('images/beach-access.jpg') }}" alt="Accès plage" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(30,41,59,0.8) 0%, transparent 60%);"></div>
                <div class="absolute bottom-4 left-4">
                    <p class="text-white font-bold text-lg" style="font-family: var(--font-serif);">Accès direct à la plage</p>
                    <p class="text-white/70 text-sm">Plage privée & côté lagune</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     6. GALERIE
═══════════════════════════════════════════ --}}
<section id="galerie" class="scroll-mt-32 py-20" style="background-color: var(--color-snow);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <p class="text-xs font-bold uppercase tracking-widest mb-2" style="color: var(--color-orange);">Photos</p>
            <h2 class="section-title">Galerie du Havre de Paix</h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-3" x-data="{ lightbox: null, imgs: [
            '{{ asset('images/hero-bg.jpg') }}',
            '{{ asset('images/rooms/bungalow-lagune-1.jpg') }}',
            '{{ asset('images/rooms/chambre-vue-mer-1.jpg') }}',
            '{{ asset('images/rooms/suite-prestige-1.jpg') }}',
            '{{ asset('images/rooms/chambre-jardin-1.jpg') }}',
            '{{ asset('images/rooms/chambre-twin-piscine-1.jpg') }}',
            '{{ asset('images/pool.jpg') }}',
            '{{ asset('images/beach-access.jpg') }}',
            '{{ asset('images/terrace.jpg') }}'
        ] }">
            <template x-for="(img, i) in imgs" :key="i">
                <button @click="lightbox = i"
                        class="relative overflow-hidden rounded-xl group cursor-zoom-in"
                        :class="i === 0 ? 'col-span-2 row-span-2' : ''"
                        :style="i === 0 ? 'aspect-ratio: 2/1' : 'aspect-ratio: 1/1'">
                    <img :src="img" :alt="'Photo ' + (i+1)"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors flex items-center justify-center">
                        <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                        </svg>
                    </div>
                </button>
            </template>

            {{-- Lightbox --}}
            <div x-show="lightbox !== null" x-transition.opacity
                 class="fixed inset-0 z-50 bg-black/95 flex items-center justify-center p-4"
                 @click.self="lightbox = null" @keydown.escape.window="lightbox = null">
                <button @click="lightbox = null" class="absolute top-4 right-4 text-white/80 hover:text-white">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
                <button @click="lightbox = (lightbox - 1 + imgs.length) % imgs.length" class="absolute left-4 top-1/2 -translate-y-1/2 text-white/80 hover:text-white">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <img :src="lightbox !== null ? imgs[lightbox] : ''" class="max-w-5xl max-h-[85vh] w-full object-contain rounded-xl" loading="lazy">
                <button @click="lightbox = (lightbox + 1) % imgs.length" class="absolute right-4 top-1/2 -translate-y-1/2 text-white/80 hover:text-white">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
                <p class="absolute bottom-4 left-1/2 -translate-x-1/2 text-white/60 text-sm" x-text="(lightbox + 1) + ' / ' + imgs.length"></p>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     7. NOS CHAMBRES
═══════════════════════════════════════════ --}}
<section id="chambres" class="scroll-mt-32 py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-14 flex-wrap gap-4">
            <div>
                <p class="text-xs font-bold uppercase tracking-widest mb-2" style="color: var(--color-orange);">Hébergements</p>
                <h2 class="section-title">Nos chambres & suites</h2>
            </div>
            <a href="{{ route('rooms.index') }}" class="btn-outline text-sm">Voir toutes les chambres</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($rooms as $room)
            <a href="{{ route('rooms.show', $room->slug) }}" class="card group no-underline block">
                <div class="relative h-52 overflow-hidden">
                    <img src="{{ asset($room->first_image) }}"
                         alt="{{ $room->name }}"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                         loading="lazy">
                    <div class="absolute top-3 left-3 flex gap-2 flex-wrap">
                        <span class="badge text-xs">{{ $room->view_label }}</span>
                    </div>
                    <div class="absolute bottom-0 inset-x-0 h-16" style="background: linear-gradient(to top, rgba(30,41,59,0.6), transparent);"></div>
                </div>
                <div class="p-5">
                    <div class="flex items-start justify-between gap-3 mb-2">
                        <h3 class="font-bold text-base group-hover:text-orange-500 transition-colors" style="font-family: var(--font-serif); color: var(--color-navy);">{{ $room->name }}</h3>
                        <div class="text-right shrink-0">
                            <span class="price-tag text-lg">{{ number_format($room->price_per_night, 0, ',', ' ') }}</span>
                            <span class="text-xs block" style="color: var(--color-slate);">FCFA/nuit</span>
                        </div>
                    </div>
                    <p class="text-xs leading-relaxed mb-4 line-clamp-2" style="color: var(--color-slate);">{{ $room->description_short }}</p>
                    <div class="flex items-center gap-3 text-xs" style="color: var(--color-slate);">
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $room->capacity_adults }} pers.
                        </span>
                        <span>·</span>
                        @if($room->size_m2)
                        <span>{{ $room->size_m2 }} m²</span>
                        <span>·</span>
                        @endif
                        <span>{{ $room->bed_type_label }}</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     8. SITUATION GÉOGRAPHIQUE
═══════════════════════════════════════════ --}}
<section id="situation" class="scroll-mt-32 py-20" style="background-color: var(--color-snow);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <p class="text-xs font-bold uppercase tracking-widest mb-2" style="color: var(--color-orange);">Localisation</p>
            <h2 class="section-title">Comment nous rejoindre</h2>
            <p class="section-subtitle max-w-xl mx-auto">Assinie Km 18,75 — Au bout d'Assinie, là où la piste longe à la fois la mer et la lagune.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-start">
            {{-- Carte Google Maps --}}
            <div class="rounded-2xl overflow-hidden shadow-lg h-80 lg:h-full min-h-72 border" style="border-color: var(--color-border);">
                <iframe
                    src="https://maps.google.com/maps?q=Assinie+Km+18,75+Cote+d'Ivoire&t=&z=13&ie=UTF8&iwloc=&output=embed"
                    width="100%" height="100%"
                    style="border:0; min-height: 320px;"
                    allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Carte Havre de Paix Assinie">
                </iframe>
            </div>

            {{-- Instructions --}}
            <div class="space-y-5">
                <div class="bg-white rounded-2xl p-6 border shadow-sm" style="border-color: var(--color-border);">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background-color: var(--color-sand);">
                            <svg class="w-5 h-5" style="color: var(--color-orange);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                        </div>
                        <h3 class="font-bold" style="color: var(--color-navy); font-family: var(--font-serif);">Depuis Abidjan</h3>
                    </div>
                    <ol class="space-y-3">
                        @foreach ([
                            'Prendre la route de Grand-Bassam (sortie Est d\'Abidjan)',
                            'Traverser Grand-Bassam, continuer vers Assinie-Mafia',
                            'À Assinie-Mafia, prendre le bac ou le pont pour rejoindre la péninsule',
                            'Suivre la piste côtière jusqu\'au Km 18,75',
                            'Le Havre de Paix est indiqué sur la droite (côté mer)',
                        ] as $i => $step)
                        <li class="flex gap-3 text-sm" style="color: var(--color-slate);">
                            <span class="w-6 h-6 rounded-full text-white text-xs font-bold flex items-center justify-center shrink-0 mt-0.5" style="background-color: var(--color-orange);">{{ $i + 1 }}</span>
                            {{ $step }}
                        </li>
                        @endforeach
                    </ol>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white rounded-xl p-4 border shadow-sm text-center" style="border-color: var(--color-border);">
                        <div class="text-2xl font-bold mb-1" style="color: var(--color-orange); font-family: var(--font-serif);">94 km</div>
                        <p class="text-xs" style="color: var(--color-slate);">Depuis Abidjan</p>
                    </div>
                    <div class="bg-white rounded-xl p-4 border shadow-sm text-center" style="border-color: var(--color-border);">
                        <div class="text-2xl font-bold mb-1" style="color: var(--color-orange); font-family: var(--font-serif);">~2h</div>
                        <p class="text-xs" style="color: var(--color-slate);">De route</p>
                    </div>
                    <div class="bg-white rounded-xl p-4 border shadow-sm text-sm col-span-2" style="border-color: var(--color-border);">
                        <p class="font-semibold mb-1" style="color: var(--color-navy);">Coordonnées GPS</p>
                        <p class="font-mono text-xs" style="color: var(--color-slate);">5.1234° N, -3.4567° W</p>
                        <p class="text-xs mt-2" style="color: var(--color-slate);">Assinie Km 18,75 — Côte d'Ivoire</p>
                    </div>
                </div>

                <a href="https://wa.me/2250000000000?text=Bonjour,%20je%20souhaite%20avoir%20des%20informations%20sur%20le%20Havre%20de%20Paix%20d'Assinie."
                   target="_blank" rel="noopener"
                   class="btn-primary w-full py-3.5 text-sm">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    Nous contacter sur WhatsApp
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     9. POLITIQUE DE L'ÉTABLISSEMENT
═══════════════════════════════════════════ --}}
<section id="politique" class="scroll-mt-32 py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <p class="text-xs font-bold uppercase tracking-widest mb-2" style="color: var(--color-orange);">Règles & conditions</p>
            <h2 class="section-title">Politique de l'établissement</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            @foreach ([
                [
                    'icon'  => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
                    'title' => 'Arrivée & départ',
                    'items' => ['Arrivée : à partir de 14h00', 'Départ : avant 12h00', 'Arrivée tardive possible (prévenir)', 'Départ express sur demande'],
                ],
                [
                    'icon'  => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                    'title' => 'Paiement',
                    'items' => ['Règlement intégral à l\'arrivée', 'Espèces ou virement acceptés', 'Aucun prépaiement en ligne', 'Caution éventuelle à l\'arrivée'],
                ],
                [
                    'icon'  => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                    'title' => 'Annulation',
                    'items' => ['Annulation gratuite 48h avant', 'Via lien dans l\'email de confirmation', 'Modification possible par email', 'Contact WhatsApp pour urgences'],
                ],
                [
                    'icon'  => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
                    'title' => 'Enfants & familles',
                    'items' => ['Enfants bienvenus', 'Lit bébé disponible (sur demande)', 'Tarif enfant -12 ans : gratuit', 'Piscine supervisée pour enfants'],
                ],
                [
                    'icon'  => 'M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13',
                    'title' => 'Règles de séjour',
                    'items' => ['Animaux non admis', 'Non-fumeur dans les chambres', 'Silence après 22h00', 'Fêtes privées sur demande'],
                ],
                [
                    'icon'  => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064',
                    'title' => 'Accès & sécurité',
                    'items' => ['Pièce d\'identité obligatoire', 'Accès clé magnétique', 'Coffre-fort en chambre', 'Parking sécurisé inclus'],
                ],
            ] as $pol)
            <div class="bg-white rounded-2xl p-6 border shadow-sm" style="border-color: var(--color-border);">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0" style="background-color: var(--color-sand);">
                        <svg class="w-5 h-5" style="color: var(--color-orange);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $pol['icon'] }}"/>
                        </svg>
                    </div>
                    <h3 class="font-bold" style="color: var(--color-navy); font-family: var(--font-serif);">{{ $pol['title'] }}</h3>
                </div>
                <ul class="space-y-2">
                    @foreach ($pol['items'] as $item)
                    <li class="flex items-start gap-2 text-sm" style="color: var(--color-slate);">
                        <svg class="w-4 h-4 shrink-0 mt-0.5" style="color: var(--color-orange);" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        {{ $item }}
                    </li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     10. FAQ
═══════════════════════════════════════════ --}}
<section class="py-20" style="background-color: var(--color-snow);">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <p class="text-xs font-bold uppercase tracking-widest mb-2" style="color: var(--color-orange);">Questions fréquentes</p>
            <h2 class="section-title">Tout ce qu'il faut savoir</h2>
        </div>

        <div class="space-y-3" x-data="{ open: null }">
            @foreach ([
                [
                    'q' => 'Comment effectuer une réservation ?',
                    'a' => 'Vous pouvez réserver directement en ligne via notre formulaire de réservation disponible sur chaque page chambre ou depuis le bouton "Réserver" en haut. La confirmation est instantanée par email. Vous pouvez aussi nous contacter par WhatsApp ou email.',
                ],
                [
                    'q' => 'Le paiement se fait-il en ligne ?',
                    'a' => 'Non. Nous n\'acceptons aucun paiement en ligne. Le règlement s\'effectue intégralement à votre arrivée, en espèces ou par virement bancaire. Cela signifie que votre réservation ne vous engage financièrement qu\'au moment de votre séjour.',
                ],
                [
                    'q' => 'Puis-je annuler ou modifier ma réservation ?',
                    'a' => 'Oui. L\'annulation est gratuite jusqu\'à 48 heures avant votre date d\'arrivée. Vous trouverez un lien d\'annulation directement dans votre email de confirmation. Pour toute modification, contactez-nous par email ou WhatsApp.',
                ],
                [
                    'q' => 'Y a-t-il un accès internet (WiFi) dans les chambres ?',
                    'a' => 'Oui, le WiFi haut débit est disponible dans toutes les chambres et les espaces communs, sans frais supplémentaires.',
                ],
                [
                    'q' => 'L\'hôtel est-il adapté aux familles avec enfants ?',
                    'a' => 'Absolument. Les enfants sont les bienvenus. Des lits bébé sont disponibles sur demande. Les enfants de moins de 12 ans séjournent gratuitement en partageant le lit des parents. La piscine est surveillée pendant les heures d\'ouverture.',
                ],
                [
                    'q' => 'Comment se rendre au Havre de Paix depuis Abidjan ?',
                    'a' => 'L\'hôtel se situe à 94 km d\'Abidjan, soit environ 2 heures de route. Prenez la direction de Grand-Bassam puis Assinie. Traversez le bac ou le pont à Assinie-Mafia et suivez la piste côtière jusqu\'au Km 18,75. Nous proposons également un service de transfert depuis Abidjan sur demande.',
                ],
            ] as $i => $faq)
            <div class="bg-white rounded-xl border shadow-sm overflow-hidden" style="border-color: var(--color-border);">
                <button @click="open = open === {{ $i }} ? null : {{ $i }}"
                        class="w-full flex items-center justify-between gap-4 p-5 text-left">
                    <span class="font-semibold text-sm" style="color: var(--color-navy);">{{ $faq['q'] }}</span>
                    <svg class="w-5 h-5 shrink-0 transition-transform duration-300" style="color: var(--color-orange);"
                         :class="open === {{ $i }} ? 'rotate-180' : ''"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open === {{ $i }}" x-transition
                     class="px-5 pb-5 text-sm leading-relaxed border-t" style="color: var(--color-slate); border-color: var(--color-border);">
                    <p class="pt-4">{{ $faq['a'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     11. CTA FINAL
═══════════════════════════════════════════ --}}
<section class="relative py-24 overflow-hidden">
    <img src="{{ asset('images/terrace.jpg') }}"
         alt="Terrasse Havre de Paix"
         class="absolute inset-0 w-full h-full object-cover">
    <div class="absolute inset-0" style="background: linear-gradient(135deg, rgba(30,41,59,0.92) 0%, rgba(30,41,59,0.75) 100%);"></div>
    <div class="relative z-10 text-center text-white max-w-2xl mx-auto px-4 sm:px-6">
        <p class="text-xs font-bold uppercase tracking-widest mb-4" style="color: var(--color-orange);">Prêt pour votre séjour ?</p>
        <h2 class="text-4xl sm:text-5xl font-bold mb-6" style="font-family: var(--font-serif);">
            Réservez votre chambre
        </h2>
        <p class="text-lg text-white/80 mb-8">
            Confirmation instantanée par email. Paiement à l'arrivée uniquement.
            Annulation gratuite jusqu'à 48h avant.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('reservation.index') }}" class="btn-primary text-base px-10 py-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Réserver maintenant
            </a>
            <a href="{{ route('rooms.index') }}" class="btn-outline text-base px-10 py-4 text-white border-white/50 hover:bg-white hover:text-navy">
                Voir les chambres
            </a>
        </div>
    </div>
</section>

</div>
@endsection
