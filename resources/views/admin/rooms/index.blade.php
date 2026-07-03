@extends('layouts.admin')
@section('page-title', 'Chambres')

@section('content')

<div class="flex items-center justify-between mb-5">
    <p class="text-sm" style="color: var(--color-slate);">{{ $rooms->count() }} chambre(s)</p>
    <a href="{{ route('admin.rooms.create') }}" class="btn-primary text-sm py-2">+ Ajouter une chambre</a>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
    @forelse ($rooms as $room)
    <div class="bg-white rounded-xl border shadow-sm overflow-hidden" style="border-color: var(--color-border);">
        <div class="relative">
            @if ($room->first_image)
            <img src="{{ asset($room->first_image) }}" alt="{{ $room->name }}" class="w-full h-44 object-cover">
            @else
            <div class="w-full h-44 flex items-center justify-center" style="background-color: var(--color-snow);">
                <svg class="w-10 h-10" style="color: var(--color-border);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            @endif
            <span class="absolute top-3 right-3 px-2 py-0.5 rounded-full text-xs font-semibold
                {{ $room->status === 'active' ? 'bg-green-100 text-green-700' : ($room->status === 'maintenance' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                {{ ucfirst($room->status) }}
            </span>
        </div>
        <div class="p-4">
            <h3 class="font-semibold mb-0.5" style="color: var(--color-navy);">{{ $room->name }}</h3>
            <p class="text-xs mb-3" style="color: var(--color-slate);">{{ $room->capacity_adults }} adultes · {{ $room->size_m2 }} m² · {{ $room->view_label }}</p>
            <p class="text-sm font-bold mb-4" style="color: var(--color-orange);">{{ number_format($room->price_per_night, 0, ',', ' ') }} FCFA / nuit</p>
            <div class="flex gap-2">
                <a href="{{ route('admin.rooms.edit', $room) }}" class="btn-outline text-xs py-1.5 flex-1 text-center">Modifier</a>
                <a href="{{ route('rooms.show', $room->slug) }}" target="_blank" class="text-xs px-3 py-1.5 rounded-lg transition-colors text-center" style="color: var(--color-blue); background-color: var(--color-sky);">Voir →</a>
            </div>
        </div>
    </div>
    @empty
    <div class="sm:col-span-2 xl:col-span-3 py-20 text-center" style="color: var(--color-slate);">
        <p class="text-sm">Aucune chambre. <a href="{{ route('admin.rooms.create') }}" style="color: var(--color-blue);">Créer la première →</a></p>
    </div>
    @endforelse
</div>

@endsection
