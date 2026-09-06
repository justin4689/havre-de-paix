@extends('layouts.app')
@section('title', __('Découvrir le domaine — Havre de Paix'))
@section('description', __('La piscine à débordement, le pavillon vitré, le ponton sur la lagune Aby et les jardins du Havre de Paix, résidence-hôtel à Assinie Kilomètre 18,75.'))
@section('hero_nav', '1')
@section('content')
<div x-data="{ lightbox: null, imgs: [
        { s: '{{ asset('images/site/hero-piscine-lagune.jpg') }}', a: 'La piscine à débordement face à la lagune' },
        { s: '{{ asset('images/site/piscine-palmiers.jpg') }}',    a: 'La piscine bordée de palmiers' },
        { s: '{{ asset('images/site/pavillon-repas.jpg') }}',      a: 'Le pavillon vitré du petit-déjeuner' },
        { s: '{{ asset('images/site/pavillon-salon.jpg') }}',      a: 'Le coin salon du pavillon' },
        { s: '{{ asset('images/site/ponton-lagune.jpg') }}',       a: 'Le ponton en bois sur la lagune Aby' },
        { s: '{{ asset('images/site/jardin.jpg') }}',              a: 'Les jardins de la résidence' },
        { s: '{{ asset('images/site/couloir.jpg') }}',             a: 'Les coursives ocre menant aux chambres' },
        { s: '{{ asset('images/site/hero-piscine-nuit-arbre.jpg') }}', a: 'La piscine illuminée de nuit et son arbre éclairé' },
        { s: '{{ asset('images/site/terrasse-nuit.jpg') }}',       a: 'La terrasse du pavillon en soirée' }
     ] }"
     @keydown.escape.window="lightbox = null">

    {{-- ===== HERO ===== --}}
    <div class="relative flex items-center justify-center text-center h-[60vh] min-h-[420px] px-4 overflow-hidden">
        <x-hero-slideshow :images="[
            ['src' => 'images/site/hero-ponton-palmier.jpg',  'alt' => 'Le ponton en bois et son palmier au bord de la lagune Aby'],
            ['src' => 'images/site/hero-piscine-turquoise.jpg', 'alt' => 'La mosaïque turquoise du bassin à débordement'],
            ['src' => 'images/site/hero-piscine-nuit-2.jpg',  'alt' => 'La piscine illuminée à la nuit tombée'],
        ]" />
        <div class="absolute inset-0 hero-overlay"></div>
        <div class="relative z-10 pt-16">
            <p class="text-sm font-semibold uppercase tracking-widest mb-3" style="color: var(--color-primary);">{{ __('Le domaine') }}</p>
            <h1 class="text-4xl sm:text-5xl font-bold text-white mb-3" style="font-family: var(--font-serif);">{{ __('Découvrir le domaine') }}</h1>
            <p class="max-w-xl mx-auto" style="color: rgba(255,255,255,0.85);">{{ __('Entre la lagune Aby et l\'océan : piscine à débordement, pavillon vitré, ponton privé et jardins.') }}</p>
        </div>
    </div>

    {{-- ===== LE DOMAINE ===== --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <p class="text-xs font-bold uppercase tracking-widest mb-2" style="color: var(--color-orange);">{{ __('Assinie · Kilomètre 18,75') }}</p>
                    <h2 class="section-title mb-5">{{ __('Un domaine les pieds dans la lagune') }}</h2>
                    <p class="leading-relaxed mb-4" style="color: var(--color-slate);">
                        {!! __('Le Havre de Paix s\'étire le long de la <strong>lagune Aby</strong>, au kilomètre 18,75 de la route d\'Assinie. Piscine à débordement, jardins tropicaux et pavillon vitré composent un décor fait pour ralentir.') !!}
                    </p>
                    <p class="leading-relaxed mb-8" style="color: var(--color-slate);">
                        {{ __("Le petit-déjeuner, inclus dans chaque séjour, est servi au pavillon face à l'eau. En attendant l'ouverture prochaine du restaurant, la piscine commune est en accès libre pour tous nos hôtes, sans surcoût.") }}
                    </p>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('rooms.index') }}" class="btn-primary">{{ __('Réserver mon séjour') }}</a>
                        <a href="https://wa.me/{{ config('hotel.whatsapp') }}?text=Bonjour,%20je%20souhaite%20des%20informations%20sur%20le%20Havre%20de%20Paix%20%C3%A0%20Assinie"
                           target="_blank" rel="noopener" class="btn-outline">{{ __('Nous écrire sur WhatsApp') }}</a>
                    </div>
                </div>

                {{-- Infos pratiques --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach ([
                        ['icon' => 'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z', 'title' => __('Piscine à débordement'), 'lines' => [__('Accès libre pour les hôtes'), __('Transats et plage en bois')]],
                        ['icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => __('Petit-déjeuner inclus'), 'lines' => [__('Servi au pavillon vitré'), __('Face à la lagune')]],
                        ['icon' => 'M8 22h8M12 11v11M19 3l-7 8-7-8h14z', 'title' => __('Ponton privé'), 'lines' => [__('Balades en pirogue'), __('Couchers de soleil sur la lagune')]],
                        ['icon' => 'M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 13h4a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z', 'title' => __('Bon à savoir'), 'lines' => [__('Restaurant : ouverture prochaine'), __('WiFi & climatisation inclus')]],
                    ] as $info)
                    <div class="rounded-2xl border p-5" style="border-color: var(--color-border); background-color: var(--color-snow);">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-3" style="background-color: var(--color-sand);">
                            <svg class="w-5 h-5" style="color: var(--color-orange);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $info['icon'] }}"/></svg>
                        </div>
                        <p class="font-semibold text-sm mb-1.5" style="color: var(--color-navy);">{{ $info['title'] }}</p>
                        @foreach ($info['lines'] as $line)
                        <p class="text-sm" style="color: var(--color-slate);">{{ $line }}</p>
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ===== MOT DE L'ÉQUIPE ===== --}}
    <section class="py-16" style="background-color: var(--color-navy);">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 text-center">
            <svg class="w-10 h-10 mx-auto mb-5 opacity-40" style="color: var(--color-orange);" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
            <p class="text-xl sm:text-2xl text-white leading-relaxed mb-6" style="font-family: var(--font-serif);">
                {{ __('« Ici, le temps se cale sur la lagune : un plongeon au lever du jour, un café face à l\'eau, et le soir qui tombe depuis le ponton. »') }}
            </p>
            <p class="text-sm font-semibold uppercase tracking-widest" style="color: var(--color-primary);">{{ __("L'équipe de la résidence") }}</p>
        </div>
    </section>

    {{-- ===== EXPÉRIENCES ===== --}}
    <section class="py-20" style="background-color: var(--color-snow);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <p class="text-xs font-bold uppercase tracking-widest mb-2" style="color: var(--color-orange);">{{ __('Expériences') }}</p>
                <h2 class="section-title">{{ __('Vos journées à Assinie') }}</h2>
                <p class="section-subtitle max-w-lg mx-auto">{{ __('Sur place ou à quelques minutes du domaine — de quoi remplir (ou vider) vos journées.') }}</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ([
                    ['i' => 0, 'img' => 'site/hero-piscine-lagune.jpg', 'title' => __('La piscine à débordement'), 'desc' => __('Un bassin turquoise qui semble se fondre dans la lagune, bordé d\'une plage en bois et de transats.')],
                    ['i' => 2, 'img' => 'site/pavillon-repas.jpg',      'title' => __('Le pavillon vitré'),         'desc' => __('Petit-déjeuner inclus chaque matin, entre les palmiers et l\'eau — le restaurant complet ouvrira prochainement.')],
                    ['i' => 4, 'img' => 'site/ponton-lagune.jpg',       'title' => __('Le ponton & la pirogue'),    'desc' => __('Embarquez pour une balade sur la lagune Aby ou rejoignez la plage océane d\'Assinie-Mafia.')],
                    ['i' => 5, 'img' => 'site/jardin.jpg',              'title' => __('Les jardins'),               'desc' => __('Pelouses, palmiers et coins d\'ombre : le décor idéal d\'une sieste ou d\'un moment de lecture.')],
                    ['i' => 7, 'img' => 'site/hero-piscine-nuit-arbre.jpg', 'title' => __('Les soirées au bord de l\'eau'), 'desc' => __('À la nuit tombée, la piscine s\'illumine et la terrasse s\'anime — le moment préféré de nos hôtes.')],
                    ['i' => 6, 'img' => 'site/couloir.jpg',             'title' => __('L\'architecture du domaine'), 'desc' => __('Coursives ocre, pierre et végétation : une résidence pensée pour vivre dehors, à l\'ombre.')],
                ] as $card)
                <div class="card group">
                    <div class="relative aspect-[16/10] overflow-hidden cursor-zoom-in" role="button" tabindex="0"
                         @click="lightbox = {{ $card['i'] }}" @keydown.enter="lightbox = {{ $card['i'] }}">
                        <img src="{{ asset('images/' . $card['img']) }}" alt="{{ $card['title'] }}"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-base mb-2" style="color: var(--color-navy);">{{ $card['title'] }}</h3>
                        <p class="text-sm leading-relaxed" style="color: var(--color-slate);">{{ $card['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===== CTA ===== --}}
    <section class="py-20 px-4 sm:px-6 lg:px-8 text-center bg-white">
        <div class="max-w-2xl mx-auto">
            <h2 class="section-title mb-4">{{ __('La lagune vous attend') }}</h2>
            <p class="section-subtitle mb-8">{{ __("Réservez votre chambre en ligne en moins de 5 minutes. Confirmation instantanée, paiement à l'arrivée.") }}</p>
            <a href="{{ route('rooms.index') }}" class="btn-primary text-base px-10 py-4">{{ __('Réserver maintenant') }}</a>
        </div>
    </section>

    {{-- ===== LIGHTBOX ===== --}}
    <template x-if="lightbox !== null">
        <div class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-8" role="dialog" aria-modal="true" aria-label="{{ __('Visionneuse de photos') }}">
            <div class="absolute inset-0" style="background-color: rgba(11,18,21,0.93); backdrop-filter: blur(8px);" @click="lightbox = null"></div>
            <div class="relative z-10 max-w-5xl w-full">
                <img :src="imgs[lightbox].s" :alt="imgs[lightbox].a" class="w-full max-h-[78vh] object-contain rounded-2xl shadow-2xl select-none">
                <p class="text-center text-sm mt-4 font-medium" style="color: rgba(255,255,255,0.85);" x-text="imgs[lightbox].a"></p>
            </div>
            <button @click="lightbox = null" aria-label="Fermer"
                    class="absolute top-5 right-5 z-20 w-10 h-10 rounded-full flex items-center justify-center text-white cursor-pointer transition-colors hover:bg-white/20"
                    style="background-color: rgba(255,255,255,0.15);">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <button @click="lightbox = (lightbox - 1 + imgs.length) % imgs.length" aria-label="Photo précédente"
                    class="absolute left-3 sm:left-6 top-1/2 -translate-y-1/2 z-20 w-11 h-11 rounded-full flex items-center justify-center text-white cursor-pointer transition-colors hover:bg-white/20"
                    style="background-color: rgba(255,255,255,0.15);">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button @click="lightbox = (lightbox + 1) % imgs.length" aria-label="Photo suivante"
                    class="absolute right-3 sm:right-6 top-1/2 -translate-y-1/2 z-20 w-11 h-11 rounded-full flex items-center justify-center text-white cursor-pointer transition-colors hover:bg-white/20"
                    style="background-color: rgba(255,255,255,0.15);">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
    </template>
</div>
@endsection
