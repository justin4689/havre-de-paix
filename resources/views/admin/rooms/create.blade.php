@extends('layouts.admin')
@section('page-title', 'Nouvelle chambre')

@section('content')

<div class="mb-5">
    <a href="{{ route('admin.rooms.index') }}" class="text-sm flex items-center gap-1" style="color: var(--color-blue);">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Retour aux chambres
    </a>
</div>

<div class="max-w-2xl">
    <div class="bg-white rounded-xl border shadow-sm p-6" style="border-color: var(--color-border);">
        <h2 class="text-lg font-semibold mb-6" style="color: var(--color-navy);">Créer une chambre</h2>

        @if ($errors->any())
        <div class="mb-5 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
            <ul class="space-y-1 list-disc list-inside">
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="form-label">Nom de la chambre <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-input" required>
                </div>
                <div class="col-span-2">
                    <label class="form-label">Slug URL <span class="text-red-500">*</span></label>
                    <input type="text" name="slug" value="{{ old('slug') }}" class="form-input" placeholder="ex: suite-lagune" required>
                </div>
                <div class="col-span-2">
                    <label class="form-label">Description courte <span class="text-red-500">*</span></label>
                    <input type="text" name="description_short" value="{{ old('description_short') }}" class="form-input" required maxlength="160">
                </div>
                <div class="col-span-2">
                    <label class="form-label">Description longue</label>
                    <textarea name="description_long" rows="4" class="form-input resize-none">{{ old('description_long') }}</textarea>
                </div>
            </div>

            <hr style="border-color: var(--color-border);">
            <h3 class="font-medium text-sm" style="color: var(--color-navy);">Caractéristiques</h3>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Capacité adultes <span class="text-red-500">*</span></label>
                    <input type="number" name="capacity_adults" value="{{ old('capacity_adults', 2) }}" min="1" max="10" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">Capacité enfants</label>
                    <input type="number" name="capacity_children" value="{{ old('capacity_children', 0) }}" min="0" max="5" class="form-input">
                </div>
                <div>
                    <label class="form-label">Surface (m²)</label>
                    <input type="number" name="size_m2" value="{{ old('size_m2') }}" min="1" class="form-input">
                </div>
                <div>
                    <label class="form-label">Étage</label>
                    <input type="number" name="floor" value="{{ old('floor', 0) }}" min="0" class="form-input">
                </div>
                <div>
                    <label class="form-label">Type de lit</label>
                    <select name="bed_type" class="form-input">
                        <option value="double" {{ old('bed_type') === 'double' ? 'selected' : '' }}>Double</option>
                        <option value="twin" {{ old('bed_type') === 'twin' ? 'selected' : '' }}>Twin (2 lits simples)</option>
                        <option value="king" {{ old('bed_type') === 'king' ? 'selected' : '' }}>King Size</option>
                        <option value="single" {{ old('bed_type') === 'single' ? 'selected' : '' }}>Simple</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Vue</label>
                    <select name="view" class="form-input">
                        <option value="lagoon" {{ old('view') === 'lagoon' ? 'selected' : '' }}>Lagune</option>
                        <option value="sea" {{ old('view') === 'sea' ? 'selected' : '' }}>Mer</option>
                        <option value="pool" {{ old('view') === 'pool' ? 'selected' : '' }}>Piscine</option>
                        <option value="garden" {{ old('view') === 'garden' ? 'selected' : '' }}>Jardin</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Prix / nuit (FCFA) <span class="text-red-500">*</span></label>
                    <input type="number" name="price_per_night" value="{{ old('price_per_night') }}" min="0" step="500" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">Nuits minimum</label>
                    <input type="number" name="min_nights" value="{{ old('min_nights', 1) }}" min="1" class="form-input">
                </div>
                <div>
                    <label class="form-label">Statut</label>
                    <select name="status" class="form-input">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="maintenance">Maintenance</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="form-label">Équipements (un par ligne)</label>
                <textarea name="amenities" rows="4" class="form-input resize-none font-mono text-sm" placeholder="WiFi haut débit&#10;Climatisation&#10;Télévision satellite&#10;Mini-bar">{{ old('amenities') }}</textarea>
                <p class="text-xs mt-1" style="color: var(--color-slate);">Entrez chaque équipement sur une ligne séparée.</p>
            </div>

            <div>
                <label class="form-label">Photos de la chambre</label>
                <input type="file" name="images[]" multiple accept="image/*" class="block w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium cursor-pointer" style="color: var(--color-slate); file:background-color: var(--color-sand); file:color: var(--color-navy);">
                <p class="text-xs mt-1" style="color: var(--color-slate);">JPG, PNG — max 2 Mo par image. La première image sera utilisée comme photo principale.</p>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">Créer la chambre</button>
                <a href="{{ route('admin.rooms.index') }}" class="btn-outline">Annuler</a>
            </div>
        </form>
    </div>
</div>

@endsection
