@extends('layouts.app')

@section('title', 'Résidence Hôtel Cascades — Résidence-Hôtel au cœur de Cocody')
@section('description', 'Réservez votre séjour à la Résidence Hôtel Cascades, résidence-hôtel à Cocody, Abidjan, Côte d\'Ivoire. Chambres et suites tout confort dans un cadre calme et verdoyant. Paiement à l\'arrivée.')
@section('hero_nav', '1')

@section('content')

{{-- ===== HERO ===== --}}
<section class="relative min-h-[85vh] flex items-center justify-center overflow-hidden">
    {{-- Background image --}}
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/hero-bg.jpg') }}"
             alt="Résidence Hôtel Cascades — Abidjan"
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
                    <label for="guests" class="block text-xs font-bold uppercase tracking-wide mb-0.5">Voyageurs</label>
                    <select id="guests" name="capacity" class="w-full bg-transparent text-sm font-medium outline-none border-0 p-0 cursor-pointer">
                        @for ($i = 1; $i <= 8; $i++)
                        <option value="{{ $i }}" {{ request('capacity') == $i ? 'selected' : '' }}>{{ $i }} {{ $i > 1 ? 'voyageurs' : 'voyageur' }}</option>
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
                <p class="section-subtitle max-w-md">Du confort standard à la suite présidentielle, trouvez l'hébergement qui vous correspond.</p>
            </div>
            <a href="{{ route('rooms.index') }}" class="btn-outline hidden sm:inline-flex">
                Voir toutes les chambres
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($rooms as $room)
            <article class="card group">
                {{-- Image --}}
                <div class="relative aspect-[4/3] overflow-hidden">
                    <img src="{{ asset($room->first_image) }}"
                         alt="{{ $room->name }}"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                         loading="lazy"
                         width="400" height="300">
                    <div class="absolute top-3 left-3">
                        <span class="badge">{{ $room->view_label }}</span>
                    </div>
                    <div class="absolute top-3 right-3 px-2 py-1 rounded-lg text-xs font-semibold text-white" style="background-color: var(--color-navy);">
                        {{ $room->capacity_adults }} pers.
                    </div>
                </div>

                {{-- Infos --}}
                <div class="p-5">
                    <h3 class="font-semibold text-base mb-1.5" style="color: var(--color-navy); font-family: var(--font-serif);">{{ $room->name }}</h3>
                    <p class="text-sm mb-4 line-clamp-2" style="color: var(--color-slate);">{{ $room->description_short }}</p>

                    {{-- Équipements --}}
                    <div class="flex gap-3 mb-4 flex-wrap">
                        @foreach (array_slice($room->amenities ?? [], 0, 3) as $amenity)
                        <span class="text-xs flex items-center gap-1.5" style="color: var(--color-slate);">
                            <x-amenity-icon :name="$amenity" class="w-3.5 h-3.5 shrink-0" style="color: var(--color-orange);" />
                            {{ $amenity }}
                        </span>
                        @endforeach
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <span class="price-tag">{{ number_format($room->price_per_night, 0, ',', ' ') }}</span>
                            <span class="text-xs ml-1" style="color: var(--color-slate);">FCFA / nuit</span>
                        </div>
                        <a href="{{ route('rooms.show', $room->slug) }}" class="btn-primary text-sm py-2 px-4">
                            Voir & Réserver
                        </a>
                    </div>
                </div>
            </article>
            @empty
            <div class="col-span-3 text-center py-12" style="color: var(--color-slate);">
                <p>Les chambres seront bientôt disponibles.</p>
            </div>
            @endforelse
        </div>

        <div class="text-center mt-8 sm:hidden">
            <a href="{{ route('rooms.index') }}" class="btn-outline">Voir toutes les chambres</a>
        </div>
    </div>
</section>

{{-- ===== LE LIEU EN IMAGES ===== --}}
<section class="py-20 px-4 sm:px-6 lg:px-8" style="background-color: white;">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12">
            <p class="text-sm font-semibold uppercase tracking-widest mb-2" style="color: var(--color-orange);">Le lieu</p>
            <h2 class="section-title">Le décor de votre séjour</h2>
            <p class="section-subtitle max-w-md mx-auto">Piscine, terrasses et jardins — un havre de calme en plein Abidjan.</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 md:grid-rows-2 gap-3 md:h-[480px]">
            <div class="col-span-2 md:row-span-2 rounded-2xl overflow-hidden group aspect-[16/10] md:aspect-auto">
                <img src="{{ asset('images/beach-access.jpg') }}" alt="Les jardins de la résidence"
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
            </div>
            <div class="rounded-2xl overflow-hidden group aspect-square md:aspect-auto">
                <img src="{{ asset('images/pool.jpg') }}" alt="Piscine de la Résidence Hôtel Cascades"
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
            </div>
            <div class="rounded-2xl overflow-hidden group aspect-square md:aspect-auto">
                <img src="{{ asset('images/terrace.jpg') }}" alt="La terrasse de la résidence"
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
            </div>
            <div class="col-span-2 rounded-2xl overflow-hidden group aspect-[16/9] md:aspect-auto">
                <img src="{{ asset('images/hero-bg.jpg') }}" alt="Vue du domaine de la Résidence Hôtel Cascades à Abidjan"
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
            </div>
        </div>
    </div>
</section>

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
        <h2 class="section-title mb-4">Prêt pour votre escapade ?</h2>
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
