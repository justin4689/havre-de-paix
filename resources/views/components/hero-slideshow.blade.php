{{--
    Diaporama de hero : fondu enchaîné automatique entre plusieurs photos.
    La première image est rendue côté serveur (visible sans JS, chargée en eager),
    les suivantes sont en lazy et pilotées par Alpine.

    Usage :
    <x-hero-slideshow :images="[
        ['src' => 'images/hero2.webp', 'alt' => '…'],
        ['src' => 'images/hero-facade-jour.jpg', 'alt' => '…'],
    ]" />
--}}
@props(['images' => [], 'interval' => 6000])

<div {{ $attributes->merge(['class' => 'absolute inset-0']) }}
     @if (count($images) > 1)
     x-data="{ slide: 0 }"
     x-init="setInterval(() => slide = (slide + 1) % {{ count($images) }}, {{ (int) $interval }})"
     @endif>
    @foreach ($images as $i => $img)
    <img src="{{ asset($img['src']) }}"
         alt="{{ $img['alt'] }}"
         class="absolute inset-0 w-full h-full object-cover"
         style="opacity: {{ $i === 0 ? '1' : '0' }}; transition: opacity 1.5s ease;"
         @if (count($images) > 1) :style="slide === {{ $i }} ? 'opacity:1; transition: opacity 1.5s ease;' : 'opacity:0; transition: opacity 1.5s ease;'" @endif
         loading="{{ $i === 0 ? 'eager' : 'lazy' }}">
    @endforeach
</div>
