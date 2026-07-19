@props(['name'])

{{-- L'association équipement → icône vit dans App\Support\AmenityIcon
     (partagée avec le champ d'équipements dynamique du back-office). --}}
<svg {{ $attributes->merge(['class' => 'w-4 h-4']) }} fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="{{ \App\Support\AmenityIcon::pathFor($name) }}"/></svg>
