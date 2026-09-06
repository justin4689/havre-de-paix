@extends('layouts.admin')
@section('page-title', 'Règles tarifaires')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Liste des règles --}}
    <div>
        <h2 class="text-base font-semibold mb-4" style="color: var(--color-navy);">Règles actives</h2>
        <div class="space-y-3">
            @forelse ($rules as $rule)
            <div class="bg-white rounded-xl border shadow-sm p-4 flex items-start gap-4" style="border-color: var(--color-border);">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <p class="font-semibold text-sm" style="color: var(--color-navy);">{{ $rule->name }}</p>
                        <span class="text-xs px-2 py-0.5 rounded-full font-medium {{ $rule->active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-500' }}">
                            {{ $rule->active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <p class="text-xs mb-1" style="color: var(--color-slate);">
                        Du {{ $rule->start_date->format('d/m/Y') }} au {{ $rule->end_date->format('d/m/Y') }}
                        @if ($rule->min_nights > 1) · min. {{ $rule->min_nights }} nuits @endif
                    </p>
                    <p class="text-sm font-bold {{ $rule->adjustment >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $rule->type === 'percentage' ? ($rule->adjustment >= 0 ? '+' : '') . $rule->adjustment . '%' : ($rule->adjustment >= 0 ? '+' : '') . number_format($rule->adjustment, 0, ',', ' ') . ' FCFA' }}
                    </p>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <form action="{{ route('admin.pricing.toggle', $rule) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" class="text-xs px-2 py-1 rounded-lg transition-colors" style="background-color: var(--color-snow); color: var(--color-slate);">
                            {{ $rule->active ? 'Désactiver' : 'Activer' }}
                        </button>
                    </form>
                    <form action="{{ route('admin.pricing.destroy', $rule) }}" method="POST" onsubmit="return confirm('Supprimer cette règle ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-xs px-2 py-1 rounded-lg text-red-600 hover:bg-red-50 transition-colors">Suppr.</button>
                    </form>
                </div>
            </div>
            @empty
            <div class="py-12 text-center text-sm rounded-xl border bg-white" style="color: var(--color-slate); border-color: var(--color-border);">Aucune règle tarifaire.</div>
            @endforelse
        </div>
    </div>

    {{-- Formulaire création --}}
    <div>
        <h2 class="text-base font-semibold mb-4" style="color: var(--color-navy);">Nouvelle règle</h2>
        <div class="bg-white rounded-xl border shadow-sm p-5" style="border-color: var(--color-border);">

            @if ($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm">
                @foreach ($errors->all() as $error) <p>{{ $error }}</p> @endforeach
            </div>
            @endif

            <form action="{{ route('admin.pricing.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="form-label">Nom de la règle <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-input text-sm" placeholder="Tarif haute saison" required>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="form-label">Date début <span class="text-red-500">*</span></label>
                        <input type="date" name="start_date" value="{{ old('start_date') }}" class="form-input text-sm" required>
                    </div>
                    <div>
                        <label class="form-label">Date fin <span class="text-red-500">*</span></label>
                        <input type="date" name="end_date" value="{{ old('end_date') }}" class="form-input text-sm" required>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="form-label">Type d'ajustement</label>
                        <select name="type" class="form-input text-sm">
                            <option value="percentage" {{ old('type') === 'percentage' ? 'selected' : '' }}>Pourcentage (%)</option>
                            <option value="fixed" {{ old('type') === 'fixed' ? 'selected' : '' }}>Montant fixe (FCFA)</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Valeur <span class="text-red-500">*</span></label>
                        <input type="number" name="adjustment" value="{{ old('adjustment') }}" class="form-input text-sm" placeholder="+20 ou -15" required>
                    </div>
                </div>
                <div>
                    <label class="form-label">Nuits minimum</label>
                    <input type="number" name="min_nights" value="{{ old('min_nights', 1) }}" min="1" class="form-input text-sm">
                </div>
                <p class="text-xs" style="color: var(--color-slate);">Utilisez une valeur positive pour une majoration, négative pour une réduction.</p>
                <button type="submit" class="btn-primary w-full">Créer la règle</button>
            </form>
        </div>
    </div>

</div>

@endsection
