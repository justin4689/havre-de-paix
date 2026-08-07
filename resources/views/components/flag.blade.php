{{-- Drapeau SVG inline (fr | gb) — fiable sur toutes les plateformes,
     contrairement aux emojis drapeaux (absents sous Windows). --}}
@props(['code'])

<span {{ $attributes->merge(['class' => 'inline-block rounded-[3px] overflow-hidden shadow-sm align-middle']) }} style="line-height: 0;">
    @if ($code === 'fr')
    <svg viewBox="0 0 24 16" class="w-full h-full" aria-hidden="true">
        <rect width="8" height="16" fill="#1A47B8"/>
        <rect x="8" width="8" height="16" fill="#FFFFFF"/>
        <rect x="16" width="8" height="16" fill="#F93939"/>
    </svg>
    @else
    <svg viewBox="0 0 24 16" class="w-full h-full" aria-hidden="true">
        <rect width="24" height="16" fill="#1A47B8"/>
        <path d="M0 0L24 16M24 0L0 16" stroke="#FFFFFF" stroke-width="3.2"/>
        <path d="M0 0L24 16M24 0L0 16" stroke="#F93939" stroke-width="1.4"/>
        <path d="M12 0V16M0 8H24" stroke="#FFFFFF" stroke-width="5"/>
        <path d="M12 0V16M0 8H24" stroke="#F93939" stroke-width="3"/>
    </svg>
    @endif
</span>
