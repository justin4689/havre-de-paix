@extends('layouts.app')
@section('title', __('Le Restaurant — Havre de Paix'))
@section('description', __('Le restaurant du Havre de Paix à Assinie : petit-déjeuner inclus servi chaque matin au pavillon vitré face à la lagune Aby. Restaurant complet en ouverture prochaine.'))
@section('hero_nav', '1')
@section('content')
<div x-data="{ lightbox: null, imgs: [
        { s: '{{ asset('images/site/pavillon-repas.jpg') }}',      a: 'Le pavillon vitré du petit-déjeuner' },
        { s: '{{ asset('images/site/pavillon-salon.jpg') }}',      a: 'Le coin salon du pavillon' },
        { s: '{{ asset('images/site/pavillon-exterieur.jpg') }}',  a: 'Le pavillon vitré face à la lagune' },
        { s: '{{ asset('images/site/hero-pavillon-nuit.jpg') }}',  a: 'Le pavillon illuminé à la tombée de la nuit' },
        { s: '{{ asset('images/site/terrasse-nuit.jpg') }}',       a: 'La terrasse du pavillon en soirée' },
        { s: '{{ asset('images/site/hero-piscine-lagune.jpg') }}', a: 'La lagune Aby, vue du petit-déjeuner' }
     ] }"
     @keydown.escape.window="lightbox = null">

    {{-- ===== HERO ===== --}}
    <div class="relative flex items-center justify-center text-center h-[60vh] min-h-[420px] px-4 overflow-hidden">
        <x-hero-slideshow :images="[
            ['src' => 'images/site/pavillon-repas.jpg',     'alt' => 'Le pavillon vitré du petit-déjeuner du Havre de Paix'],
            ['src' => 'images/site/hero-pavillon-nuit.jpg', 'alt' => 'Le pavillon illuminé à la tombée de la nuit'],
            ['src' => 'images/site/pavillon-exterieur.jpg', 'alt' => 'Le pavillon vitré face à la lagune d\'Assinie'],
        ]" />
        <div class="absolute inset-0 hero-overlay"></div>
        <div class="relative z-10 pt-16">
            <p class="text-sm font-semibold uppercase tracking-widest mb-3" style="color: var(--color-primary);">{{ __('Saveurs') }}</p>
            <h1 class="text-4xl sm:text-5xl font-bold text-white mb-3" style="font-family: var(--font-serif);">{{ __('Le Restaurant') }}</h1>
            <p class="max-w-xl mx-auto" style="color: rgba(255,255,255,0.85);">{{ __('Le petit-déjeuner face à la lagune, chaque matin — et bientôt bien plus.') }}</p>
        </div>
    </div>

    {{-- ===== LE PAVILLON ===== --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <span class="badge-orange mb-4 inline-flex">{{ __('Restaurant complet : ouverture prochaine') }}</span>
                    <h2 class="section-title mb-5">{{ __('Le petit-déjeuner') }} <em>{{ __('face à la lagune') }}</em></h2>
                    <p class="leading-relaxed mb-4" style="color: var(--color-slate);">
                        {!! __('Chaque matin, votre petit-déjeuner — <strong>inclus dans le séjour</strong> — est servi dans le pavillon vitré, entre les palmiers et la lagune Aby. Café, jus frais et douceurs, avec l\'eau calme pour seul horizon.') !!}
                    </p>
                    <p class="leading-relaxed mb-8" style="color: var(--color-slate);">
                        {{ __("Le restaurant complet est en préparation et ouvrira prochainement. D'ici là, de nombreuses tables d'Assinie se trouvent à quelques minutes du domaine — la réception se fera un plaisir de vous conseiller.") }}
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
                        ['icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => __('Petit-déjeuner inclus'), 'lines' => [__('Servi chaque matin'), __('Au pavillon vitré')]],
                        ['icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => __('Vue lagune'), 'lines' => [__('À chaque table'), __('Terrasse en soirée')]],
                        ['icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'title' => __('Restaurant complet'), 'lines' => [__('Ouverture prochaine'), __('Cuisine ivoirienne & internationale')]],
                        ['icon' => 'M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 13h4a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z', 'title' => __('Bon à savoir'), 'lines' => [__('Restaurants d\'Assinie à quelques minutes'), __('Conseils à la réception')]],
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
                {{ __('« Le premier café du matin, face à l\'eau calme de la lagune : c\'est là que commence chaque journée au Havre de Paix. »') }}
            </p>
            <p class="text-sm font-semibold uppercase tracking-widest" style="color: var(--color-primary);">{{ __("L'équipe de la résidence") }}</p>
        </div>
    </section>

    {{-- ===== LE PAVILLON EN IMAGES ===== --}}
    <section class="py-20" style="background-color: var(--color-snow);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <p class="text-xs font-bold uppercase tracking-widest mb-2" style="color: var(--color-orange);">{{ __('Le cadre') }}</p>
                <h2 class="section-title">{{ __('Le pavillon') }} <em>{{ __('en images') }}</em></h2>
                <p class="section-subtitle max-w-lg mx-auto">{{ __('Verre, bois et lagune : le décor de vos petits-déjeuners — de jour comme en soirée.') }}</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ([
                    ['i' => 0, 'img' => 'site/pavillon-repas.jpg',      'title' => __('La salle vitrée'),          'desc' => __('Des tables face à la lagune, baignées de lumière dès le matin.')],
                    ['i' => 2, 'img' => 'site/pavillon-exterieur.jpg',  'title' => __('Le pavillon côté jardin'),  'desc' => __('Un écrin de verre posé entre les palmiers et l\'eau.')],
                    ['i' => 1, 'img' => 'site/pavillon-salon.jpg',      'title' => __('Le coin salon'),            'desc' => __('Fauteuils en rotin pour prolonger le café du matin.')],
                    ['i' => 3, 'img' => 'site/hero-pavillon-nuit.jpg',  'title' => __('Le pavillon en soirée'),    'desc' => __('À la nuit tombée, les lumières prennent le relais du soleil.')],
                    ['i' => 4, 'img' => 'site/terrasse-nuit.jpg',       'title' => __('La terrasse'),              'desc' => __('Le prolongement du pavillon, à ciel ouvert au bord de l\'eau.')],
                    ['i' => 5, 'img' => 'site/hero-piscine-lagune.jpg', 'title' => __('La vue au petit-déjeuner'), 'desc' => __('La lagune Aby pour seul horizon, une pirogue qui passe.')],
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
            <h2 class="section-title mb-4">{{ __('Votre table vous attend') }} <em>{{ __('au bord de l\'eau') }}</em></h2>
            <p class="section-subtitle mb-8">{{ __("Réservez votre chambre en ligne en moins de 5 minutes — le petit-déjeuner est inclus. Paiement à l'arrivée.") }}</p>
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
