@extends('layouts.admin')
@section('page-title', 'Catégories de chambres')

@section('content')

@if ($errors->any())
<div class="mb-5 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
    @foreach ($errors->all() as $error) <p>{{ $error }}</p> @endforeach
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Liste des catégories --}}
    <div>
        <h2 class="text-base font-semibold mb-4" style="color: var(--color-navy);">Catégories ({{ $categories->count() }})</h2>
        <div class="space-y-3">
            @forelse ($categories as $category)
            <div class="bg-white rounded-xl border shadow-sm p-4 flex items-start gap-4 {{ $editing && $editing->is($category) ? 'ring-2 ring-orange-300' : '' }}" style="border-color: var(--color-border);">
                <span class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-bold shrink-0 mt-0.5" style="background-color: var(--color-sand); color: #8A4B06;">
                    {{ $category->sort_order }}
                </span>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1 flex-wrap">
                        <p class="font-semibold text-sm" style="color: var(--color-navy);">{{ $category->name }}</p>
                        <span class="text-xs px-2 py-0.5 rounded-full font-medium" style="background-color: var(--color-sky); color: #075985;">
                            {{ $category->rooms_count }} chambre{{ $category->rooms_count > 1 ? 's' : '' }}
                        </span>
                    </div>
                    <p class="text-xs mb-1" style="color: var(--color-slate);">
                        <span class="font-mono">{{ $category->slug }}</span>
                        @if ($category->name_en) · EN : {{ $category->name_en }} @endif
                    </p>
                    @if ($category->tagline)
                    <p class="text-xs italic" style="color: var(--color-slate);">« {{ $category->tagline }} »</p>
                    @endif
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <a href="{{ route('admin.categories.index', ['edit' => $category->id]) }}"
                       class="text-xs px-2 py-1 rounded-lg transition-colors" style="background-color: var(--color-snow); color: var(--color-slate);">
                        Modifier
                    </a>
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                          onsubmit="return confirm('Supprimer la catégorie « {{ $category->name }} » ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-xs px-2 py-1 rounded-lg text-red-600 hover:bg-red-50 transition-colors cursor-pointer"
                                @disabled($category->rooms_count > 0)
                                title="{{ $category->rooms_count > 0 ? 'Réaffectez d\'abord les chambres de cette catégorie' : '' }}">
                            Suppr.
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="py-12 text-center text-sm rounded-xl border bg-white" style="color: var(--color-slate); border-color: var(--color-border);">
                Aucune catégorie — créez la première ci-contre.
            </div>
            @endforelse
        </div>
        <p class="mt-4 text-xs" style="color: var(--color-slate);">
            L'ordre d'affichage (site et filtres) suit le champ « Ordre ». Le slug est créé automatiquement et ne change plus,
            même si vous renommez la catégorie — les chambres restent rattachées.
        </p>
    </div>

    {{-- Formulaire création / édition --}}
    <div>
        <h2 class="text-base font-semibold mb-4" style="color: var(--color-navy);">
            {{ $editing ? 'Modifier : '.$editing->name : 'Nouvelle catégorie' }}
        </h2>
        <div class="bg-white rounded-xl border shadow-sm p-5" style="border-color: var(--color-border);">
            <form action="{{ $editing ? route('admin.categories.update', $editing) : route('admin.categories.store') }}" method="POST" class="space-y-4">
                @csrf
                @if ($editing) @method('PATCH') @endif

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Nom (français) <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $editing?->name) }}" class="form-input" required maxlength="60" placeholder="Ex. : Bungalow">
                    </div>
                    <div>
                        <label class="form-label">Nom (anglais)</label>
                        <input type="text" name="name_en" value="{{ old('name_en', $editing?->name_en) }}" class="form-input" maxlength="60" placeholder="Ex. : Bungalow">
                    </div>
                    <div>
                        <label class="form-label">Tagline (français)</label>
                        <input type="text" name="tagline" value="{{ old('tagline', $editing?->tagline) }}" class="form-input" maxlength="100" placeholder="Affichée sur la carte de l'accueil">
                    </div>
                    <div>
                        <label class="form-label">Tagline (anglais)</label>
                        <input type="text" name="tagline_en" value="{{ old('tagline_en', $editing?->tagline_en) }}" class="form-input" maxlength="100">
                    </div>
                    <div>
                        <label class="form-label">Ordre d'affichage</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $editing?->sort_order ?? ($categories->max('sort_order') + 1)) }}" min="0" max="999" class="form-input">
                    </div>
                    @if ($editing)
                    <div>
                        <label class="form-label">Slug (fixe)</label>
                        <input type="text" value="{{ $editing->slug }}" class="form-input" disabled>
                    </div>
                    @endif
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="btn-primary text-sm">
                        {{ $editing ? 'Enregistrer' : 'Créer la catégorie' }}
                    </button>
                    @if ($editing)
                    <a href="{{ route('admin.categories.index') }}" class="text-sm underline" style="color: var(--color-slate);">Annuler</a>
                    @endif
                </div>
            </form>
        </div>

        <div class="mt-4 p-4 rounded-xl text-xs leading-relaxed" style="background-color: var(--color-sky); color: #0c4a6e;">
            Une nouvelle catégorie apparaît automatiquement dans les filtres du site, sur la page d'accueil
            (dès qu'une chambre active y est rattachée) et dans le formulaire des chambres.
        </div>
    </div>
</div>

@endsection
