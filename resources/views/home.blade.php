@extends('layouts.app')

@section('title', __('Havre de Paix — Résidence-Hôtel à Assinie, au bord de la lagune'))
@section('description', __('Réservez votre séjour au Havre de Paix, résidence-hôtel à Assinie (Km 18,75), Côte d\'Ivoire. Piscine à débordement sur la lagune, chambres et suites climatisées, petit-déjeuner inclus. Paiement à l\'arrivée.'))
@section('hero_nav', '1')

@section('content')

{{-- ===== HERO ===== --}}
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    {{-- Background : la façade de la résidence --}}
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/site/hero-facade-hotel.jpg') }}"
             alt="{{ __('La façade de la résidence, vue depuis l\'entrée du domaine') }}"
             class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 hero-overlay"></div>
    </div>

    <div class="relative z-10 text-center text-white px-4 sm:px-6 max-w-5xl mx-auto pt-16">
        <h1 class="text-5xl sm:text-6xl lg:text-7xl font-bold leading-tight" style="font-family: var(--font-serif);">
            Havre de <span style="color: var(--color-orange);">Paix</span>
        </h1>
        <p class="mt-4 text-xl sm:text-3xl lg:text-4xl font-bold uppercase tracking-[0.14em] sm:tracking-[0.2em]">
            Assinie <span style="color: var(--color-orange);">·</span> {{ __('Kilomètre') }} 18,75
        </p>
    </div>

    {{-- Bandeau réservation ancré en bas du hero --}}
    <div class="absolute bottom-0 inset-x-0 z-10 shadow-2xl" style="background-color: var(--color-blue);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between gap-4">

            <div class="text-white leading-tight shrink-0">
                <span class="block font-bold uppercase tracking-[0.2em] text-sm sm:text-base">{{ __('Réservez') }}</span>
                <span class="block text-xs" style="color: rgba(255,255,255,0.75);">{{ __('votre séjour') }}</span>
            </div>

            <div class="hidden md:flex items-center text-white">
                @foreach ([
                    ['icon' => 'M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z', 'l1' => __('Paiement'), 'l2' => __('100 % sécurisé')],
                    ['icon' => 'M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'l1' => __('Meilleur prix'), 'l2' => __('garanti')],
                    ['icon' => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z', 'l1' => __('Disponibilités'), 'l2' => __('en temps réel')],
                ] as $item)
                <div class="flex items-center gap-2.5 px-5 lg:px-7 {{ $loop->first ? '' : 'border-l' }}" style="border-color: rgba(255,255,255,0.25);">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/></svg>
                    <span class="leading-tight text-left">
                        <span class="block text-xs" style="color: rgba(255,255,255,0.8);">{{ $item['l1'] }}</span>
                        <span class="block text-sm font-bold">{{ $item['l2'] }}</span>
                    </span>
                </div>
                @endforeach
            </div>

            <a href="{{ route('rooms.index') }}"
               class="shrink-0 bg-white rounded-lg px-5 py-2.5 text-sm font-bold transition-transform hover:-translate-y-0.5 shadow-md"
               style="color: var(--color-blue);">
                {{ __('Réserver maintenant') }}
            </a>
        </div>
    </div>
</section>

{{-- ===== NOTRE DIFFÉRENCE (éditorial + badge logo rotatif) ===== --}}
<section class="py-24 px-4 sm:px-6 lg:px-8" style="background-color: white;">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-14 items-start">

            {{-- Colonne gauche : titre éditorial + badge logo --}}
            <div class="lg:col-span-5 lg:sticky lg:top-28">
                <p class="text-sm font-semibold uppercase tracking-widest mb-4" style="color: var(--color-orange);">{{ __('Notre différence') }}</p>
                <h2 class="section-title text-4xl sm:text-5xl mb-6">
                    {{ __('Le luxe simple,') }}<br>
                    <em>{{ __("les pieds dans l'eau") }}</em>
                </h2>
                <p class="leading-relaxed mb-10 max-w-md" style="color: var(--color-slate);">
                    {{ __("Pas de dorures, pas de superflu : une lagune, une piscine qui s'y fond, des jardins et le temps qui ralentit. C'est notre définition du luxe à Assinie.") }}
                </p>

                {{-- Badge logo rotatif --}}
                <div class="relative w-40 h-40" aria-hidden="true">
                    <svg viewBox="0 0 160 160" class="absolute inset-0 w-full h-full spin-slow">
                        <defs>
                            <path id="badge-circle" d="M 80,80 m -64,0 a 64,64 0 1,1 128,0 a 64,64 0 1,1 -128,0" />
                        </defs>
                        <text class="uppercase" style="font-size: 12.5px; letter-spacing: 0.32em; fill: var(--color-slate); font-weight: 600;">
                            <textPath href="#badge-circle">Résidence-Hôtel · Assinie · Lagune Aby ·</textPath>
                        </text>
                    </svg>
                    <img src="{{ asset('images/logo.png') }}" alt=""
                         class="absolute inset-0 m-auto w-24 h-24 rounded-full bg-white object-contain p-1 shadow-xl ring-2"
                         style="--tw-ring-color: rgba(232,114,12,0.3);">
                </div>
            </div>

            {{-- Colonne droite : features numérotées --}}
            <div class="lg:col-span-7">
                @foreach ([
                    ['num' => '01', 'icon' => 'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z', 'title' => __('Piscine à débordement'), 'desc' => __('Un bassin turquoise qui semble se fondre dans la lagune, bordé d\'une plage en bois — en accès libre pour tous nos hôtes.')],
                    ['num' => '02', 'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => __('Les pieds dans la lagune'), 'desc' => __('Au Km 18,75 d\'Assinie, entre la lagune Aby et l\'océan : jardins au bord de l\'eau, balades en pirogue et couchers de soleil sur la lagune.')],
                    ['num' => '03', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'title' => __('Paiement à l\'arrivée'), 'desc' => __('Réservez sans risque : aucun prépaiement en ligne, annulation gratuite jusqu\'à 48h avant votre arrivée.')],
                    ['num' => '04', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'title' => __('Confirmation immédiate'), 'desc' => __('Votre réservation est confirmée en ligne en moins de 5 minutes, avec le petit-déjeuner inclus chaque matin.')],
                ] as $feat)
                <div class="group flex items-start gap-6 py-8 border-t transition-colors hover:bg-[var(--color-snow)] rounded-b-none px-2 sm:px-4 {{ $loop->last ? 'border-b' : '' }}" style="border-color: var(--color-border);">
                    <span class="feature-num pt-1 w-14 shrink-0">{{ $feat['num'] }}</span>
                    <div class="flex-1">
                        <h3 class="text-xl mb-2" style="color: var(--color-navy); font-family: var(--font-serif); font-weight: 600;">{{ $feat['title'] }}</h3>
                        <p class="text-sm leading-relaxed max-w-lg" style="color: var(--color-slate);">{{ $feat['desc'] }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-full hidden sm:flex items-center justify-center shrink-0 transition-all duration-300 group-hover:scale-110" style="background-color: var(--color-sand);">
                        <svg class="w-5 h-5" style="color: #9A3412;" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $feat['icon'] }}"/></svg>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ===== CHAMBRES VEDETTES ===== --}}
<section class="py-20 px-4 sm:px-6 lg:px-8" style="background-color: var(--color-snow);">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-end justify-between mb-12">
            <div>
                <p class="text-sm font-semibold uppercase tracking-widest mb-2" style="color: var(--color-orange);">{{ __('Notre catalogue') }}</p>
                <h2 class="section-title">{{ __('Nos Chambres') }} <em>{{ __('& Suites') }}</em></h2>
                <p class="section-subtitle max-w-md">{{ __('Quatre catégories de chambres — à deux, en famille ou entre amis, vue jardin ou lagune.') }}</p>
            </div>
        </div>

        @if ($roomsByCategory->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($roomsByCategory as $categoryKey => $room)
            <a href="{{ route('rooms.index', ['category' => [$categoryKey]]) }}" class="card group no-underline flex flex-col">
                <div class="p-3 pb-0">
                    <div class="relative rounded-xl overflow-hidden aspect-[4/3]">
                        <img src="{{ asset($room->first_image) }}" alt="{{ __($room->category_label) }}"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                    </div>
                </div>
                <div class="p-5 flex-1 flex flex-col">
                    <h3 class="text-lg leading-snug mb-2" style="font-family: var(--font-serif); font-weight: 600; color: var(--color-navy);">{{ __($room->category_label) }}</h3>
                    <span class="block w-8 h-0.5 rounded mb-4" style="background-color: var(--color-orange);" aria-hidden="true"></span>

                    <ul class="space-y-3 text-sm" style="color: var(--color-navy);">
                        <li class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 mt-0.5 shrink-0" style="color: var(--color-orange);" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>
                                <span class="block text-xs" style="color: var(--color-slate);">{{ __('Pour') }}</span>
                                <strong>{{ $room->capacity_adults > 2 ? '2-' . $room->capacity_adults : $room->capacity_adults }} {{ __('pers.') }}</strong>
                            </span>
                        </li>
                        @if ($room->size_m2)
                        <li class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 mt-0.5 shrink-0" style="color: var(--color-orange);" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 8V6a2 2 0 012-2h2M4 16v2a2 2 0 002 2h2m8-16h2a2 2 0 012 2v2m-4 12h2a2 2 0 002-2v-2"/></svg>
                            <span>
                                <span class="block text-xs" style="color: var(--color-slate);">{{ __('Superficie') }}</span>
                                <strong>{{ $room->size_m2 }} m²</strong>
                            </span>
                        </li>
                        @endif
                    </ul>

                    <p class="mt-auto pt-4 mt-5 border-t text-xs font-medium flex items-center gap-2" style="border-color: var(--color-border); color: var(--color-slate);">
                        <svg class="w-3.5 h-3.5 shrink-0" style="color: var(--color-orange);" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        {{ $room->categoryRef?->tagline_label }}
                    </p>
                </div>
            </a>
            @endforeach
        </div>

        {{-- Présentation + CTA --}}
        <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-start text-sm leading-relaxed" style="color: var(--color-slate);">
            <p>
                {!! __('Avec <strong>quatre catégories de chambres</strong>, le Havre de Paix vous accueille en couple, en famille ou entre amis — toutes avec petit-déjeuner, WiFi et climatisation inclus.') !!}
            </p>
            <div>
                <p class="mb-5">
                    {{ __("Choisissez une chambre côté jardin, une Suite avec baignoire ou une Chambre Familiale jusqu'à 4 personnes — la piscine à débordement et la lagune sont à quelques pas, pour tous.") }}
                </p>
                <a href="{{ route('rooms.index') }}" class="btn-navy">{{ __('Découvrez toutes nos chambres') }}</a>
            </div>
        </div>
        @else
        <div class="text-center py-12" style="color: var(--color-slate);">
            <p>{{ __('Les chambres seront bientôt disponibles.') }}</p>
        </div>
        @endif

    </div>
</section>

{{-- ===== L'HÔTEL EN VIDÉO ===== --}}
<section class="py-20 px-4 sm:px-6 lg:px-8 overflow-hidden" style="background-color: var(--color-ink);"
         x-data="{ videoOpen: null,
                   openVideo(src) { this.videoOpen = src; document.querySelectorAll('.js-hotel-video').forEach(v => v.pause()); },
                   closeVideo()  { this.videoOpen = null; document.querySelectorAll('.js-hotel-video').forEach(v => v.play().catch(() => {})); } }"
         @keydown.escape.window="closeVideo()">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

            <div class="text-center lg:text-left">
                <p class="text-sm font-semibold uppercase tracking-widest mb-3" style="color: var(--color-primary);">{{ __('Immersion') }}</p>
                <h2 class="text-4xl text-white tracking-tight mb-4" style="font-family: var(--font-serif); font-weight: 600;">{{ __('Visitez avant') }} <em class="title-accent">{{ __('de réserver') }}</em></h2>
                <p class="leading-relaxed mb-8 max-w-md mx-auto lg:mx-0" style="color: rgba(255,255,255,0.65);">
                    {{ __("Quelques secondes suffisent pour ressentir l'atmosphère du domaine : la lagune, la piscine à débordement, les jardins — comme si vous y étiez.") }}
                </p>
                <a href="{{ route('rooms.index') }}" class="btn-primary">
                    {{ __('Réserver mon séjour') }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="flex justify-center">
                @foreach (['visite.mp4' => __('Visite de la résidence')] as $file => $label)
                <div class="relative w-full max-w-xl">
                    <div class="rounded-[1.75rem] overflow-hidden shadow-2xl border-4 cursor-pointer group relative"
                         style="border-color: rgba(255,255,255,0.12); aspect-ratio: 16/9; background-color: #000;"
                         @click="openVideo('{{ asset('videos/' . $file) }}')"
                         role="button" tabindex="0" aria-label="{{ __('Regarder :') }} {{ $label }}"
                         @keydown.enter="openVideo('{{ asset('videos/' . $file) }}')">
                        <video src="{{ asset('videos/' . $file) }}"
                               class="w-full h-full object-cover js-hotel-video"
                               loop muted playsinline preload="metadata"
                               aria-label="{{ $label }}"></video>
                        {{-- Indice lecture --}}
                        <div class="absolute inset-0 flex items-center justify-center bg-black/0 group-hover:bg-black/25 transition-colors">
                            <span class="w-14 h-14 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity"
                                  style="background-color: rgba(255,255,255,0.22); backdrop-filter: blur(4px);">
                                <svg class="w-7 h-7 text-white ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            </span>
                        </div>
                    </div>
                    <p class="text-center text-xs mt-3 font-medium" style="color: rgba(255,255,255,0.55);">{{ $label }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Visionneuse vidéo plein écran --}}
    <template x-if="videoOpen">
        <div class="fixed inset-0 z-[100] bg-black/95 flex items-center justify-center p-4" @click.self="closeVideo()"
             role="dialog" aria-modal="true" aria-label="{{ __('Lecture de la vidéo') }}">
            <button @click="closeVideo()" class="absolute top-4 right-4 z-20 text-white/80 hover:text-white cursor-pointer" aria-label="Fermer">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <video :src="videoOpen" class="max-h-[88vh] max-w-full w-full sm:max-w-4xl rounded-2xl shadow-2xl"
                   controls autoplay playsinline></video>
        </div>
    </template>
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
            <p class="text-sm font-semibold uppercase tracking-widest mb-2" style="color: var(--color-orange);">{{ __('Le lieu') }}</p>
            <h2 class="section-title">{{ __('Le décor de') }} <em>{{ __('votre séjour') }}</em></h2>
            <p class="section-subtitle max-w-md mx-auto">{{ __("De jour comme de nuit — la résidence, sa piscine et ses lumières. Cliquez sur une photo pour l'agrandir.") }}</p>
        </div>

        @php
        // Le domaine de jour, la piscine et la terrasse de nuit.
        $decorTiles = [
            ['img' => 'site/hero-piscine-lagune.jpg', 'label' => __('La piscine sur la lagune'),  'alt' => 'La piscine à débordement face à la lagune d\'Assinie',        'class' => 'col-span-2 md:row-span-2 aspect-[4/3] md:aspect-auto'],
            ['img' => 'site/pavillon-exterieur.jpg',  'label' => __('Le pavillon vitré'),         'alt' => 'Le pavillon vitré du petit-déjeuner face à la lagune',        'class' => 'aspect-square md:aspect-auto'],
            ['img' => 'site/jardin.jpg',              'label' => __('Les jardins'),               'alt' => 'Les jardins verdoyants de la résidence',                      'class' => 'aspect-square md:aspect-auto'],
            ['img' => 'site/piscine-palmiers.jpg',    'label' => __('Les palmiers'),              'alt' => 'La piscine bordée de palmiers',                               'class' => 'aspect-square md:aspect-auto'],
            ['img' => 'site/coursive-nuit.jpg',       'label' => __('Les coursives, le soir'),    'alt' => 'Les coursives éclairées à la tombée de la nuit',              'class' => 'aspect-square md:aspect-auto'],
            ['img' => 'site/hero-piscine-nuit-arbre.jpg', 'label' => __('La piscine de nuit'),    'alt' => 'La piscine illuminée de nuit et son arbre éclairé',           'class' => 'aspect-square md:aspect-auto'],
            ['img' => 'site/terrasse-nuit.jpg',       'label' => __('La terrasse en soirée'),     'alt' => 'La terrasse du pavillon éclairée en soirée',                  'class' => 'aspect-square md:aspect-auto'],
            ['img' => 'site/hero-piscine-large.jpg',  'label' => __('Le bassin à débordement'),   'alt' => 'Le grand bassin à débordement et sa plage en bois',           'class' => 'col-span-2 aspect-[16/9] md:aspect-auto'],
        ];
        @endphp

        <div class="grid grid-cols-2 md:grid-cols-4 md:grid-rows-3 gap-3 md:h-[760px]">
            @foreach ($decorTiles as $tile)
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
            <p class="text-sm font-semibold uppercase tracking-widest mb-2" style="color: var(--color-orange);">{{ __('L\'expérience') }}</p>
            <h2 class="section-title">{{ __('Le pavillon &') }} <em>{{ __('la lagune') }}</em></h2>
            <p class="section-subtitle max-w-md mx-auto">{{ __('Petit-déjeuner face à l\'eau, baignade à débordement et couchers de soleil — la lagune rythme vos journées.') }}</p>
        </div>

        {{-- Deux moments éditoriaux (images en arche) --}}
        <div class="space-y-20 mb-16">

            {{-- Le pavillon --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center">
                <div class="relative cursor-zoom-in group img-arch h-[380px] sm:h-[460px]"
                     data-gallery="saveurs" role="button" tabindex="0"
                     @click="show($event.currentTarget)" @keydown.enter="show($event.currentTarget)">
                    <img src="{{ asset('images/site/pavillon-repas.jpg') }}" alt="Le pavillon vitré du petit-déjeuner du Havre de Paix"
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy">
                </div>
                <div class="lg:pr-8">
                    <p class="text-xs font-bold uppercase tracking-[0.2em] mb-3" style="color: var(--color-orange);">{{ __('Le Pavillon') }}</p>
                    <h3 class="section-title text-3xl mb-5">{{ __('Le petit-déjeuner') }} <em>{{ __('face à la lagune') }}</em></h3>
                    <p class="leading-relaxed mb-6" style="color: var(--color-slate);">
                        {{ __('Chaque matin, votre petit-déjeuner — inclus dans le séjour — est servi dans le pavillon vitré, entre les palmiers et la lagune. Le restaurant complet ouvrira prochainement.') }}
                    </p>
                    <div class="flex flex-wrap gap-2.5">
                        <span class="badge-orange">{{ __('Petit-déjeuner inclus') }}</span>
                        <span class="badge">{{ __('Vue lagune à chaque table') }}</span>
                    </div>
                </div>
            </div>

            {{-- La lagune --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center">
                <div class="lg:pl-8 order-2 lg:order-1">
                    <p class="text-xs font-bold uppercase tracking-[0.2em] mb-3" style="color: var(--color-orange);">{{ __('La Lagune') }}</p>
                    <h3 class="section-title text-3xl mb-5">{{ __('Les couchers de soleil sur') }} <em>{{ __('la lagune Aby') }}</em></h3>
                    <p class="leading-relaxed mb-6" style="color: var(--color-slate);">
                        {{ __("Depuis les jardins au bord de l'eau, embarquez pour une balade en pirogue, rejoignez la plage d'Assinie-Mafia ou contemplez simplement le coucher de soleil sur la lagune.") }}
                    </p>
                    <div class="flex flex-wrap gap-2.5">
                        <span class="badge-orange">{{ __('Balades en pirogue') }}</span>
                        <span class="badge">{{ __('Plage océane à quelques minutes') }}</span>
                    </div>
                </div>
                <div class="relative cursor-zoom-in group img-arch h-[380px] sm:h-[460px] order-1 lg:order-2"
                     data-gallery="saveurs" role="button" tabindex="0"
                     @click="show($event.currentTarget)" @keydown.enter="show($event.currentTarget)">
                    <img src="{{ asset('images/site/hero-palmiers.jpg') }}" alt="Les palmiers penchés au-dessus du bassin, la lagune en toile de fond"
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy">
                </div>
            </div>
        </div>

        {{-- Ambiances --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            @foreach ([
                ['img' => 'site/hero-piscine.jpg',   'label' => __('Le bassin turquoise'),  'alt' => 'Le bassin turquoise de la piscine à débordement'],
                ['img' => 'site/pavillon-salon.jpg', 'label' => __('Le salon du pavillon'), 'alt' => 'Le coin salon du pavillon vitré'],
                ['img' => 'site/jardin-nuit.jpg',    'label' => __('Le jardin, le soir'),   'alt' => 'Le jardin de la résidence à la tombée de la nuit'],
                ['img' => 'site/hero-facade-hotel.jpg', 'label' => __('La résidence'),      'alt' => 'La façade de la résidence, vue depuis l\'entrée du domaine'],
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
                {{ __('Découvrir le Restaurant') }}
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
        <p class="text-sm font-semibold uppercase tracking-widest mb-3" style="color: var(--color-orange);">{{ __('Avis clients') }}</p>
        <h2 class="text-4xl text-white tracking-tight" style="font-family: var(--font-serif); font-weight: 600;">{{ __('Ce que disent') }} <em class="title-accent">{{ __('nos hôtes') }}</em></h2>
    </div>

    @php
    $reviews = [
        ['name' => 'Kofi A.',        'note' => 5, 'context' => __('Séjour en famille · Avril 2026'),      'text' => __('Un séjour parfait en famille. La piscine à débordement face à la lagune est magique, les enfants ne voulaient plus partir.')],
        ['name' => 'Aminata D.',     'note' => 5, 'context' => __('Week-end en couple · Mars 2026'),      'text' => __('Le petit-déjeuner dans le pavillon vitré, avec la lagune sous les yeux : le plus beau réveil de l\'année.')],
        ['name' => 'Sophie M.',      'note' => 5, 'context' => __('Séjour en couple · Février 2026'),     'text' => __('Cadre paisible et verdoyant, chambres impeccables et très bien climatisées. On a adoré le coucher de soleil sur la lagune.')],
        ['name' => 'Yao K.',         'note' => 5, 'context' => __('Anniversaire · Mai 2026'),             'text' => __('Réservation en ligne simple, paiement à l\'arrivée rassurant. La Suite Premium vaut chaque franc.')],
        ['name' => 'Jean-Paul K.',   'note' => 4, 'context' => __('Week-end entre amis · Janv. 2026'),    'text' => __('La Chambre Familiale est parfaite à quatre : chacun son espace, un salon commun, et la lagune à dix mètres.')],
        ['name' => 'Mariam T.',      'note' => 4, 'context' => __('Week-end entre amies · Juin 2026'),    'text' => __('Un vrai havre de paix, loin du bruit d\'Abidjan. La balade en pirogue sur la lagune est à faire absolument.')],
        ['name' => 'Franck B.',      'note' => 5, 'context' => __('Séjour en famille · Déc. 2025'),       'text' => __('À 1h30 d\'Abidjan et pourtant la déconnexion totale. Piscine impeccable, personnel aux petits soins.')],
        ['name' => 'Awa S.',         'note' => 5, 'context' => __('Voyage solo · Mai 2026'),              'text' => __('L\'annulation gratuite m\'a décidée, l\'accueil m\'a conquise. Chambre parfaite, cadre sûr et reposant.')],
    ];
    @endphp

    <div class="relative marquee">
        {{-- Fondus latéraux --}}
        <div class="absolute inset-y-0 left-0 w-16 sm:w-32 z-10 pointer-events-none" style="background: linear-gradient(to right, var(--color-navy), transparent);"></div>
        <div class="absolute inset-y-0 right-0 w-16 sm:w-32 z-10 pointer-events-none" style="background: linear-gradient(to left, var(--color-navy), transparent);"></div>

        <div class="marquee-track flex w-max gap-5">
            @foreach (array_merge($reviews, $reviews) as $t)
            <div class="w-96 shrink-0 rounded-3xl p-7 text-left relative" style="background-color: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.08);">
                <span class="absolute top-4 right-6 text-6xl leading-none select-none" style="font-family: var(--font-serif); color: rgba(232,114,12,0.35);" aria-hidden="true">”</span>
                <div class="flex items-center gap-1 mb-4" role="img" aria-label="Note : {{ $t['note'] }} sur 5">
                    @for ($i = 1; $i <= 5; $i++)
                    <svg class="w-4 h-4" style="color: {{ $i <= $t['note'] ? 'var(--color-orange)' : 'rgba(255,255,255,0.2)' }};" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <p class="text-base leading-relaxed mb-5 italic" style="color: rgba(255,255,255,0.85); font-family: var(--font-serif); font-weight: 300;">{{ $t['text'] }}</p>
                <div class="flex items-center gap-3">
                    <span class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold text-white shrink-0" style="background-color: var(--color-orange);">{{ mb_substr($t['name'], 0, 1) }}</span>
                    <div>
                        <p class="text-sm font-semibold text-white">{{ $t['name'] }}</p>
                        <p class="text-xs mt-0.5" style="color: rgba(255,255,255,0.5);">{{ $t['context'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== CTA FINAL (panneau immersif) ===== --}}
<section class="py-20 px-4 sm:px-6 lg:px-8" style="background-color: white;">
    <div class="max-w-7xl mx-auto relative overflow-hidden rounded-[2.5rem]">
        <img src="{{ asset('images/site/piscine-nuit.jpg') }}" alt="" aria-hidden="true"
             class="absolute inset-0 w-full h-full object-cover" loading="lazy">
        <div class="absolute inset-0" style="background: linear-gradient(135deg, rgba(11,18,21,0.9) 0%, rgba(11,18,21,0.62) 100%);"></div>

        <div class="relative z-10 text-center text-white max-w-2xl mx-auto px-6 py-20 sm:py-24">
            <img src="{{ asset('images/logo.png') }}" alt="Havre de Paix"
                 class="w-20 h-20 mx-auto mb-6 rounded-full bg-white object-contain p-1 shadow-2xl ring-2"
                 style="--tw-ring-color: rgba(232,114,12,0.45);">
            <h2 class="text-4xl sm:text-5xl mb-5" style="font-family: var(--font-serif); font-weight: 600;">
                {{ __('Prêt pour votre') }} <em class="title-accent">{{ __('escapade ?') }}</em>
            </h2>
            <p class="text-white/75 mb-9 leading-relaxed">
                {{ __("Réservez votre chambre en ligne en moins de 5 minutes. Confirmation instantanée. Paiement à l'arrivée.") }}
            </p>
            <a href="{{ route('rooms.index') }}" class="btn-primary text-base px-10 py-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                {{ __('Réserver maintenant') }}
            </a>
            <p class="mt-5 text-sm text-white/60">{{ __("Annulation gratuite jusqu'à 48h avant l'arrivée") }}</p>
        </div>
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
</script>
@endpush
