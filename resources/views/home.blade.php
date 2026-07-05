@extends('layouts.app')

@section('title', 'Havre de Paix Assinie — Résidence-Hôtel entre mer et lagune')
@section('description', 'Réservez votre séjour au Havre de Paix, résidence-hôtel à Assinie Km 18,75, Côte d\'Ivoire. Chambres et suites avec vue mer ou lagune. Paiement à l\'arrivée.')

@section('content')

{{-- ===== HERO ===== --}}
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    {{-- Background image --}}
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/hero-bg.jpg') }}"
             alt="Havre de Paix — Assinie"
             class="w-full h-full object-cover"
             loading="eager">
        <div class="absolute inset-0 hero-overlay"></div>
    </div>

    <div class="relative z-10 text-center text-white px-4 sm:px-6 max-w-5xl mx-auto pt-24">
        <div class="badge-orange mb-6 inline-flex">
            <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            Assinie · Km 18,75 · Côte d'Ivoire
        </div>

        <h1 class="text-5xl sm:text-6xl lg:text-7xl font-bold mb-6 leading-tight" style="font-family: var(--font-serif);">
            Votre Havre<br>
            <span style="color: var(--color-orange);">de Paix</span>
        </h1>

        <p class="text-lg sm:text-xl mb-10 leading-relaxed max-w-2xl mx-auto" style="color: rgba(255,255,255,0.85);">
            Entre mer et lagune, à 94 km d'Abidjan. Chambres et suites en cadre tropical.
            <strong style="color: white;">Paiement à l'arrivée — aucun prépaiement requis.</strong>
        </p>

        {{-- Widget de recherche --}}
        <div class="bg-white rounded-2xl shadow-2xl p-6 max-w-3xl mx-auto animate-fade-up" style="color: var(--color-navy);">
            <p class="text-sm font-semibold mb-4 text-left uppercase tracking-wider" style="color: var(--color-orange);">Vérifier les disponibilités</p>
            <form action="{{ route('rooms.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div>
                    <label for="check_in" class="form-label">Arrivée</label>
                    <input type="date" id="check_in" name="check_in"
                           min="{{ date('Y-m-d') }}"
                           value="{{ request('check_in') }}"
                           class="form-input" required>
                </div>
                <div>
                    <label for="check_out" class="form-label">Départ</label>
                    <input type="date" id="check_out" name="check_out"
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                           value="{{ request('check_out') }}"
                           class="form-input" required>
                </div>
                <div>
                    <label for="guests" class="form-label">Personnes</label>
                    <div class="flex gap-2">
                        <select id="guests" name="capacity" class="form-input flex-1">
                            @for ($i = 1; $i <= 8; $i++)
                            <option value="{{ $i }}" {{ request('capacity') == $i ? 'selected' : '' }}>{{ $i }} {{ $i > 1 ? 'personnes' : 'personne' }}</option>
                            @endfor
                        </select>
                        <button type="submit" class="btn-primary px-5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </button>
                    </div>
                </div>
            </form>
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
            <h2 class="section-title">Pourquoi choisir le Havre de Paix ?</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach ([
                ['icon' => '🏖', 'title' => 'Plage privée', 'desc' => 'Accès direct à une plage privée de sable fin entre mer et lagune.'],
                ['icon' => '🌴', 'title' => 'Cadre tropical', 'desc' => 'Un écrin de nature à 94 km d\'Abidjan, au cœur d\'Assinie.'],
                ['icon' => '✅', 'title' => 'Paiement à l\'arrivée', 'desc' => 'Réservez sans risque. Vous payez uniquement à votre arrivée.'],
                ['icon' => '⚡', 'title' => 'Confirmation immédiate', 'desc' => 'Votre réservation est confirmée en ligne en moins de 5 minutes.'],
            ] as $feat)
            <div class="text-center p-6 rounded-2xl transition-all duration-300 hover:-translate-y-1" style="background-color: var(--color-snow);">
                <div class="text-4xl mb-4">{{ $feat['icon'] }}</div>
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
                        <span class="text-xs flex items-center gap-1" style="color: var(--color-slate);">
                            <svg class="w-3 h-3" style="color: var(--color-orange);" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
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

{{-- ===== TÉMOIGNAGES ===== --}}
<section class="py-20 px-4 sm:px-6 lg:px-8" style="background-color: var(--color-navy);">
    <div class="max-w-5xl mx-auto text-center">
        <p class="text-sm font-semibold uppercase tracking-widest mb-3" style="color: var(--color-orange);">Avis clients</p>
        <h2 class="text-4xl font-semibold text-white mb-12" style="font-family: var(--font-serif);">Ce que disent nos hôtes</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ([
                ['name' => 'Kofi A.', 'note' => '5/5', 'text' => 'Un séjour parfait en famille. La plage privée est magnifique et le service impeccable.'],
                ['name' => 'Sophie M.', 'note' => '5/5', 'text' => 'Cadre exceptionnel entre mer et lagune. Les chambres sont propres et bien équipées.'],
                ['name' => 'Jean-Paul K.', 'note' => '4/5', 'text' => 'Idéal pour un séminaire résidentiel. Personnel accueillant et cuisine délicieuse.'],
            ] as $t)
            <div class="rounded-2xl p-6 text-left" style="background-color: rgba(255,255,255,0.08);">
                <div class="flex items-center gap-1 mb-3">
                    @for ($i = 0; $i < 5; $i++)
                    <svg class="w-4 h-4" style="color: var(--color-orange);" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <p class="text-sm leading-relaxed mb-4" style="color: rgba(255,255,255,0.8);">"{{ $t['text'] }}"</p>
                <p class="text-sm font-semibold text-white">— {{ $t['name'] }}</p>
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
        <a href="{{ route('reservation.index') }}" class="btn-primary text-base px-10 py-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Réserver maintenant
        </a>
        <p class="mt-4 text-sm" style="color: var(--color-slate);">Annulation gratuite jusqu'à 48h avant l'arrivée</p>
    </div>
</section>

@endsection

@push('scripts')
<script>
// CTA flottant : apparaît après le hero
const floatingCta = document.getElementById('floating-cta');
if (floatingCta) {
    window.addEventListener('scroll', () => {
        floatingCta.style.display = window.scrollY > window.innerHeight * 0.8 ? 'inline-flex' : 'none';
    }, { passive: true });
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
