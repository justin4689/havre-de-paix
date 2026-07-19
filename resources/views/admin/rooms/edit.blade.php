@extends('layouts.admin')
@section('page-title', 'Modifier — ' . $room->name)

@section('content')

<div class="mb-5">
    <a href="{{ route('admin.rooms.index') }}" class="text-sm flex items-center gap-1" style="color: var(--color-blue);">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Retour aux chambres
    </a>
</div>

<div>
    <div class="bg-white rounded-xl border shadow-sm p-6" style="border-color: var(--color-border);">
        <h2 class="text-lg font-semibold mb-6" style="color: var(--color-navy);">Modifier : {{ $room->name }}</h2>

        @if ($errors->any())
        <div class="mb-5 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
            <ul class="space-y-1 list-disc list-inside">
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.rooms.update', $room) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2 lg:col-span-1">
                    <label class="form-label">Nom de la chambre <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $room->name) }}" class="form-input" required>
                </div>
                <div class="col-span-2 lg:col-span-1">
                    <label class="form-label">Slug URL</label>
                    <input type="text" name="slug" value="{{ old('slug', $room->slug) }}" class="form-input">
                </div>
                <div class="col-span-2">
                    <label class="form-label">Description courte <span class="text-red-500">*</span></label>
                    <input type="text" name="description_short" value="{{ old('description_short', $room->description_short) }}" class="form-input" required>
                </div>
                <div class="col-span-2">
                    <label class="form-label">Description longue</label>
                    <input type="hidden" id="description_long" name="description_long" value="{{ old('description_long', $room->description_long) }}">
                    <trix-editor input="description_long" class="trix-content" placeholder="Décrivez la chambre en détail : cadre, décoration, atouts..."></trix-editor>
                </div>
            </div>

            <hr style="border-color: var(--color-border);">

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="form-label">Capacité adultes</label>
                    <input type="number" name="capacity_adults" value="{{ old('capacity_adults', $room->capacity_adults) }}" min="1" max="10" class="form-input">
                </div>
                <div>
                    <label class="form-label">Capacité enfants</label>
                    <input type="number" name="capacity_children" value="{{ old('capacity_children', $room->capacity_children) }}" min="0" class="form-input">
                </div>
                <div>
                    <label class="form-label">Surface (m²)</label>
                    <input type="number" name="size_m2" value="{{ old('size_m2', $room->size_m2) }}" min="1" class="form-input">
                </div>
                <div>
                    <label class="form-label">Étage</label>
                    <input type="number" name="floor" value="{{ old('floor', $room->floor) }}" min="0" class="form-input">
                </div>
                <div>
                    <label class="form-label">Type de lit</label>
                    <select name="bed_type" class="form-input">
                        @foreach (['double' => 'Double', 'twin' => 'Twin', 'king' => 'King Size', 'single' => 'Simple'] as $val => $label)
                        <option value="{{ $val }}" {{ old('bed_type', $room->bed_type) === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Vue</label>
                    <select name="view" class="form-input">
                        @foreach (['lagoon' => 'Lagune', 'sea' => 'Mer', 'pool' => 'Piscine', 'garden' => 'Jardin'] as $val => $label)
                        <option value="{{ $val }}" {{ old('view', $room->view) === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Prix / nuit (FCFA)</label>
                    <input type="number" name="price_per_night" value="{{ old('price_per_night', $room->price_per_night) }}" min="0" step="500" class="form-input">
                </div>
                <div>
                    <label class="form-label">Nuits minimum</label>
                    <input type="number" name="min_nights" value="{{ old('min_nights', $room->min_nights) }}" min="1" class="form-input">
                </div>
                <div>
                    <label class="form-label">Statut</label>
                    <select name="status" class="form-input">
                        @foreach (['active' => 'Active', 'inactive' => 'Inactive', 'maintenance' => 'Maintenance'] as $val => $label)
                        <option value="{{ $val }}" {{ old('status', $room->status) === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            @include('admin.rooms._amenities-field', ['amenities' => (array) old('amenities', $room->amenities ?? [])])

            {{-- Photos existantes --}}
            @if ($room->images && count($room->images))
            <div>
                <p class="form-label mb-2">Photos actuelles</p>
                <div class="flex flex-wrap gap-2">
                    @foreach ($room->images as $img)
                    <img src="{{ asset($img) }}" alt="" class="w-20 h-20 object-cover rounded-lg border" style="border-color: var(--color-border);">
                    @endforeach
                </div>
            </div>
            @endif

            @include('admin.rooms._images-field', ['label' => 'Ajouter des photos'])

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">Enregistrer</button>
                <a href="{{ route('admin.rooms.index') }}" class="btn-outline">Annuler</a>
            </div>
        </form>
    </div>
</div>

@endsection

@push('head')
<link rel="stylesheet" href="//unpkg.com/trix@2/dist/trix.css">
<script src="//unpkg.com/trix@2/dist/trix.umd.min.js" defer></script>
<style>
    trix-editor { min-height: 160px; background: white; border: 1px solid var(--color-border); border-radius: 0.5rem; padding: 0.75rem 1rem; font-size: 0.875rem; color: var(--color-navy); }
    trix-editor:focus { outline: none; border-color: var(--color-orange); box-shadow: 0 0 0 3px rgba(249,115,22,0.15); }
    trix-toolbar .trix-button-group--file-tools { display: none; }
</style>
@endpush

@push('scripts')
<script>
// Pas d'upload de fichiers dans la description (photos gérées par le champ dédié)
document.addEventListener('trix-file-accept', e => e.preventDefault());
</script>
@endpush
