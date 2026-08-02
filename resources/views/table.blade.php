@extends('layouts.app')
@section('title', 'Notre Table — Résidence Hôtel Cascades')
@section('description', 'Le restaurant et le bar de la Résidence Hôtel Cascades à Cocody, Abidjan : cuisine ivoirienne et internationale, produits frais, cadre verdoyant.')
@section('hero_nav', '1')
@section('content')
<div x-data="{ lightbox: null, imgs: [
        { s: '{{ asset('images/resto2.jpg') }}', a: 'La salle du restaurant' },
        { s: '{{ asset('images/resto1.jpg') }}', a: 'Le jardin en configuration banquet' },
        { s: '{{ asset('images/resto3.jpg') }}', a: 'Les tables dressées' },
        { s: '{{ asset('images/bar1.jpg') }}',   a: 'Le comptoir du bar' },
        { s: '{{ asset('images/bar2.jpg') }}',   a: 'L\'espace lounge du bar' },
        { s: '{{ asset('images/bar3.jpg') }}',   a: 'Le bar en soirée' }
     ] }"
     @keydown.escape.window="lightbox = null">

    {{-- ===== HERO ===== --}}
    <div class="relative flex items-center justify-center text-center h-[60vh] min-h-[420px] px-4 overflow-hidden">
        <img src="{{ asset('images/resto2.jpg') }}" alt="La salle du restaurant de la Résidence Hôtel Cascades"
             class="absolute inset-0 w-full h-full object-cover" loading="eager">
        <div class="absolute inset-0 hero-overlay"></div>
        <div class="relative z-10 pt-16">
            <p class="text-sm font-semibold uppercase tracking-widest mb-3" style="color: var(--color-primary);">Saveurs</p>
            <h1 class="text-4xl sm:text-5xl font-bold text-white mb-3" style="font-family: var(--font-serif);">Notre Table</h1>
            <p class="max-w-xl mx-auto" style="color: rgba(255,255,255,0.85);">Cuisine ivoirienne et internationale, du petit-déjeuner au dernier verre.</p>
        </div>
    </div>

    {{-- ===== UNIVERS CULINAIRE ===== --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <p class="text-xs font-bold uppercase tracking-widest mb-2" style="color: var(--color-orange);">Notre restaurant</p>
                    <h2 class="section-title mb-5">L'univers culinaire des Cascades</h2>
                    <p class="leading-relaxed mb-4" style="color: var(--color-slate);">
                        Notre équipe de cuisine prépare chaque jour une carte qui marie les
                        <strong style="color: var(--color-navy);">grands classiques ivoiriens</strong> et une
                        <strong style="color: var(--color-navy);">cuisine internationale généreuse</strong>,
                        à partir de produits frais et de saison.
                    </p>
                    <p class="leading-relaxed mb-8" style="color: var(--color-slate);">
                        À table dans notre salle chaleureuse, à l'ombre du jardin pour vos grandes tablées
                        ou au comptoir du bar — vous recevoir et vous servir est notre plus belle mission.
                    </p>
                    <div class="flex flex-wrap gap-3">
                        <a href="https://wa.me/2250506505592?text=Bonjour,%20je%20souhaite%20r%C3%A9server%20une%20table%20au%20restaurant%20de%20la%20R%C3%A9sidence%20H%C3%B4tel%20Cascades"
                           target="_blank" rel="noopener" class="btn-primary">
                            Réserver une table
                        </a>
                        <a href="tel:+2250506505592" class="btn-outline">Ou appelez-nous : +225 05 06 50 55 92</a>
                    </div>
                </div>

                {{-- Infos pratiques --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach ([
                        ['icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'title' => "Jours d'ouverture", 'lines' => ['Lundi – Dimanche', 'Service en chambre disponible']],
                        ['icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => "Heures d'ouverture", 'lines' => ['Petit-déjeuner · 6h30 – 10h30', 'Déjeuner · 12h00 – 15h00', 'Dîner · 19h00 – 22h30']],
                        ['icon' => 'M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0A2.704 2.704 0 003 15.546V19a2 2 0 002 2h14a2 2 0 002-2v-3.454zM12 3v9m0 0l-3-3m3 3l3-3', 'title' => 'Le bar', 'lines' => ['10h00 – 23h00', 'Cocktails, jus frais & spiritueux']],
                        ['icon' => 'M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 13h4a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z', 'title' => 'Réservation de table', 'lines' => ['+225 05 06 50 55 92', 'Groupes & événements au jardin']],
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
            <svg class="w-10 h-10 mx-auto mb-6 opacity-40" style="color: var(--color-primary);" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
            <p class="text-xl sm:text-2xl text-white leading-relaxed mb-6" style="font-family: var(--font-serif);">
                « Vous recevoir, vous servir et vous offrir la plus délicieuse des expériences est notre mission.
                Toute l'équipe a hâte de vous accueillir à sa table. »
            </p>
            <p class="text-sm font-semibold uppercase tracking-widest" style="color: var(--color-primary);">L'équipe de cuisine des Cascades</p>
        </div>
    </section>

    {{-- ===== LA CARTE ===== --}}
    <section class="py-20" style="background-color: var(--color-snow);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14">
                <p class="text-xs font-bold uppercase tracking-widest mb-2" style="color: var(--color-orange);">La carte</p>
                <h2 class="section-title">Un aperçu de notre carte</h2>
                <p class="section-subtitle max-w-xl mx-auto">Quelques-unes de nos spécialités — la carte complète vous attend à table.</p>
            </div>

            @php
            $menu = [
                ['title' => 'Nos entrées', 'items' => [
                    ['name' => 'Salade fraîcheur du jardin', 'desc' => 'Cœur de palmier, avocat, tomates et vinaigrette passion'],
                    ['name' => 'Aloco crevettes', 'desc' => 'Bananes plantain dorées, crevettes sautées à l\'ail'],
                    ['name' => 'Velouté du marché', 'desc' => 'Légumes de saison, huile de coco torréfiée'],
                ]],
                ['title' => 'Nos plats « terre & mer »', 'items' => [
                    ['name' => 'Poisson braisé entier', 'desc' => 'Dorade ou capitaine, attiéké, sauce claire et piment vert'],
                    ['name' => 'Poulet braisé façon Cascades', 'desc' => 'Marinade citron-gingembre, alloco et salade croquante'],
                    ['name' => 'Brochettes de bœuf grillées', 'desc' => 'Riz parfumé, sauce arachide légère'],
                    ['name' => 'Gambas flambées', 'desc' => 'Riz de Kovié au gingembre, jus corsé'],
                ]],
                ['title' => 'Les délices du terroir', 'items' => [
                    ['name' => 'Kedjenou de poulet', 'desc' => 'Mijoté en canari, riz blanc ou foutou banane'],
                    ['name' => 'Sauce graine poisson fumé', 'desc' => 'Foutou ou placali, selon l\'humeur du jour'],
                    ['name' => 'Garba de la maison', 'desc' => 'Thon frit, attiéké, tomates-oignons-piment'],
                ]],
                ['title' => 'Végétarien & douceurs', 'items' => [
                    ['name' => 'Curry de légumes au lait de coco', 'desc' => 'Riz ou céréales du terroir'],
                    ['name' => 'Carpaccio de fruits exotiques', 'desc' => 'Ananas, mangue, sirop de bissap'],
                    ['name' => 'Douceur coco-passion', 'desc' => 'Crème coco, coulis de fruit de la passion'],
                ]],
            ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($menu as $section)
                <div class="bg-white rounded-2xl border p-7 shadow-sm" style="border-color: var(--color-border);">
                    <h3 class="font-bold text-lg mb-5 pb-4 border-b" style="color: var(--color-navy); font-family: var(--font-serif); border-color: var(--color-border);">
                        {{ $section['title'] }}
                    </h3>
                    <ul class="space-y-4">
                        @foreach ($section['items'] as $item)
                        <li>
                            <p class="font-semibold text-sm" style="color: var(--color-navy);">{{ $item['name'] }}</p>
                            <p class="text-sm mt-0.5" style="color: var(--color-slate);">{{ $item['desc'] }}</p>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endforeach
            </div>

            <p class="text-center text-sm mt-8" style="color: var(--color-slate);">
                Les tarifs de la carte sont disponibles à table et à la réception.
            </p>
        </div>
    </section>

    {{-- ===== LE BAR ===== --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="relative rounded-3xl overflow-hidden group cursor-zoom-in" @click="lightbox = 3">
                    <img src="{{ asset('images/bar1.jpg') }}" alt="Le comptoir du bar de la Résidence Hôtel Cascades"
                         class="w-full h-[420px] object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                    <div class="absolute top-4 left-4 px-3 py-1.5 rounded-full text-xs font-bold text-white" style="background-color: rgba(11,18,21,0.75);">Le Bar</div>
                </div>
                <div>
                    <p class="text-xs font-bold uppercase tracking-widest mb-2" style="color: var(--color-orange);">L'heure du cocktail</p>
                    <h2 class="section-title mb-5">Un bar à l'atmosphère feutrée</h2>
                    <p class="leading-relaxed mb-4" style="color: var(--color-slate);">
                        Cocktails, jus frais et belle sélection de spiritueux au comptoir, dans une ambiance
                        qui s'anime en soirée — pour nos hôtes comme pour leurs invités.
                    </p>
                    <ul class="space-y-2.5 mb-8">
                        @foreach (['Cocktails signatures & jus de fruits frais', 'Ambiance lounge en soirée', 'Ouvert de 10h00 à 23h00, tous les jours'] as $line)
                        <li class="flex items-center gap-2.5 text-sm" style="color: var(--color-navy);">
                            <svg class="w-4 h-4 shrink-0" style="color: var(--color-orange);" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            {{ $line }}
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== GALERIE ===== --}}
    <section class="py-20" style="background-color: var(--color-snow);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <p class="text-xs font-bold uppercase tracking-widest mb-2" style="color: var(--color-orange);">En images</p>
                <h2 class="section-title">Le restaurant & le bar</h2>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                <template x-for="(img, i) in imgs" :key="i">
                    <button @click="lightbox = i" class="relative overflow-hidden rounded-xl group cursor-zoom-in" style="aspect-ratio: 4/3">
                        <img :src="img.s" :alt="img.a" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors flex items-center justify-center">
                            <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                            </svg>
                        </div>
                    </button>
                </template>
            </div>
        </div>
    </section>

    {{-- ===== DÉCOUVREZ AUSSI ===== --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="section-title text-center mb-12">Découvrez aussi</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                @foreach ([
                    ['img' => 'images/decor1.jpg', 'title' => 'Nos Chambres & Suites', 'text' => 'Mini Suites, chambres Standard, Executive et Open Space sur trois étages.', 'route' => 'rooms.index', 'cta' => 'Voir les chambres'],
                    ['img' => 'images/decor4.jpg', 'title' => 'La Résidence', 'text' => 'Jardins verdoyants, murs végétaux et calme absolu au cœur de Cocody.', 'route' => 'about', 'cta' => 'Découvrir les lieux'],
                ] as $card)
                <a href="{{ route($card['route']) }}" class="card group no-underline block">
                    <div class="relative h-52 overflow-hidden">
                        <img src="{{ asset($card['img']) }}" alt="{{ $card['title'] }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg mb-1.5 group-hover:text-orange-500 transition-colors" style="color: var(--color-navy); font-family: var(--font-serif);">{{ $card['title'] }}</h3>
                        <p class="text-sm mb-3" style="color: var(--color-slate);">{{ $card['text'] }}</p>
                        <span class="text-sm font-medium" style="color: var(--color-blue);">{{ $card['cta'] }} →</span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===== LIGHTBOX ===== --}}
    <div x-show="lightbox !== null" x-transition.opacity x-cloak
         class="fixed inset-0 z-50 bg-black/95 flex items-center justify-center p-4"
         @click.self="lightbox = null">
        <button @click="lightbox = null" class="absolute top-4 right-4 text-white/80 hover:text-white" aria-label="Fermer">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <button @click="lightbox = (lightbox - 1 + imgs.length) % imgs.length" @keydown.arrow-left.window="lightbox !== null && (lightbox = (lightbox - 1 + imgs.length) % imgs.length)" class="absolute left-4 top-1/2 -translate-y-1/2 text-white/80 hover:text-white" aria-label="Photo précédente">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <img :src="lightbox !== null ? imgs[lightbox].s : ''" :alt="lightbox !== null ? imgs[lightbox].a : ''" class="max-w-5xl max-h-[85vh] w-full object-contain rounded-xl">
        <button @click="lightbox = (lightbox + 1) % imgs.length" @keydown.arrow-right.window="lightbox !== null && (lightbox = (lightbox + 1) % imgs.length)" class="absolute right-4 top-1/2 -translate-y-1/2 text-white/80 hover:text-white" aria-label="Photo suivante">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </button>
        <p class="absolute bottom-4 left-1/2 -translate-x-1/2 text-white/60 text-sm" x-text="lightbox !== null ? (lightbox + 1) + ' / ' + imgs.length : ''"></p>
    </div>
</div>
@endsection
