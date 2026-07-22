<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Résidence Hôtel Cascades') — Résidence-Hôtel · Cocody, Abidjan</title>
    <meta name="description" content="@yield('description', 'Résidence Hôtel Cascades, résidence-hôtel au cœur de Cocody à Cocody, Abidjan, Côte d\'Ivoire. Réservez en ligne, confirmation instantanée, paiement à l\'arrivée.')">

    {{-- Open Graph --}}
    <meta property="og:title" content="@yield('title', 'Résidence Hôtel Cascades')">
    <meta property="og:description" content="@yield('description', 'Résidence-hôtel à Abidjan, Côte d\'Ivoire.')">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ asset('images/og-cover.jpg') }}">

    {{-- Schema.org LodgingBusiness --}}
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "LodgingBusiness",
        "name": "Résidence Hôtel Cascades",
        "description": "Résidence-hôtel au cœur de Cocody, à Abidjan, Côte d'Ivoire.",
        "url": "{{ url('/') }}",
        "address": {
            "@@type": "PostalAddress",
            "streetAddress": "Kilomètre 18,75",
            "addressLocality": "Abidjan",
            "addressCountry": "CI"
        },
        "telephone": "+225 00 00 00 00",
        "priceRange": "FCFA"
    }
    </script>

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="antialiased" style="font-family: var(--font-sans); background-color: var(--color-snow); color: var(--color-navy);">

    {{-- NAVBAR : transparente uniquement sur les pages qui déclarent @section('hero_nav')
         (hero sombre plein écran derrière) — blanche et solide dès le départ partout ailleurs. --}}
    @php($heroNav = $__env->hasSection('hero_nav'))
    <header id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
            x-data="{ open: false, scrolled: {{ $heroNav ? 'false' : 'true' }} }"
            @scroll.window="scrolled = {{ $heroNav ? 'window.scrollY > 60' : 'true' }}">
        <div :class="scrolled || open ? 'bg-white shadow-md' : 'bg-transparent'" class="transition-all duration-300" {!! $heroNav ? '' : 'style="background-color: white;"' !!}>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16 lg:h-20">

                    {{-- Logo --}}
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                        <img src="{{ asset('images/logo.png') }}" alt="Résidence Hôtel Cascades"
                             class="w-12 h-12 lg:w-14 lg:h-14 rounded-full bg-white object-contain p-1.5 shadow-md transition-transform group-hover:scale-105">
                        <div>
                            <div class="font-bold text-base leading-none transition-colors" :style="scrolled || open ? 'color: var(--color-navy)' : 'color: white'">Résidence Hôtel Cascades</div>
                            <div class="text-xs leading-none mt-0.5 transition-colors" :style="scrolled || open ? 'color: var(--color-slate)' : 'color: rgba(255,255,255,0.8)'">Abidjan · Cocody</div>
                        </div>
                    </a>

                    {{-- Navigation desktop --}}
                    <nav class="hidden lg:flex items-center gap-8">
                        @foreach ([
                            ['route' => 'home', 'label' => 'Accueil'],
                            ['route' => 'rooms.index', 'label' => 'Nos Chambres'],
                            ['route' => 'about', 'label' => 'À Propos'],
                            ['route' => 'contact', 'label' => 'Contact'],
                            ['route' => 'reservation.lookup', 'label' => 'Ma réservation'],
                        ] as $item)
                        <a href="{{ route($item['route']) }}"
                           class="text-sm font-medium transition-colors duration-200"
                           :style="scrolled ? 'color: var(--color-navy)' : 'color: rgba(255,255,255,0.9)'"
                           style="text-decoration: none;">
                            {{ $item['label'] }}
                        </a>
                        @endforeach
                    </nav>

                    {{-- CTA --}}
                    <div class="hidden lg:flex items-center gap-3">
                        @auth
                        <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium" style="color: var(--color-orange);">Back-office</a>
                        @endauth
                        <a href="{{ route('rooms.index') }}" class="btn-primary text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Réserver
                        </a>
                    </div>

                    {{-- Burger mobile --}}
                    <button @click="open = !open" class="lg:hidden p-2 rounded-lg" :style="scrolled || open ? 'color: var(--color-navy)' : 'color: white'" aria-label="Menu">
                        <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>

            {{-- Menu mobile --}}
            <div x-show="open" x-transition class="lg:hidden border-t px-4 py-4 space-y-1" style="border-color: var(--color-border);">
                @foreach ([
                    ['route' => 'home', 'label' => 'Accueil'],
                    ['route' => 'rooms.index', 'label' => 'Nos Chambres'],
                    ['route' => 'about', 'label' => 'À Propos'],
                    ['route' => 'contact', 'label' => 'Contact'],
                    ['route' => 'reservation.lookup', 'label' => 'Ma réservation'],
                ] as $item)
                <a href="{{ route($item['route']) }}" class="block px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-orange-50 transition-colors" style="color: var(--color-navy);">{{ $item['label'] }}</a>
                @endforeach
                <div class="pt-2">
                    <a href="{{ route('rooms.index') }}" class="btn-primary w-full text-center">Réserver maintenant</a>
                </div>
            </div>
        </div>
    </header>

    {{-- CONTENU --}}
    <main>
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer style="background-color: var(--color-navy); color: rgba(255,255,255,0.8);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">

                {{-- Branding --}}
                <div class="lg:col-span-2">
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Résidence Hôtel Cascades" class="w-16 h-16 rounded-full bg-white object-contain p-2">
                        <div>
                            <div class="font-bold text-white text-lg">Résidence Hôtel Cascades</div>
                            <div class="text-xs" style="color: rgba(255,255,255,0.6);">Abidjan · Cocody</div>
                        </div>
                    </div>
                    <p class="text-sm leading-relaxed max-w-xs" style="color: rgba(255,255,255,0.6);">
                        Résidence-hôtel au cœur de Cocody, à Abidjan. Un havre de calme et de confort en pleine ville.
                    </p>
                    <div class="flex gap-3 mt-5">
                        <a href="https://wa.me/2250000000000" class="w-9 h-9 rounded-full flex items-center justify-center transition-colors" style="background-color: rgba(255,255,255,0.1);" aria-label="WhatsApp">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </a>
                    </div>
                </div>

                {{-- Navigation --}}
                <div>
                    <h3 class="font-semibold text-white text-sm mb-4 uppercase tracking-wider">Navigation</h3>
                    <ul class="space-y-2.5 text-sm">
                        @foreach ([
                            ['route' => 'rooms.index', 'label' => 'Nos Chambres'],
                            ['route' => 'reservation.lookup', 'label' => 'Ma réservation'],
                            ['route' => 'about', 'label' => 'À Propos'],
                            ['route' => 'contact', 'label' => 'Contact'],
                        ] as $item)
                        <li><a href="{{ route($item['route']) }}" class="hover:text-white transition-colors" style="color: rgba(255,255,255,0.6);">{{ $item['label'] }}</a></li>
                        @endforeach
                    </ul>
                </div>

                {{-- Contact --}}
                <div>
                    <h3 class="font-semibold text-white text-sm mb-4 uppercase tracking-wider">Contact</h3>
                    <ul class="space-y-3 text-sm" style="color: rgba(255,255,255,0.6);">
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 shrink-0" style="color: var(--color-orange);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Cocody, Abidjan, Côte d'Ivoire
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 shrink-0" style="color: var(--color-orange);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            +225 XX XX XX XX XX
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 shrink-0" style="color: var(--color-orange);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            contact@residencehotelcascades.com
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t mt-10 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs" style="border-color: rgba(255,255,255,0.1); color: rgba(255,255,255,0.4);">
                <p>© {{ date('Y') }} Résidence Hôtel Cascades — Abidjan. Tous droits réservés.</p>
                <div class="flex gap-4">
                    <a href="{{ route('legal') }}#mentions-legales" class="hover:text-white transition-colors">Mentions légales</a>
                    <a href="{{ route('legal') }}#cgv" class="hover:text-white transition-colors">CGV</a>
                    <a href="{{ route('legal') }}#confidentialite" class="hover:text-white transition-colors">Confidentialité</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="//unpkg.com/alpinejs" defer></script>
    @stack('scripts')
</body>
</html>
