@extends('layouts.app')

@section('title', $room->name . ' — Havre de Paix Assinie')
@section('description', $room->description_short . ' Vue ' . $room->view_label . '. Réservez en ligne.')

@push('head')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "HotelRoom",
    "name": "{{ $room->name }}",
    "description": "{{ $room->description_short }}",
    "occupancy": { "@type": "QuantitativeValue", "maxValue": {{ $room->capacity_adults }} },
    "floorSize": { "@type": "QuantitativeValue", "value": {{ $room->size_m2 ?? 0 }}, "unitCode": "MTK" }
}
</script>
@endpush

@section('content')
<div class="pt-20" style="background-color: var(--color-snow);">

    {{-- Breadcrumb --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <nav class="flex items-center gap-2 text-sm" style="color: var(--color-slate);">
            <a href="{{ route('home') }}" class="hover:text-orange-500 transition-colors">Accueil</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('rooms.index') }}" class="hover:text-orange-500 transition-colors">Chambres</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span style="color: var(--color-orange);">{{ $room->name }}</span>
        </nav>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">

        @if (session('info'))
        <div class="mb-6 p-4 rounded-xl text-sm flex items-center gap-3" style="background-color: var(--color-sky); color: #0c4a6e;">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('info') }}
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

            {{-- ===== COLONNE GAUCHE ===== --}}
            <div class="lg:col-span-2">

                {{-- Galerie --}}
                <div x-data="{ active: 0, images: {{ json_encode(array_map(fn($img) => asset($img), $room->images ?: ['images/placeholder.svg'])) }} }" class="mb-8">
                    {{-- Image principale --}}
                    <div class="relative aspect-[16/9] rounded-2xl overflow-hidden mb-3 shadow-lg">
                        <template x-for="(img, i) in images" :key="i">
                            <img :src="img" :alt="'{{ $room->name }} - photo ' + (i+1)"
                                 x-show="active === i"
                                 class="absolute inset-0 w-full h-full object-cover"
                                 loading="lazy">
                        </template>
                        {{-- Nav --}}
                        <button @click="active = (active - 1 + images.length) % images.length"
                                class="absolute left-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-black/40 text-white flex items-center justify-center hover:bg-black/60 transition-colors"
                                x-show="images.length > 1" aria-label="Précédent">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <button @click="active = (active + 1) % images.length"
                                class="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-black/40 text-white flex items-center justify-center hover:bg-black/60 transition-colors"
                                x-show="images.length > 1" aria-label="Suivant">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                        {{-- Counter --}}
                        <div class="absolute bottom-3 right-3 px-2 py-1 rounded text-xs text-white" style="background-color: rgba(0,0,0,0.5);">
                            <span x-text="active + 1"></span>/<span x-text="images.length"></span>
                        </div>
                    </div>
                    {{-- Miniatures --}}
                    <div class="flex gap-2 overflow-x-auto pb-1">
                        <template x-for="(img, i) in images" :key="i">
                            <button @click="active = i"
                                    class="shrink-0 w-16 h-16 rounded-lg overflow-hidden border-2 transition-all"
                                    :class="active === i ? 'border-orange-500' : 'border-transparent opacity-60 hover:opacity-100'">
                                <img :src="img" class="w-full h-full object-cover" :alt="'Vue ' + (i+1)" loading="lazy">
                            </button>
                        </template>
                    </div>
                </div>

                {{-- Titre + caractéristiques --}}
                <div class="mb-6">
                    <h1 class="section-title">{{ $room->name }}</h1>
                    <p class="mt-2 text-sm font-medium" style="color: var(--color-navy);">
                        {{ $room->capacity_adults }} voyageur{{ $room->capacity_adults > 1 ? 's' : '' }}
                        &middot; {{ $room->bed_type_label }}
                        @if ($room->size_m2) &middot; {{ $room->size_m2 }} m² @endif
                        &middot; Vue {{ mb_strtolower($room->view_label) }}
                        &middot; Étage {{ $room->floor }}
                    </p>
                    <p class="section-subtitle">{{ $room->description_short }}</p>
                </div>

                {{-- Description longue --}}
                @if ($room->description_long)
                <div class="bg-white rounded-2xl p-6 mb-6 shadow-sm border" style="border-color: var(--color-border);">
                    <h2 class="font-semibold text-lg mb-3" style="color: var(--color-navy); font-family: var(--font-serif);">Description</h2>
                    <div class="text-sm leading-relaxed rich-text" style="color: var(--color-slate);">
                        {!! $room->description_long_html !!}
                    </div>
                </div>
                @endif

                {{-- Équipements --}}
                <div class="bg-white rounded-2xl p-6 shadow-sm border mb-6" style="border-color: var(--color-border);">
                    <h2 class="font-semibold text-lg mb-4" style="color: var(--color-navy); font-family: var(--font-serif);">Équipements</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        @foreach ($room->amenities ?? [] as $amenity)
                        <div class="flex items-center gap-2.5 text-sm" style="color: var(--color-slate);">
                            <x-amenity-icon :name="$amenity" class="w-5 h-5 shrink-0" style="color: var(--color-orange);" />
                            {{ $amenity }}
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Politique d'annulation --}}
                <div class="rounded-2xl p-5 text-sm flex gap-3" style="background-color: #f0fdf4; border: 1px solid #bbf7d0;">
                    <svg class="w-5 h-5 shrink-0 mt-0.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div>
                        <p class="font-medium text-green-800">Annulation gratuite jusqu'à 48h avant l'arrivée</p>
                        <p class="text-green-700 mt-1">Paiement intégral à l'arrivée — aucun prépaiement en ligne requis.</p>
                    </div>
                </div>
            </div>

            {{-- ===== COLONNE DROITE — Widget réservation ===== --}}
            <div class="lg:col-span-1">
                <div class="sticky top-24 bg-white rounded-2xl shadow-lg border p-6" style="border-color: var(--color-border);"
                     x-data="bookingWidget({{ $room->id }}, {{ $room->price_per_night }})">

                    <div class="flex items-baseline gap-1.5 mb-5">
                        <span class="price-tag text-3xl">{{ number_format($room->price_per_night, 0, ',', ' ') }}</span>
                        <span class="text-sm" style="color: var(--color-slate);">FCFA / nuit</span>
                    </div>

                    {{-- Bloc dates + voyageurs soudé --}}
                    <div class="rounded-xl border mb-4 overflow-hidden" style="border-color: #94A3B8;">
                        <div class="grid grid-cols-2">
                            <div class="p-3">
                                <label for="room-check-in" class="block text-[10px] font-bold uppercase tracking-wide" style="color: var(--color-navy);">Arrivée</label>
                                <input type="date" x-model="checkIn"
                                       @change="updatePrice()"
                                       :min="today"
                                       value="{{ request('check_in') }}"
                                       class="w-full bg-transparent text-sm outline-none border-0 p-0 cursor-pointer"
                                       id="room-check-in">
                            </div>
                            <div class="p-3 border-l" style="border-color: #94A3B8;">
                                <label for="room-check-out" class="block text-[10px] font-bold uppercase tracking-wide" style="color: var(--color-navy);">Départ</label>
                                <input type="date" x-model="checkOut"
                                       @change="updatePrice()"
                                       :min="minCheckOut"
                                       value="{{ request('check_out') }}"
                                       class="w-full bg-transparent text-sm outline-none border-0 p-0 cursor-pointer"
                                       id="room-check-out">
                            </div>
                        </div>
                        <div class="p-3 border-t" style="border-color: #94A3B8;">
                            <label for="room-guests" class="block text-[10px] font-bold uppercase tracking-wide" style="color: var(--color-navy);">Voyageurs</label>
                            <select x-model="guests" id="room-guests" class="w-full bg-transparent text-sm outline-none border-0 p-0 cursor-pointer">
                                @for ($i = 1; $i <= $room->capacity_adults; $i++)
                                <option value="{{ $i }}">{{ $i }} {{ $i > 1 ? 'voyageurs' : 'voyageur' }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <a :href="nights > 0 ? reservationUrl : '#'"
                       @click.prevent="nights > 0 ? window.location.href = reservationUrl : null"
                       class="btn-primary w-full text-base py-3.5"
                       :class="nights === 0 ? 'opacity-50 cursor-not-allowed' : ''">
                        <span x-text="nights > 0 ? 'Réserver' : 'Sélectionner les dates'"></span>
                    </a>

                    <p class="text-center text-xs mt-3" style="color: var(--color-slate);">Aucun montant débité aujourd'hui &middot; Confirmation instantanée</p>

                    {{-- Détail du prix --}}
                    <div x-show="nights > 0" class="mt-5 pt-4 border-t" style="border-color: var(--color-border);">
                        <div class="flex justify-between text-sm mb-3" style="color: var(--color-navy);">
                            <span class="underline" x-text="pricePerNight.toLocaleString('fr-FR') + ' FCFA × ' + nights + ' nuit(s)'"></span>
                            <span x-text="totalPrice.toLocaleString('fr-FR') + ' FCFA'"></span>
                        </div>
                        <div class="flex justify-between font-bold border-t pt-3" style="border-color: var(--color-border); color: var(--color-navy);">
                            <span>Total <span class="font-normal text-sm">(payé à l'arrivée)</span></span>
                            <span x-text="totalPrice.toLocaleString('fr-FR') + ' FCFA'"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Chambres similaires --}}
        @if ($similar->count() > 0)
        <div class="mt-16">
            <h2 class="section-title mb-8">Chambres similaires</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                @foreach ($similar as $s)
                <a href="{{ route('rooms.show', $s->slug) }}" class="card flex gap-4 p-4 no-underline group">
                    <div class="w-24 h-24 rounded-xl overflow-hidden shrink-0">
                        <img src="{{ asset($s->first_image) }}" alt="{{ $s->name }}" class="w-full h-full object-cover transition-transform group-hover:scale-105" loading="lazy">
                    </div>
                    <div>
                        <h3 class="font-semibold mb-1" style="color: var(--color-navy); font-family: var(--font-serif);">{{ $s->name }}</h3>
                        <p class="text-xs mb-2 line-clamp-2" style="color: var(--color-slate);">{{ $s->description_short }}</p>
                        <span class="price-tag text-lg">{{ number_format($s->price_per_night, 0, ',', ' ') }}</span>
                        <span class="text-xs" style="color: var(--color-slate);"> FCFA/nuit</span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
function bookingWidget(roomId, pricePerNight) {
    return {
        roomId,
        pricePerNight,
        checkIn:  '{{ request("check_in", "") }}',
        checkOut: '{{ request("check_out", "") }}',
        guests:   1,
        nights:   0,
        totalPrice: 0,
        today:    new Date().toISOString().split('T')[0],
        get minCheckOut() {
            if (!this.checkIn) return new Date(Date.now() + 86400000).toISOString().split('T')[0];
            const d = new Date(this.checkIn);
            d.setDate(d.getDate() + 1);
            return d.toISOString().split('T')[0];
        },
        get reservationUrl() {
            return `/reservation?room_id=${this.roomId}&check_in=${this.checkIn}&check_out=${this.checkOut}&guests=${this.guests}`;
        },
        updatePrice() {
            if (!this.checkIn || !this.checkOut) { this.nights = 0; return; }
            const ms = new Date(this.checkOut) - new Date(this.checkIn);
            this.nights = ms > 0 ? Math.round(ms / 86400000) : 0;
            this.totalPrice = this.nights * this.pricePerNight;
        },
        init() { this.updatePrice(); }
    };
}
</script>
@endpush
