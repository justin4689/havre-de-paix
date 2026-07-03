@extends('layouts.admin')
@section('page-title', 'Modifier — ' . $room->name)

@section('content')

<div class="mb-5">
    <a href="{{ route('admin.rooms.index') }}" class="text-sm flex items-center gap-1" style="color: var(--color-blue);">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Retour aux chambres
    </a>
</div>

<div class="max-w-2xl">
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
                <div class="col-span-2">
                    <label class="form-label">Nom de la chambre <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $room->name) }}" class="form-input" required>
                </div>
                <div class="col-span-2">
                    <label class="form-label">Slug URL</label>
                    <input type="text" name="slug" value="{{ old('slug', $room->slug) }}" class="form-input">
                </div>
                <div class="col-span-2">
                    <label class="form-label">Description courte <span class="text-red-500">*</span></label>
                    <input type="text" name="description_short" value="{{ old('description_short', $room->description_short) }}" class="form-input" required>
                </div>
                <div class="col-span-2">
                    <label class="form-label">Description longue</label>
                    <textarea name="description_long" rows="4" class="form-input resize-none">{{ old('description_long', $room->description_long) }}</textarea>
                </div>
            </div>

            <hr style="border-color: var(--color-border);">

            <div class="grid grid-cols-2 gap-4">
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

            <div>
                <label class="form-label">Équipements (un par ligne)</label>
                <textarea name="amenities" rows="4" class="form-input resize-none font-mono text-sm">{{ old('amenities', is_array($room->amenities) ? implode("\n", $room->amenities) : $room->amenities) }}</textarea>
            </div>

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

            <div>
                <label class="form-label">Ajouter des photos</label>
                <input type="file" name="images[]" multiple accept="image/*" class="block w-full text-sm cursor-pointer" style="color: var(--color-slate);">
                <p class="text-xs mt-1" style="color: var(--color-slate);">Les nouvelles photos s'ajouteront aux existantes.</p>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">Enregistrer</button>
                <a href="{{ route('admin.rooms.index') }}" class="btn-outline">Annuler</a>
            </div>
        </form>
    </div>
</div>

@endsection
