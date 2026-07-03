@extends('layouts.admin')
@section('page-title', 'Réservations')

@section('content')

{{-- Filtres --}}
<div class="bg-white rounded-xl border p-4 mb-5 shadow-sm" style="border-color: var(--color-border);">
    <form action="{{ route('admin.reservations.index') }}" method="GET" class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom, ref, email..." class="form-input text-sm col-span-2 sm:col-span-1">
        <select name="status" class="form-input text-sm">
            <option value="">Tous statuts</option>
            <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmées</option>
            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Annulées</option>
            <option value="modified" {{ request('status') === 'modified' ? 'selected' : '' }}>Modifiées</option>
        </select>
        <input type="date" name="date" value="{{ request('date') }}" class="form-input text-sm">
        <div class="flex gap-2">
            <button type="submit" class="btn-primary text-sm flex-1">Filtrer</button>
            <a href="{{ route('admin.reservations.index') }}" class="btn-outline text-sm px-3">✕</a>
        </div>
    </form>
</div>

{{-- Actions --}}
<div class="flex items-center justify-between mb-4">
    <p class="text-sm" style="color: var(--color-slate);">{{ $reservations->total() }} réservation(s)</p>
    <a href="{{ route('admin.reservations.create') }}" class="btn-primary text-sm py-2">
        + Nouvelle réservation manuelle
    </a>
</div>

{{-- Table --}}
<div class="bg-white rounded-xl border shadow-sm overflow-hidden" style="border-color: var(--color-border);">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr style="background-color: var(--color-snow); border-bottom: 1px solid var(--color-border);">
                    <th class="px-4 py-3 text-left font-medium text-xs uppercase tracking-wide" style="color: var(--color-slate);">Référence</th>
                    <th class="px-4 py-3 text-left font-medium text-xs uppercase tracking-wide" style="color: var(--color-slate);">Client</th>
                    <th class="px-4 py-3 text-left font-medium text-xs uppercase tracking-wide hidden md:table-cell" style="color: var(--color-slate);">Chambre</th>
                    <th class="px-4 py-3 text-left font-medium text-xs uppercase tracking-wide hidden lg:table-cell" style="color: var(--color-slate);">Dates</th>
                    <th class="px-4 py-3 text-right font-medium text-xs uppercase tracking-wide hidden sm:table-cell" style="color: var(--color-slate);">Montant</th>
                    <th class="px-4 py-3 text-center font-medium text-xs uppercase tracking-wide" style="color: var(--color-slate);">Statut</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y" style="--tw-divide-opacity: 1;">
                @forelse ($reservations as $r)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-4 py-3 font-mono font-semibold text-xs" style="color: var(--color-orange);">{{ $r->ref }}</td>
                    <td class="px-4 py-3">
                        <p class="font-medium" style="color: var(--color-navy);">{{ $r->guest_name }}</p>
                        <p class="text-xs" style="color: var(--color-slate);">{{ $r->guest_phone }}</p>
                    </td>
                    <td class="px-4 py-3 hidden md:table-cell" style="color: var(--color-slate);">{{ $r->room->name }}</td>
                    <td class="px-4 py-3 hidden lg:table-cell text-xs" style="color: var(--color-slate);">
                        {{ $r->check_in->format('d/m/Y') }} → {{ $r->check_out->format('d/m/Y') }}<br>
                        <span>{{ $r->nights }} nuit(s)</span>
                    </td>
                    <td class="px-4 py-3 text-right font-semibold hidden sm:table-cell" style="color: var(--color-navy);">
                        {{ number_format($r->total_price, 0, ',', ' ') }} <span class="text-xs font-normal" style="color: var(--color-slate);">FCFA</span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                            {{ $r->status === 'confirmed' ? 'bg-green-100 text-green-700' : ($r->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                            {{ $r->status_label }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <a href="{{ route('admin.reservations.show', $r) }}" class="text-xs font-medium transition-colors" style="color: var(--color-blue);">Voir →</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-12 text-center text-sm" style="color: var(--color-slate);">Aucune réservation trouvée.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">{{ $reservations->links() }}</div>

@endsection
