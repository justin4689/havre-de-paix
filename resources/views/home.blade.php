@extends('layouts.app')

@section('title', __('Havre de Paix — Résidence-Hôtel à Assinie, au bord de la lagune'))
@section('description', __('Réservez votre séjour au Havre de Paix, résidence-hôtel à Assinie (Km 18,75), Côte d\'Ivoire. Piscine à débordement sur la lagune, chambres et suites climatisées, petit-déjeuner inclus. Paiement à l\'arrivée.'))
@section('hero_nav', '1')

@section('content')

{{-- ===== HERO ===== --}}
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    {{-- Background : vidéo de la lagune (image fixe en repli / reduced motion) --}}
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/site/hero-piscine-lagune.jpg') }}"
             alt="{{ __('La piscine à débordement du Havre de Paix face à la lagune d\'Assinie') }}"
             class="absolute inset-0 w-full h-full object-cover">
        <video class="absolute inset-0 w-full h-full object-cover motion-reduce:hidden"
               src="{{ asset('videos/hero.mp4') }}"
               poster="{{ asset('images/site/hero-piscine-lagune.jpg') }}"
               autoplay muted loop playsinline preload="metadata" aria-hidden="true" tabindex="-1"></video>
        <div class="absolute inset-0 hero-overlay"></div>
    </div>

    <div class="relative z-10 text-center text-white px-4 sm:px-6 max-w-5xl mx-auto pt-24">
        <div class="badge-orange mb-6 inline-flex">
            <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            {{ __("Assinie · Kilomètre 18,75 · Côte d'Ivoire") }}
        </div>

        <h1 class="text-5xl sm:text-6xl lg:text-7xl font-bold mb-6 leading-tight" style="font-family: var(--font-serif);">
            Havre de <span style="color: var(--color-orange);">Paix</span>
        </h1>

        <p class="text-lg sm:text-xl mb-10 leading-relaxed max-w-2xl mx-auto" style="color: rgba(255,255,255,0.85);">
            {{ __('Une résidence-hôtel les pieds dans la lagune, à Assinie. Piscine à débordement, jardins et chambres climatisées, petit-déjeuner inclus.') }}
            <strong style="color: white;">{{ __('Paiement à l\'arrivée — aucun prépaiement requis.') }}</strong>
        </p>

        {{-- Barre de recherche « pill » segmentée --}}
        <div class="max-w-3xl mx-auto animate-fade-up">
            <form action="{{ route('rooms.index') }}" method="GET"
                  class="bg-white rounded-2xl sm:rounded-full shadow-2xl p-2 flex flex-col sm:flex-row sm:items-center text-left"
                  style="color: var(--color-navy);">

                <div class="flex-1 min-w-0 px-5 py-2.5 rounded-2xl sm:rounded-full transition-colors hover:bg-slate-50">
                    <label for="check_in" class="block text-xs font-bold uppercase tracking-wide mb-0.5">{{ __('Arrivée') }}</label>
                    <input type="date" id="check_in" name="check_in"
                           min="{{ date('Y-m-d') }}"
                           value="{{ request('check_in') }}"
                           class="w-full bg-transparent text-sm font-medium outline-none border-0 p-0 cursor-pointer"
                           required>
                </div>

                <div class="hidden sm:block w-px self-stretch my-3" style="background-color: var(--color-border);"></div>
                <div class="sm:hidden h-px mx-5" style="background-color: var(--color-border);"></div>

                <div class="flex-1 min-w-0 px-5 py-2.5 rounded-2xl sm:rounded-full transition-colors hover:bg-slate-50">
                    <label for="check_out" class="block text-xs font-bold uppercase tracking-wide mb-0.5">{{ __('Départ') }}</label>
                    <input type="date" id="check_out" name="check_out"
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                           value="{{ request('check_out') }}"
                           class="w-full bg-transparent text-sm font-medium outline-none border-0 p-0 cursor-pointer"
                           required>
                </div>

                <div class="hidden sm:block w-px self-stretch my-3" style="background-color: var(--color-border);"></div>
                <div class="sm:hidden h-px mx-5" style="background-color: var(--color-border);"></div>

                <div class="flex-1 min-w-0 px-5 py-2.5 rounded-2xl sm:rounded-full transition-colors hover:bg-slate-50">
                    <label for="guests" class="block text-xs font-bold uppercase tracking-wide mb-0.5">{{ __('Hôtes') }}</label>
                    <select id="guests" name="capacity" class="w-full bg-transparent text-sm font-medium outline-none border-0 p-0 cursor-pointer">
                        @for ($i = 1; $i <= 8; $i++)
                        <option value="{{ $i }}" {{ request('capacity') == $i ? 'selected' : '' }}>{{ trans_choice(':n hôte|:n hôtes', $i, ['n' => $i]) }}</option>
                        @endfor
                    </select>
                </div>

                <button type="submit" class="btn-search h-12 sm:w-12 w-auto px-6 sm:px-0 m-1 sm:m-0 sm:ml-2" aria-label="{{ __('Rechercher les disponibilités') }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <span class="sm:hidden">{{ __('Rechercher') }}</span>
                </button>
            </form>

            <p class="mt-5 text-sm font-medium" style="color: rgba(255,255,255,0.85);">
                {{ __("Annulation gratuite jusqu'à 48h") }} &middot; {{ __("Paiement à l'arrivée") }} &middot; {{ __('Confirmation immédiate') }}
            </p>
        </div>
    </div>

    {{-- Scroll indicator --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10 animate-bounce">
        <svg class="w-6 h-6 text-white opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
    </div>
</section>

{{-- ===== BANDEAU DÉFILANT ===== --}}
<div class="py-4 overflow-hidden marquee" style="background-color: var(--color-ink);" aria-hidden="true">
    <div class="marquee-track flex w-max items-center">
        @for ($i = 0; $i < 2; $i++)
        <div class="ticker-item pr-6 text-sm font-semibold uppercase tracking-[0.22em] text-white/80">
            @foreach ([__('Piscine à débordement'), __('Lagune Aby'), __('Petit-déjeuner inclus'), __('Ponton privé'), __('Paiement à l\'arrivée'), __('Assinie · Km 18,75')] as $mot)
            <span>{{ $mot }}</span>
            <svg class="w-3.5 h-3.5 shrink-0" style="color: var(--color-orange);" fill="currentColor" viewBox="0 0 20 20"><path d="M10 1l2.35 6.65L19 10l-6.65 2.35L10 19l-2.35-6.65L1 10l6.65-2.35L10 1z"/></svg>
            @endforeach
        </div>
        @endfor
    </div>
</div>

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
                    ['num' => '02', 'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => __('Les pieds dans la lagune'), 'desc' => __('Au Km 18,75 d\'Assinie, entre la lagune Aby et l\'océan : ponton privé, balades en pirogue et couchers de soleil sur l\'eau.')],
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
                <p class="section-subtitle max-w-md">{{ __("De la Chambre Standard au Duplex familial, trouvez l'hébergement qui vous correspond.") }}</p>
            </div>
            <a href="{{ route('rooms.index') }}" class="btn-outline hidden sm:inline-flex">
                {{ __('Voir toutes les chambres') }}
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        @if ($roomsByCategory->isNotEmpty())
        {{-- Carrousel horizontal : une carte « arche » par catégorie --}}
        <div class="snap-row -mx-4 px-4 sm:mx-0 sm:px-0">
            @foreach ($roomsByCategory as $categoryKey => $room)
            <a href="{{ route('rooms.show', $room->slug) }}"
               class="group relative block shrink-0 w-[280px] sm:w-[320px] h-[460px] img-arch no-underline">
                <img src="{{ asset($room->first_image) }}" alt="{{ __($room->name) }}"
                     class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy">
                <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(11,18,21,0.82) 0%, rgba(11,18,21,0.12) 45%, rgba(11,18,21,0.18) 100%);"></div>

                {{-- Chip catégorie (verre) --}}
                <span class="absolute top-5 left-1/2 -translate-x-1/2 px-4 py-1.5 rounded-full text-[11px] font-bold uppercase tracking-[0.16em] text-white whitespace-nowrap"
                      style="background-color: rgba(255,255,255,0.16); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.25);">
                    {{ __($room->category_label) }}
                </span>

                {{-- Bas de carte --}}
                <div class="absolute inset-x-0 bottom-0 p-6">
                    <h3 class="text-white text-2xl mb-1" style="font-family: var(--font-serif); font-weight: 600;">{{ __($room->name) }}</h3>
                    <p class="text-white/70 text-xs mb-3">
                        {{ trans_choice(':n hôte|:n hôtes', $room->capacity_adults, ['n' => $room->capacity_adults]) }}
                        @if ($room->size_m2) · {{ $room->size_m2 }} m² @endif
                        · {{ $room->bed_type_label }}
                    </p>
                    <div class="flex items-end justify-between gap-3">
                        <p class="text-white">
                            <span class="text-[11px] uppercase tracking-wide text-white/60 block">{{ __('à partir de') }}</span>
                            <span class="text-xl font-bold">{{ number_format($room->price_per_night, 0, ',', ' ') }}</span>
                            <span class="text-xs text-white/70">FCFA / {{ __('nuit') }}</span>
                        </p>
                        <span class="w-11 h-11 rounded-full flex items-center justify-center shrink-0 transition-all duration-300 group-hover:rotate-45"
                              style="background-color: var(--color-orange);">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17L17 7M7 7h10v10"/></svg>
                        </span>
                    </div>
                </div>
            </a>
            @endforeach

            {{-- Carte finale : tout le catalogue --}}
            <a href="{{ route('rooms.index') }}"
               class="group relative shrink-0 w-[280px] sm:w-[320px] h-[460px] img-arch no-underline flex flex-col items-center justify-center text-center p-8"
               style="background-color: var(--color-ink);">
                <img src="{{ asset('images/logo.png') }}" alt="" class="w-16 h-16 rounded-full bg-white object-contain p-1 mb-6 shadow-lg" aria-hidden="true">
                <p class="text-white text-2xl mb-2" style="font-family: var(--font-serif); font-weight: 600;">{{ __('Toutes nos chambres') }}</p>
                <p class="text-white/60 text-sm mb-8">{{ __('Filtrez par dates, capacité et budget') }}</p>
                <span class="w-14 h-14 rounded-full flex items-center justify-center transition-all duration-300 group-hover:rotate-45" style="background-color: var(--color-orange);">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17L17 7M7 7h10v10"/></svg>
                </span>
            </a>
        </div>
        <p class="mt-2 text-xs flex items-center gap-1.5 sm:hidden" style="color: var(--color-slate);">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            {{ __('Faites défiler pour découvrir') }}
        </p>
        @else
        <div class="text-center py-12" style="color: var(--color-slate);">
            <p>{{ __('Les chambres seront bientôt disponibles.') }}</p>
        </div>
        @endif

        <div class="text-center mt-8 sm:hidden">
            <a href="{{ route('rooms.index') }}" class="btn-outline">{{ __('Voir toutes les chambres') }}</a>
        </div>
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
            ['img' => 'site/ponton-lagune.jpg',       'label' => __('Le ponton'),                 'alt' => 'Le ponton en bois sur la lagune Aby',                         'class' => 'aspect-square md:aspect-auto'],
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
            <p class="section-subtitle max-w-md mx-auto">{{ __('Petit-déjeuner face à l\'eau, baignade à débordement et ponton privé — la lagune rythme vos journées.') }}</p>
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
                    <h3 class="section-title text-3xl mb-5">{{ __('Le ponton sur') }} <em>{{ __('la lagune Aby') }}</em></h3>
                    <p class="leading-relaxed mb-6" style="color: var(--color-slate);">
                        {{ __("Depuis le ponton privé, embarquez pour une balade en pirogue, rejoignez la plage d'Assinie-Mafia ou contemplez simplement le coucher de soleil sur l'eau.") }}
                    </p>
                    <div class="flex flex-wrap gap-2.5">
                        <span class="badge-orange">{{ __('Balades en pirogue') }}</span>
                        <span class="badge">{{ __('Plage océane à quelques minutes') }}</span>
                    </div>
                </div>
                <div class="relative cursor-zoom-in group img-arch h-[380px] sm:h-[460px] order-1 lg:order-2"
                     data-gallery="saveurs" role="button" tabindex="0"
                     @click="show($event.currentTarget)" @keydown.enter="show($event.currentTarget)">
                    <img src="{{ asset('images/site/ponton-lagune.jpg') }}" alt="Le ponton en bois du Havre de Paix sur la lagune Aby"
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy">
                </div>
            </div>
        </div>

        {{-- Ambiances --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            @foreach ([
                ['img' => 'site/hero-piscine.jpg',   'label' => __('Le bassin turquoise'),  'alt' => 'Le bassin turquoise de la piscine à débordement'],
                ['img' => 'site/pavillon-salon.jpg', 'label' => __('Le salon du pavillon'), 'alt' => 'Le coin salon du pavillon vitré'],
                ['img' => 'site/ponton.jpg',         'label' => __('Face à la lagune'),     'alt' => 'Le ponton et les palmiers face à la lagune'],
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
                {{ __('Découvrir le domaine') }}
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
        ['name' => 'Sophie M.',      'note' => 5, 'context' => __('Séjour en couple · Février 2026'),     'text' => __('Cadre paisible et verdoyant, chambres impeccables et très bien climatisées. On a adoré le coucher de soleil depuis le ponton.')],
        ['name' => 'Yao K.',         'note' => 5, 'context' => __('Anniversaire · Mai 2026'),             'text' => __('Réservation en ligne simple, paiement à l\'arrivée rassurant. La Suite Premium vaut chaque franc.')],
        ['name' => 'Jean-Paul K.',   'note' => 4, 'context' => __('Week-end entre amis · Janv. 2026'),    'text' => __('Le Duplex est parfait à quatre : chacun sa chambre, un salon commun, et la lagune à dix mètres.')],
        ['name' => 'Mariam T.',      'note' => 4, 'context' => __('Week-end entre amies · Juin 2026'),    'text' => __('Un vrai havre de paix, loin du bruit d\'Abidjan. La balade en pirogue au départ du ponton est à faire absolument.')],
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
