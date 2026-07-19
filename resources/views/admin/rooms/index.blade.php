@extends('layouts.admin')
@section('page-title', 'Chambres')

@section('content')

{{-- En-tête --}}
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div>
        <p class="text-sm" style="color: var(--color-slate);">
            <strong style="color: var(--color-navy);">{{ $rooms->count() }}</strong> chambre{{ $rooms->count() > 1 ? 's' : '' }} au catalogue
            &middot; {{ $rooms->where('status', 'active')->count() }} active{{ $rooms->where('status', 'active')->count() > 1 ? 's' : '' }}
        </p>
    </div>
    <a href="{{ route('admin.rooms.create') }}" class="btn-primary text-sm py-2.5">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Ajouter une chambre
    </a>
</div>

@php
$statusLabels = ['active' => 'Active', 'inactive' => 'Inactive', 'maintenance' => 'En maintenance'];
$statusClasses = ['active' => 'bg-green-100 text-green-700', 'inactive' => 'bg-red-100 text-red-700', 'maintenance' => 'bg-yellow-100 text-yellow-700'];
@endphp

<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
    @forelse ($rooms as $room)
    <div class="bg-white rounded-xl border shadow-sm overflow-hidden transition-shadow duration-200 hover:shadow-md" style="border-color: var(--color-border);">
        <div class="relative">
            @if ($room->first_image)
            <img src="{{ asset($room->first_image) }}" alt="{{ $room->name }}" class="w-full h-44 object-cover" loading="lazy">
            @else
            <div class="w-full h-44 flex items-center justify-center" style="background-color: var(--color-snow);">
                <svg class="w-10 h-10" style="color: var(--color-border);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            @endif
            <span class="absolute top-3 right-3 px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusClasses[$room->status] ?? 'bg-slate-100 text-slate-700' }}">
                {{ $statusLabels[$room->status] ?? $room->status }}
            </span>
        </div>
        <div class="p-4">
            <h3 class="font-bold mb-0.5" style="color: var(--color-navy);">{{ $room->name }}</h3>
            <p class="text-xs mb-3" style="color: var(--color-slate);">
                {{ $room->capacity_adults }} voyageur{{ $room->capacity_adults > 1 ? 's' : '' }}
                @if ($room->size_m2) &middot; {{ $room->size_m2 }} m² @endif
                &middot; {{ $room->view_label }}
                @if ($room->min_nights > 1) &middot; {{ $room->min_nights }} nuits min. @endif
            </p>
            <p class="text-base font-bold mb-4 tabular-nums" style="color: var(--color-navy);">
                {{ number_format($room->price_per_night, 0, ',', ' ') }} <span class="text-xs font-normal" style="color: var(--color-slate);">FCFA / nuit</span>
            </p>
            <div class="flex gap-2">
                <a href="{{ route('admin.rooms.edit', $room) }}" class="btn-outline text-xs py-2 flex-1 text-center">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Modifier
                </a>
                <a href="{{ route('rooms.show', $room->slug) }}" target="_blank"
                   class="text-xs font-medium px-3 py-2 rounded-lg transition-colors text-center flex items-center gap-1.5 cursor-pointer hover:opacity-80"
                   style="color: var(--color-blue); background-color: var(--color-sky);">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Voir
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="sm:col-span-2 xl:col-span-3 py-20 text-center">
        <svg class="w-12 h-12 mx-auto mb-3" style="color: var(--color-border);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        <p class="text-sm mb-4" style="color: var(--color-slate);">Aucune chambre au catalogue.</p>
        <a href="{{ route('admin.rooms.create') }}" class="btn-primary text-sm">Créer la première chambre</a>
    </div>
    @endforelse
</div>

@endsection
